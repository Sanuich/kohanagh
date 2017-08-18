<?php 

namespace Kohana;

/**
 * Model base class. All models should extend this class.
 *
 * @package    Kohana
 * @category   Models
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Model {

	/**
	 * Create a new model instance.
	 *
	 *     $model = Model::factory($name);
	 *
	 * @param   string  $name   model name
	 * @return  Model
	 sanuich bundles
	 no need to add prefix for model name
	 user must point as a namespace
	 */
	public static function factory($name)
	{
		return new $name;
	}

}
