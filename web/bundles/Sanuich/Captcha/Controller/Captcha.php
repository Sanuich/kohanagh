<?php 

namespace Sanuich\Captcha\Controller;

use \Kohana\View as KohanaView;
use \Kohana\Request as KohanaRequest;
use \Kohana\Controller as KohanaController;
use \Kohana\Model as KohanaModel;


class Captcha extends KohanaController {

	public $Mtools;

	public function before()
	{
        parent::before();
        session_start();
		///
		$this->Mtools = KohanaModel::factory('\Sanuich\Captcha\Model\tools');		
	}
	
	public function action_captcha_image()
    {	
		if(empty($_GET['code'])) {echo "no code"; return false;}		
		$code = $this->Mtools->dsCrypt($_GET['code'],1);
		$width = 160;
		$height = 48;
		$im = ImageCreate ($width, $height);
		$r = rand (50, 255);
		$g = rand (50, 255);
		$b = rand (50, 255);
		$bg = ImageColorAllocate ($im, $r, $g, $b);
		$text = ImageColorAllocate ($im, 0, 0, 0);
		for ($i = 0; $i <= 1500; $i++) {
			$col = ImageColorAllocate ($im, rand (0,255), rand (0,255), rand (0,255));
			ImageSetPixel ($im, rand (0, $width), rand (0, $height), $col);
		}
		$wid = -10;
		$heig = 28;
		for ($i = 0; $i < strlen ($code); $i++) {
			$wid += 20 + rand (0, 3);
			$tmp = rand (0, 1);
			if ($tmp == 1) {
				$heig += rand (0, 2);
			} else {
				$heig -= rand (0, 2);
			}
			imagettftext($im, 18, 0, $wid, $heig, $text, 'bundles/Sanuich/Captcha/asset/ttf/comic.ttf', $code[$i]);
		}
		       
        $this->response->headers('Content-Type', 'image/jpeg');
        imagejpeg($im);
    }

    public function action_captcha_check()
    {
    	if(!empty($_POST['code']) && !empty($_POST['captcha']) && $_POST['captcha'] == $CaptchaTools->dsCrypt($_POST['code'],1))
    	{
    		echo json_encode(array('res'=>1,'ans'=>'right'));  
			return false;
    	}
    	else
    	{
    		echo json_encode(array('res'=>0,'ans'=>'wrong'));  
			return false;
    	}
    }
}