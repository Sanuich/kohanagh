<?php 

namespace Kohana\HTTP\Exception;

use Kohana\HTTP as HTTP;


class Exception_413 extends \Kohana\HTTP\Exception {

	/**
	 * @var   integer    HTTP 413 Request Entity Too Large
	 */
	protected $_code = 413;

}
