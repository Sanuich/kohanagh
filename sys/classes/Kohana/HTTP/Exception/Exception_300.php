<?php 

namespace Kohana\HTTP\Exception;

use Kohana\HTTP as HTTP;


class Exception_300 extends \Kohana\HTTP\Exception\Redirect {

	/**
	 * @var   integer    HTTP 300 Multiple Choices
	 */
	protected $_code = 300;

}
