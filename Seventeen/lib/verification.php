<?php
/*
 * SeventeenPHP — 超轻量级 PHP 开发框架
 *
 * @author        哈尔滨伟成科技有限公司 (唐晓伟 QQ:77701950)
 * @copyright     Copyright (c) 2026 哈尔滨伟成科技有限公司
 * @license       Apache License 2.0（Apache 2.0 开源协议）
 *                本框架基于 Apache 2.0 协议开源，分发使用时必须保留上述版权声明。
 * @link          http://www.ourphp.net
 *
 */

namespace Seventeen\lib;
use Seventeen\ourphp_function;

class verification
{
	
	public function __construct()
	{
		
	}
	
	public function PHONE($number = '', $filter = 'n'){
		
		if($number == ''){
			return false;

		}else{
			if($filter == 'n')
			{
				return substr_replace($number,'****',3,4);
			}
			if($filter == 'y')
			{
				return ourphp_function::dowith_sql(substr_replace($number,'****',3,4));
			}

		}
	}
	
	public function NAME($name, $filter = 'n'){
		
		$t = ourphp_function::abslength($name);
		if($filter == 'n')
		{
			$name = $name;
		}
		if($filter == 'y')
		{
			$name = ourphp_function::dowith_sql($name);
		}
		if($t >= 2){
		 	$strlen		= mb_strlen($name, 'utf-8');
		    $firstStr	= mb_substr($name, 0, 1, 'utf-8');
		    $lastStr	= mb_substr($name, -1, 1, 'utf-8');
			return $strlen == 2 ? $firstStr . str_repeat('*', mb_strlen($name, 'utf-8') - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
			
		}else{
			return false;

		}
	}
	
	public function EMAIL($email, $filter = 'n'){
		
		if($email == ''){
			return false;

		}else{
		    $email_array = explode("@", $email);
		    $prevfix = (strlen($email_array[0]) < 4) ? "" : substr($email, 0, 3); 
		    $count = 0;
		    $str = preg_replace('/([\d\w+_-]{0,100})@/', '***@', $email, -1, $count);
		    $rs = $prevfix . $str;
			
			if($filter == 'n')
			{
				return $rs;
			}
			if($filter == 'y')
			{
				return ourphp_function::dowith_sql($rs);
			}

		}
	}
	
	public function IDCARD($number, $filter = 'n'){
		
		if($number == ''){
			return false;

		}else{
		    $t = strlen($number) == 15 ? substr_replace($number,"****",8,4) : (strlen($number) == 18 ? substr_replace($number,"********",6,8) : "身份证位数不正常！");
			if($filter == 'n')
			{
				return $t;
			}
			if($filter == 'y')
			{
				return ourphp_function::dowith_sql($t);
			}

		}
	}
	
	public function BANKNUM($number, $filter = 'n'){
		
	    if (!$number) {
	        return $number;
	    }
	    preg_match('/([\d]{4})([\d]{4})([\d]{4})([\d]{4})([\d]{0,})?/', $number, $match);
	    $t = ''; unset($match[0]);
	    foreach ($match as $vo) {
	        $t .= $vo . ' ';
	    }
		if($filter == 'n')
		{
			return $t;
		}
		if($filter == 'y')
		{
			return ourphp_function::dowith_sql($t);
		}

	}
	

	public function DECIMAL($number,$p = 0, $filter = 'n'){

		$o = rtrim(rtrim($number, '0'), '.');
		if($o == 0){
			$t = "0.00";
		}else{
			if(strpos($o,'.') !== false){
				$t = $o;
			}else{

				if($p == 0){
					$t = $o;
				}else{
					$digit = '';
					for ($x=1; $x<=$p; $x++)
					{
						$digit .= 0;
					}
					$t = $o.".".$digit;
				}
			}
		}
		if($filter == 'n')
		{
			return $t;
		}
		if($filter == 'y')
		{
			return ourphp_function::dowith_sql($t);
		}
	}
	
	public function FORMATNUMBER($number, $filter = 'n')
	{
	    if (empty($number) || !is_numeric($number)) return $number;
	    $unit = "";
		if ($number > 1000 && $number < 10000) {
			
	        $leftNumber = floor($number / 1000);
	        $rightNumber = round(($number % 1000) / 1000, 2);
	        $number = floatval($leftNumber + $rightNumber);
	        $unit = "k";		
			
		}elseif ($number > 10000 && $number < 99999999) {
			
	        $leftNumber = floor($number / 10000);
	        $rightNumber = round(($number % 10000) / 10000, 2);
	        $number = floatval($leftNumber + $rightNumber);
	        $unit = "万";
			
	    }elseif ($number > 99999999){
			
	        $leftNumber = floor($number / 100000000);
	        $rightNumber = round(($number % 100000000) / 100000000, 2);
	        $number = floatval($leftNumber + $rightNumber);
	        $unit = "亿"; 
			
	    }else {
			
	        $decimals = $number > 1 ? 2 : 6;
	        $number = (float)number_format($number, $decimals, '.', '');
	    }
		if($filter == 'n')
		{
			return (string)$number . $unit;
		}
		if($filter == 'y')
		{
			return ourphp_function::dowith_sql((string)$number . $unit);
		}
	}
	
	public function NEWTIME($time){
		$now_time = date("Y-m-d H:i:s", time());  
		$now_time = strtotime($now_time);  
		$show_time = strtotime($time);  
		$dur = $now_time - $show_time;  
		if ($dur < 0) {  
			return date("Y-m-d H:i:s", strtotime($time));  
		} else {  
			if ($dur < 60) {  
				return $dur . '秒前';  
			} else {  
				if ($dur < 3600) {  
					return floor($dur / 60) . '分钟前';  
				} else {  
					if ($dur < 86400) {  
						return floor($dur / 3600) . '小时前';  
					} else {  
						if ($dur < 259200) {
							return floor($dur / 86400) . '天前';  
						} else {  
							return date("Y-m-d H:i:s", strtotime($time));
						}  
					}  
				}  
			}  
		}  
	}
	
}
?>