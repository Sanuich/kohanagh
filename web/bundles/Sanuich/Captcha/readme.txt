Sanuich Captcha boundle for Kohana Golden Hair 1.0

put all files in HTTP_ROOT/BUNDLESFOULDER/Sanuich/Captcha folder

generate
$captcha = \Model::factory('Sanuich\Captcha\Model\tools')->generatePassword(6,6);
$code = \Model::factory('Sanuich\Captcha\Model\tools')->dsCrypt($captcha);
$captcha_html = \View::factory('Sanuich\Captcha\views\captcha', array('code'=>$code));

check
$_POST['captcha'] == $this->Mtools->dsCrypt($_POST['code'],1)

dont forget to add boundle in main bootstrap file

Boundles::set(array('vendor'=>'Sanuich','bundle'=>'Captcha'));