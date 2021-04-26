<?php 

namespace Sanuich\Captcha\Controller;

use \Kohana\View as KohanaView;
use \Kohana\Request as KohanaRequest;
use \Kohana\Controller as KohanaController;
use \Kohana\Model as KohanaModel;


class Modules extends KohanaController {

	public function before()
	{
        parent::before();
        session_start();
		///
		//$this->Mtools = KohanaModel::factory('\Sanuich\Captcha\Model\tools');		
	}
	
	public function action_get()
	{
		
	}
}