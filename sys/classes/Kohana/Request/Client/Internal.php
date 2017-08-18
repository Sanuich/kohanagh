<?php 

namespace Kohana\Request\Client;

use Kohana\Core as Kohana;
use Kohana\Exception as Exception;
use Kohana\Response as Response;
use Kohana\Request as Request;
use Kohana\HTTP as HTTP;
use Kohana\Profiler as Profiler;

/**
 * Request Client for internal execution
 *
 * @package    Kohana
 * @category   Base
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 * @since      3.1.0
 */
class Internal extends Request\Client {

	/**
	 * @var    array
	 */
	protected $_previous_environment;

	/**
	 * Processes the request, executing the controller action that handles this
	 * request, determined by the [Route].
	 *
	 *     $request->execute();
	 *
	 * @param   Request $request
	 * @return  Response
	 * @throws  Kohana_Exception
	 * @uses    [Kohana::$profiling]
	 * @uses    [Profiler]
	 //sanuich bundles
	 Controller folder must be pointed in bootstrap file by user
	 so we dont have to add prefix
	 */
	public function execute_request(Request $request, Response $response)
	{
		// Create the class prefix
		//$prefix = 'Controller_';
		$prefix = '';

		// Directory
		$directory = $request->directory();

		// Controller
		$controller = $request->controller();

		if ($directory)
		{
			// Add the directory name to the class prefix
			$prefix .= str_replace(array('\\', DIRECTORY_SEPARATOR), '_', trim($directory, DIRECTORY_SEPARATOR)).'_';
		}
		
		$path = Kohana::split_class_name($controller,"\\","\\");
		$path = $path['path'].$prefix.$path['file'];

		if (Kohana::$profiling)
		{
			// Set the benchmark name
			$benchmark = '"'.$request->uri().'"';

			if ($request !== Request::$initial AND Request::$current)
			{
				// Add the parent request uri
				$benchmark .= ' « "'.Request::$current->uri().'"';
			}

			// Start benchmarking
			$benchmark = Profiler::start('Requests', $benchmark);
		}

		// Store the currently active request
		$previous = Request::$current;

		// Change the current request to this request
		Request::$current = $request;

		// Is this the initial request
		$initial_request = ($request === Request::$initial);

		try
		{
			if ( ! class_exists($path))
			{
				throw HTTP\Exception::factory(404,
					'The requested URL :uri was not found on this server. Class '.$path.' not exists.',
					array(':uri' => $request->uri())
				)->request($request);
			}

			// Load the controller using reflection
			$class = new \ReflectionClass($path);

			if ($class->isAbstract())
			{
				throw new Exception(
					'Cannot create instances of abstract :controller',
					array(':controller' => $path)
				);
			}

			// Create a new instance of the controller
			$controller = $class->newInstance($request, $response);

			// Run the controller's execute() method
			$response = $class->getMethod('execute')->invoke($controller);

			if ( ! $response instanceof Response)
			{
				// Controller failed to return a Response.
				throw new Exception('Controller failed to return a Response');
			}
		}
		catch (HTTP\Exception $e)
		{
			// Store the request context in the Exception
			if ($e->request() === NULL)
			{
				$e->request($request);
			}

			// Get the response via the Exception
			$response = $e->get_response();
		}
		catch (\Exception $e)
		{
			// Generate an appropriate Response object
			$response = Exception::_handler($e);
		}

		// Restore the previous request
		Request::$current = $previous;

		if (isset($benchmark))
		{
			// Stop the benchmark
			Profiler::stop($benchmark);
		}

		// Return the response
		return $response;
	}

}
