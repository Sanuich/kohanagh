<?php 

namespace Sanuich;

defined('SYSPATH') or die('No direct access allowed.');

class Bundles {

	protected static $_bundles = array();//['vendor']['bundle'] = 'theme'
	
	public static function auto_load()
	{
		require $path;
		return true;
	}
	
	public static function set($data)
	{
		if(empty($data['vendor']) || empty($data['bundle'])) return false;
		Bundles::$_bundles[$data['vendor']][$data['bundle']] = '';
		if(!empty($data['theme']))  Bundles::$_bundles[$data['vendor']][$data['bundle']] = $data['theme'];
		return true;
	}
	
	public static function clear()
	{
		Bundles::$_bundles = array();
		return true;
	}
	
	public static function remove($data)
	{
		if(empty($data['vendor']) || empty($data['bundle'])) return false;
		if(empty(Bundles::$_bundles[$data['vendor']][$data['bundle']])) return false;
		unset(Bundles::$_bundles[$data['vendor']][$data['bundle']]);
		if(empty(Bundles::$_bundles)) Bundles::$_bundles = array();
		return true;
	}
	
	public static function get_theme($data)
	{
		if(empty($data['vendor']) || empty($data['bundle'])) return false;
		return Bundles::$_bundles[$data['vendor']][$data['bundle']];
	}
	
	public static function read_routes()
	{
		foreach(Bundles::$_bundles as $vname=>$vendor)
			foreach($vendor as $bname=>$bundle)
			{
				if(file_exists(BUNDLESPATH.$vname."/".$bname."/".'bootstrap'.EXT))
					require BUNDLESPATH.$vname."/".$bname."/".'bootstrap'.EXT;
				if(!empty(Bundles::$_bundles[$vname][$bname]))
					if(file_exists(BUNDLESPATH.$vname."/".$bname."/themes/".Bundles::$_bundles[$vname][$bname]."/".'bootstrap'.EXT))
						require BUNDLESPATH.$vname."/".$bname."/themes/".Bundles::$_bundles[$vname][$bname]."/".'bootstrap'.EXT;
			}
	}

	public function __construct($config = array())
	{
		return true;
	}

} // End Bundles
