<?php

namespace Controller;

use Kohana\Controller\Template as Template;
use Kohana\Exception as Exception;

/**
 * Codebench — A benchmarking module.
 *
 * @package    Kohana/Codebench
 * @category   Controllers
 * @author     Kohana Team
 * @copyright  (c) 2009 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Codebench extends Template {

	// The codebench view
	public $template = 'views/codebench';

	public function action_index()
	{
		$class = $this->request->param('class');

		// Convert submitted class name to URI segment
		if (isset($_POST['class']))
		{
			throw Exception::factory(302)->location('codebench/'.trim($_POST['class']));
		}

		// Pass the class name on to the view
		$this->template->class = (string) $class;

		// Try to load the class, then run it
		if (Kohana::auto_load($class) === TRUE)
		{
			$codebench = new $class;
			$this->template->codebench = $codebench->run();
		}
	}
}
