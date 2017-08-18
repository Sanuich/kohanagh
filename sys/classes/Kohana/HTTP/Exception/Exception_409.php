<?php 

namespace Kohana\HTTP;

use Kohana\HTTP as HTTP;


class Exception_409 extends \Kohana\HTTP\Exception {

	/**
	 * @var   integer    HTTP 409 Conflict
	 */
	protected $_code = 409;

}
