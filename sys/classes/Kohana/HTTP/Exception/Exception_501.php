<?php 

namespace Kohana\HTTP;

use Kohana\HTTP as HTTP;


class Exception_501 extends \Kohana\HTTP\Exception {

	/**
	 * @var   integer    HTTP 501 Not Implemented
	 */
	protected $_code = 501;

}
