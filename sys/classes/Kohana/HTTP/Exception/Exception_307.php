<?php 

namespace Kohana\HTTP\Exception;

use Kohana\HTTP as HTTP;


class Exception_307 extends \Kohana\HTTP\Exception\Redirect {

	/**
	 * @var   integer    HTTP 307 Temporary Redirect
	 */
	protected $_code = 307;

}
