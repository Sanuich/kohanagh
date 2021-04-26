<?php

namespace Model;

use Kohana\Model as KohanaModel;

class Mailservice extends KohanaModel 
{	
	
	public function MailSend($data = array('afrom'=>'','nfrom'=>'','to'=>'','replyto'=>'','nreplyto'=>'','return-path'=>'','subject'=>'','body'=>'','content-type'=>'text/plain','charset'=>'utf-8'))
	{
		if(empty($data['content-type'])) $data['content-type'] = "text/plain";
		if(empty($data['charset'])) $data['charset'] = "utf-8";
		if(empty($data['replyto']) && empty($data['nreplyto'])) $data['nreplyto'] = "NoReply";
		
		$headers  = "";
		$headers .= "Date: ".date("D, d M Y H:i:s") . " UT\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: '.$data['content-type'].'; charset='.$data['charset'] . "\r\n";
		$headers .= 'From: '.$data['nfrom'].' <'. $data['afrom'] . ">\r\n";
        $headers .= 'Reply-To: '.$data['nreplyto'].' <'.$data['replyto'].">\r\n";
		$headers .= "Return-Path: ".$data['return-path']."\r\n";			
		$rez=@mail($data['to'], $data['subject'], $data['body'], $headers);
        return $rez;
	}
}