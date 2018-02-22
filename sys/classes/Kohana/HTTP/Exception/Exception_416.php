<?php 

namespace Kohana\HTTP\Exception;

use Kohana\HTTP as HTTP;


class Exception_416 extends \Kohana\HTTP\Exception {

	/**
	 * @var   integer    HTTP 416 Request Range Not Satisfiable
	 */
	protected $_code = 416;

}
