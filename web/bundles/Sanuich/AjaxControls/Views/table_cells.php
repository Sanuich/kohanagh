<?php if(!empty($list) && !empty($name)){
if(!empty($head)){?>
<thead>
<tr>
<?php foreach($list[0] as $fname=>$item){
if((!empty($id) && $fname=='id')||($fname!='id')){?>
<td <?=(substr_count($fname,"hidden")>0)?' style="display:none" ':""?>><?=$fname?></td>
<?php }
}
if(!empty($options)){?>
<td colspan=2 style="width:64px">options</td>
<?php }?>
</tr>
</thead>
<?php }
foreach($list as $row){?>
<tr id="<?=$name?>_<?=$row['id']?>">
<?php foreach($row as $cname=>$cell){
if((!empty($id) && $cname=='id')||($cname!='id')){?>
<td id="<?=$cname?>_<?=$row['id']?>" 
<?php if((!empty($name_function) && $cname=='name')){?> 
onclick="<?=$name_function?>('<?=$row['id']?>');" 
<?php }?>
<?=(strpos($cname,"hidden")!==false)?' style="display:none" ':""?>><?=$cell?></td>
<?php }
}
if(!empty($options)){?>
<td style="width:32px"><a href="javascript:edit_<?=$name?>('<?=$row['id']?>')" style="width:32px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
<td style="width:32px"><a href="javascript:delete_<?=$name?>('<?=$row['id']?>')" style="width:32px;"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a></td>
<?php }?>
</tr>
<?php }
}?>