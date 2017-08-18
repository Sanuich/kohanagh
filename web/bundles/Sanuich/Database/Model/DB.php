<?php

namespace Sanuich\Database\Model;

use Kohana\DB as KDB;
use Kohana\Model as Model;
use Kohana\Database as Database;


class DB extends Model 
{
	/////
	public function dbselect($q = "")
	{
		return KDB::query(Database::SELECT, $q)->execute()->as_array();
	}
	
	public function dbinsert($q = "")
	{
		return KDB::query(Database::INSERT, $q)->execute();
	}
	
	public function dbdelete($q = "")
	{		
		return KDB::query(Database::DELETE, $q)->execute();
	}
	
	public function dbupdate($q = "")
	{		
		return KDB::query(Database::UPDATE, $q)->execute();
	}
	
	public function dbinsert_data($tbl="", $data = array(), $replace=false)
	{
		if(count($data)>0)
		{
			foreach($data as $key=>$val){
				if(gettype($val)=="string") $data[$key] = "'".addslashes($val)."'";
				if(gettype($val)=="array" || gettype($val)=="object" || gettype($val)=="resource") unset($data[$key]); 
			}
			
			$qrows = implode(",",array_keys($data));
			$qvalues = implode(",",$data);
			
			if($replace) $q="REPLACE INTO ";
			else $q = "INSERT INTO ";
			$q .= $tbl." (".$qrows.") VALUES (".$qvalues.")";
			list($insert_id, $affected_rows) = $this->dbinsert($q);
			return $insert_id;
		}
		else return false;
	}
	
	public function dbreplace_data($tbl="", $data = array())
	{
		$this->dbinsert_data($tbl, $data, true);
	}
	
	public function dbunassoc($a = array())//turn assoc array to number index array
	{
		$arez = array();
		foreach($a as $i=>$j)
		{
			$arez[$i] = array();
			foreach($j as $val) $arez[$i][] = $val;
		}
		return $arez;
	}
	
	public function dbnonassocselect($q="")//select from DB to number index array
	{
		$rez = $this->dbselect($q);
		return $this->dbunassoc($rez);
	}
	
	public function dbtoonecolarray($a = array())//turn firs col of assoc array to one dimentional nonassoc array
	{
		$arez = array();
		foreach($a as $i=>$j)
		{
			$arez[] = $j[0];
		}
		return $arez;
	}
	
	public function dbonecolnonassocselect($q="")//select from DB to one dimentional nonassoc array
	{
		$rez = $this->dbnonassocselect($q);
		return $this->dbtoonecolarray($rez);
	}
	
	public function get_table($tbl_name="")
	{
		if(!empty($tbl_name)) return KDB::query(Database::SELECT, "SELECT * FROM ".$tbl_name)->execute()->as_array();
		else array();
	}
	
	public function dbidselect($q = "")//select array, set name ofeach record with id field
	{
		$result = $this->dbselect($q);
		if(count($result)>0 && isset($result[0]['id']))
		{
			$result2 = array();
			foreach($result as $res)
			{
				$row = $res;
				unset($row['id']);
				$result2[$res['id']] = $row;
			}
			return $result2;			
		}
		else return false;
	}
	
	public function db_table_id_select($tbl_name = "")//select table, set name ofeach record with id field
	{
		$result = $this->get_table($tbl_name);
		if(count($result)>0 && isset($result[0]['id']))
		{
			$result2 = array();
			foreach($result as $res)
			{
				$row = $res;
				unset($row['id']);
				$result2[$res['id']] = $row;
			}
			return $result2;			
		}
		else return false;
	}
	
	public function dbrow($q = "")
	{
		$row = $this->dbselect($q);
		if(count($row)>0) return $row[0];
		else return false;
	}
	
	public function dbval($tbl = "", $val = "", $id = 0)
	{
		$q = "SELECT ".$val." FROM ".$tbl." WHERE id=".addslashes(strip_tags($id));
		$v = $this->dbrow($q);
		if(!empty($v[$val]))
		{
			return $v[$val];
		}
		else return false;
	}
	
	public function db_col($tbl="", $col="")//SELECT field col from Table tbl as assoc array marked by ID 
	///field in query
	{
		$res = array();
		$data = KDB::query(Database::SELECT, "SELECT id,".$col." as `val` FROM ".$tbl)->execute()->as_array();
		foreach($data as $key=>$val)
			$res[$val['id']] = $val['val'];
		return $res;
	}
	
	public function dbupdate_data($tbl = "", $data = array(), $key="id")
	{
		if(isset($data[$key]) && count($data)>1)
		{
			$set_data = $data;
			unset($set_data[$key]);
			foreach($set_data as $id=>$val){				
				if(gettype($val)=="array" || gettype($val)=="object" || gettype($val)=="resource") unset($set_data[$key]);
				else{
					if(gettype($val)=="string" && $val!=='now()')	
						$set_data[$id] = $id."='".addslashes($val)."'";
					else $set_data[$id] = $id."=".$val;
				}
			}
			$qset = "SET ".implode(",",$set_data);
			
			$q = "UPDATE ".$tbl." ".$qset." WHERE ".$key."='".addslashes(strip_tags($data[$key]))."';";
			$this->dbupdate($q);
			return true;
		}
		else return false;
	}
	
	//public function dbexecute($type="INSERT");

	
}///END Db