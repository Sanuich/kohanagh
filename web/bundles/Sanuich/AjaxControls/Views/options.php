<?php
$i=0;$id='';$value='';
if((isset($list))&&(isset($selected))){
if($name!='undefined'){?><option disabled <?php if($selected=='-1'){echo 'selected';}?> value="-1"><?=$name?></option><?php }
if($all!="0"){?>
<option <?php if($selected=='%'){echo 'selected';}?> value="%"><?=$all?></option>
<?php
}
foreach($list as $item){?>
<option <?php reset($item); $id=current($item); next($item); $value=current($item);
if($selected==$id){echo ' selected ';}
if($selected!="%" && $name=='undefined' && $i==0){echo ' selected';}?>
value="<?=$id?>"><?=$value?></option>
<?php 
$i++;
}
}?>