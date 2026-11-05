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
use Seventeen\ourphp_database;

class database
{
	
	public function __construct()
	{
		
	}
	
	public static function sql()
	{
		$D = ourphp_database::databaseinfo();
		if($D['openclose'])
		{
			$mysqltype = "Seventeen\ourphp_" . $D['mysqltype'];
			$db = new $mysqltype($D['mysqlurl'], $D['mysqlname'], $D['mysqlpass'], $D['mysqldb'], $D['mysqlport'], $D['mysqlprefix']);
			return $db;
		}
	}
	
}
?>