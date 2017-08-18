<?php 

namespace Kohana\HTTP;

use Kohana\HTTP as HTTP;


class Exception_303 extends \Kohana\HTTP\Exception\Redirect {

	/**
	 * @var   integer    HTTP 303 See Other
	 */
	protected $_code = 303;

}
