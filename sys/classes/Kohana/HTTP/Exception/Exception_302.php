<?php 

namespace Kohana\HTTP;

use Kohana\HTTP as HTTP;


class Exception_302 extends \Kohana\HTTP\Exception\Redirect {

	/**
	 * @var   integer    HTTP 302 Found
	 */
	protected $_code = 302;

}
