<?php

namespace Sanuich\AjaxControls\Controller;

use \Kohana\Controller as KohanaController;
use \Kohana\Model as KohanaModel;
use \Kohana\View as KohanaView;

class Controls extends KohanaController {

	public $fills;

	public function before()
	{
		parent::before();    
		session_start();
		header('Content-type: text/html; charset=utf-8');

		$this->fills = KohanaModel::factory('\Sanuich\AjaxControls\Model\fills');
	}
	
	public function action_getdata()
	{   
		$cond = (!empty($_POST['cond'])) ? $_POST['cond'] : array();
		$list = $this->fills->{$_POST['query']}($cond);
		if(empty($list)) {echo ""; return false;}
		echo $list[0][$_POST['field_name']];
		return true;
	}
    
    public function action_filloptions()
	{
		$cond = (!empty($_POST['cond'])) ? $_POST['cond'] : array();
		$list = $this->fills->{$_POST['query']}($cond);
		if(empty($list)) {echo ""; return false;}
		$data = array();
		$data['list'] = $list;
		$data['name'] = $_POST['name'];
		$data['selected'] = $_POST['selected'];
		$data['all'] = $_POST['all'];
		$options = KohanaView::factory('Sanuich/AjaxControls/Views/options', $data);
		echo $options;
    }
    
    public function action_filldivs()
	{
		$cond = (!empty($_POST['cond'])) ? $_POST['cond'] : array();
		$list = $this->fills->{$_POST['query']}($cond);
		if(empty($list)) {echo ""; return false;}
		$data = array();
		$data['list'] = $list;
		$data['name'] = (!empty($_POST['name'])) ? $_POST['name'] : '';
		$data['clas'] = (!empty($_POST['clas'])) ? $_POST['clas'] : '';
		$data['click'] = (!empty($_POST['click'])) ? $_POST['click'] : '';
		echo KohanaView::factory('Sanuich/AjaxControls/Views/divs', $data);
		return true;
    }
    
    public function action_filltable()
	{
		$cond = (!empty($_POST['cond'])) ? $_POST['cond'] : array();
		$list = $this->fills->{$_POST['query']}($cond);
		if(empty($list)) {echo ""; return false;}
		$data = array();
		$data['list'] = $list;
		$data['name'] = (!empty($_POST['name'])) ? $_POST['name'] : 'table';
		$data['id'] = (!empty($_POST['id'])) ? 1 : false;;
		$data['options'] = (!empty($_POST['options'])) ? 1 : false;
		$data['head'] =  (!empty($_POST['head'])) ? 1 : false;
		$data['name_function'] = $_POST['name_function'];
		/*$data['page'] = $_POST['page'];
		$data['perpage'] = $_POST['perpage'];*/
		echo KohanaView::factory('Sanuich/AjaxControls/Views/table_cells' ,$data);    
    }   

}