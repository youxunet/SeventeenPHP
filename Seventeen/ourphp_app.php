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
use Seventeen\lib\html;
use Seventeen\lib\style;

class ourphp_app
{
	public function __construct()
	{
		
	}
	
	public function run()
	{
		self::geturl();
	}
	
	private static function geturl()
	{
		
		global $config, $tpl;
		$weburl = strip_tags(htmlspecialchars(stripslashes($_SERVER['REQUEST_URI'])));
		if($weburl == '/' || $weburl == '/index.php' || empty($weburl))
		{
			
			$urlinfo[0] = $config['default_model'];
			$urlinfo[1] = $config['default_controller'];
			$urlinfo[2] = $config['default_function'];
			
			$par = [$urlinfo[0],$urlinfo[1],$urlinfo[2]];
			
		}else{
			
			$newweburl = str_replace("/index.php/","",$weburl);
			$newweburl = trim($newweburl,"/");
			$newweburl = explode("/",$newweburl);
			
			$urlinfo[0] = $newweburl[0];
			$urlinfo[1] = $newweburl[1];
			$urlinfo[2] = $newweburl[2];
			
			$par = self::parameter($newweburl);
			if($urlinfo[0] == 'version'): html::E(style::E(Seventeen . " " . $config['version'])); exit; endif;
		}
		
		self::judgmentnull($urlinfo[0], $urlinfo[1], $urlinfo[2]);
		self::controller($urlinfo[0], $urlinfo[1], $urlinfo[2], $par, $config, $tpl);
		
	}
	
	private static function parameter($array = [])
	{
		return $array;
	}
	
	private static function judgmentnull($model, $controller, $function)
	{
		$newmodel = APP_ROOT . $model;
		$newcontroller = APP_ROOT . $model . OP . "controller" . OP . $controller . "_controller.php";
		$newfunction = APP_NAMESPACE . "\\" . $model . "\\" . "controller" . "\\" . $controller . "_controller";
		
		if(!is_dir($newmodel))
		{
			html::E(style::E("模型 ".$newmodel." 未找到"));
			exit();
		}
		if(!file_exists($newcontroller))
		{
			html::E(style::E("控制器 ".$newcontroller." 未找到"));
			exit();
		}
		if(!class_exists($newfunction))
		{
			html::E(style::E("控制器类 ".$newfunction." 未找到"));
			exit();
		}
		if(!method_exists($newfunction, $function . "_function"))
		{
			html::E(style::E("控制器方法 ".$newfunction . "\\" . $function . "_function"." 未找到"));
			exit();
		}

	}
	
	public static function controller($model, $controller, $function, $geturlstr = [], $config, $tpl)
	{
		$viewpath = APP_ROOT . $model . OP . "view" . OP . $controller;
		$newmodel = '\\' . APP_NAMESPACE . '\\' . $model . '\model\\' . $controller . '_model';
		$newcontroller = '\\' . APP_NAMESPACE . '\\' . $model . '\controller\\' . $controller . '_controller';
		$newfunction = $function . "_function";

		$new = new $newcontroller($viewpath, $geturlstr, $config, $newmodel, $newfunction, $controller);
		$new -> $newfunction($tpl);
	}
	
}
?>