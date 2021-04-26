<?php

class Sanuich_db {
	private $dbcnx;
	function __construct()
	{
		$db = include('app'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'database.php');

		$dbcnx = mysqli_connect(
			$db['default']['connection']['hostname'],
			$db['default']['connection']['username'],
			$db['default']['connection']['password'],
			$db['default']['connection']['database']
		) or exit('error server');

		mysqli_select_db(
			$dbcnx,
			$db['default']['connection']['database']			
		) or exit('error DB');

		mysqli_set_charset($dbcnx, 'utf8');

		$this->dbcnx = $dbcnx;

	}
	
	function get_array($query){
		$result = mysqli_query($this->dbcnx, $query) or exit('error operation '.$query);

		$row=array();
		$num_results = mysqli_num_rows($result) ;
		for ($i=0; $i <$num_results; $i++)
			$row[$i] = mysqli_fetch_array($result);

		return $row;
	}
	
	function insert($query)
	{
		$rez = mysqli_query($this->dbcnx, $query); 
		
		if($rez!=false)
		{
			$newid = mysqli_insert_id($this->dbcnx);
			return $newid;
		}
		else exit('error operation '.$query);
	}
		
	function __destruct(){
		mysqli_close($this->dbcnx);}
}



function get_array($query){
	global $san_db;
	return $san_db->get_array($query);
}
function insert($query){
	global $san_db;
	return $san_db->insert($query);
}

global $san_db;
$san_db = new Sanuich_db;