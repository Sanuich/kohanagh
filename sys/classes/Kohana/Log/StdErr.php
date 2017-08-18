<?php 

namespace Kohana\Log;

/**
 * STDERR log writer. Writes out messages to STDERR.
 *
 * @package    Kohana
 * @category   Logging
 * @author     Kohana Team
 * @copyright  (c) 2008-2014 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class StdErr extends \Log\Writer {
	/**
	 * Writes each of the messages to STDERR.
	 *
	 *     $writer->write($messages);
	 *
	 * @param   array   $messages
	 * @return  void
	 */
	public function write(array $messages)
	{
		foreach ($messages as $message)
		{
			// Writes out each message
			fwrite(STDERR, $this->format_message($message).PHP_EOL);
		}
	}

}
