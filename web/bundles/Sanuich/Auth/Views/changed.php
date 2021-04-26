<div class="registration-form-section">
<div class="section-title reg-header">
<h3>Congratulations!</h3>
</div>					
<div class="login-form-links link1 " data-animation="fadeInRightBig" data-animation-delay=".2s">
<h4 class="blue">Password changed</h4>
<span>You can </span><a href="/si-login" class="green">Log in</a> <span> now using new passord</span>
</div>
</div>

<script>
var sec = 5;

var timerId = setInterval(function(){
	sec=sec-1;
	if(sec==0){window.location="/si-login"; clearTimeout(timerId);}
}, 1000);
</script>