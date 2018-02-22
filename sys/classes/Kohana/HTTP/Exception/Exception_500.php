<?php 

namespace Kohana\HTTP\Exception;

use Kohana\HTTP as HTTP;


class Exception_500 extends \Kohana\HTTP\Exception {

	/**
	 * @var   integer    HTTP 500 Internal Server Error
	 */
	protected $_code = 500;

}
