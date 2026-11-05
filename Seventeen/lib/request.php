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

class request
{
	
	public function __construct()
	{
		
	}
	
	public function P($name, $filter = 'n')
	{
        if(empty($_POST[$name]))
        {
            return false;
        }
		$p = $_POST[$name];
		if(isset($p))
		{
			if($filter == 'n')
			{
				$p = ourphp_function::admin_sql($p);
			}
			if($filter == 'y')
			{
				$p = ourphp_function::dowith_sql($p);
			}
			return $p;
			
		}else{
			return false;
		}
	}
	
	public function G($name, $filter = 'n')
	{
        if(empty($_GET[$name]))
        {
            return false;
        }
		$g = $_GET[$name];
		if(isset($g))
		{
			if($filter == 'n')
			{
				$g = ourphp_function::admin_sql($g);
			}
			if($filter == 'y')
			{
				$g = ourphp_function::dowith_sql($g);
			}
			return $g;
			
		}else{
			return false;
		}
	}
	
	public function R($name, $filter = 'n')
	{
        if(empty($_REQUEST[$name]))
        {
            return false;
        }
		$r = $_REQUEST[$name];
		if(isset($r))
		{
			if($filter == 'n')
			{
				$r = ourphp_function::admin_sql($r);
			}
			if($filter == 'y')
			{
				$r = ourphp_function::dowith_sql($r);
			}
			return $r;
			
		}else{
			return false;
		}
	}
}
?>