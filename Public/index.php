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

//error_reporting(0);

define('Seventeen', "SeventeenPHP");
/*
*	系统目录分隔符
*/
define('OP', DIRECTORY_SEPARATOR);

/*
*	项目目录绝对路径（一）
*/
define('WEB_ROOT', realpath(__DIR__.OP.'..'.OP).OP);


/*
*	项目目录绝对路径（二）
*/
//define('WEB_ROOT', dirname(__FILE__).OP);


/*
*	应用命名空间
*/
define('APP_NAMESPACE', 'App');

/*
*	应用目录入口
*/
define('APP_ROOT', WEB_ROOT . 'App'.OP);

/*
*	启动php-t
*/
require(WEB_ROOT .'Seventeen'.OP.'ourphp_boot.php');

?>