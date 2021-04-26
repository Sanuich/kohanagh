<?php

namespace Sanuich\Auth\Controller;

use \Kohana\Controller as KohanaController;
use \Kohana\Model as KohanaModel;
use \Kohana\View as KohanaView;

class Ajaxo extends KohanaController {

	public function before()
	{
        parent::before();
        //if isset SID
        if(isset($_POST['email']) && isset($_POST['']))
        {
        ////if session exists - set SID

        }else{
        ////else restrict
        }
        session_start();
		header('Content-type: text/html; charset=utf-8');									  
	}
	
	public function after()
	{
		parent::after();
	}
    

}