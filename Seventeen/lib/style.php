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

class style
{
	
	public function __construct()
	{
		
	}
	
	public static function E($font = '')
	{
		$html = '
				<style type="text/css">
					.style{
							width:86%;
							float:left;
							margin:20px 5%;
							padding:2%;
							background:#f4f4f4;
							border-radius:8px;
							color:#333;
					}
				</style>
				<div class="style">
				'.$font.'
				</div>
		';
		return $html;
	}
	
}
?>