<?php

namespace Model;

use Kohana\Model as KohanaModel;

class Tools extends KohanaModel 
{
	/////
	
	public function generatePassword($minLength, $maxLength)
	{
		$password = "";
		$passwordLength = mt_rand($minLength, $maxLength);
		for ($i = 1; $i <= $passwordLength; $i++)
		{
			$random = 0;
			while (($random < 48 || $random > 122) || (($random >= 58 && $random <= 64) || ($random >= 91 && $random <= 96)))
			{
				$random = mt_rand(1, 256);
			}
			$password .= chr($random);
		}
		return $password;
	}
	
	public function validDate($date , $format = 'Y-m-d')
	{
		$d = \DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	
	public function validEmail($email = "")
	{ 
		if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) return true; 
		else return false;    
	}
	
	function rus2translit($string) {
		$converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		);

		return strtr($string, $converter);
	}

	function str2url($str) {
		if(!empty($str))
		{
			// переводим в транслит
			$str = $this->rus2translit($str);
			// в нижний регистр
			$str = strtolower($str);
			// заменям все ненужное нам на "-"
			$str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
			// удаляем начальные и конечные '-'
			$str = trim($str, "-");
		}
		return $str;
	}
	
	function encode($String, $Password)
	{
		$Salt='awegrartBe5TRb'; 
		$StrLen = strlen($String);
		$Seq = $Password;
		$Gamma = '';
		while (strlen($Gamma)<$StrLen)
		{
			$Seq = pack("H*",sha1($Gamma.$Seq.$Salt)); 
			$Gamma.=substr($Seq,0,8);
		}
		
		return $String^$Gamma;
	}
	
	function dsCrypt($input, $decrypt=false) 
	{
		$o = $s1 = $s2 = array(); // Arrays for: Output, Square1, Square2
		// формируем базовый массив с набором символов
		$basea = array('?','(','@',';','$','#',"]","&",'*'); // base symbol set
		$basea = array_merge($basea, range('a','z'), range('A','Z'), range(0,9) );
		$basea = array_merge($basea, array('!',')','_','+','|','%','/','[','.',' ') );
		$dimension=9; // of squares
		for($i=0;$i<$dimension;$i++) { // create Squares
			for($j=0;$j<$dimension;$j++) {
				$s1[$i][$j] = $basea[$i*$dimension+$j];
				$s2[$i][$j] = str_rot13($basea[($dimension*$dimension-1) - ($i*$dimension+$j)]);
			}
		}
		unset($basea);
		$m = floor(strlen($input)/2)*2; // !strlen%2
		$symbl = $m==strlen($input) ? '':$input[strlen($input)-1]; // last symbol (unpaired)
		$al = array();
		// crypt/uncrypt pairs of symbols
		for ($ii=0; $ii<$m; $ii+=2) {
			$symb1 = $symbn1 = strval($input[$ii]);
			$symb2 = $symbn2 = strval($input[$ii+1]);
			$a1 = $a2 = array();
			for($i=0;$i<$dimension;$i++) { // search symbols in Squares
				for($j=0;$j<$dimension;$j++) {
					if ($decrypt) {
						if ($symb1===strval($s2[$i][$j]) ) $a1=array($i,$j);
						if ($symb2===strval($s1[$i][$j]) ) $a2=array($i,$j);
						if (!empty($symbl) && $symbl===strval($s2[$i][$j])) $al=array($i,$j);
					}
					else {
						if ($symb1===strval($s1[$i][$j]) ) $a1=array($i,$j);
						if ($symb2===strval($s2[$i][$j]) ) $a2=array($i,$j);
						if (!empty($symbl) && $symbl===strval($s1[$i][$j])) $al=array($i,$j);
					}
				}
			}
			if (sizeof($a1) && sizeof($a2)) {
				$symbn1 = $decrypt ? $s1[$a1[0]][$a2[1]] : $s2[$a1[0]][$a2[1]];
				$symbn2 = $decrypt ? $s2[$a2[0]][$a1[1]] : $s1[$a2[0]][$a1[1]];
			}
			$o[] = $symbn1.$symbn2;
		}

		if (!empty($symbl) && sizeof($al)) // last symbol
			$o[] = $decrypt ? $s1[$al[1]][$al[0]] : $s2[$al[1]][$al[0]];
		return implode('',$o);
	}
	
	public function escape($text = "")
	{
		return addslashes(strip_tags($text));
	}
	
	//
	public function get_code($i=0)
	{
		$i = (int) $i;
		$code = '';
		
		if($i<0) return $code;
		$r = 26;
		$p = 1;
		$f = 0;
		
		do{
			$f = $i%$r;
			$code = chr($f+65).$code;
			$i = floor($i/($p*$r));
			//$p++;
			
		} while ($i>0);

		return $code;
	}
	
	public function text2word($text="")
	{
		$text=  str_ireplace(" ","",$text);
		$text=  str_ireplace("%20","",$text);
		return $text;
	}
}