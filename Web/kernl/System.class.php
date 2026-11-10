<?php
/* ---------------------------------------------------- */
/* 程序名称: 核心函数
/* 程序功能: 所有核心函数的调用均在此页面中
/* 程序开发: Source
/* 联系方式: 542112943@qq.com
/* Date: 1970-01-01 / 2019-01-01
/* ---------------------------------------------------- */
/* 使用条款:
/* 1.该软件免费使用.
/* 2.禁止任何衍生版本.
/* ---------------------------------------------------- */
/* 安全修订说明（2026）：
/*  1. 删除 switch/循环之外的 break（PHP7 起为致命语法错误）
/*  2. 所有拼接进 SQL 的外部输入统一走 quote() / safeIdent() 白名单
/*  3. 所有回显到 HTML 的变量统一走 h() 转义；嵌入 JS 的走 js_text()
/*  4. 登录态由可伪造的明文 Cookie 改为 服务端会话 + HMAC 签名令牌
/*  5. 调试入口（Browse 系统信息/探针）不再向未登录用户暴露
/* ---------------------------------------------------- */

class System extends DbMysql
{
    /* ---------------------------------------------------- */
    /* 系统设置表信息                                        */
    /* ---------------------------------------------------- */
    function Info($data)
    {
        $query = $this->query("SELECT `value` FROM `zd_system_setting` WHERE `vars` = " . $this->quote($data) . " LIMIT 1");
        $row   = $this->fetch_array($query);
        if (!$row) {
            return null;
        }
        return $row[0];
    }
    /* ---------------------------------------------------- */

    /* 软件设置表信息                                        */
    function SInfo($data)
    {
        $row = $this->fetch_array($this->query("SELECT * FROM `zd_config` LIMIT 1"));
        if (!$row || !isset($row[$data])) {
            return null;
        }
        return $row[$data];
    }
    /* ---------------------------------------------------- */

    /* 软件信息                                             */
    function SoftwareDataInfo($various, $id)
    {
        $col = $this->safeIdent($various);
        if ($col === false) {
            return null;
        }
        $query = $this->query("SELECT `" . $col . "` FROM `zd_software` WHERE `id` = " . to_int($id) . " LIMIT 1");
        $row   = $this->fetch_array($query);
        if (!$row) {
            return null;
        }
        return $row[$col];
    }
    /* ---------------------------------------------------- */

    /* 删除一条或多条数据                                    */
    /* 参数：表$table, 条件头$hterm, 条件$term, 操作方式$method */
    function DelData($table, $hterm, $term, $method)
    {
        $tbl  = $this->safeIdent($table);
        $col  = $this->safeIdent($hterm);
        $term = (string)$term;
        if ($tbl === false || $col === false || $table === '' || $hterm === '' || $term === '' || $method === '') {
            echo '<meta charset="utf-8"><script language="JavaScript">window.alert("操作请求所需要的值错误，请检查！")</script>';
            return false;
        }

        // 条件值只允许“纯数字”或“数字,数字,...”，彻底消除注入面
        $ids = array();
        foreach (explode(',', $term) as $piece) {
            $piece = trim($piece);
            if (preg_match('/^[0-9]{1,20}$/', $piece)) {
                $ids[] = (int)$piece;
            }
        }
        if (empty($ids)) {
            echo '<meta charset="utf-8"><script language="JavaScript">window.alert("参数格式不正确")</script>';
            return false;
        }

        $list = implode(',', $ids);
        $sql  = "DELETE FROM `" . $tbl . "` WHERE `" . $col . "` IN (" . $list . ")";
        if (!$this->query($sql)) {
            echo '<meta charset="utf-8"><script language="JavaScript">window.alert("删除失败！")</script>';
        } else {
            echo '<meta charset="utf-8"><script language="JavaScript">window.alert("删除成功！")</script>';
        }
        echo '<script language="JavaScript">self.location=document.referrer;</script>';
        return true;
    }
    /* ---------------------------------------------------- */

    /* 页面功能生成：自动生成后台左侧列表                     */
    function table_list_New($table, $table_list)
    {
        if (empty($table)) {
            echo '<meta charset="utf-8"><script language="JavaScript">window.alert("初始化页面失败！");history.back(-1);</script>';
            return '';
        }
        $tab         = '';
        $TableData   = explode("|", (string)$this->Info("system_table"));
        foreach ($TableData as $val) {
            $row = explode(";", $val);
            if (empty($row[0])) {
                continue;
            }
            $tab .= "<li><a class='waves-effect parent-item js__control' href='#'><i class='menu-icon mdi mdi-desktop-mac'></i><span>"
                . h($row[0]) . "</span><span class='menu-arrow fa fa-angle-down'></span></a><ul class='sub-menu js__content'>";
            $list = $this->query(
                "SELECT * FROM `zd_adminlist` WHERE `table` = " . $this->quote($row[0]) . " ORDER BY `count` ASC"
            );
            while ($row1 = $this->fetch_array($list)) {
                $tab .= "<li><a href='" . h($row1['url']) . "'>" . h($row1['menu']) . "</a></li>";
            }
            $tab .= "</ul></li>";
        }
        return $tab;
    }

    /* 前台左侧分类列表                                       */
    function front_table_list()
    {
        $index_d = 'index.php';
        $tab     = "<li><a class='waves-effect parent-item js__control' href='" . h($index_d) . "'><i class='menu-icon mdi mdi-desktop-mac' style='top:13px;left:5px'></i><span>软件分类</span><span class='menu-arrow fa fa-angle-down'></span></a><ul class='sub-menu js__content'><li><a href='" . h($index_d) . "'> |- 全部软件 </a></li>";
        $sql     = "SELECT `type` FROM `zd_type` ORDER BY `uid` ASC";
        $result  = $this->query($sql);
        while ($row = $this->fetch_array($result)) {
            if ((string)$row['type'] === '') {
                continue;
            }
            // 前台使用 ?/分类 形式，需与 AddrConvery 的解析规则一致
            $tab .= "<li><a href='index.php?/" . rawurlencode($row['type']) . "'> |- " . h($row['type']) . "</a></li>";
        }
        $tab .= "</ul></li>";
        return $tab;
    }

    /* 后台导航栏内容                                         */
    function navigation($table, $table_list)
    {
        $TaskBar = '';
        if (empty($table) || empty($table_list)) {
            echo '<meta charset="utf-8"><script language="JavaScript">window.alert("初始化导航栏失败！");history.back(-1);</script>';
            return '';
        }
        $query = $this->query(
            "SELECT * FROM `zd_adminlist` WHERE `table` = " . $this->quote($table)
            . " AND `menu` = " . $this->quote($table_list) . " ORDER BY `count` ASC LIMIT 1"
        );
        while ($row = $this->fetch_array($query)) {
            $TaskBar  = "<a href='admin.php' class='icon-home'> 首页</a> > ";
            $TaskBar .= "<ui>" . h($row['table']) . "管理</ui> > ";
            $TaskBar .= h($table_list);
            break;
        }
        return $TaskBar;
    }

    /* 将英文名称转换为中文（返回一条 zd_adminlist 记录）      */
    function convert($table, $table_list)
    {
        $query = $this->query(
            "SELECT * FROM `zd_adminlist` WHERE `t_e` = " . $this->quote($table)
            . " AND `m_e` = " . $this->quote($table_list) . " LIMIT 1"
        );
        $row = $this->fetch_array($query);
        return $row ? $row : array();
    }

    /**
     * 处理请求地址（把 ?/a/b/c 形式的伪静态参数拆成数组）
     * 返回值做了字符白名单过滤，避免后续拼 SQL / 拼文件路径时被注入
     */
    function AddrConvery($data)
    {
        $raw = array();
        if (is_array($data) && count($data) > 0) {
            reset($data);
            $first_key = key($data);
            $raw       = explode('/', (string)$first_key);
        }
        $clean = array();
        foreach ($raw as $part) {
            // 允许中文、字母、数字、下划线、连字符、点（用于 id 判断）
            $part = preg_replace('/[^\p{Han}\p{Latin}\p{N}_\-\.]/u', '', (string)$part);
            if (function_exists('mb_substr')) {
                $part = mb_substr($part, 0, 100, 'UTF-8');
            } else {
                $part = substr($part, 0, 100);
            }
            $clean[] = $part;
        }
        return $clean;
    }

    /* 只保留安全的查询字符串（用于回显 URL）                  */
    function SafeQueryString()
    {
        $qs = isset($_SERVER['QUERY_STRING']) ? (string)$_SERVER['QUERY_STRING'] : '';
        $qs = preg_replace('/[^\p{Han}\p{Latin}\p{N}_\-\.\/=&%]/u', '', $qs);
        // 去掉可能的目录穿越与协议注入
        $qs = str_replace(array('../', '..\\', '://'), '', $qs);
        return $qs;
    }

    /* 载入框架页面                                           */
    function PageLoading($table, $table_list = '')
    {
        $query = $this->query(
            "SELECT `page` FROM `zd_adminlist` WHERE `table` = " . $this->quote($table)
            . " AND `menu` = " . $this->quote($table_list) . " LIMIT 1"
        );
        $row = $this->fetch_array($query);
        return $row ? $row['page'] : '';
    }

    /* 检查框架页面是否被外部直接访问                          */
    function FormCheck($address = '')
    {
        $address = (string)$address;
        echo '<script>if(window.top==window.self){window.alert("请勿试图在非授权区域运行！");'
            . $this->WriteLog('Get', '试图从外部访问地址:' . $address . '已被拦截', $address)
            . ';var browserName=navigator.appName;if(browserName=="Netscape"){window.opener=null;window.open("","_self");window.close();}else{open(location,"_self").close();window.location.href="about:blank";window.close();}}</script>';
    }

    /* 多选项夹生成                                           */
    function FormCreate($data)
    {
        $form = '<div class="col-xs-12"><div class="box-content"><div class="row"><div class="col-md-12"><ul class="nav nav-tabs" id="myTabs" role="tablist">';
        unset($data['TabName']);
        foreach ($data as $row) {
            if (!isset($row['tab'], $row['Name'])) {
                continue;
            }
            $active = (isset($row['active']) && $row['active'] === 'active') ? ' class="active"' : '';
            $form  .= "<li role=\"presentation\"" . $active . "><a href=\"" . h($row['tab']) . "\" role=\"tab\" id=\"" . h($row['tab'])
                . "\" data-toggle=\"tab\" aria-controls=\"" . h($row['tab']) . "\">" . h($row['Name']) . "</a></li>";
        }
        $form .= "</ul>";
        echo $form;
    }

    /* 读入页面参数                                           */
    function PageValue($table, $table_list = '')
    {
        // zd_content_data 无 value 字段，保留方法以兼容旧调用
        return '';
    }

    /* 内容页面相关参数返回                                   */
    function content($data, $value)
    {
        $allowed = array('list', 'list_name', 'script', 'table_head', 'table');
        if (!in_array($value, $allowed, true)) {
            return 'error';
        }
        $query = $this->query("SELECT * FROM `zd_content_data` WHERE `list` = " . $this->quote($data) . " LIMIT 1");
        if (!$query || $this->num_rows($query) == 0) {
            return 'error';
        }
        $row = $this->fetch_array($query);
        return isset($row[$value]) ? $row[$value] : 'error';
    }
    /* ---------------------------------------------------- */

    /* 写入系统日志                                           */
    function WriteLog($method, $data, $addr)
    {
        $ip   = $this->Get_LocalIP();
        $time = date("Y-m-d H:i:s", time());
        $sql  = "INSERT INTO `zd_system_log` (`method`, `ip`, `data`, `addr`, `time`) VALUES ("
            . $this->quote(substr((string)$method, 0, 50)) . ","
            . $this->quote(substr($ip, 0, 45)) . ","
            . $this->quote(substr((string)$data, 0, 4000)) . ","
            . $this->quote(substr((string)$addr, 0, 4000)) . ","
            . $this->quote($time) . ")";
        $ok = $this->query($sql);
        if (!$ok && defined('Debug') && Debug === 'on') {
            echo '<!-- write log failed -->';
        }
    }
    /* ---------------------------------------------------- */

    /* 上传大小检查                                           */
    function CheckUploadSize()
    {
        $File_size = $this->Info('upload_size');
        $PHP_Size  = (float)str_replace(array("M", "m"), "", ini_get('post_max_size'));
        if ($File_size === null || (float)$File_size <= 0 || (float)$File_size > $PHP_Size) {
            $size = max(1, $PHP_Size - 1);
            $sql  = "UPDATE `zd_system_setting` SET `value` = " . $this->quote($size) . " WHERE `vars` = 'upload_size'";
            if (!$this->query($sql)) {
                echo '参数检测发现异常，但尝试修复失败！';
            }
        }
    }

    /* 系统状态检查（维护模式）                                */
    function CheckServerState()
    {
        $status = $this->Info('server_status');
        if ($status == "1") {
            echo $this->Sys_ErrorPage(503);
            exit;
        }
    }

    /* ---------------------------------------------------- */
    /* 登录状态：优先使用服务端会话，其次使用 HMAC 签名令牌    */
    /* ---------------------------------------------------- */
    function AccountState()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            SmSessionStart();
        }
        $now = time();

        if (!empty($_SESSION['sm_user'])) {
            $last = isset($_SESSION['sm_login_time']) ? (int)$_SESSION['sm_login_time'] : 0;
            if ($now - $last <= 7200) {
                $_SESSION['sm_login_time'] = $now;
                return $_SESSION['sm_user'];
            }
            unset($_SESSION['sm_user'], $_SESSION['sm_login_time']);
        }

        $token = isset($_COOKIE['sm_token']) ? (string)$_COOKIE['sm_token'] : '';
        if ($token !== '') {
            $data = $this->VerifyToken($token);
            if ($data !== false) {
                $_SESSION['sm_user']        = $data['u'];
                $_SESSION['sm_login_time']  = $now;
                return $data['u'];
            }
            $this->cookie('sm_token', '', $now - 86400);
        }
        return 'Access denied';
    }

    /* 生成登录令牌（供 login_check 使用）                     */
    function MakeToken($user, $ttl = 1296000)
    {
        $u   = (string)$user;
        $exp = time() + (int)$ttl;
        $sig = hash_hmac('sha256', $u . '|' . $exp, $this->TokenKey());
        $raw = json_encode(array('u' => $u, 'exp' => $exp, 'sig' => $sig));
        return rtrim(strtr(base64_encode($raw), '+/', '-_'), '=');
    }

    /* 校验登录令牌                                           */
    function VerifyToken($token)
    {
        $raw = base64_decode(strtr((string)$token, '-_', '+/'), true);
        if ($raw === false) {
            return false;
        }
        $arr = json_decode($raw, true);
        if (!is_array($arr) || !isset($arr['u'], $arr['exp'], $arr['sig'])) {
            return false;
        }
        $expect = hash_hmac('sha256', $arr['u'] . '|' . $arr['exp'], $this->TokenKey());
        if (!hash_equals($expect, (string)$arr['sig'])) {
            return false;
        }
        if ((int)$arr['exp'] < time()) {
            return false;
        }
        // 确认账户仍然存在
        $query = $this->query("SELECT `username` FROM `zd_admin_user` WHERE `username` = " . $this->quote($arr['u']) . " LIMIT 1");
        if ($this->num_rows($query) !== 1) {
            return false;
        }
        return $arr;
    }

    private function TokenKey()
    {
        return hash('sha256', 'sm|' . key . '|' . (defined('DB') ? DB : ''));
    }

    /* 登录成功后登记会话                                     */
    function LoginUser($user, $remember = false)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            SmSessionStart();
        }
        session_regenerate_id(true);
        $_SESSION['sm_user']       = (string)$user;
        $_SESSION['sm_login_time'] = time();
        if ($remember) {
            $this->cookie('sm_token', $this->MakeToken($user), time() + 1296000);
        } else {
            $this->cookie('sm_token', '', time() - 86400);
        }
    }

    /* 注销                                                 */
    function Logout()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            SmSessionStart();
        }
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p["path"], $p["domain"], $p["secure"], $p["httponly"]);
        }
        @session_destroy();
        $this->cookie('sm_token', '', time() - 86400);
        $this->cookie('usr', '', time() - 86400);
        $this->cookie('pwd', '', time() - 86400);
        $this->cookie('state', '', time() - 86400);
    }

    /* PHP COOKIE 设置函数立即生效，支持数组                   */
    function cookie($var, $value = '', $time = 0, $path = '', $domain = '', $s = false)
    {
        $_COOKIE[$var] = $value;
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                setcookie($var . '[' . $k . ']', $v, $time, $path, $domain, $s, true);
            }
        } else {
            setcookie($var, $value, $time, $path ?: '/', $domain, $s, true);
        }
    }

    /* 在线检查更新                                           */
    function CheckUpdate()
    {
        if (strtolower((string)$this->Info("update_status")) === 'custom') {
            return '定制版请联系开发者获取更新';
        }
        $status = $this->Info("update_status");
        if (empty($status)) {
            return '';
        }
        $ctx = stream_context_create(array('http' => array('method' => "GET", 'timeout' => 10)));
        $url = 'http://service.csource.com.cn/update/check.php?product=' . rawurlencode($status);
        $html = @file_get_contents($url, false, $ctx);
        if ($html === false) {
            return '';
        }
        $return_data = json_decode(trim($html), true);
        if (!is_array($return_data) || empty($return_data['version'])) {
            return '';
        }
        return '<a href="javascript:SystemBox(2,\'' . h('http://service.csource.com.cn/update/update.php?product=' . rawurlencode($status)) . '\',\'\',\'系统更新\',400,420)">' . h($return_data['version']) . '</a>';
    }

    /* 数据表检查                                             */
    function TableCheck($table)
    {
        $tbl = $this->safeIdent($table);
        if ($tbl === false || !$this->table_exist($tbl)) {
            die('系统初始化出现异常错误，请与管理员联系！');
        }
    }

    /* IP 核心部分                                            */
    /* type: 0 白名单 / 1 黑名单 / 2 双向                      */
    function Get_LocalIP()
    {
        $candidates = array();
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $candidates[] = $_SERVER['HTTP_CLIENT_IP'];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // 只取第一个地址，防止伪造串
            $parts        = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $candidates[] = trim($parts[0]);
        }
        if (!empty($_SERVER['REMOTE_ADDR'])) {
            $candidates[] = $_SERVER['REMOTE_ADDR'];
        }
        foreach ($candidates as $ip) {
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
        return 'unknown';
    }

    /* 检查当前 IP 是否被限制（表不存在时直接放行）            */
    function Check_IPStatus()
    {
        $enabled = $this->Info('ipfirewall_status');
        if ($enabled === null || (string)$enabled !== '0') {
            return null;
        }
        $data = $this->Get_IpList();
        if (empty($data)) {
            return null;
        }
        $client = explode('.', $this->Get_LocalIP());
        $mode   = (string)$this->Info('ipfirewall_mode');
        $allow  = false;
        foreach ($data as $value) {
            if ((string)$value['ControlMode'] !== '2' && (string)$value['ControlMode'] !== $mode) {
                continue;
            }
            $rule      = explode('.', (string)$value['start_ip']);
            $hit       = 0;
            $wildcard  = 0;
            for ($i = 0; $i < 4; $i++) {
                if (!isset($rule[$i])) {
                    break;
                }
                if ($rule[$i] !== '*') {
                    if (isset($client[$i]) && $client[$i] === $rule[$i]) {
                        $hit++;
                    }
                } else {
                    $wildcard++;
                }
            }
            if ($wildcard > 0 ? ($hit + $wildcard === 4) : ($hit === 4)) {
                $allow = true;
            }
        }
        if (($mode === '0' && !$allow) || ($mode === '1' && $allow)) {
            return json_encode(array('status' => 2, 'msg' => '该IP无权限访问', 'data' => $client));
        }
        return null;
    }

    /* IP 黑白名单增删改                                       */
    function IPFirewallControl($method, $ip, $mode)
    {
        $mode = (string)$mode;
        if ($method !== '' && $ip !== '') {
            switch ($method) {
                case 'add':
                    $sql = "INSERT INTO `zd_ipfirewall` (`start_ip`, `ControlMode`, `remark`) VALUES ("
                        . $this->quote($ip) . "," . $this->quote($mode) . ",'')";
                    break;
                case 'edit':
                    $sql = "UPDATE `zd_ipfirewall` SET `ControlMode` = " . $this->quote($mode)
                        . " WHERE `start_ip` = " . $this->quote($ip);
                    break;
                case 'del':
                    $sql = "DELETE FROM `zd_ipfirewall` WHERE `start_ip` = " . $this->quote($ip);
                    break;
                default:
                    return 'failed';
            }
            if (!$this->query($sql)) {
                return 'failed';
            }
            echo '<meta charset="utf-8"><script language="JavaScript">window.alert("操作成功！")</script>';
            return true;
        }
        die("参数数据错误！<a href='javascript:history.go(-1)'>点击返回</a>");
    }

    /* 获取当前 IP 名单                                        */
    function Get_IpList()
    {
        if (!$this->table_exist('zd_ipfirewall')) {
            return array();
        }
        return $this->fetch_array_all('zd_ipfirewall');
    }

    /* 随机密码生成                                           */
    function generate_password($length = 8)
    {
        $chars    = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#%&*';
        $password = '';
        $max      = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, $max)];
        }
        return $password;
    }

    function getNeedBetween($kw, $mark1, $mark2)
    {
        $st = stripos($kw, $mark1);
        $ed = stripos($kw, $mark2);
        if ($st === false || $ed === false || $st >= $ed) {
            return 0;
        }
        return substr($kw, ($st + 1), ($ed - $st - 1));
    }

    /* 首页错误页生成                                         */
    function Index_ErrorPage($code = 3)
    {
        $errorcode = '';
        $data      = '';
        $title     = '';
        switch ((string)$code) {
            case '307':
                $errorcode = "<span>3</span><span>0</span><span>7</span>";
                $data      = "如果您看到此页面，是由于启用了首页模块，但所设置的页面系统未搜索到，如果您是网站管理员请检查所设置页面是否可以访问";
                break;
            case '301':
                $errorcode = "<span>3</span><span>0</span><span>1</span>";
                $data      = "如果您看到此页面，是由于启用了首页模块，但并未设置相应页面，如果您是网站管理员可到系统设置中进行设置";
                break;
            case '404':
                $errorcode = "<span>4</span><span>0</span><span>4</span>";
                $data      = "这是系统默认首页，如果您看到此页面说明当前网站服务是正常的，但未设置前端主页！";
                $title     = "Page No Found!";
                break;
            default:
                $errorcode = "<span>?</span><span>?</span><span>?</span>";
                $data      = "页面不存在";
        }
        return '<!DOCTYPE html><html lang="en"><head><meta name="viewport" content="width=device-width, initial-scale=1" />'
            . '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>' . h($title) . '</title>'
            . '<link href="../css/error.css" rel="stylesheet" type="text/css" media="all" /><body><div class="w3layouts-bg">'
            . '<h1 class="header-w3ls">Error Page</h1><div class="agileits-content"><h2>' . $errorcode . '</h2></div>'
            . '<div class="w3layouts-right"><div class="w3ls-text"><h3>sorry !</h3><h4 class="w3-agileits2">' . h($title) . '</h4>'
            . '<p>' . h($data) . '</p><p class="copyright">' . h((string)$this->Info('bottom')) . '</p></div></div>'
            . '<div class="clearfix"></div></div></body></html>';
    }

    /* 后台 404 错误页生成                                     */
    function Admin_ErrorPage($MainParameter, $SubParameter, $FilePath)
    {
        $MainParameter = (string)$MainParameter;
        $SubParameter  = (string)$SubParameter;
        $data          = $this->convert($MainParameter, $SubParameter);
        $this->WriteLog('GET', '加载模块：' . $MainParameter . '/' . $SubParameter . ' 失败', '404.php');
        return '<div id="main"><header id="header"><h1><span class="sub">模块加载失败！</span></h1></header>'
            . '<div id="content"><p>[ 主参数 ] ' . h(isset($data['table']) ? $data['table'] : '') . ' ( ' . h($MainParameter) . ' )'
            . '<br />[ 子参数 ] ' . h(isset($data['menu']) ? $data['menu'] : '') . ' ( ' . h($SubParameter) . ' )'
            . '<br />[ 模块名称 ] ' . h($FilePath)
            . '<br />[ 错误原因 ] 由于模块未找到或出现异常，加载失败！'
            . '<br /> [ 记录时间 ] ' . h(defined('Time') ? constant("Time") : date('y/m/d H:i:s'))
            . ' [ 访问IP ] ' . h($this->Get_LocalIP()) . '</p></div></div>';
    }

    /* 系统错误页生成                                         */
    function Sys_ErrorPage($code = 3)
    {
        $title   = '操作失败';
        $content = '';
        switch ((string)$code) {
            case '503':
                $title   = '系统正在维护中！';
                $content = $this->Info('server_infomaction');
                $this->WriteLog('GET', '访问请求由于 系统维护中 被拦截', 'error.php');
                break;
            case '342':
                $title   = '系统数据检查失败';
                $content = '检测到一个或多个核心数据字段丢失，请删除kernl目录下的conf文件，重新安装系统！';
                break;
            case '336:1':
                $title   = '操作非法';
                $content = '当前操作不在系统许可范围内，请检查后重试！';
                break;
            case '336:2':
                $title   = '操作非法';
                $content = 'Session值校验异常，请检查后重试！';
                break;
            case '336:3':
                $title   = '操作非法';
                $content = '用户检查失败,系统安装未完成！';
                break;
            case '336:4':
                $title   = '路径检查失败';
                $content = '路径检查失败，系统仅支持在一级目录下安装！';
                break;
            case '195':
                $title   = '浏览器检查失败！';
                $content = '当前浏览器版本不受支持，请更新浏览器或更换为更安全的Google浏览器';
                break;
            case '330':
                $title   = '管理员已禁用留言板';
                $content = '管理员已禁用留言板，如需帮助请与网站管理员联系！&nbsp; &nbsp; <a href="../index.php">返回首页</a>';
                break;
            case '500':
                $title   = 'Access Denied';
                $content = '您无权使用所提供的凭据查看此目录或页面。';
                break;
            case '701':
                $title   = 'Access Denied';
                $content = '当前请求包含违禁字符，已被系统拦截！';
                break;
            case '999':
                $title   = 'Access Denied';
                $content = '当前IP已被限制访问！';
                break;
            default:
                $content = '请求无法处理。';
        }
        $time = date("y/m/d H:i:s", time());
        return '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>' . h($title) . '</title></head>'
            . '<body><div id="main"><header id="header"><h1><span class="sub"> ' . h($title) . '</span></h1></header>'
            . '<div id="content"><p>[ 错误原因 ] ' . $content . ' <br /> [ 出错时间 ] ' . h($time)
            . ' [ 访问IP ] ' . h($this->Get_LocalIP()) . '</p>------------------------------------------------'
            . '<p class="copyright">' . h((string)$this->Info('bottom')) . '</p></div></div></html>';
    }

    /* 上传框架参数自动修复                                   */
    function UploadFrameFix()
    {
        if ($this->Info('upload_frame') === null) {
            $sql = "UPDATE `zd_system_setting` SET `value` = " . $this->quote('system;.png、.jpg、.gif;../../images/|module;.zip;../../module/|') . " WHERE `vars` = 'upload_frame'";
            if (!$this->query($sql)) {
                return 'null';
            }
        }
        return true;
    }

    /* 上传框架解析，返回数组                                 */
    function UploadFrame()
    {
        $raw     = $this->Info("upload_frame");
        $uploadData = array();
        if ($raw === null) {
            $this->UploadFrameFix();
            $raw = $this->Info("upload_frame");
        }
        $pieces = explode("|", (string)$raw);
        foreach ($pieces as $val) {
            if ($val === '') {
                continue;
            }
            $IndexData = explode(";", $val);
            if (count($IndexData) < 3) {
                continue;
            }
            $uploadData[] = array($IndexData[0], $IndexData[1], $IndexData[2]);
        }
        return $uploadData;
    }

    /* 上传框架处理                                           */
    function UploadFrameServicing($method, $data)
    {
        $ReturnData = $this->UploadFrame();
        $sql        = '';
        switch ($method) {
            case 'add':
                $SystemUploadFrame = (string)$this->Info("upload_frame");
                $sql = "UPDATE `zd_system_setting` SET `value` = " . $this->quote($SystemUploadFrame . $data) . " WHERE `vars` = 'upload_frame'";
                break;
            case 'edit':
                $pieces   = explode(";", (string)$data);
                $index    = to_int($pieces[0] ?? -1, -1);
                if ($index < 0 || !isset($ReturnData[$index])) {
                    return 'failed';
                }
                $ReturnData[$index] = array($pieces[0], $pieces[1] ?? '', $pieces[2] ?? '');
                $buf = '';
                foreach ($ReturnData as $val) {
                    if (strpos($val[2], "|") === false) {
                        $val[2] = $val[2] . "|";
                    }
                    $buf .= $val[0] . ";" . $val[1] . ";" . $val[2];
                }
                $sql = "UPDATE `zd_system_setting` SET `value` = " . $this->quote($buf) . " WHERE `vars` = 'upload_frame'";
                break;
            case 'del':
                $index = to_int($data, -1);
                $buf   = '';
                unset($ReturnData[$index]);
                foreach ($ReturnData as $value) {
                    $buf .= $value[0] . ";" . $value[1] . ";" . $value[2] . "|";
                }
                $sql = "UPDATE `zd_system_setting` SET `value` = " . $this->quote($buf) . " WHERE `vars` = 'upload_frame'";
                break;
            default:
                return 'failed';
        }
        if (!$this->query($sql)) {
            return 'failed';
        }
        echo '<meta charset="utf-8"><script language="JavaScript">window.alert("操作成功！")</script>';
        return true;
    }

    /**
     * 模块安装
     * 安全修订：只允许读取 module 目录内的模块，拒绝任意路径
     */
    function ModuleInstall($path)
    {
        $root = realpath(ROOT_PATH . 'module');
        if ($root === false) {
            return "Install Failed！Module Directory Not Exists.";
        }
        $base = realpath(ROOT_PATH . $path);
        if ($base === false || strpos($base, $root) !== 0) {
            return "Install Failed！Illegal Module Path.";
        }
        if (!file_exists($base . '/install.xml')) {
            return "Install Failed！The File Was Not Module.";
        }
        $database = @file_get_contents($base . '/data.sql');
        if ($database !== false) {
            $database = iconv("gb2312", "utf-8//IGNORE", $database);
        }
        $xml_array = @simplexml_load_string(file_get_contents($base . '/install.xml'));
        if ($xml_array === false) {
            return "Install Failed！Invalid install.xml.";
        }
        if ($database) {
            if ((string)$xml_array->Type == 1) {
                $InstallSqlData = str_replace("\$InstallSystemTable$", (string)$this->Info("system_table"), $database);
                if ((string)$xml_array->Index == 1) {
                    $InstallIndex      = (string)$this->Info("index_page_all");
                    $InstallIndexCount = $InstallIndex != '' ? count(explode("|", $InstallIndex)) : 1;
                    $InstallSqlData    = str_replace(array("\$InstallSystemIndex$", "\$InstallSystemIndexCount$"), array($InstallIndex, $InstallIndexCount), $InstallSqlData);
                }
                foreach (explode(";\r\n", $InstallSqlData) as $value) {
                    if (trim($value) !== '') {
                        $this->query($value);
                    }
                }
            }
        }
        // 文件操作
        $FileControl  = new FileUtil();
        $FileRootPath = str_replace('\\', '/', ROOT_PATH);
        $scriptPath   = 'module/' . basename($path);
        if ((string)$xml_array->IndexFile != '' && (string)$xml_array->Index == 1) {
            foreach (explode(";", (string)$xml_array->IndexFile) as $value) {
                if ($this->IsSafeRelative($value)) {
                    $FileControl->copyDir($FileRootPath . $scriptPath . '/' . $value, $FileRootPath . '/' . $value);
                }
            }
        }
        if ((string)$xml_array->KernlFile != '') {
            foreach (explode(";", (string)$xml_array->KernlFile) as $value) {
                if ($this->IsSafeRelative($value)) {
                    $FileControl->copyDir($FileRootPath . $scriptPath . '/' . $value, $FileRootPath . '/kernl/' . $value);
                }
            }
        }
        if ((string)$xml_array->ManagerFile != '') {
            foreach (explode(";", (string)$xml_array->ManagerFile) as $value) {
                if ($this->IsSafeRelative($value)) {
                    $FileControl->copyDir($FileRootPath . $scriptPath . '/' . $value, $FileRootPath . '/admin/' . $value);
                }
            }
        }
        @rename($base . '/install.xml', $base . '/uninstall.xml');
        @$FileControl->createFile($base . '/Init.Lock');
        return "Install Success!";
    }

    /** 判断相对路径是否安全（不含 ..，不以 / 开头） */
    function IsSafeRelative($value)
    {
        $value = str_replace('\\', '/', (string)$value);
        if ($value === '' || strpos($value, '..') !== false || $value[0] === '/') {
            return false;
        }
        return (bool)preg_match('/^[A-Za-z0-9_\-\/.]+$/', $value);
    }

    function ModuleUninstall($name)
    {
        // 功能未实现（原版即为空方法）
    }

    /* ---------------------------------------------------- */
    /* WebSite Safe Check System (wscs 网站安全检查系统)
    /* 修订：只拦截真正危险的组合特征，不再误伤正常搜索词
    /* ---------------------------------------------------- */
    function WSCS_Check()
    {
        $needles = array(
            '<script', '%3cscript', 'javascript:', 'onerror=', 'onload=', 'onmouseover=',
            'union select', 'information_schema', 'into outfile', 'load_file(', 'sleep(',
            'benchmark(', '../', '..\\', 'etc/passwd', 'base64_decode(', 'eval(',
        );
        $targets = array();
        if (!empty($_SERVER['QUERY_STRING'])) {
            $targets[] = rawurldecode($_SERVER['QUERY_STRING']);
            $targets[] = (string)$_SERVER['QUERY_STRING'];
        }
        foreach ($_GET as $value) {
            if (is_string($value)) {
                $targets[] = $value;
            }
        }
        foreach ($targets as $t) {
            $lower = str_replace(' ', '', strtolower($t));
            foreach ($needles as $needle) {
                if (strpos($lower, $needle) !== false) {
                    $this->WriteLog('Get', '请求存在违禁内容：' . substr($t, 0, 500), isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '-');
                    echo $this->Sys_ErrorPage(701);
                    exit;
                }
            }
        }
    }

    /* 取特定部分内容                                         */
    function getSubstr($str, $leftStr, $rightStr)
    {
        $left  = strpos($str, $leftStr);
        if ($left === false) {
            return '';
        }
        $right = strpos($str, $rightStr, $left);
        if ($right === false || $right < $left) {
            return '';
        }
        return substr($str, $left + strlen($leftStr), $right - $left - strlen($leftStr));
    }

    /* 更新软件 Logo                                          */
    function UpdateSoftwareLogo($data)
    {
        if ($data !== null) {
            $sql = "UPDATE `zd_config` SET `softwarelogo` = " . $this->quote($data);
            if (!$this->query($sql)) {
                $this->WriteLog('POST', '更新软件LOGO失败：' . $this->SystemError(), 'UpdateSoftwareLogo');
            }
        }
    }

    /* 列出目录中的目录和文件                                 */
    function getFileList3($directory)
    {
        $files = array();
        if (!is_dir($directory)) {
            return $files;
        }
        try {
            $dir = new DirectoryIterator($directory);
        } catch (Exception $e) {
            return $files;
        }
        foreach ($dir as $file) {
            if ($file->isDot() || $file->isDir()) {
                continue;
            }
            $files[] = $file->getFileName();
        }
        return $files;
    }

    /* 生成随机字符串                                         */
    function random_strings($length_of_string)
    {
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $out        = '';
        $max        = strlen($str_result) - 1;
        for ($i = 0; $i < $length_of_string; $i++) {
            $out .= $str_result[random_int(0, $max)];
        }
        return $out;
    }

    /* 处理软件 LOGO 图片数据                                 */
    function UpdateSoftwareLogoData($datatype, $data, $sid)
    {
        $sid = to_int($sid);
        if ($sid <= 0 || $datatype === null) {
            return;
        }
        if ($datatype === 'local') {
            if ($data !== null && $data !== '') {
                $random = $this->random_strings(5);
                $this->query("INSERT INTO `zd_imgdata` (`type`,`data`,`querycode`,`softwareid`) VALUES (0,"
                    . $this->quote($data) . "," . $this->quote($random) . "," . $sid . ")");
                $this->query("UPDATE `zd_software` SET `logotype`=0, `logodata`=" . $this->quote($random) . " WHERE `id`=" . $sid);
            } else {
                $this->query("UPDATE `zd_software` SET `logotype`=0, `logodata`='' WHERE `id`=" . $sid);
                echo '<meta charset="utf-8"><script>alert("已切换至本地源");</script>';
            }
        } else {
            $this->query("UPDATE `zd_software` SET `logotype`=1, `logodata`=" . $this->quote($data) . " WHERE `id`=" . $sid);
            $this->DelSoftwareLogoData(1, '', $sid);
            echo '<meta charset="utf-8"><script>alert("操作成功！");</script>';
        }
    }

    function DelSoftwareLogoData($type, $code, $sid)
    {
        $sid = to_int($sid);
        if ($type === null || $sid <= 0) {
            return;
        }
        if ((int)$type === 0) {
            $this->query("DELETE FROM `zd_imgdata` WHERE `softwareid`=" . $sid . " AND `querycode`=" . $this->quote($code));
            $this->query("UPDATE `zd_software` SET `logotype`=NULL, `logodata`=NULL WHERE `id`=" . $sid);
        } else {
            $this->query("DELETE FROM `zd_imgdata` WHERE `softwareid`=" . $sid . " AND `type`=0");
        }
    }

    /* 处理软件运行截图数据                                   */
    function UpdateSoftwareImgData($datatype, $data, $sid)
    {
        $sid = to_int($sid);
        if ($sid <= 0 || $datatype === null) {
            return;
        }
        if ($datatype === 'local') {
            if ($data !== null && $data !== '') {
                $random = $this->random_strings(5);
                $this->query("INSERT INTO `zd_imgdata` (`type`,`data`,`querycode`,`softwareid`) VALUES (1,"
                    . $this->quote($data) . "," . $this->quote($random) . "," . $sid . ")");
                $row  = $this->fetch_array($this->query("SELECT `runpic` FROM `zd_software` WHERE `id`=" . $sid));
                $list = trim((string)($row['runpic'] ?? ''), ',');
                $list = $list === '' ? $random : $list . ',' . $random;
                $this->query("UPDATE `zd_software` SET `runpictype`=0, `runpic`=" . $this->quote($list) . " WHERE `id`=" . $sid);
            } else {
                $this->query("UPDATE `zd_software` SET `runpictype`=0, `runpic`='' WHERE `id`=" . $sid);
                echo '<meta charset="utf-8"><script>alert("已切换至本地源");</script>';
            }
        } else {
            $row  = $this->fetch_array($this->query("SELECT `runpic` FROM `zd_software` WHERE `id`=" . $sid));
            $list = trim((string)($row['runpic'] ?? ''), ',');
            $list = $list === '' ? (string)$data : $list . ',' . $data;
            $this->query("UPDATE `zd_software` SET `runpictype`=1, `runpic`=" . $this->quote($list) . " WHERE `id`=" . $sid);
            $this->DelSoftwareImgData(1, '', $sid);
            echo '<meta charset="utf-8"><script>alert("操作成功！");</script>';
        }
    }

    function DelSoftwareImgData($type, $code, $sid)
    {
        $sid = to_int($sid);
        if ($type === null || $sid <= 0) {
            return;
        }
        switch ((int)$type) {
            case 1:
                $this->query("DELETE FROM `zd_imgdata` WHERE `softwareid`=" . $sid . " AND `querycode`=" . $this->quote($code));
                $row  = $this->fetch_array($this->query("SELECT `runpic` FROM `zd_software` WHERE `id`=" . $sid));
                $keep = array();
                foreach (explode(',', (string)($row['runpic'] ?? '')) as $x) {
                    if ($x !== '' && $x !== (string)$code) {
                        $keep[] = $x;
                    }
                }
                $this->query("UPDATE `zd_software` SET `runpictype`=0, `runpic`=" . $this->quote(implode(',', $keep)) . " WHERE `id`=" . $sid);
                break;
            case 2:
                $row    = $this->fetch_array($this->query("SELECT `runpic` FROM `zd_software` WHERE `id`=" . $sid));
                $outside = explode(',', (string)($row['runpic'] ?? ''));
                unset($outside[(int)$code - 1]);
                $keep = array();
                foreach ($outside as $x) {
                    if ($x !== '') {
                        $keep[] = $x;
                    }
                }
                $this->query("UPDATE `zd_software` SET `runpictype`=1, `runpic`=" . $this->quote(implode(',', $keep)) . " WHERE `id`=" . $sid);
                break;
        }
    }

    /* Get IP 归属地                                          */
    function Get_IPData($ipdata)
    {
        if (empty($ipdata)) {
            return '';
        }
        if (!filter_var($ipdata, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return '';
        }
        $file = ROOT_PATH . 'kernl/ipdata.dat';
        if (!is_file($file)) {
            return '';
        }
        $IPQuery = new IPQueryEngine($file);
        $detail  = $IPQuery->getDetail($ipdata);
        if (!is_array($detail)) {
            return '';
        }
        return (isset($detail['dataA']) ? $detail['dataA'] : '') . (isset($detail['dataB']) ? $detail['dataB'] : '');
    }

    /* 加载 Bing 每日壁纸                                     */
    function LoadingBingBackground()
    {
        $fallback = '../images/bg_4.jpg';
        $path     = ROOT_PATH . 'images/bing/' . date("Ym");
        if (!is_dir($path)) {
            @mkdir($path, 0755, true);
        }
        $fileName = date("d") . '.jpg';
        $fullPath = $path . '/' . $fileName;
        if (!is_file($fullPath)) {
            $str = @file_get_contents("https://cn.bing.com/HPImageArchive.aspx?idx=0&n=1");
            if ($str !== false && preg_match('/<urlBase>(.+?)<\/urlBase>/is', $str, $matches)) {
                $imgurl = "https://cn.bing.com" . $matches[1] . "_1920x1080.jpg";
                @copy($imgurl, $fullPath);
            }
        }
        $rel = is_file($fullPath)
            ? '../images/bing/' . date("Ym") . '/' . $fileName
            : $fallback;
        return '<style>body.login{background:url("' . h($rel) . '") no-repeat center center fixed;background-size:cover;}</style>';
    }

    /* 处理下载数更新                                         */
    function UpdateSoftwareDownloadCount($sid)
    {
        $sid = to_int($sid);
        if ($sid <= 0) {
            return;
        }
        // 直接自增，避免select+update的竞态与回显污染下载响应流
        $this->query("UPDATE `zd_software` SET `downloadcount` = COALESCE(`downloadcount`,0) + 1 WHERE `id` = " . $sid);
    }

    /* 获取指定位置内容                                       */
    function strip_comments($start, $end, $input)
    {
        $input = (string)$input;
        $pos   = strpos($input, $start);
        if ($pos === false) {
            return $input;
        }
        $substr = substr($input, $pos + strlen($start) - 1, (strlen($input) - $pos) * -1);
        return $substr;
    }
}

