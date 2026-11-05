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

class temp
{
	
	public function __construct()
	{
		
	}
	
	public function JS($html = '', $cache = 0){
		if($cache == 0)
		{
			$t = '';
		}else{
			$t = '?'.time().rand(000,999);
		}
		$html = str_replace("，", ",", $html);
		$html = explode(",", $html);
		foreach($html as $op)
		{
			$return .= '<script type="text/javascript" src="'.$op.$t.'"></script>';
		}
		return $return;
	}

	public function CSS($html = '', $cache = 0){
		if($cache == 0)
		{
			$t = '';
		}else{
			$t = '?'.time().rand(000,999);
		}
		$html = str_replace("，", ",", $html);
		$html = explode(",", $html);
		foreach($html as $op)
		{
			$return .= '<link href="'.$op.$t.'" rel="stylesheet">';
		}
		return $return;
	}

	
}
?>