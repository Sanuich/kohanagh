<?php 

namespace Kohana\HTTP;

use Kohana\HTTP as HTTP;


class Exception_410 extends \Kohana\HTTP\Exception {

	/**
	 * @var   integer    HTTP 410 Gone
	 */
	protected $_code = 410;

}
