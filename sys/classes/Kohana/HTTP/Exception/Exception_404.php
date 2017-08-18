<?php 

namespace Kohana\HTTP\Exception;


class Exception_404 extends \Kohana\HTTP\Exception {

	/**
	 * @var   integer    HTTP 404 Not Found
	 */
	protected $_code = 404;

}
