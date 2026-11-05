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

namespace Seventeen;

class ourphp_database
{
	public function __construct()
	{
		
	}
	
	public static function databaseinfo()
	{
		$database = [
						// 是否使用数据库  true 开启  false 关闭
						"openclose" => false, 
						//数据库链接类型
						'mysqltype' => 'mysqli', 
						// 数据库链接地址
						"mysqlurl" => "127.0.0.1", 
						// 数据库登录账号
						"mysqlname" => "root", 
						// 数据库登录密码
						"mysqlpass" => "tangwei", 
						// 数据库名
						"mysqldb" => "ourphp", 
						// 数据库连接端口
						"mysqlport" => "3306",
						// 数据库表前缀
						"mysqlprefix" => "",
		];
		return $database;
	}
}

?>