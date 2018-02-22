<?php 

namespace Kohana\HTTP\Exception;

use Kohana\HTTP as HTTP;


class Exception_415 extends \Kohana\HTTP\Exception {

	/**
	 * @var   integer    HTTP 415 Unsupported Media Type
	 */
	protected $_code = 415;

}
