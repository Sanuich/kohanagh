<?php 
$i=0;$id='';$value='';
if((isset($list))&&(isset($name))){
foreach($list as $row){
reset($row); $id=current($row); next($row); $value=current($row);?>
<div id="<?=(!empty($name)) ? $name.'_' : ''?><?=$id?>" <?=(!empty($clas))?' class="'.$clas.'"':''?> <?php if(!empty($click)){?> onclick="<?=$click?>('<?=$id?>')"<?php }?>><?=$value?></div>
<?php }
}?>