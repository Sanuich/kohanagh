<?php 

namespace Kohana\HTTP\Exception;

use Kohana\HTTP as HTTP;


class Exception_405 extends \Kohana\HTTP\Exception_Expected {

	/**
	 * @var   integer    HTTP 405 Method Not Allowed
	 */
	protected $_code = 405;

	/**
	 * Specifies the list of allowed HTTP methods
	 *
	 * @param  array $methods List of allowed methods
	 */
	public function allowed($methods)
	{
		if (is_array($methods))
		{
			$methods = implode(',', $methods);
		}

		$this->headers('allow', $methods);

		return $this;
	}

	/**
	 * Validate this exception contains everything needed to continue.
	 *
	 * @throws Kohana_Exception
	 * @return bool
	 */
	public function check()
	{
		if ($location = $this->headers('allow') === NULL)
			throw new Kohana_Exception('A list of allowed methods must be specified');

		return TRUE;
	}

}
