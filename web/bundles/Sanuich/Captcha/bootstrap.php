<?php
 
use Sanuich\Bundles as Bundles;

use Kohana\Route as Route;

Bundles::set(array('vendor'=>'Sanuich','bundle'=>'Captcha','theme'=>''));

$vendor = "Sanuich";
$bundle = "Captcha";

/////////////////CAPTCHA 
Route::set($vendor."/".$bundle.'/images/captcha', $vendor."/".$bundle.'/captcha/image')
	->defaults(array(
		'controller' => $vendor."\\".$bundle.'\Controller\Captcha',
		'action'     => 'captcha_image',
	));

Route::set($vendor."/".$bundle.'/images/captcha_check', $vendor."/".$bundle.'/captcha/check')
	->defaults(array(
		'controller' => $vendor."\\".$bundle.'\Controller\Captcha',
		'action'     => 'captcha_check',
	));	
?>