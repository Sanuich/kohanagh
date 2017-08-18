<?php 

namespace Controller;

use Kohana\Controller as Controller;
use Kohana\View as View;
use Kohana\Model as Model;
use Kohana\Cache as Cache;
use Kohana\Date as Date;
use Kohana\Pagination;
use Kohana\ORM;


class Welcome extends Controller\Template {

	public $auto_render = false;
	
	public function before()
	{
		parent::before();
		@session_start();
	
		$this->template='views/template';		
		$this->template = View::factory($this->template);
		
	}
	
	public function action_index()
	{
		
		
		Cache::instance()->set('image', '1', Date::HOUR * 1);
		$image = Cache::instance()->get('image');

		$SanuichDB = Model::factory('Sanuich\Database\Model\DB');
		//$users = $SanuichDB->dbselect("SELECT * FROM users");
		
		//$crypt = \Kohana\Encrypt::instance();
		
		//$products_count = 10;

    	/*$pagination = Pagination::factory(array(
            'total_items' => $products_count,
            'items_per_page' => 5,
        ));*/
		
		
		$user = ORM::factory('user',1);

		$CaptchaTools = Model::factory('Sanuich\Captcha\Model\tools');
		$captcha = $CaptchaTools->generatePassword(6,6);
		$code = $CaptchaTools->dsCrypt($captcha);
		$captcha_html = View::factory('Sanuich/Captcha/Views/captcha', array('code'=>$code));
		$result = "";
		if(!empty($_POST['captcha'])) 
		$result = ($_POST['captcha'] == $CaptchaTools->dsCrypt($_POST['code'],1))?'correct':'wrong';

		$input = View::factory('Sanuich/AjaxControls/Views/combobox',
		array('button_name'=>'add',
			'option_name'=>'name',
			'fill'=>'get_names',
			'button_click'=>'send()',
			'input_id'=>'name',
			'limit'=>'3',
			'class'=>'name_div',
			'option_class'=>'list_el',
			'placeholder'=>'Input something'));
		$this->template->content = View::factory("views/index", array(
		'msg'=>'Hello World!',
		'input_name'=>$input,
		'captcha'=>$captcha_html,
		'result'=>$result));
		
	}
	
	public function after()
	{
		parent::after();
		$this->response->body($this->template->render());
	}

} // End Welcome
