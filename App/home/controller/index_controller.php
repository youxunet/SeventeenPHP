<?php
namespace App\home\controller;
use Seventeen\lib\html;

class index_controller
{
	public $viewpath;
	public $geturlstr;
	public $config;
	public $model;
	public $functions;
	public $controller;

	public function __construct($viewpath, $geturlstr, $config, $model, $function, $controller)
	{
		$this -> viewpath = $viewpath;
		$this -> geturlstr = $geturlstr;
		$this -> config = $config;
		$this -> model = $model;
		$this -> functions = $function;
		$this -> controller = $controller;
	}
	
	public function index_function($tpl = null)
	{
		//配置文件（必须）
		$config = $this -> config;
		//URL传入参数 array（必须）
		$geturlstr = $this -> geturlstr;
		//加载数据库操作（必须）
		$model = "\\App\\".$geturlstr[0]."\\model\\".$this -> controller."_model";
		$data = new $model;
		/*
			方法一的业务逻辑，可根据URL在本类中添加更多方法
		*/
		//演示调用数据库数据
		$demo = $data -> sql();


		$tpl->assign('title', 'SeventeenPHP!');
		
		
		/*
			业务逻辑结束
		*/
		//加载视图层
		$tpl->display(html::I($this -> viewpath . ".html"));
	}
	
}
?>