<?php 

namespace Kohana\HTTP;

use Kohana\HTTP as HTTP;


class Exception_502 extends \Kohana\HTTP\Exception {

	/**
	 * @var   integer    HTTP 502 Bad Gateway
	 */
	protected $_code = 502;

}
