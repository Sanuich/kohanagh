<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'alternate' => array
	(
		'type'       => 'mysql',
		'connection' => array(
			/**
			 * The following options are available for MySQL:
			 *
			 * string   hostname     server hostname, or socket
			 * string   database     database name
			 * string   username     database username
			 * string   password     database password
			 * boolean  persistent   use persistent connections?
			 * array    variables    system variables as "key => value" pairs
			 *
			 * Ports and sockets may be appended to the hostname.
			 */
			'hostname'   => 'localhost',
			'database'   => 'info',
			'username'   => ($_SERVER['REMOTE_ADDR']=='127.0.0.1')?'root':'',
			'password'   => ($_SERVER['REMOTE_ADDR']=='127.0.0.1')?'':'',
			'persistent' => FALSE,
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	),
	'default' => array(
		'type'       => 'pdo',
		'connection' => array(
			/**
			 * The following options are available for PDO:
			 *
			 * string   dsn         Data Source Name
			 * string   username    database username
			 * string   password    database password
			 * boolean  persistent  use persistent connections?
			 */
			'dsn'        => 'mysql:host=localhost;dbname=info',
			'username'   => ($_SERVER['REMOTE_ADDR']=='127.0.0.1')?'root':'',
			'password'   => ($_SERVER['REMOTE_ADDR']=='127.0.0.1')?'':'',
			'persistent' => FALSE,
			'options'    => array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'),
		),
		/**
		 * The following extra options are available for PDO:
		 *
		 * string   identifier  set the escaping identifier
		 */
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	),
);