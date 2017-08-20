# Kohana Golden Hair (based on Kohana Framework 3.3.5 version)

##  About
Kohana Golden Hair is fork of Kohana Framework, based on Kohana 3.3.5 Framework.

Kohana Golden Hair is using NAMESPACES and supporting latest PSR-4 standart.

Updated to work with PHP 7.0.x version. PHP 5.4 - 7.0.x compatibility.

Released under a BSD license. Kohana framework and it's fork - Golden Hair can be used legally for any open source, commercial, or personal project.

Pagination module also added.

##  The major changes:

- **[Autoloader]** rewrited to [PSR-4] standart, that means that all classes should be declared in a namespaces.

- **[Bundles module]** added

- **Kohana\URL::site** function now has a new parameter $subdomain = NULL, if you are extending the class and this function add it.

- **Kohana\Exception** (old Kohana_Kohana_Exception), all functions that received parameter Exception $e have been replaced to just $e. If you are extending the class verify you have the same.

- **Module encrypt**, now encryption works as a module. If you are using new Encrypt or similar you need to enable the module in your bootstrap ex: 'encrypt' => MODPATH.'Kohana\encrypt'.

- **Kohana\ORM module** fixed to work with PDO database driver.

- **Views Filters** View class was extended with Filters (like Smarty or Twig).

All modules was reworked for maximal compatibility with old code but Some of them still need to be tested.

###  Namespaces AND PSR-4
New autoloader rewritten to seek classes files by namespace. 
Underscore in class name now allowed. 
All classes that only extends different classes where removed.
For example, there's no more Kohana class that extends Kohana_Core class.
Instead of this need to declare
use Kohana\Core as Kohana;
in every file where this class is used, e.t.c.

As file_seek function was also rewritten, Controller,Module and Views folder names now up to user.
In applications classes - controllers names now should be placed in a Controller namespace that should be the same as Controller folder name

When creating Instances of Models and other classes need to provide full Classname with namespace.
Like: $CaptchaTools = Model::factory('Sanuich\Captcha\Model\tools');
where Sanuich is a vendor's name, Capthcha is a Application name, Model is a part of path where Model is file tools.php
Or $CaptchaTools = Model::factory('Model\tools'); if Model tools lying in appllication\classes\Models folder

###  Views Filters

We decided to fill some emptiness with a few lines of code. So now you can use in a Views some filters.

To use filters in a View, 3d unnecessary parameter wath added to View::factory function

$html = View::factory('index',$data, true);
by default it has value - false. To enable filters in a view - set this parameter to any value that !=false. 1 or true.
or define  constanr
define('VIEWS_FILTERS',1);
in index file or bootstrap file.

For now there are [escape] [data] and [datastr] filters. For more details see [kohanagoldenhair.xyz](https://kohanagoldenhair.xyz)

###  Bundles
Bundles is a new module for this Framework that allows to create separated applications in a public folder.

It is similar to modules, almost like modules, just allows to create each bundle in a public\bundles\vendor\bundle_name folder

That's why actualy was necessary to rewrite autoloader to PSR-4 standart

Some bundles added to default project:

- **Sanuich\AjaxControls** - bundle that allows to create some HTML tags like Table, Select, Div's list and fill them with data
- **Sanuich\Captcha** - Creates captcha input and check inputed code inside controller
- **Sanuich\Database** - Some additional sugar: new bundle Sanuich\Database that contains module Database with many useful functions to work with database
There's a leak of documentation but default application in a app\classes folder is not empty.

####  How ot use Database Bundle
$SanuichDB = Model::factory('Sanuich\Database\Model\DB'); 
some of the functions:
dbrow($q); select with query $q and return one first row of result or false
dbidselect($q); select with query $q and return array associated with value of id column
dbinsert_data($tbl, $data, $replace); insert or replace $data array in a table $tbl. $replace (0,1)
dbupdate_data($tbl, $data, $key); update table $tbl with record array $data WHERE $key==$data[$key]
AND MORE...