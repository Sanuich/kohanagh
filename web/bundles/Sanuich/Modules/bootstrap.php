<?php
 
use Sanuich\Bundles as Bundles;

use Kohana\Route as Route;

Bundles::set(array('vendor'=>'Sanuich','bundle'=>'Modules','theme'=>''));

$vendor = "Sanuich";
$bundle = "Modules";

/////////////////CAPTCHA 
Route::set($vendor."/".$bundle.'/API', 'RESTAPI/<action>')
	->defaults(array(
		'controller' => $vendor."\\".$bundle.'\Controller\Modules',
		'action'     => 'get',
	));	
?>