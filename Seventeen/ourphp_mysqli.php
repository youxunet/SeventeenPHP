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
use Seventeen\lib\style;

class ourphp_mysqli
{
    private $conn;
    private $dblang = 'utf8mb4';
    private $errmsg = '';
	private $prefix  = '';

    public function __construct($dburl = '', $dbname = '', $dbpass = '', $dbtabel = '', $mysqlport = 3306, $prefix = '')
    {
        mysqli_report(MYSQLI_REPORT_OFF);
		$this->prefix = $prefix;
		
        @$this->conn = mysqli_connect($dburl, $dbname, $dbpass, $dbtabel, $mysqlport);
        if (!$this->conn) {
            echo style::E('数据库链接出错, 请检查 Seventeen/ourphp_database.php');
            exit;
        }
        mysqli_set_charset($this->conn, $this->dblang);
    }

    public function __destruct()
    {
        $this->close();
    }

    public function close()
    {
        if ($this->conn) {
            mysqli_close($this->conn);
            $this->conn = null;
        }
    }

    /* ================= 核心：执行预处理 ================= */
    private function run($sql, array $params = [])
    {
        $this->errmsg = '';
        $stmt = mysqli_prepare($this->conn, $sql);
        if (!$stmt) {
            $this->errmsg = 'prepare failed: ' . mysqli_error($this->conn) . ' | ' . $sql;
            return false;
        }

        if ($params) {
            $types  = '';
            $values = [];
            foreach ($params as $v) {
                $values[] = $v;
                if (is_int($v) || is_bool($v))      $types .= 'i';
                elseif (is_float($v))               $types .= 'd';
                else                                $types .= 's';
            }
            $refs = [];
            $refs[] = &$types;
            foreach ($values as $i => $v) {
                $refs[] = &$values[$i];
            }
            call_user_func_array([$stmt, 'bind_param'], $refs);
        }

        if (!mysqli_stmt_execute($stmt)) {
            $this->errmsg = 'execute failed: ' . mysqli_stmt_error($stmt) . ' | ' . $sql;
            mysqli_stmt_close($stmt);
            return false;
        }
        return $stmt;
    }

    /* ================= 查询 ================= */
    // 查询一条记录，无数据返回 false
    public function select($o, $u, $r = '', array $params = [])
    {
        $stmt = $this->run("SELECT {$o} FROM {$u} {$r}", $params);
        if (!$stmt) return false;

        $res = mysqli_stmt_get_result($stmt);
        $row = $res ? mysqli_fetch_assoc($res) : false;
        if ($res) mysqli_free_result($res);
        mysqli_stmt_close($stmt);

        return $row ?: false;
    }

    // 查询记录集，返回二维数组（foreach 循环即可）
    public function listgo($o, $u, $r = '', array $params = [])
    {
        $stmt = $this->run("SELECT {$o} FROM {$u} {$r}", $params);
        if (!$stmt) return [];

        $res  = mysqli_stmt_get_result($stmt);
        $rows = $res ? mysqli_fetch_all($res, MYSQLI_ASSOC) : [];
        if ($res) mysqli_free_result($res);
        mysqli_stmt_close($stmt);

        return $rows;
    }

    /* ================= 插入 ================= */
    // 方式一：insert('表名', '字段=?,字段=?', '', [值1, 值2])  返回自增ID，失败返回 false
    public function insert($o, $u, $r = '', array $params = [])
    {
        $stmt = $this->run("INSERT INTO {$o} SET {$u} {$r}", $params);
        if (!$stmt) return false;

        $id = mysqli_insert_id($this->conn);
        mysqli_stmt_close($stmt);
        return $id;
    }

    // 方式二：批量插入，返回受影响行数
    // $info = ['table' => '字段1,字段2,字段3', 'data' => [[1,'a','x'],[2,'b','y']]]
    public function insertarray($o, $u, $r = '')
    {
        if (empty($u['table']) || empty($u['data'])) return false;

        $field = $u['table'];
        $rows  = [];
        $params = [];
        foreach ($u['data'] as $row) {
            $rows[] = '(' . implode(',', array_fill(0, count($row), '?')) . ')';
            foreach ($row as $v) $params[] = $v;
        }

        $sql  = "INSERT INTO {$o} ({$field}) VALUES " . implode(',', $rows) . " {$r}";
        $stmt = $this->run($sql, $params);
        if (!$stmt) return false;

        $n = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        return $n;
    }

    /* ================= 更新 / 删除 ================= */
    // update('表', '字段1=?,字段2=?', 'WHERE id=?', [值1, 值2, id])
    public function update($o, $u, $r = '', array $params = [])
    {
        $stmt = $this->run("UPDATE {$o} SET {$u} {$r}", $params);
        if (!$stmt) return false;

        $n = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        return $n;
    }

    // del('表', 'WHERE id=?', [id])
    public function del($o, $u = '', array $params = [])
    {
        $stmt = $this->run("DELETE FROM {$o} {$u}", $params);
        if (!$stmt) return false;

        $n = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        return $n;
    }

    /* ================= 建表 / 删表 / 任意 SQL ================= */
    public function create($o = '', $u = 1)
    {
        if ($u == 1) $o = 'CREATE TABLE ' . $o;
        return $this->run($o) !== false;
    }

    public function drop($o = '')
    {
        return $this->run("DROP TABLE {$o}") !== false;
    }

    // 任意 SQL（复杂查询、DDL、事务等都用它）
    public function query($sql, array $params = [])
    {
        return $this->run($sql, $params);
    }
	
	public function queryAll($sql, array $params = [])
	{
		$stmt = $this->run($sql, $params);
		if (!$stmt) return [];
		$res  = mysqli_stmt_get_result($stmt);
		$rows = $res ? mysqli_fetch_all($res, MYSQLI_ASSOC) : [];
		if ($res) mysqli_free_result($res);
		mysqli_stmt_close($stmt);
		return $rows;
	}

	public function queryRow($sql, array $params = [])
	{
		$rows = $this->queryAll($sql, $params);
		return $rows ? $rows[0] : false;
	}

	public function queryValue($sql, array $params = [])
	{
		$row = $this->queryRow($sql, $params);
		return $row ? reset($row) : null;
	}
	
    /* ================= 特殊 SQL 辅助 ================= */
    // IN 占位符：placeholders([1,2,3]) => "?,?,?"
    public function placeholders(array $arr)
    {
        $n = count($arr);
        return $n ? implode(',', array_fill(0, $n, '?')) : 'NULL';
    }

    // LIKE 参数处理：自动转义 % _ \ 并加通配符
    // $mode: both(两边) / left(左边) / right(右边) / none(不加)
    public function like($kw, $mode = 'both')
    {
        $kw = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $kw);
        if ($mode === 'both' || $mode === 'left')  $kw = '%' . $kw;
        if ($mode === 'both' || $mode === 'right') $kw = $kw . '%';
        return $kw;
    }

    /* ================= 其它 ================= */

    public function datatable($o = '')
    {
        return $this->prefix . $o;
    }

    public function other($o = '', $u = '', $r = '')
    {
        switch ($o) {
            case 'escape_string':
                return mysqli_real_escape_string($this->conn, $u);
            case 'num_fields':
                return mysqli_num_fields($u);
        }
        return false;
    }

    public function error()
    {
        return $this->errmsg ?: mysqli_error($this->conn);
    }
}
?>