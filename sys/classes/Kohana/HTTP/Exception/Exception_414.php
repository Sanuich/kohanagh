<?php 

namespace Kohana\HTTP;

use Kohana\HTTP as HTTP;


class Exception_414 extends \Kohana\HTTP\Exception {

	/**
	 * @var   integer    HTTP 414 Request-URI Too Long
	 */
	protected $_code = 414;

}
