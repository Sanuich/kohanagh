<?php 

namespace Kohana\HTTP\Exception;

use Kohana\HTTP as HTTP;


class Exception_407 extends \Kohana\HTTP\Exception {

	/**
	 * @var   integer    HTTP 407 Proxy Authentication Required
	 */
	protected $_code = 407;

}
