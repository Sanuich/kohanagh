<div class="login-form-section">
<div class="login-content " data-animation="bounceIn">
<form action="" method=post>
<div class="section-title reg-header">
<h3>Create account</h3>
</div>					
<span class="label label-danger" style="margin-left: 20px;"><?=(!empty($error))?'error':''?></span>
<?php if(!empty($error)):?><div class="alert alert-danger" role="alert">
<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
<?=(!empty($error))?$error:''?></div>
<?php endif;?>
<div class="textbox-wrap">
	<div class="input-group">
		<span class="input-group-addon "><i class="icon-color">@</i></span>
		<input type="text" required="required" class="form-control" name="email" placeholder="Email" value="<?=(!empty($email))?$email:''?>">
	</div>
</div>
<div class="textbox-wrap">
	<div class="input-group">
		<span class="input-group-addon "><i class="icon-user icon-color"></i></span>
		<input type="text" required="required" class="form-control" name="name" placeholder="Username" value="<?=(!empty($name))?$name:''?>">
	</div>
</div>
<div class="textbox-wrap">
<div class="input-group">
<span class="input-group-addon "><i class="icon-key icon-color"></i></span>
<input type="password" required="required" class="form-control" name="pass" placeholder="Password">
</div>
</div>
<div class="textbox-wrap">
<div class="input-group">
<span class="input-group-addon "><i class="icon-key icon-color"></i></span>
<input type="password" required="required" class="form-control" name="pass2" placeholder="Confirm password">
</div>
</div>
<div class="textbox-wrap">
<?=$captcha_html?>
</div>
<div class="login-form-action clearfix">
<a href="/si-login" class="btn btn-success pull-left blue-btn ">
<i class="icon-chevron-left"></i>&nbsp; &nbsp;Back To Login</a>
<button type="submit" class="btn btn-success pull-right green-btn">Register &nbsp; <i class="icon-chevron-right"></i></button>
</div>
</form>
</div>

</div>
<script>

</script>