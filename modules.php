<?php

require 'db.php';

$e = get_array("SHOW TABLES LIKE 'users'");

if(empty($e))
{
	echo "Table users not exists\n";
	$e = insert("CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `uid` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `password` text NOT NULL,
  `skey` text NOT NULL,
  `code` text NOT NULL,
  `last_login` timestamp NOT NULL,
  `last_ip` tinytext NOT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT 0,
  `approved` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

	$e = insert("ALTER TABLE `users` ADD PRIMARY KEY (`id`);");

	$e = insert("ALTER TABLE `users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
	
	$e = insert("COMMIT;");
	
	echo "Created\n";
	
	echo "input admin name[admin]:";
	$aname = trim( fgets(STDIN) );
	if(empty($aname)) $aname= 'admin';
	
	echo "\ninput admin email[admin@email.com]:";
	$aemail = trim( fgets(STDIN) );
	if(empty($aemail)) $aemail= 'admin@email.com';
	
	echo "\ninput admin password[12345678]:";
	$apass = trim( fgets(STDIN) );
	if(empty($apass)) $apass= '12345678';
	
	$e = insert("INSERT INTO users (name,email,password,admin,approved) VALUES ('".$aname."','".$aemail."',MD5('".$apass."'),1,1)");
	
	echo "Created\n";
	
}
else
{
	echo "Table users exists\n";
}

$e = get_array("SHOW TABLES LIKE 'groups'");

if(empty($e))
{
	echo "Table groups not exists\n";
	$e = insert("CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

	$e = insert("ALTER TABLE `groups` ADD PRIMARY KEY (`id`);");

	$e = insert("ALTER TABLE `groups` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
	
	$e = insert("COMMIT;");
	
	echo "Created\n";
}
else
{
	echo "Table groups exists\n";
}

$e = get_array("SHOW TABLES LIKE 'permissions'");

if(empty($e))
{
	echo "Table permissions not exists\n";
	$e = insert("CREATE TABLE `permissions` (
  `group_id` int(11) NOT NULL,
  `module` varchar(32) NOT NULL,
  `pget` tinyint(4) NOT NULL,
  `pcreate` tinyint(4) NOT NULL,
  `pupdate` tinyint(4) NOT NULL,
  `pdelete` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

	$e = insert("ALTER TABLE `permissions` ADD PRIMARY KEY (`group_id`,`module`);");
	
	$e = insert("COMMIT;");
	
	echo "Created\n";
}
else
{
	echo "Table permission exists\n";
}

$e = get_array("SHOW TABLES LIKE 'users_groups'");

if(empty($e))
{
	echo "Table users_groups not exists\n";
	$e = insert("CREATE TABLE `users_groups` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

	$e = insert("ALTER TABLE `users_groups` ADD PRIMARY KEY (`user_id`,`group_id`);");
	
	$e = insert("COMMIT;");
	
	echo "Created\n";
}
else
{
	echo "Table users_groups exists\n";
}

$cur_menu = 1;

$module = '';
$fields = array();
$label_pattern = "/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/";

$curpos = 1;

function divider()
{
	echo "============================\n";
	return true;
}

function show_menu()
{   global $curpos;
	if($curpos==1)
	{
		echo "1 - Input Module name\n";
		echo "2 - Input fields\n";
		echo "3 - Show fields\n";
		echo "C - Create Module\n";
		echo "Q - Quit\n";
	}
}

function workout_menu($input)
{
	global $curpos, $module, $label_pattern, $fields;
	$types = ['tinyint', 'int', 'tinytext' ,'text', 'timestamp'];

	if($curpos==1)
	{
		if($input=="Q")
		{
			$curpos = 0;
			
			echo "Chiao ;)\n";
			return false;
		}
		
		if($input==1)
		{
			echo "Input Module (valid php label)[plural preferable. this will be the name of the controller, model and the MySQL table]:";
			$str = trim( fgets(STDIN) );
			if(preg_match($label_pattern, $str)==true)
			{
				$module = $str;
			}
			else "Wrong name.\n";
			return true;
		}
		
		if($input==2)
		{
			echo "\e[0;30;41m!!!Warning!!! Fields: id,uid(timestamp oncreate),changed(timestamp onupdate),changed_by(user_id) Will be created automatically\e[0m\n";
			$exit = 0;
			$i = 0;
			$fieldst = [];
			while(!$exit)
			{
				
				echo "Input filed Name[_a for abort, _s for exit and save]:";
				$sname = trim( fgets(STDIN) );
				if($sname=='_a') {return false;}
				if($sname=="_s"){$fields = $fieldst; return true;}
				if(preg_match($label_pattern, $sname)==true)
				{					
					echo "Input filed type[int, tinyint(for boolean), tinytext, text, timestamp]:";
					$stype = trim( fgets(STDIN) );
					if(in_array($stype, $types))
					{
						$fieldst[] = array('name'=>$sname, 'type'=>$stype);
					}
					else{
						echo "Wrong type\n";
						break;
					}
					show_fields($fieldst);
				}
				else "Wrong name.\n";
			}
		}
		
		if($input==3)
		{
			show_fields($fields);
		}
		
		if($input=="C")
		{
			echo create_module();
			return true;
		}
		
		echo "Wrong input\n";
		
	}
	
	return true;
}

function show_inputs()
{
	global $module, $fields;
	clearstatcache();
	$module_e = false;
	if(!empty($module)) $module_e = is_file(dirname(__FILE__).DIRECTORY_SEPARATOR."web".DIRECTORY_SEPARATOR."bundles".DIRECTORY_SEPARATOR.'Sanuich'.DIRECTORY_SEPARATOR.'Modules'.DIRECTORY_SEPARATOR."Model".DIRECTORY_SEPARATOR.str_ireplace("_","",$module).".php");
	
	
	echo "Module: \e[1;33;40m".((!empty($module))?$module:' not set')."\e[0;36;40m (".(($module_e)?"exists":"not exists").")\e[0m\nFields: \e[1;33;40m".((!empty($fields))?'set':' not set')."\e[0m\n";
}

function show_fields($fields)
{
	$str = [];
	foreach($fields as $field)		 
	 $str[] = $field['name']."[".$field['type']."]";
	echo implode(",", $str)."\n";
	return true;
}


while($curpos!=0)
{
	global $fields;
	show_inputs();
	show_menu();
	show_fields($fields);
	
	echo "Select:";
	// Read user choice
	$choice = trim( fgets(STDIN) );
	
	//echo $choise;		
	
	$rez = workout_menu($choice);

	//echo $rez; 		
	
}

function create_module()
{
	global  $module, $fields;
	
	if(empty($module))
	{
		echo "\e[0;30;41mModule not set\e[0m\n";
		return false;
	}
	clearstatcache();
	$module_e = false;
	$module_e = is_file(dirname(__FILE__).DIRECTORY_SEPARATOR."web".DIRECTORY_SEPARATOR."bundles".DIRECTORY_SEPARATOR.'Sanuich'.DIRECTORY_SEPARATOR.'Modules'.DIRECTORY_SEPARATOR."Model".DIRECTORY_SEPARATOR.str_ireplace("_","",$module).".php");
	if($module_e!=false)
	{
		echo "\e[0;30;41mModule Class already exists.\e[0m\n";
		return false;
	}
	
	if(empty($fields))
	{
		echo "\e[0;30;41mFields not set\e[0m\n";
		return false;
	}
			
	//create Module (copy and replace)
	$modulefile = file_get_contents('model');
	$modulefile = str_ireplace("[module]", str_ireplace("_","",$module), $modulefile);
	$modulefile = str_ireplace("[tablename]", strtolower($module), $modulefile);
	$myfile = fopen(dirname(__FILE__).DIRECTORY_SEPARATOR."web".DIRECTORY_SEPARATOR."bundles".DIRECTORY_SEPARATOR.'Sanuich'.DIRECTORY_SEPARATOR.'Modules'.DIRECTORY_SEPARATOR."Model".DIRECTORY_SEPARATOR.str_ireplace("_","",$module).".php", "w");
	fwrite($myfile, $modulefile);
	fclose($myfile);
	
	//create table
	
	return true;
}