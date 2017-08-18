<?php

namespace Sanuich\AjaxControls\Model;

use Kohana\Model as KohanaModel;


class Fills extends KohanaModel {
    
	public function bye($data=array())
	{
		$rez = array(0=>array('id'=>'1','msg'=>"hello!"));
		return $rez;
	}
	
	public function get_names($data=array())
	{
		return array(
		0=>array('id'=>'0','name'=>'alex'),
		1=>array('id'=>'1','name'=>'bob'),
		2=>array('id'=>'2','name'=>'tod')
		);
	}

} // End Model_Fills
