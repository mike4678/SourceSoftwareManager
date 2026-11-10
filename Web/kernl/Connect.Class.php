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
/* 安全修订说明（2026）：
/*  1. 移除 PHP4 风格构造函数，改为 __construct
/*  2. 移除已删除的 mysql_* 函数（PHP7 起不可用），统一使用 mysqli
/*  3. 新增 quote() / escape() / ident() 三个安全转义入口
/*     - 所有外部输入进入 SQL 前必须经过 quote()/ident()
/*     - 表名、字段名必须经过 ident() 白名单校验，杜绝结构注入
/*  4. 编码统一 utf8mb4，避免宽字节注入
/* ---------------------------------------------------- */

class DbMysql
{
    private $DBSERVER;     // 数据库主机
    private $USER;         // 数据库用户名
    private $PASSWORD;     // 数据库用户名密码
    private $DB;           // 数据库名
    private $charset;      // 数据库编码，GBK,UTF8,gb2312
    private $dou_link;     // 数据库连接标识
    public  $sql;          // sql执行语句
    public  $result;       // 执行query命令的结果资源标识
    private $error_msg;    // 数据库错误提示
    public  $server_version; // 服务器版本

    // 构造函数
    function __construct($DBSERVER, $USER, $PASSWORD, $DB = '', $charset = 'utf8')
    {
        $this->DBSERVER = $DBSERVER;
        $this->USER     = $USER;
        $this->PASSWORD = $PASSWORD;
        $this->DB       = $DB;
        $this->charset  = strtolower(str_replace('-', '', (string)$charset));
        if ($this->charset === 'utf8') {
            $this->charset = 'utf8mb4';
        }
        $this->connect();
    }

    // 数据库连接
    function connect()
    {
        // 关闭 mysqli 的异常抛出，保持老代码“返回 false”的调用习惯
        if (function_exists('mysqli_report')) {
            @mysqli_report(MYSQLI_REPORT_OFF);
        }
        $link = @mysqli_connect($this->DBSERVER, $this->USER, $this->PASSWORD);
        if (!$link) {
            $this->error_msg = 'Can not connect to mysql server: ' . mysqli_connect_error();
            $this->error('Can not connect to mysql server');
            return false;
        }
        $this->dou_link = $link;
        @mysqli_set_charset($this->dou_link, $this->charset);
        if (@mysqli_select_db($this->dou_link, $this->DB) === false) {
            return false;
        }
        return true;
    }

    // 数据库执行语句，可执行查询添加修改删除等任何sql语句
    function query($sql)
    {
        $this->sql = $sql;
        $query = @mysqli_query($this->dou_link, $this->sql);
        if ($query === false) {
            $this->error_msg = mysqli_error($this->dou_link);
        }
        return $query;
    }

    /* ---------------- 安全转义入口 ---------------- */

    /** 转义字符串内容（不含引号），用于拼接进 SQL 字面量内部 */
    function escape($string)
    {
        return mysqli_real_escape_string($this->dou_link, (string)$string);
    }

    /** 把任意值转成带引号的 SQL 字面量；null 转成 NULL */
    function quote($value)
    {
        if ($value === null) {
            return 'NULL';
        }
        if (is_int($value) || is_float($value)) {
            return (string)$value;
        }
        return "'" . mysqli_real_escape_string($this->dou_link, (string)$value) . "'";
    }

    /**
     * 校验标识符（表名/字段名）
     * 仅允许 字母 数字 下划线，且允许为空时的默认值
     */
    function ident($name, $default = '')
    {
        $name = trim((string)$name);
        if (!preg_match('/^[A-Za-z0-9_]{1,64}$/', $name)) {
            return $default === '' ? '``' : '`' . $default . '`';
        }
        return '`' . $name . '`';
    }

    /** 只允许通过的标识符原样返回（用于拼 WHERE 列名等），失败返回 false */
    function safeIdent($name)
    {
        if (preg_match('/^[A-Za-z0-9_]{1,64}$/', trim((string)$name))) {
            return trim($name);
        }
        return false;
    }

    // 取得前一次 MySQL 操作所影响的记录行数
    function affected_rows()
    {
        return mysqli_affected_rows($this->dou_link);
    }

    // 返回结果集中一个字段的值
    function result($row = 0)
    {
        if (!($this->result instanceof mysqli_result)) {
            return false;
        }
        if (!@mysqli_data_seek($this->result, (int)$row)) {
            return false;
        }
        $r = @mysqli_fetch_row($this->result);
        return $r === false || $r === null ? false : $r[0];
    }

    // 返回结果集中行的数目
    function num_rows($query)
    {
        if (!($query instanceof mysqli_result)) {
            return 0;
        }
        return @mysqli_num_rows($query);
    }

    // 返回结果集中字段的数
    function num_fields($query)
    {
        if (!($query instanceof mysqli_result)) {
            return 0;
        }
        return @mysqli_num_fields($query);
    }

    // 释放结果内存
    function free_result()
    {
        if ($this->result instanceof mysqli_result) {
            return mysqli_free_result($this->result);
        }
        return false;
    }

    // 返回上一步 INSERT 操作产生的 ID
    function insert_id()
    {
        return mysqli_insert_id($this->dou_link);
    }

    // 获取下一个自增(id)值
    function auto_id($table)
    {
        $tbl = $this->safeIdent($table);
        if ($tbl === false) {
            return false;
        }
        return $this->get_one(
            "SELECT auto_increment FROM information_schema.`TABLES` WHERE TABLE_SCHEMA = "
            . $this->quote($this->DB) . " AND TABLE_NAME = " . $this->quote($tbl)
        );
    }

    // 从结果集中取得一行作为数字数组
    function fetch_row($query)
    {
        if (!($query instanceof mysqli_result)) {
            return false;
        }
        return @mysqli_fetch_row($query);
    }

    // 从结果集中取得一行作为关联数组
    function fetch_assoc($query)
    {
        if (!($query instanceof mysqli_result)) {
            return false;
        }
        return @mysqli_fetch_assoc($query);
    }

    // 从结果集取得的行生成的数组
    function fetch_array($query)
    {
        if (!($query instanceof mysqli_result)) {
            return false;
        }
        return @mysqli_fetch_array($query);
    }

    // 返回 MySQL 服务器的信息
    function version()
    {
        if (empty($this->server_version)) {
            $this->server_version = @mysqli_get_server_info($this->dou_link);
        }
        return $this->server_version;
    }

    // 关闭 MySQL 连接
    function close()
    {
        return @mysqli_close($this->dou_link);
    }

    // 查询全部
    function select_all($table)
    {
        $tbl = $this->safeIdent($table);
        if ($tbl === false) {
            return false;
        }
        return $this->query("SELECT * FROM `" . $tbl . "`");
    }

    // 判断表是否存在
    function table_exist($table)
    {
        $tbl = $this->safeIdent($table);
        if ($tbl === false) {
            return false;
        }
        return $this->num_rows($this->query("SHOW TABLES LIKE " . $this->quote($tbl))) == 1;
    }

    // 判断字段是否存在
    function field_exist($table, $field)
    {
        $tbl = $this->safeIdent($table);
        if ($tbl === false) {
            return false;
        }
        $sql   = "SHOW COLUMNS FROM `" . $tbl . "`";
        $query = $this->query($sql);
        $array = array();
        while ($row = $this->fetch_array($query)) {
            $array[] = $row['Field'];
        }
        return in_array($field, $array, true);
    }

    // 验证信息是否已经存在
    function value_exist($table, $field, $value)
    {
        $tbl = $this->safeIdent($table);
        $col = $this->safeIdent($field);
        if ($tbl === false || $col === false) {
            return false;
        }
        $sql    = "SELECT `" . $col . "` FROM `" . $tbl . "` WHERE `" . $col . "` = " . $this->quote($value);
        $number = $this->num_rows($this->query($sql));
        return $number > 0;
    }

    // 条件查询
    function select($table, $columnName = "*", $condition = '', $debug = '')
    {
        $tbl     = $this->safeIdent($table);
        if ($tbl === false) {
            return false;
        }
        $columns = $columnName === '*' ? '*' : $columnName; // 由调用方保证，均来自内部常量
        $cond    = $condition ? ' Where ' . $condition : '';
        $sql     = "SELECT $columns FROM `$tbl` $cond";
        if ($debug) {
            echo htmlspecialchars($sql, ENT_QUOTES, 'UTF-8');
            return null;
        }
        return $this->query($sql);
    }

    // 删除数据
    function delete($table, $condition)
    {
        $tbl = $this->safeIdent($table);
        if ($tbl === false) {
            return false;
        }
        return $this->query("DELETE FROM `$tbl` WHERE $condition");
    }

    // 仿真 Adodb 函数
    function get_one($sql, $limited = false)
    {
        if ($limited === true) {
            $sql = trim($sql . ' LIMIT 1');
        }
        $res = $this->query($sql);
        if ($res !== false) {
            $row = $this->fetch_row($res);
            return ($row !== false && $row !== null) ? $row[0] : '';
        }
        return false;
    }

    // 转义特殊字符（兼容旧调用）
    function escape_string($string)
    {
        return $this->escape($string);
    }

    // 循环读取结果集并储存至数组
    function fetch_array_all($table, $order_by = '')
    {
        $tbl = $this->safeIdent($table);
        if ($tbl === false) {
            return array();
        }
        $order = $order_by ? " ORDER BY " . $order_by : '';
        $query = $this->query("SELECT * FROM `" . $tbl . "`" . $order);
        $data  = array();
        while ($row = $this->fetch_assoc($query)) {
            $data[] = $row;
        }
        return $data;
    }

    // 返回错误信息
    function error($msg = '')
    {
        $msg = $msg ? "AS Error: $msg" : '<b>MySQL server error report</b><br>' . $this->error_msg;
        // 不再把数据库细节直接回显给访问者
        $this->WriteFatalLog($msg);
        exit('数据库服务暂时不可用，请稍后重试');
    }

    /** 把数据库错误写入日志，不回显（避免泄露表结构/路径） */
    private function WriteFatalLog($msg)
    {
        $line = '[' . date('Y-m-d H:i:s') . '] ' . $msg . ' URI=' . (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '-') . PHP_EOL;
        $logDir = defined('ROOT_PATH') ? ROOT_PATH . 'logs' : dirname(__FILE__) . '/../logs';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0750, true);
        }
        @file_put_contents($logDir . '/db_error.log', $line, FILE_APPEND);
    }

    // 执行错误信息
    function SystemError()
    {
        return mysqli_error($this->dou_link);
    }

    // 数据库导入
    function fn_execute($sql)
    {
        $sqls = $this->fn_split($sql);
        if (is_array($sqls)) {
            foreach ($sqls as $s) {
                if (trim($s) != '') {
                    $this->query($s);
                }
            }
        } else {
            $this->query($sqls);
        }
        return true;
    }

    // 数据分离
    function fn_split($sql)
    {
        if ($this->version() > '4.1' && !empty($this->charset)) {
            $sql = preg_replace("/TYPE=(InnoDB|MyISAM)( DEFAULT CHARSET=[^; ]+)?/", "TYPE=\\1 DEFAULT CHARSET=" . $this->charset, $sql);
        }
        $sql          = str_replace("\r", "\n", $sql);
        $ret          = array();
        $num          = 0;
        $queriesarray = explode(";\n", trim($sql));
        unset($sql);
        foreach ($queriesarray as $query) {
            $ret[$num] = '';
            $queries   = explode("\n", trim($query));
            $queries   = array_filter($queries);
            foreach ($queries as $q) {
                $str1 = substr($q, 0, 1);
                if ($str1 != '#' && $str1 != '-') {
                    $ret[$num] .= $q;
                }
            }
            $num++;
        }
        return $ret;
    }
}

/* ---------------------------------------------------- */
/* 输出转义 / 输入过滤通用函数（全局可用）
/* ---------------------------------------------------- */

/** HTML 上下文转义 */
function h($value, $flags = ENT_QUOTES)
{
    if (is_array($value)) {
        return '';
    }
    return htmlspecialchars((string)$value, $flags | ENT_SUBSTITUTE, 'UTF-8');
}

/** JSON / JS 字符串上下文 */
function js_str($value)
{
    $json = json_encode((string)$value, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    return $json === false ? '""' : $json;
}

/** 用于嵌入在 JS 字符串中的 HTML 文本：去标签、去引号、去反斜杠 */
function js_text($value)
{
    $s = (string)$value;
    $s = preg_replace('/<br\s*\/?>/i', "\n", $s);
    $s = strip_tags($s);
    $s = str_replace(array('"', "'", '\\'), array('＂', '＇', '＼'), $s);
    $s = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $s);
    return $s;
}

/** 严格整数 */
function to_int($value, $default = 0)
{
    if (is_int($value)) {
        return $value;
    }
    if (is_string($value) && preg_match('/^-?[0-9]{1,20}$/', trim($value))) {
        return (int)trim($value);
    }
    return $default;
}

