<?php 

namespace Kohana\HTTP;

use Kohana\HTTP as HTTP;


class Exception_503 extends \Kohana\HTTP\Exception {

	/**
	 * @var   integer    HTTP 503 Service Unavailable
	 */
	protected $_code = 503;

}
