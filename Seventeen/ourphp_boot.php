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

header("Content-Type:text/html; charset=UTF-8"); 
header("Cache-Control:no-cache");

require_once(WEB_ROOT . 'Seventeen' . OP . 'ourphp_config.php');
require_once(WEB_ROOT . 'Seventeen' . OP . 'ourphp_autoload.php');

session_start();
date_default_timezone_set($config['timezone']);
spl_autoload_register("ourphp_autoload");


$tpl = new Seventeen\ourphp_templates(__DIR__ . '/tpl/');
$app = new Seventeen\ourphp_app;
$app -> run();

?>