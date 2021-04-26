<?php 

use Sanuich\Bundles as Bundles;

use Kohana\Route as Route;

Bundles::set(array('vendor'=>'Sanuich','bundle'=>'Auth','theme'=>''));

$vendor = "Sanuich";
$bundle = "Auth";
	
///auth
Route::set($vendor.'_'.$bundle.'_default_auth', '<action>')
	->defaults(array(
            'controller' => $vendor.'\\'.$bundle.'\Controller\Auth',
            'action'     => 'index',
	));

Route::set($vendor.'_'.$bundle.'_default_ajax', 'authapi/<action>')
	->defaults(array(
            'controller' => $vendor.'\\'.$bundle.'\Controller\Ajax',
            'action'     => 'index',
	));
	
?>