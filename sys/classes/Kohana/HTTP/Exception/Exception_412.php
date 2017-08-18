<?php 

namespace Kohana\HTTP;

use Kohana\HTTP as HTTP;


class Exception_412 extends \Kohana\HTTP\Exception {

	/**
	 * @var   integer    HTTP 412 Precondition Failed
	 */
	protected $_code = 412;

}
