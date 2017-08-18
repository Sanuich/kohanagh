<div class="<?=(!empty($class)?$class:'')?>">
<input type=text autocomplete=off id="<?=$input_id?>" name="<?=$input_id?>" placeholder="<?=(!empty($placeholder))?$placeholder:''?>">
&nbsp;<input type=button onclick="<?=$button_click?>" value="<?=$button_name?>"><br>
<div id="options"></div>
<script></script>
<input type=hidden id="selected">
<script>
var select_option;

window.onload = function() {
	
select_option = function(id)
{
	$("#<?=$input_id?>").val($("#<?=$option_name?>_"+id).html());
	$("#selected").val(id);
	$("#options").html('');
}

$("#<?=$input_id?>").keyup(function(event){
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if ( keycode == 13 ) {
		event.preventDefault();
		return false;
	}
	$("#selected").val('');
	if($(this).val()!=''){
		cond = {
			this_id: <?=(!empty($this_id)?$this_id:'-1')?>,
			name: $(this).val(),
			limit: <?=(!empty($limit)?$limit:'0')?>
		}
	filldivs('options',
	'<?=(!empty($fill)?$fill:'')?>',
	cond,
	'<?=$option_name?>',
	'<?=(!empty($option_class)?$option_class:'')?>',
	'select_option'	);
	}
	else $("#options").html('');
});

};
</script>
</div>