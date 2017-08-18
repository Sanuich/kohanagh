<?php 

namespace Kohana\HTTP;

use Kohana\HTTP as HTTP;


class Exception_304 extends \Kohana\HTTP\Exception_Expected {

	/**
	 * @var   integer    HTTP 304 Not Modified
	 */
	protected $_code = 304;

}
