<div class="container-fluid content middled">
<div class="row">
<div class="col-md-12">
<h1>Kohana Golden Hair (based on Kohana Framework 3.3.5 version)</h1>
<p></p>
<h2><a href="/kohana.gh.zip" download>Download</a></h2>
<p>Soon on Github...</p>
<p></p>
<h2>About</h2>
<p>Kohana Golden Hair is fork of Kohana Framework, based on Kohana 3.3.5 Framework.</p>
<p>Kohana Golden Hair is using NAMESPACES and supporting latest PSR-4 standart</p>
<p>Updated to work with PHP 7.0.x version. PHP 5.4 - 7.0.x compatibility</p>
<p>Released under a <a href="LICENSE.md">BSD license</a>, Kohana Golden Hair can be used legally for any open source, commercial, or personal project.</p>
<p><b>Pagination module</b> also added.</p>

<p>The major changes:</p>
<ol>
<li>autoloader rewrited to PSR-4 standart, that means that all classes should be declared in a <a href="#namespaces">namespaces</a>.</li>
<li><a href="#bundles">Bundles module</a> added</li>
<li><strong>Kohana\URL::site</strong> function now has a new parameter <code class="highlighter-rouge">$subdomain = NULL</code>, if you are extending the class and this function add it.</li>
<li><strong>Kohana\Exception (old Kohana_Kohana_Exception)</strong>, all functions that received parameter Exception $e have been replaced to just $e. If you are extending the class verify you have the same.</li>
<li><b>Module encrypt</b>, now encryption works as a module,<br> if you are using new Encrypt or similar you need to enable the module in your bootstrap ex: 'encrypt' => MODPATH.'Kohana\encrypt',</li>
<li><strong>Kohana\ORM</strong> module fixed to work with PDO database driver</li>
</ol>
<p>All modules was reworked for maximal compatibility with old code but Some of them still need to be tested. For example </p>

<div id="namespaces"></div>
<h2>Namespaces AND PSR-4</h2>
<p>New autoloader rewritten to seek classes files by namespace. <br>
Underscore in class name now allowed. <br>
All classes that only extends different classes where removed.
</p>
<p>For example, there's no more <b>Kohana</b> class that extends <b>Kohana_Core</b> class.<br>
Instead of this need to declare<br> <code>use Kohana\Core as Kohana;</code><br>
in every file where this class is used, e.t.c.
</p>
<p>As file_seek function was also rewritten, <b>Controller</b>,<b>Module</b> and <b>Views</b> folder names now up to user.<br>
 In applications classes - controllers names now should be placed in a <b>Controller</b> namespace that should be the same as <b>Controller</b> folder name</p>
<p>When creating Instances of Models and other classes need to provide full Classname with namespace.<br>
Like: <code>$CaptchaTools = Model::factory('Sanuich\Captcha\Model\tools');</code><br>
where Sanuich is a vendor's name, Capthcha is a Application name, Model is a part of path where Model is file tools.php<br>Or <code>$CaptchaTools = Model::factory('Model\tools');</code> if Model tools lying in appllication\classes\Models folder</p>

<div id="bundles"></div>
<h2>Bundles</h2>
<p>Bundles is a new  module for this Framework that allows to create separated applications in a public folder.</p>
<p>It is similar to modules, almost like modules, just allows to create each bundle in a <b>public\bundles\vendor\bundle_name</b> folder</p>
<p>That's why actualy was necessary to rewrite autoloader to PSR-4 standart</p>
<p>Some bundles added to default project:</p>
<ul>
<li>Sanuich\AjaxControls - bundle that allows to create some HTML tags like Table, Select, Div's list and fill them with data</li>
<li>Sanuich\Captcha - Creates captcha input and check inputed code inside controller</li>
<li>Sanuich\Database</li>
</ul>
<p>There's a leak of documentation but default application in a app\classes folder is not empty.</p>
<p></p>
<h2>Sanuich Database</h2>
<p>Some additional sugar: new bundle Sanuich\Database that contains module Database with many useful functions to work with database</p>
<code>$SanuichDB = Model::factory('Sanuich\Database\Model\DB');</code>
<br>
some of the functions:
<ul>
<li><code>dbrow($q);</code> select with query $q and return one first row of result or false</li>
<li><code>dbidselect($q);</code> select with query $q and return array associated with value of id column</li>
<li><code>dbinsert_data($tbl, $data, $replace);</code> insert or replace $data array in a table $tbl. $replace (0,1)</li>
<li><code>dbupdate_data($tbl, $data, $key);</code> update table $tbl with record array $data WHERE $key==$data[$key]</li>
<li>AND MORE...</li>
</ul>
<p></p>
<p>There are some examples of using new features below</p>
</div>
</div>

<div class="row">
<div class="col-md-12">
<h3>captcha:</h3>
<code>
$CaptchaTools = Model::factory('Sanuich\Captcha\Model\tools');<br>
$captcha = $CaptchaTools->generatePassword(6,6);<br>
$code = $CaptchaTools->dsCrypt($captcha);<br>
$captcha_html = View::factory('Sanuich/Captcha/Views/captcha', array('code'=>$code));<br>
$result = "";<br>
if(!empty($_POST['captcha'])) <br>
$result = ($_POST['captcha'] == $CaptchaTools->dsCrypt($_POST['code'],1))?'correct':'wrong';</code><br>
<?=(!empty($result))?'<div class="error">'.$result.'</div>':''?>
<form action="" method=post>
<?=$captcha?>
<input type=submit value="check"/>
</form>
<p></p>
<h2>Ajax Controls</h2>
header<br>
<code>&lt;script src="/bundles/Sanuich/AjaxControls/asset/js/core.js"&gt;&lt;/script&gt;</code><br>
bootstrap<br>
<code>Bundles::set(array('vendor'=>'Sanuich','bundle'=>'AjaxControls'));</code><br>
have fun<br>
<h3>message:</h3>
<code>
&lt;div id="msg"&gt;&lt;/div&gt;<br>
&lt;script&gt;get_data('msg','bye','','msg');&lt;/script&gt;</code> <br>
<div id="msg"></div>
<p></p>
<h3>combobox:</h3>
<code>$input = View::factory('Sanuich/AjaxControls/views/combobox',<br>
		array('button_name'=>'add',<br>
			'option_name'=>'name',<br>
			'fill'=>'get_names',<br>
			'button_click'=>'send()',<br>
			'input_id'=>'name',<br>
			'limit'=>'3',<br>
			'class'=>'name_div',<br>
			'option_class'=>'list_el',<br>
			'placeholder'=>'Input something'));</code><br>
<?=$input_name?>
<p></p>
<h3>select:</h3>
<code>
&lt;select id="opt"&gt;&lt;/select&gt;<br>
&lt;script&gt;filloptions('opt','get_names','','names','','','');&lt;/script&gt;</code><br>
<select id="opt"></select>
<p></p>
<h3>table:</h3>
<code>
&lt;table class="table table-bordered" id="tab"&gt;&lt;/table&gt;<br>
&lt;script&gt;filltable('tab','get_names','','names',1,1,1,'');&lt;/script&gt;</code><br>
<table class="table table-bordered" id="tab"></table>
</div>
</div>
</div>
<script>
get_data('msg','bye','','msg');
filloptions('opt','get_names','','names','','','');
filltable('tab','get_names','','names',1,1,1,'');

function edit_names(id)
{
	alert('record number '+id+' is editing');
}
</script>