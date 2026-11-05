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

class safe
{
	
	public function __construct()
	{
		
	}
	
	public function TOKEN($token = ''){
		global $config;
		if($token == ''){
			return false;

		}else{
			return MD5($token.$config['safecode']);
			
		}
	}
	
	public function HIDDENINPUT($str = '',$name = ''){
		global $config;
		if($str == '' || $name == ''){

			return false;

		}else{

		    $t = $this -> TOKEN($str);
			return '<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.$str.'@'.$t.'">';

		}

	}
	
}
?>