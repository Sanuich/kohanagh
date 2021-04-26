<div class="registration-form-section">
<div class="section-title reg-header">
<h3>Congratulations!</h3>
</div>					
<div class="login-form-links link1 " data-animation="fadeInRightBig" data-animation-delay=".2s">
<h4 class="blue">You successfully approved your email</h4>
<span>And now you can <a href="/si-login" class="green">Log in</a> to web site.</span><br>
<span>You will be redirected to home page in a few seconds. Or use</span><a href="/" class="green">This link</a><br>
</div>
</div>

<script>
var sec = 5;

var timerId = setInterval(function(){
	sec=sec-1;
	if(sec==0){window.location="/"; clearTimeout(timerId);}
}, 1000);
</script>