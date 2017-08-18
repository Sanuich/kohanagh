<?php

namespace Kohana\Minion\Exception;

/**
 * Invalid Task Exception
 *
 * @package    Kohana
 * @category   Minion
 * @author     Kohana Team
 * @copyright  (c) 2009-2011 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class InvalidTask extends \Kohana\Minion\Exception {

	public function format_for_cli()
	{
		return 'ERROR: '. $this->getMessage().PHP_EOL;
	}

}
