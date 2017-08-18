<?php 

namespace Kohana\HTTP;

use Kohana\HTTP as HTTP;


class Exception_411 extends \Kohana\HTTP\Exception {

	/**
	 * @var   integer    HTTP 411 Length Required
	 */
	protected $_code = 411;

}
