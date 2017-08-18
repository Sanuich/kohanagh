<?php 

namespace Kohana\HTTP;

use Kohana\HTTP as HTTP;


class Exception_400 extends \Kohana\HTTP\Exception {

	/**
	 * @var   integer    HTTP 400 Bad Request
	 */
	protected $_code = 400;

}
