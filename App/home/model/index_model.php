<?php
namespace App\home\model;
use Seventeen\lib\database;

class index_model
{
	public function __construct()
	{
		
	}
	
	public function sql()
	{
		$db = database::sql();
		//数据库开启设置为 true 不然报错
		
		//单条读取
		//$rs = $db->select('*', 'ourphp_web', 'WHERE id = ?', [1]);
		//if ($rs) {
		//	echo $rs['OP_Webadd'];
		//}
		
	}
	
}
?>