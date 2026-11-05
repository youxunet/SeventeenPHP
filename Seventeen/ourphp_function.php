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

class ourphp_function
{
	
	public function __construct()
	{
		
	}
	
	public static function dowith_sql($ourphpstr)
	{
        $ourphpstr = addslashes($ourphpstr);
        $ourphpstr = str_ireplace("and","**",$ourphpstr);
        $ourphpstr = str_ireplace("or","**",$ourphpstr);
        $ourphpstr = str_ireplace("&&","**",$ourphpstr);
        $ourphpstr = str_ireplace("||","**",$ourphpstr);
        $ourphpstr = str_ireplace("<script","**",$ourphpstr);
        $ourphpstr = str_ireplace("<iframe","**",$ourphpstr);
        $ourphpstr = str_ireplace("<embed","**",$ourphpstr);
        $ourphpstr = str_ireplace("<","&lt;",$ourphpstr);
        $ourphpstr = str_ireplace(">","&gt;",$ourphpstr);
        $ourphpstr = str_ireplace("&","&amp;",$ourphpstr);
        $ourphpstr = str_ireplace('--',"**",$ourphpstr);
        $ourphpstr = str_ireplace("%","\%",$ourphpstr);
        $ourphpstr = str_ireplace("'","**",$ourphpstr);
        $ourphpstr = str_ireplace("ascii","<span>ascii</span>",$ourphpstr);
        $ourphpstr = str_ireplace("alert","<span>alert</span>",$ourphpstr);
        $ourphpstr = str_ireplace("count","<span>count</span>",$ourphpstr);
        $ourphpstr = str_ireplace("chr","<span>chr</span>",$ourphpstr);
        $ourphpstr = str_ireplace("char","<span>char</span>",$ourphpstr);
        $ourphpstr = str_ireplace("concat","<span>concat</span>",$ourphpstr);
        $ourphpstr = str_ireplace("columns","<span>columns</span>",$ourphpstr);
        $ourphpstr = str_ireplace("declare","<span>declare</span>",$ourphpstr);
        $ourphpstr = str_ireplace("delete","<span>delete</span>",$ourphpstr);
        $ourphpstr = str_ireplace("document","<span>document</span>",$ourphpstr);
        $ourphpstr = str_ireplace("database","<span>database</span>",$ourphpstr);
        $ourphpstr = str_ireplace("execute","<span>execute</span>",$ourphpstr);
        $ourphpstr = str_ireplace("extractvalue","<span>extractvalue</span>",$ourphpstr);
        $ourphpstr = str_ireplace("eval","<span>eval</span>",$ourphpstr);
        $ourphpstr = str_ireplace("encode","<span>encode</span>",$ourphpstr);
        $ourphpstr = str_ireplace("from","<span>from</span>",$ourphpstr);
        $ourphpstr = str_ireplace("group_concat","<span>group_concat</span>",$ourphpstr);
        $ourphpstr = str_ireplace("information_schema","<span>information_schema</span>",$ourphpstr);
        $ourphpstr = str_ireplace("insert","<span>insert</span>",$ourphpstr);
        $ourphpstr = str_ireplace("if","<span>if</span>",$ourphpstr);
        $ourphpstr = str_ireplace("join","<span>join</span>",$ourphpstr);
        $ourphpstr = str_ireplace("length","<span>length</span>",$ourphpstr);
        $ourphpstr = str_ireplace("limit","<span>limit</span>",$ourphpstr);
        $ourphpstr = str_ireplace("onmouseover","<span>onmouseover</span>",$ourphpstr);
        $ourphpstr = str_ireplace("print","<span>print</span>",$ourphpstr);
        $ourphpstr = str_ireplace("password","<span>password</span>",$ourphpstr);
        $ourphpstr = str_ireplace("replace","<span>replace</span>",$ourphpstr);
        $ourphpstr = str_ireplace("regexp_replace","<span>regexp_replace</span>",$ourphpstr);
        $ourphpstr = str_ireplace("substr","<span>substr</span>",$ourphpstr);
        $ourphpstr = str_ireplace("sleep","<span>sleep</span>",$ourphpstr);
        $ourphpstr = str_ireplace("select","<span>select</span>",$ourphpstr);
        $ourphpstr = str_ireplace("truncate","<span>truncate</span>",$ourphpstr);
        $ourphpstr = str_ireplace("tables","<span>tables</span>",$ourphpstr);
        $ourphpstr = str_ireplace("union","<span>union</span>",$ourphpstr);
        $ourphpstr = str_ireplace("updatexml","<span>updatexml</span>",$ourphpstr);
        $ourphpstr = str_ireplace("username","<span>username</span>",$ourphpstr);
        $ourphpstr = str_ireplace("update","<span>update</span>",$ourphpstr);
        $ourphpstr = str_ireplace("where","<span>where</span>",$ourphpstr);
		return $ourphpstr;
	}
	
	public static function admin_sql($ourphpstr){
        $ourphpstr = str_ireplace("'","",$ourphpstr);
        $ourphpstr = str_ireplace(" and ","<span>and</span>",$ourphpstr);
        $ourphpstr = str_ireplace(" or ","<span>or</span>",$ourphpstr);
        $ourphpstr = str_ireplace("&&","<span>&&</span>",$ourphpstr);
        $ourphpstr = str_ireplace("||","<span>||</span>",$ourphpstr);
        $ourphpstr = str_ireplace("ascii","<span>ascii</span>",$ourphpstr);
        $ourphpstr = str_ireplace("columns","<span>columns</span>",$ourphpstr);
        $ourphpstr = str_ireplace("count","<span>count</span>",$ourphpstr);
        $ourphpstr = str_ireplace("concat","<span>concat</span>",$ourphpstr);
        $ourphpstr = str_ireplace("database","<span>database</span>",$ourphpstr);
        $ourphpstr = str_ireplace("delete","<span>delete</span>",$ourphpstr);
        $ourphpstr = str_ireplace("execute","<span>execute</span>",$ourphpstr);
        $ourphpstr = str_ireplace("encode","<span>encode</span>",$ourphpstr);
        $ourphpstr = str_ireplace("from","<span>from</span>",$ourphpstr);
        $ourphpstr = str_ireplace("group_concat","<span>group_concat</span>",$ourphpstr);
        $ourphpstr = str_ireplace("information_schema","<span>information_schema</span>",$ourphpstr);
        $ourphpstr = str_ireplace("insert","<span>insert</span>",$ourphpstr);
        $ourphpstr = str_ireplace("if","<span>if</span>",$ourphpstr);
        $ourphpstr = str_ireplace("join","<span>join</span>",$ourphpstr);
        $ourphpstr = str_ireplace("length","<span>length</span>",$ourphpstr);
        $ourphpstr = str_ireplace("print","<span>print</span>",$ourphpstr);
        $ourphpstr = str_ireplace("password","<span>password</span>",$ourphpstr);
        $ourphpstr = str_ireplace("replace","<span>replace</span>",$ourphpstr);
        $ourphpstr = str_ireplace("regexp_replace","<span>regexp_replace</span>",$ourphpstr);
        $ourphpstr = str_ireplace("substr","<span>substr</span>",$ourphpstr);
        $ourphpstr = str_ireplace("sleep","<span>sleep</span>",$ourphpstr);
        $ourphpstr = str_ireplace("select","<span>select</span>",$ourphpstr);
        $ourphpstr = str_ireplace("tables","<span>tables</span>",$ourphpstr);
        $ourphpstr = str_ireplace("union","<span>union</span>",$ourphpstr);
        $ourphpstr = str_ireplace("updatexml","<span>updatexml</span>",$ourphpstr);
        $ourphpstr = str_ireplace("username","<span>username</span>",$ourphpstr);
        $ourphpstr = str_ireplace("update","<span>update</span>",$ourphpstr);
        $ourphpstr = str_ireplace("where","<span>where</span>",$ourphpstr);
        $ourphpstr = str_ireplace("white-space:n<span>or</span>mal;","white-space:normal;",$ourphpstr);
        $ourphpstr = str_ireplace("data-<span>or</span>iginal","data-original",$ourphpstr);
		return $ourphpstr;
	}
	
	public static function abslength($str){
		if(empty($str)){
			return 0;
		}
		if(function_exists('mb_strlen')){
			return mb_strlen($str,'utf-8');
		}
		else {
			preg_match_all("/./u", $str, $ar);
			return count($ar[0]);
		}
	}
}
?>