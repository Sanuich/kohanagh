Sanuich AjaxControls bundle for Kohana Golden Hair 1.0
Generate HTML of some tags (like select options, table cells, divs...) based on ajax request to model functions
jquery required

put all files in HTTP_ROOT/BUNDLESFOULDER/Sanuich/AjaxControls folder

1. create functins you need in fills Model
2. link core.js to page
<script src="/BUNDLESFOULDER/Sanuich/AjaxControls/asset/js/core.js"></script>
	where BUNDLESFOULDER - folder name for bundles you set in index.php file
3. call a js function to get data and put it into custom TAG
<div id="tag_name"></div> 
.....
<script>
get_data('tag_name','function_name','','field_name');
</script>
where:
function_name - function name in fills Model
field_name - field name in query result record (See Controls.php and fills.php)

see core.js for descriptins of functins

dont forget to add bundle in main bootstrap file

Bundles::set(array('vendor'=>'Sanuich','bundle'=>'AjaxControls'));

Combobox is a input tag with hidden list of options that fills with matched values from database
while input is filling with text
Using Combobox in any controller
\View::factory('Sanuich/AjaxControls/views/combobox',
array('button_name'=>'btn_name',
		'fill'=>'fill_function',
		'option_name'=>'prefix_of_each_div_option'
		'button_click'=>'js_function_name()',
		'input_id'=>'input_tag_id_name',
		'limit'=>'limit_of_records',
		'class'=>'css_class_name_of_parent_div',
		'option_class'=>'css_class_of_returned_options'));