<?php

namespace Sanuich\Auth\Controller;

use \Kohana\Model as KohanaModel;
use \Kohana\View as KohanaView;

class Ajax extends Ajaxo {
	
	public function action_logout()
	{
		$Muser = KohanaModel::factory('Sanuich\Auth\Model\User');
		$Muser->logout();
		echo json_encode(array('res'=>1, 'ans'=>'ok')); 
		return false;
	}
	
	public function action_login()
	{
		if(!empty($_POST['iCheck'])) $_SESSION['remember_me'] = true;

		$Muser = KohanaModel::factory('Sanuich\Auth\Model\User');
		echo json_encode($Muser->login($_POST));
		return false;
	}

	public function action_register()
	{
		$CaptchaTools = KohanaModel::factory('Sanuich\Captcha\Model\tools');
		if(empty($_POST['captcha']) || empty($_POST['code']) || empty($_SESSION['captcha']) || $_POST['captcha']!=$_SESSION['captcha'] || $_POST['captcha'] !== $CaptchaTools->dsCrypt($_POST['code'],1))
		{	
			echo json_encode(array('res'=>0, 'ans'=>'captcha error')); 
			return false;
		}

		if(empty($_POST['pass']) || empty($_POST['pass2'])) 
		{
			$data['error'][] = 'Input passwords';
		}
		else if($_POST['pass']!=$_POST['pass2']) $data['error'][] = 'Passwords not match';

		if(empty($data['error'])) 
		{
			$res = $this->Muser->register($_POST);
			if(empty($res['rez'])) $data['error'][] = $res['ans'];
			else 
			{
				//send email, redirect registered
				$body="Success registration as ".$this-domain."\nlogin:".$_POST['email']."\nPassword:".$_POST['pass']."\n
				To finish registration process, approve your meaning by following this link:\n
				".$_SERVER['SERVER_NAME']."/approve?email=".$_POST['email']."&code=".$res['code']."\n
				If it wasn't you just ignore this message";
				$this->Mmail->ToUserSend($_POST['email'], $nfrom='SteroidWiki', 'registraion', $body);
				$_SESSION['accepted'] = 1;
				$this->redir("http://".$this->domain."/registration_accepted");
				return true;
			}
		}			
	}

	public function action_restore()
	{
		$restore_error="";
		if(empty($_POST['email'])) {echo json_encode(array('res'=>0, 'ans'=>'empty data'));  return false;}
		$Muser = KohanaModel::factory('Sanuich\Auth\Model\User');
		$restore = $Muser->set_restore($_POST['email']);
		echo json_encode($restore);  
		return false;
	}
	
	public function action_reset()
	{
		if(empty($_POST['email']) || empty($_POST['code'])) {
			echo json_encode(array('res'=>0, 'ans'=>'no data'));
			return false;}
			
		if(!$this->Mtools->ValidEmail($_POST['email'])){
			echo json_encode(array('res'=>1, 'ans'=>'Invalid E-mail'));
			return false;
			}

		$Mdb = KohanaModel::factory('Sanuich\Database\Model\DB');
		$user = $Mdb->dbrow("SELECT * FROM users WHERE email='".$_POST['email']."'");
		if(empty($user)){echo json_encode(array('res'=>0, 'ans'=>'E-mail not found')); return false;}
		
		$q = "SELECT * FROM users WHERE id='".$user['id']."' AND code='".$_POST['code']."'";

		$user = $Mdb->dbrow($q);
		if(empty($user)){echo json_encode(array('res'=>0, 'ans'=>'resert failed')); return false;}

		$Muser = KohanaModel::factory('Sanuich\Auth\Model\User');
		$reset = $Muser->reset_pass($_POST);
			
		echo json_encode($reset);
		return false;
	}
	
	public function action_approve()
	{
		if(empty($_POST['email']) || empty($_POST['code'])) {
			echo json_encode(array('res'=>0, 'ans'=>'empty data'));
			return false;}
		
		$Mtools = KohanaModel::factory('Model\Tools');	
		if(!$Mtools->ValidEmail($_POST['email'])){
			echo json_encode(array('res'=>0, 'ans'=>'Invalid E-mail'));
			return false;
			}
		
		$Muser = KohanaModel::factory('Sanuich\Auth\Model\User');
		$approve = $Muser->approve($_POST);
		echo json_encode($approve);
		return false;}
	}
	
	public function action_logout()
	{
		$Muser = KohanaModel::factory('Sanuich\Auth\Model\User');
		echo json_encode($Muser->logout());		
		return false;
	}
}
