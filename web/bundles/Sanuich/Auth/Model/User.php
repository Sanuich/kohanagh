<?php

namespace Sanuich\Auth\Model;

use Kohana\Model as KohanaModel;

class User extends KohanaModel 
{
	/////
	public function auth()
	{
		$user=0;		

		$Mdb = KohanaModel::factory('Sanuich\Database\Model\DB');
		if(isset($_SESSION['user']['email'])){

			if(empty($_SESSION['remember_me']))
			{
				if(empty($_SESSION['last_activity']) || time()-$_SESSION['last_activity']>3600)
				return $this->logout();
			}


			$rez = $this->Mdb->dbrow("SELECT * FROM users WHERE email='".$_SESSION['user']['email']."' AND approved=1");
            if(empty($rez)){
                unset($_SESSION['user']);
				return false;
			}
            else {
				$this->Mdb->dbupdate("UPDATE users SET last_login=NOW(), last_ip='".$_SERVER['REMOTE_ADDR']."' WHERE email='".$_SESSION['user']['email']."'");
				$user = $rez; return $user;
			}
        }
        else {unset($_SESSION['user']); return false;}
	}
	
	public function get_user($data = array())
	{
		if(empty($data['email']) || empty($data['password'])) return false;
		$user = $this->Mdb->dbrow("SELECT * FROM users WHERE email='".$data['email']."' AND password=MD5('".$data['password']."')");
		return $user;
	}
	
	public function login($data)
	{
		$user = $this->get_user($data);
		if(empty($user)) return array('res'=>'0', 'ans'=>'wrong email or password');
		if(!$user['approved']) return array('res'=>'0', 'ans'=>'user not approved');
		
		$_SESSION['user'] = $user;
		return array('res'=>'1', 'ans'=>'granted');
	}
	
	public function logout()
	{
		if(!isset($_SESSION['user']))
		{
			return array('res'=>0, 'ans'=>'Not Logged');
		}
		else
		{
			unset($_SESSION['user']);
			unset($_SESSION['remember_me']);
			return array('res'=>'1', 'ans'=>'Logouted');
		}
	}
	/*
	public function register($user = array())
    {        
		$user_data = array();

        if(!isset($user['email']) || empty($user['email']))
        {
			return array('rez'=>0, 'ans'=>'email not set');		
		}
		
		if(!filter_var($user['email'], FILTER_VALIDATE_EMAIL)){
			return array('rez'=>0, 'ans'=>'email is not valid E-mail address');	}
       
        $user_data = $this->Mdb->dbrow("SELECT * FROM users WHERE email='".$user['email']."'");		
		if(!empty($user_data)){return array('rez'=>0, 'ans'=>'E-mail already exists');}
		//if not approved we delete old attempt and allow repeat registration
		
		//insert new user
		if(!isset($user['password']) || empty($user['password']))
			{return array('rez'=>0, 'ans'=>'input password');}

		if(strlen($user['password'])<6) {return array('rez'=>0, 'ans'=>'password too short. Password must be at least 6 chars');}
		
		$code = $this->Mtools->generatePassword(16, 16);
		if(!isset($user['owner'])) $user['owner'] = 0;
		
		$q1 = "INSERT INTO `users` (`email`,`password`,`name`)  
VALUES ('".$user['email']."',MD5('".$user['password']."'),'".$user['email']."')";
		list($user_id, $affected_rows) = $this->Mdb->dbinsert($q1);
		if($affected_rows>0){
			//email to user
			$body = "Yo created account at Social Lite service http://social.thesage.org.ua\n\r
			Please approve your account by link http://social.thesage.org.ua/approve?email=".$user['email']."&code=".$code;
			$this->Mmail->MailSend(array('afrom'=>'info@social.thesage.org.ua',
		'nfrom'=>'Social Lite',
		'to'=>$user['email'],
		'replyto'=>'',
		'nreplyto'=>'NoReply',
		'return-path'=>'info@social.thesage.org.ua',
		'subject'=>'Restore password',
		'body'=>$body,
		'content-type'=>'text/plain',
		'charset'=>'utf-8'));
			return array('rez'=>1, 'ans'=>'ok');
		}
		else{return array('rez'=>0, 'ans'=>'operation error');}	
    }
    */
	
	public function user_create($data = array())
	{
		if(empty($data['email'])) {return array('rez'=>0, 'ans'=>'Empty email');}
		$Mtools = KohanaModel::factory('Model\Tools');
		if(!$Mtools->ValidEmail($data['email'])) {return array('rez'=>0, 'ans'=>'Invalid email');}

		if(empty($data['admin'])) $data['admin'] = 0; else $data['admin'] = 1; 
		if(empty($data['approved'])) $data['approved'] = 0; else $data['approved'] = 1;

		if(!isset($data['password'])) $password = $Mtools->generatePassword(8,8);
		else $password = $data['password'];
		$data['password'] = md5($data['password']);

		$data['code'] = '';
		if($data['approved']==0) $data['code'] = $Mtools->generatePassword(12,12);

		$Mdb = KohanaModel::factory('Sanuich\Database\Model\DB');
		$user = $Mdb->dbrow("SELECT id FROM users WHERE email='".$data['email']."'");
		if(!empty($user))  {return array('rez'=>0, 'ans'=>'This email already exists');}
		
		$id = $Mdb->dbinsert_data("users", $data);
		return array('rez'=>1, 'id'=>$id, 'ans'=>'created', 'password'=>$password, 'code'=>$data['code']);	
	}
	
	public function set_restore($email = 0)
	{
		$Mtools = KohanaModel::factory('Model\Tools');
		$Mdb = KohanaModel::factory('Sanuich\Database\Model\DB');
		if(!$Mtools->ValidEmail($email)) {return array('rez'=>0, 'ans'=>'Not a valid email address.');}

		$user = $Mdb->dbrow("SELECT * FROM users WHERE email='".$email."'");
		if(empty($user)) {return array('rez'=>0, 'ans'=>'User not found.');}
		if($user['approved']=='0') {return array('rez'=>0, 'ans'=>'User not approved.');}

		
		$restore_data = [];
		
		$restore_data['id'] = $user['id'];
		$code = $Mtools->generatePassword(12, 12);
		$restore_data['code'] = $code;

		$Mdb->dbupdate_data("users", $restore_data);
		
		//send email to user
		$body = "You requested restore access at ".$_SERVER['SERVER_NAME']." account <".$user['email'].">\n\r
If it was you just proceed this link: ".$_SERVER['SERVER_NAME']."\restore?email=".$user['email']."&code=".$code."\n\r
Or just ignore this email.";
		$this->Mmail->MailSend(array('afrom'=>'contact@'.$_SERVER['SERVER_NAME'],
		'nfrom'=>'',
		'to'=>$user['email'],
		'replyto'=>'',
		'nreplyto'=>'NoReply',
		'return-path'=>'contact@'.$_SERVER['SERVER_NAME'],
		'subject'=>'Restore password',
		'body'=>$body,
		'content-type'=>'text/plain',
		'charset'=>'utf-8'));
		
		return array('rez'=>1, 'ans'=>'restore password set. check email box for instructions', 'code'=>$code);
	}
	
	public function reset_pass($data = array())
	{
		$Mtools = KohanaModel::factory('Model\Tools');
		$Mdb = KohanaModel::factory('Sanuich\Database\Model\DB');
		if(!$Mtools->ValidEmail($data['email'])){
			return array('rez'=>0, 'ans'=>'Incorrect address.');}
			
		if(!isset($data['password']) || empty($data['password']))
			{return array('rez'=>0, 'ans'=>'Input password.');}	
		
		if(empty($data['repeat']) || $data['password']!=$data['repeat'])
		{
			{return array('rez'=>0, 'ans'=>'Passwords not match.');}
		}
		
		if(strlen($data['password'])<6) {return array('rez'=>0, 'ans'=>'Password too short. Password must be at least 6 chars');}
		
		$user = $Mdb->dbrow("SELECT * FROM users WHERE email='".$data['email']."'");
		if(empty($user)){return array('rez'=>0, 'ans'=>'E-mail not found.');}
		
		$user = $Mdb->dbrow("SELECT * FROM users WHERE id='".$user['id']."' AND code='".$data['code']."'");
		if(empty($user)){return array('rez'=>0, 'ans'=>'Record not found.');}

		$Mdb->dbupdate("UPDATE users SET password='".md5($data['password'])."', code='' WHERE id=".$user['id']);
		
		return array('rez'=>1, 'ans'=>'new password set');
	}
	
	public function approve($data = array())
	{
		if(empty($data['email']) || empty($data['code']))
		{return array('rez'=>0, 'ans'=>'Error.');}
		$Mdb = KohanaModel::factory('Sanuich\Database\Model\DB');
		$user = $Mdb->dbrow("SELECT * FROM users WHERE email='".$data['email']."'");
		if(empty($user)){return array('rez'=>0, 'ans'=>'E-mail not found.');}
		if($user['approved']==1){return array('rez'=>0, 'ans'=>'Already approved.');}
		if($data['code']!=$user['code']){return array('rez'=>0, 'ans'=>'Wrong code.');}
		
		$this->Mdb->dbupdate("UPDATE users SET approved=1, code='' WHERE email='".$data['email']."'");
		return array('rez'=>1, 'ans'=>'ok');
	}
	
}///END User