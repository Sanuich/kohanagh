<?php

use Kohana\Core as Kohana;

if ( ! class_exists('\Kohana\Core'))
{
	die('Please include the kohana bootstrap file (see README.markdown)');
}

if ($file = Kohana::find_file('classes', 'Unittest/Tests'))
{
	require_once $file;

	// PHPUnit requires a test suite class to be in this file,
	// so we create a faux one that uses the kohana base
	class TestSuite extends \Kohana\Unittest\Tests
	{}
}
else
{
	die('Could not include the test suite');
}
