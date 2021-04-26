<?php

namespace Sanuich\Auth\Controller;

use \Kohana\Model as KohanaModel;
use \Kohana\View as KohanaView;

class Auth extends Autho {

	public function redir($url="")
	{
		header("Location: ".$url, true, 301);die();return true;
	}
	
	public function action_logout()
	{
		$Muser = KohanaModel::factory('Sanuich\Auth\Model\User');
		$Muser->logout();
		header("Location: /login", true, 301); die(); return true;
	}
	
	public function action_login()
	{
		$this->template->content = KohanaView::factory('/Sanuich/Auth/Views/login');
		return true;
	}
	
	public function action_register()
	{
		$data = array();
		$data['error'] = [];
		
		$CaptchaTools = KohanaModel::factory('Sanuich\Captcha\Model\tools');
		$captcha = $CaptchaTools->generatePassword(6,6);
		$_SESSION['captcha'] = $captcha;
		$code = $CaptchaTools->dsCrypt($captcha);
		$data['captcha_html'] = KohanaView::factory('Sanuich/Captcha/Views/captcha', array('code'=>$code));
		
		$this->template->content = KohanaView::factory($this->namespace.'/Views/register', $data);
		return true;
	}
	
	public function action_accepted()
	{
		if(empty($_SESSION['accepted'])) {$this->redir("http://".$this->domain."/"); return false;}
		$this->template->content = KohanaView::factory($this->namespace.'/Views/accepted');
		unset($_SESSION['accepted']); 
		return true;
	}
	
	public function action_approve_registration()
	{
		if(empty($_GET['code']) || empty($_GET['email'])) {$this->redir("http://".$this->domain."/"); return false;}
		$user = $this->Mdb->dbrow("SELECT * FROM users WHERE email='".addslashes(strip_tags($_GET['email']))."' AND code='".addslashes(strip_tags($_GET['code']))."' AND approved=0");
		if(empty($user)) {$this->redir("http://".$this->domain."/"); return false;}
		$this->Mdb->dbupdate("UPDATE users SET approved=1,code='' WHERE email='".addslashes(strip_tags($_GET['email']))."'");
		//$_SESSION['user'] = $user;
		$this->template->content = KohanaView::factory($this->namespace.'/Views/approved');

		return true;
	}	
	
	public function action_remind()
	{		
		$data = array();
		if(!empty($_POST)){
			$email = addslashes(strip_tags($_POST['email']));
			$user = array();
				$user = $this->Mdb->dbrow("SELECT id FROM users WHERE email='".$email."' AND approved=1");
			
			if(empty($user))
				$data['error'] = "Email not found. OR email not approved.";
			if(!empty($user)){
				$code = md5($this->Mtools->generatePassword(6, 6));
				$this->Mdb->dbupdate("UPDATE users SET code='".$code."' WHERE email='".addslashes(strip_tags($_POST['email']))."'");
				$body="Somebody tried to restore password on a Steroid Wiki website\n
					May be it was you. To complete restoration of password follow this link:\n
					http://".$this->domain."/restoration?email=".$_POST['email']."&code=".$code."\n
					If it wasnt you just ignore this message";
					$this->Mmail->ToUserSend($_POST['email'], $nfrom='SteroidWiki', 'registraion', $body);
				$_SESSION['reminded'] = 1;
				$this->redir("http://".$this->domain."/password_reminded");
				return true;
			}
			
		}
		
		$this->template->content = KohanaView::factory($this->namespace.'/Views/remind', $data);
		return true;
	}

	public function action_reset()
	{
		if(empty($_GET['email']) || empty($_GET['code'])) {
			$this->template->content = "Error";
			return false;}
			
		if(!$this->Mtools->ValidEmail($_GET['email'])){
			$this->template->content = 'Incorrect address.';
			return false;
			}

		$user = $this->Mdb->dbrow("SELECT * FROM social_users WHERE email='".$_GET['email']."'");
		if(empty($user)){$this->template->content = 'E-mail not found.'; return false;}
		
		$q = "SELECT * FROM restores WHERE user='".$user['id']."' AND code='".md5($_GET['code'])."' AND uid>DATE_ADD(NOW(), INTERVAL -1 HOUR)";
		var_dump($q);
		$restore = $this->Mdb->dbrow($q);
		if(empty($restore)){$this->template->content = "Restore record not found."; return false;}
		
		$reset_error = "";
		
		
		$this->template->content = KohanaView::factory('Sanuich/Auth/Views/reset', [ 
		'reset_error'=>$reset_error
		]);
		return true;
	}
	
	public function action_reminded()
	{
		if(empty($_SESSION['reminded'])) {$this->redir("http://".$this->domain."/"); return false;}
		$this->template->content = View::factory('auth/remind_sent');
		unset($_SESSION['reminded']);
		return true;
	}
	
	public function action_input_new_password()
	{		
		if(empty($_GET['code']) || empty($_GET['email'])) {$this->redir("http://".$this->domain."/"); return false;}
		$user = $this->Mdb->dbrow("SELECT * FROM users WHERE email='".addslashes(strip_tags($_GET['email']))."' AND code='".addslashes(strip_tags($_GET['code']))."' AND approved=1");
		if(empty($user)) {$this->redir("http://".$this->domain."/"); return false;}
		$data = array();
		$data['email'] = $_GET['email'];
		if(!empty($_POST)){
			if(empty($_POST['pass']) || empty($_POST['pass2'])) $data['error'] = "input passwords";
			else if($_POST['pass']!=$_POST['pass2']) $data['error'] = "Passwords not match";
			
			if(empty($data['error'])){
				$this->Mdb->dbupdate("UPDATE users SET pass='".md5($_POST['pass'])."' WHERE email='".addslashes(strip_tags($_GET['email']))."'");
				$_SESSION['changed'] = 1;
				$this->redir("http://".$this->domain."/password_changed");
				return true;
			}
			
		}
		
		$this->template->content = KohanaView::factory($this->namespace.'/Views/restoration', $data);
		return true;
	}
	
	public function action_changed()
	{
		if(empty($_SESSION['changed'])) {$this->redir("http://".$this->domain."/"); return false;}
		$this->template->content = KohanaView::factory($this->namespace.'/Views/changed');
		unset($_SESSION['changed']);
		return true;
	}
	
}
