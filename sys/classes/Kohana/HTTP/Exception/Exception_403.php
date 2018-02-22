<?php 

namespace Kohana\HTTP\Exception;

use Kohana\HTTP as HTTP;


class Exception_403 extends \Kohana\HTTP\Exception {

	/**
	 * @var   integer    HTTP 403 Forbidden
	 */
	protected $_code = 403;

}
