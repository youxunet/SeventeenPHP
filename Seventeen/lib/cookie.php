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

class cookie
{
	
	public function __construct()
	{
		
	}
	
	public function COOKIE($key = '', $info = '', $type = 1){
		if($key == '' || $type == '')
		{
			return false;
		}
		switch($type){
			case "1":
				setcookie($key, $info, time() + 86400);
			break;
			case "2":
				if(empty($_COOKIE[$key])){
					return false;
				}else{
					return $_COOKIE[$key];
				}
			break;
			case "3":
				setcookie($key, "");
			break;
			case "4":
				if(isset($_COOKIE[$key])){
					return true;
				}else{
					return false;
				}
			break;
		}
	}

	
}
?>