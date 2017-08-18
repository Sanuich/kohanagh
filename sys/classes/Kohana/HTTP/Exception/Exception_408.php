<?php 

namespace Kohana\HTTP;

use Kohana\HTTP as HTTP;


class Exception_408 extends \Kohana\HTTP\Exception {

	/**
	 * @var   integer    HTTP 408 Request Timeout
	 */
	protected $_code = 408;

}
