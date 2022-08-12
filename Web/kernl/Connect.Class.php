<?php
/* ---------------------------------------------------- */
/* 程序名称: 数据库连接函数库
/* 程序功能: 网页中所有数据库连接控制部分
/* 程序开发: Source
/* 联系方式: 542112943@qq.com
/* Date: 1970-01-01 / 2016-10-30
/* ---------------------------------------------------- */
/* 使用条款:
/* 1.该软件免费使用.
/* 2.禁止任何衍生版本.
/* ---------------------------------------------------- */
//error_reporting(0);

class DbMysql {
    private $DBSERVER; // 数据库主机
    private $USER; // 数据库用户名
    private $PASSWORD; // 数据库用户名密码
    private $DB; // 数据库名
    private $dou_link; // 数据库连接标识
    //private $prefix; // 数据库前缀
    //private $charset; // 数据库编码，GBK,UTF8,gb2312
    private $sql; // sql执行语句
    private $result; // 执行query命令的结果资源标识
    private $error_msg; // 数据库错误提示
                        
    // 构造函数
    function DbMysql($DBSERVER, $USER, $PASSWORD, $DB = '', $charset = 'utf8') {
        $this->DBSERVER = $DBSERVER;
        $this->USER = $USER;
        $this->PASSWORD = $PASSWORD;
        $this->DB = $DB;
       // $this->prefix = $prefix;
        $this->charset = strtolower(str_replace('-', '', $charset));
        $this->connect();
    }
    
    // 数据库连接	
    function connect() {
            if (!$this->dou_link = mysqli_connect($this->DBSERVER, $this->USER, $this->PASSWORD)) {
				$this->error('Can not connect to mysql server');
                return false;
            }

        
        if ($this->version() > '4.1') {
            if ($this->charset) {
                $this->query("SET character_set_connection=" . $this->charset . ", character_set_results=" . $this->charset .
                         ", character_set_client=binary");
            }
            
            if ($this->version() > '5.0.1') {
                $this->query("SET sql_mode=''");
            }
        }
        
        if (mysqli_select_db($this->dou_link , $this->DB) === false) {
            //$this->error("NO THIS DBNAME:" . $this->dbname);
            return false;
        }
    }
    
    // 数据库执行语句，可执行查询添加修改删除等任何sql语句
    function query($sql) {
        $this->sql = $sql;
        $query = mysqli_query($this->dou_link , $this->sql);
        return $query;
    }
    
    // 取得前一次 MySQL 操作所影响的记录行数
    function affected_rows() {
        return mysqli_affected_rows($this->dou_link);
    }
    
    // 返回结果集中一个字段的值
    function result($row = 0) {
        return @ mysqli_result($this->result, $row);
    }
    
    // 返回结果集中行的数目
    function num_rows($query) {
        return @ mysqli_num_rows($query);
    }
    
    // 返回结果集中字段的数
    function num_fields($query) {
        return mysqli_num_fields($query);
    }
    
    // 释放结果内存
    function free_result() {
        return mysqli_free_result($this->result);
    }
    
    // 返回上一步 INSERT 操作产生的 ID
    function insert_id() {
        return mysqli_insert_id();
    }
    
    // 获取下一个自增(id)值
    function auto_id($table) {
        return $this->get_one("SELECT auto_increment FROM information_schema.`TABLES` WHERE  TABLE_SCHEMA='" . $this->dbname . "' AND TABLE_NAME = '" . trim($this->table($table), '`') . "'");
    }
    
    // 从结果集中取得一行作为数字数组
    function fetch_row($query) {
        return mysqli_fetch_row($query);
    }
    
    // 从结果集中取得一行作为关联数组
    function fetch_assoc($query) {
        return mysqli_fetch_assoc($query);
    }
    
    // 从结果集取得的行生成的数组
    function fetch_array($query) {
        return mysqli_fetch_array($query);
    }
    
    // 返回 MySQL 服务器的信息
    function version() {
        if (empty($this->version)) {
            $this->version = mysqli_get_server_info($this->dou_link);
        }
        return $this->version;
    }
    
    // 关闭 MySQL 连接
    function close() {
        return mysqli_close($this->dou_link);
    }
    
    // 查询全部
    function select_all($table) {
        return $this->query("SELECT * FROM "  .$table . ';');
    }
    
    // 判断表是否存在
    function table_exist($table) {
        if($this->num_rows($this->query("SHOW TABLES LIKE '" . trim($table) . "'")) == 1)
            return true;
    }
    
    // 判断字段是否存在
    function field_exist($table, $field) {
        $sql = "SHOW COLUMNS FROM " . $table;
        $query = $this->query($sql);
        while($row = mysqli_fetch_array($query, MYSQL_ASSOC))   {
            $array[] = $row['Field'];
        }
        
        if (in_array($field, $array))
            return true;
    }
    
    // 验证信息是否已经存在
    function value_exist($table, $field, $value, $where = '') {
        $sql = "SELECT $field FROM " . $this->table($table) . " WHERE $field = '$value'" . $where;
        $number = $this->num_rows($this->query($sql));
        
        if ($number > 0)
            return true;
    }
    
    // 条件查询
    function select($table, $columnName = "*", $condition = '', $debug = '') {
        $condition = $condition ? ' Where ' . $condition : NULL;
        if ($debug) {
            echo "SELECT $columnName FROM $table $condition";
        } else {
            $query = $this->query("SELECT $columnName FROM $table $condition");
            return $query;
        }
    }
    
    // 删除数据
    function delete($table, $condition, $url = '') {
        if ($this->query("DELETE FROM $table WHERE $condition")) {
            if (!empty($url)) {
                $GLOBALS['dou']->dou_msg($GLOBALS['_LANG']['del_succes'], $url);
            }
        }
    }

    // 仿真 Adodb 函数
    function get_one($sql, $limited = false) {
        if ($limited == true) {
            $sql = trim($sql . ' LIMIT 1');
        }
        
        $res = $this->query($sql);
        if ($res !== false) {
            $row = mysql_fetch_row($res);
            
            if ($row !== false) {
                return $row[0];
            } else {
                return '';
            }
        } else {
            return false;
        }
    }
    
    // 转义特殊字符
    function escape_string($string) {
        if (PHP_VERSION >= '4.3') {
            return mysql_real_escape_string($string);
        } else {
            return mysql_escape_string($string);
        }
    }
    
    // 循环读取结果集并储存至数组
    function fetch_array_all($table, $order_by = '') {
        $order_by = $order_by ? " ORDER BY " . $order_by : '';
        $query = $this->query("SELECT * FROM " . $table . $order_by);
        while ($row = $this->fetch_assoc($query)) {
            $data[] = $row;
        }
        return $data;
    }
    
    // 返回错误信息
    function error($msg = '') {
        $msg = $msg ? "AS Error: $msg" : '<b>MySQL server error report</b><br>' . $this->error_msg;
        exit($msg);
    }
	
    // 执行错误信息
	function SystemError() {
        return mysqli_error($this->dou_link);
    }
	
    // 数据库导入
    function fn_execute($sql) {
        $sqls = $this->fn_split($sql);
        if (is_array($sqls)) {
            foreach ($sqls as $sql) {
                if (trim($sql) != '')
                    $this->query($sql);
            }
        } else {
            $this->query($sqls);
        }
        return true;
    }
 
    // 数据分离
    function fn_split($sql) {
        if ($this->version() > '4.1' && $this->sqlcharset)
            $sql = preg_replace("/TYPE=(InnoDB|MyISAM)( DEFAULT CHARSET=[^; ]+)?/", "TYPE=\\1 DEFAULT CHARSET=" . $this->sqlcharset, $sql);
        
        $sql = str_replace("\r", "\n", $sql);
        $ret = array ();
        $num = 0;
        $queriesarray = explode(";\n", trim($sql));
        unset($sql);
        foreach ($queriesarray as $query) {
            $ret[$num] = '';
            $queries = explode("\n", trim($query));
            $queries = array_filter($queries);
            foreach ($queries as $query) {
                $str1 = substr($query, 0, 1);
                if ($str1 != '#' && $str1 != '-')
                    $ret[$num] .= $query;
            }
            $num++;
        }
        return ($ret);
    }
}




//function ConnectSQL() //连接数据库
//{ 
	//$con = mysqli_connect(DBSERVER,USER,PASSWORD);
	//$select = mysqli_select_db($con,DB);
 	// if (!$con)
  	//{
  	//die('无法连接到数据库: ' . mysqli_error($con));
 	// }
  	//if (!$select)
  	//{
 	 //die('初始化数据表失败: ' . mysqli_error($con));
  	//}  
	//return $con; 

//} 


class DataQuery     
{ 
	//数据查询
	public static function SQLQuery($sql,$require,$sort,$tocken) //语句、条件、排序方式、校验码（系统自身查询校验码为system）
	{
	$Que = mysqli_query($query,$sql);
	$row = mysqli_fetch_array($Que);
	return $row;
	echo $row;
	}

} 

//$query = ConnectSQL();
//mysqli_query($query,"set names utf8");

?>
