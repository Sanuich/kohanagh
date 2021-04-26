<?php

namespace Sanuich\Auth\Controller;

use \Kohana\Controller as KohanaController;
use \Kohana\Model as KohanaModel;
use \Kohana\View as KohanaView;

class Autho extends KohanaController\Template {

	public $auto_render = false;
	
	public $Muser;
	public $user = 0;
	public $domain = "";
	public $assets = "/bundles/Sanuich/Auth/assets";
	public $namespace = "Sanuich/Auth";

	public function before()
	{
        parent::before();
        session_start();
		header('Content-type: text/html; charset=utf-8');
		///
		$this->domain=$_SERVER['SERVER_NAME'];
		$this->uri = $_SERVER['REQUEST_URI'];
		$url = explode("?", $this->uri);
		$this->url = $url[0];
		$this->Mdb = KohanaModel::factory('Sanuich\Database\Model\DB');
		
		$this->Muser = KohanaModel::factory('Sanuich\Auth\Model\User');
		
		///AUTH
		$this->user = $this->Muser->auth();
		
		///TEMPLATE
		$this->template = '/'.$this->namespace.'/Views/template';		
		$this->template = KohanaView::factory($this->template);
		
		$this->template->title = "AUTH";
		$this->template->assets = $this->assets;
								  
	}
	
	public function after()
	{
		parent::after();
	
		$this->response->body($this->template->render());
	}
    

}