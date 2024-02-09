<?php

use Sanuich\Bundles as Bundles;
use Kohana\Core as Kohana;
use Kohana\I18n as I18n;
use Kohana\HTTP as HTTP;
use Kohana\Route as Route;
use Kohana\Cookie as Cookie;
use Kohana\Log as Log;
use Kohana\Config as Config;


// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT))
{
	// Application extends the core
	//require APPPATH.'classes/Kohana'.EXT;
}
else
{
	// Load empty core extension
	//require SYSPATH.'classes/Kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('America/Chicago');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('\Kohana\Core', 'auto_load'));

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

/**
 * Enable composer autoload libraries
 */
if (is_file(DOCROOT.'/vendor/autoload.php'))
{
	require DOCROOT.'/vendor/autoload.php';
}

/**
 * Set the mb_substitute_character to "none"
 *
 * @link http://www.php.net/manual/function.mb-substitute-character.php
 */
mb_substitute_character('none');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

if (isset($_SERVER['SERVER_PROTOCOL']))
{
	// Replace the default protocol.
	HTTP::$protocol = $_SERVER['SERVER_PROTOCOL'];
}

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
	'base_url'   => '/',
	'index_file'	=> false
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log\File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config\File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	// 'encrypt'    => MODPATH.'Kohana/encrypt',    // Encryption supprt
	 'auth'       => MODPATH.'Kohana/auth',       // Basic authentication
	 'cache'      => MODPATH.'Kohana/cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'Kohana/codebench',  // Benchmarking tool
	 'database'   => MODPATH.'Kohana/database',   // Database access
	// 'image'      => MODPATH.'Kohana/image',      // Image manipulation
	// 'minion'     => MODPATH.'Kohana/minion',     // CLI Tasks
	 'orm'        => MODPATH.'Kohana/orm',        // Object Relationship Mapping
	'pagination' => MODPATH.'Kohana/pagination', // Pagination
	// 'unittest'   => MODPATH.'Kohana/unittest',   // Unit testing
	'userguide'  => MODPATH.'Kohana/userguide',  // User guide and API documentation
	'Bundles'		=> MODPATH.'Sanuich/Bundles',	//Bundles manager
	));
	
//Cache::$default = 'memcache';

//sanuich Bundles
/*
Bundles
*/
Bundles::set(array('vendor'=>'Sanuich','bundle'=>'Database'));
Bundles::set(array('vendor'=>'Sanuich','bundle'=>'AjaxControls'));
Bundles::set(array('vendor'=>'Sanuich','bundle'=>'Captcha'));
Bundles::set(array('vendor'=>'Sanuich','bundle'=>'Auth'));

Bundles::read_routes();

/**
 * Cookie Salt
 * @see  http://kohanaframework.org/3.3/guide/kohana/cookies
 * 
 * If you have not defined a cookie salt in your Cookie class then
 * uncomment the line below and define a preferrably long salt.
 */
Cookie::$salt = 'aeseryrtyrg34utjesngmdg';

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 controllers of default application load from
 classes folder but Controller folder must be pointed here
 */
 
Route::set('home', '')
	->defaults(array(
		'controller' => 'Controller\Welcome',
		'action'     => 'index',
	));
 
/*
Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'Controller\Welcome',
		'action'     => 'index',
	));
*/