<?php 

namespace Kohana\HTTP\Exception;

use Kohana\HTTP as HTTP;


class Exception_504 extends \Kohana\HTTP\Exception {

	/**
	 * @var   integer    HTTP 504 Gateway Timeout
	 */
	protected $_code = 504;

}
