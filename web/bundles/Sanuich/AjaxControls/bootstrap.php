<?php 

use Sanuich\Bundles as Bundles;

use Kohana\Route as Route;

Bundles::set(array('vendor'=>'Sanuich','bundle'=>'AjaxControls','theme'=>''));

$vendor = "Sanuich";
$bundle = "AjaxControls";
/////CONTROLS
Route::set($vendor."/".$bundle."/".'fill_divs', $vendor."/".$bundle."/".'fill_divs')
	->defaults(array(
            'controller' => $vendor."\\".$bundle.'\Controller\Controls',
            'action'     => 'filldivs',
	));
	
Route::set($vendor."/".$bundle."/".'fill_table', $vendor."/".$bundle."/".'fill_table')
	->defaults(array(
            'controller' => $vendor."\\".$bundle.'\Controller\Controls',
            'action'     => 'filltable',
	));

Route::set($vendor."/".$bundle."/".'fill_options', $vendor."/".$bundle."/".'fill_options')
	->defaults(array(
            'controller' => $vendor."\\".$bundle.'\Controller\Controls',
            'action'     => 'filloptions',
	));

Route::set($vendor."/".$bundle."/".'get_data', $vendor."/".$bundle."/".'get_data')
	->defaults(array(
            'controller' => $vendor."\\".$bundle.'\Controller\Controls',
            'action'     => 'getdata',
	));
?>