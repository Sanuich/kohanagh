<div class="login-form-section">
<div class="login-content " data-animation="bounceIn">
<form action="" method=post>
<div class="section-title">
<h3>LogIn to your Account</h3>
</div>					
<span class="label label-danger" style="margin-left: 20px;"><?=(!empty($error))?'error':''?></span>
<?php if(!empty($error)):?><div class="alert alert-danger" role="alert">
<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
<?=(!empty($error))?$error:''?></div>
<?php endif;?>
<div class="textbox-wrap">
<div class="input-group">
<span class="input-group-addon "><i class="icon-color">@</i></span>
<input type="text" required="required" class="form-control" name="email" placeholder="E-mail">
</div>
</div>
<div class="textbox-wrap">
<div class="input-group">
<span class="input-group-addon "><i class="icon-key icon-color"></i></span>
<input type="password" required="required" class="form-control" name="pass" placeholder="Password">
</div>
</div>
<div class="login-form-action clearfix">
<div class="checkbox pull-left">
<div class="custom-checkbox">
<div class="icheckbox_polaris checked" style="position: relative;">
<input type="checkbox" checked="" name="iCheck" style="">
<ins class="iCheck-helper" style=""></ins>
</div>
</div>
<span class="checkbox-text pull-left">&nbsp;Remember Me</span>
</div>
<button type="submit" class="btn btn-success pull-right green-btn">LogIn &nbsp; <i class="icon-chevron-right"></i></button>
</div>
</form>
</div>
<div class="login-form-links link1 " data-animation="fadeInRightBig" data-animation-delay=".2s">
<h4 class="blue">Don't have an Account?</h4>
<span>No worry</span>
<a href="/register" class="blue">Click Here</a>
<span>to Register</span>
</div>
<div class="login-form-links link2 " data-animation="fadeInLeftBig" data-animation-delay=".4s">
<h4 class="green">Forget your Password?</h4>
<span>Dont worry</span>
<a href="/remind" class="green">Click Here</a>
<span>to Get New One</span>
</div>
</div>
<script>
$('.icheckbox_polaris').click(function(){
//el = $(this).parents('.toc').children('ul');
if($(this).hasClass('checked')){
$(this).removeClass('checked');
//$(this).find('input').prop('checked',false);
$('input[name="iCheck"]').prop('checked',false);
}
else
{
$(this).addClass('checked');
$('input[name="iCheck"]').prop('checked',true);
}
});
</script>