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
use Seventeen\lib\style;

class html
{
	
	public function __construct()
	{
		
	}
	
	public static function E($content = '')
	{
		echo $content;
	}
	
	public static function I($file = '')
	{
		if($file == '')
		{
			echo style::E("加载模板地址不能为空");
			exit;
		}
		if(!file_exists($file))
		{
			echo style::E("模板 ".$file." 未找到");
			exit;
		}
		
		return $file;
	}
	
}
?>