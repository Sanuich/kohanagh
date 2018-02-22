<?php 

namespace Kohana\HTTP\Exception;

use Kohana\HTTP as HTTP;


class Exception_301 extends \Kohana\HTTP\Exception\Redirect {

	/**
	 * @var   integer    HTTP 301 Moved Permanently
	 */
	protected $_code = 301;

}
