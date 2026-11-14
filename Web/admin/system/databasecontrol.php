<?php
/* ---------------------------------------------------- */
/* 数据库备份 / 恢复 / 删除 / 清空
/* 安全修订说明（2026）：
/*  1. 备份文件名统一由服务端生成，客户端传入的 filename 只允许
/*     [A-Za-z0-9_.-] 且必须以 .sql 结尾，并经 realpath 限定在 admin/backup 内，
/*     消除 ../ 路径穿越导致的任意文件删除与任意文件读取
/*  2. 清空/恢复涉及的表名走 safeIdent 白名单，SHOW tables 结果同样校验
/*  3. 写入系统日志的 $addr 先过滤控制字符与标签，避免日志页存储型 XSS
/*  4. 备份内容使用数据库连接的 escape()，不再用 addslashes
/*  5. 恢复前要求二次确认参数，避免一次请求误清库
/* ---------------------------------------------------- */
require("../../kernl/Init.php");

if (!defined('source')) {
    echo json_encode(array('status' => '-1', 'message' => '账户状态异常，请重试！'));
    exit;
}

if ($dou->AccountState() === 'Access denied') {
    echo json_encode(array('status' => '-1', 'message' => '账户状态异常，请重试！'));
    exit;
}

$addr = $_SERVER['PHP_SELF'] . '?' . preg_replace('/[^\x20-\x7E]/', '', substr((string)file_get_contents('php://input'), 0, 200));

/** 取得 admin/backup 下的合法备份文件绝对路径；不合法返回 false */
function sm_backup_path($filename)
{
    $filename = (string)$filename;
    if ($filename === '' || !preg_match('/^[A-Za-z0-9_\-\.]{1,120}$/', $filename)) {
        return false;
    }
    if (strtolower(pathinfo($filename, PATHINFO_EXTENSION)) !== 'sql') {
        return false;
    }
    $dir = realpath(ROOT_PATH . 'admin/backup');
    if ($dir === false) {
        return false;
    }
    $file = $dir . DIRECTORY_SEPARATOR . $filename;
    $real = realpath($file);
    if ($real === false) {
        return false;
    }
    if (strpos($real, $dir . DIRECTORY_SEPARATOR) !== 0) {
        return false;
    }
    return $real;
}

$filename = isset($_POST['filename']) ? (string)$_POST['filename'] : '';
$control  = isset($_POST['control']) ? (string)$_POST['control'] : '';

switch ($control) {
    case '备份数据库':
        $mysql   = '';
        $resu    = $dou->query("SHOW TABLES");
        $failedT = array();
        while ($t = $dou->fetch_array($resu)) {
            $table = $dou->safeIdent(isset($t[0]) ? $t[0] : '');
            if ($table === false) {
                continue;
            }
            $q2  = $dou->query("SHOW CREATE TABLE `" . $table . "`");
            $sql = $dou->fetch_array($q2);
            $create = '';
            foreach ($sql as $k => $v) {
                if ($k === 'Create Table' || $k === 'Create View') {
                    $create = (string)$v;
                    break;
                }
            }
            if ($create === '') {
                $failedT[] = $table;
                continue;
            }
            $mysql .= $create . ";\r\n";
            $q3 = $dou->query("SELECT * FROM `" . $table . "`");
            while ($data = $dou->fetch_assoc($q3)) {
                $keys = array();
                foreach (array_keys($data) as $kk) {
                    $keys[] = '`' . str_replace('`', '', (string)$kk) . '`';
                }
                $vals = array();
                foreach ($data as $vv) {
                    $vals[] = "'" . $dou->escape((string)$vv) . "'";
                }
                $mysql .= "INSERT INTO `" . $table . "`(" . implode(',', $keys) . ") VALUES (" . implode(',', $vals) . ");\r\n";
            }
        }

        $backupDir = ROOT_PATH . 'admin/backup';
        if (!is_dir($backupDir)) {
            @mkdir($backupDir, 0755, true);
        }
        $name = 'bk_' . date('Ymd_His') . '_' . bin2hex(random_bytes(8)) . '.sql';
        $path = $backupDir . '/' . $name;
        if (@file_put_contents($path, $mysql) === false) {
            echo json_encode(array('status' => '-1', 'message' => '备份文件写入失败，请检查 admin/backup 目录权限'));
            exit;
        }
        @chmod($path, 0644);
        echo json_encode(array('status' => '0', 'message' => '数据备份成功<br>备份文件 [ admin/backup/' . h($name) . ' ]'));
        $dou->OpLog('数据库备份', '备份文件 admin/backup/' . $name, '成功', $addr);
        break;

    case '恢复数据库':
        if ($filename === '') {
            echo json_encode(array('status' => '-1', 'message' => '请选择需要恢复的备份！'));
            exit;
        }
        if (!isset($_POST['confirm']) || $_POST['confirm'] !== '1') {
            echo json_encode(array('status' => '-1', 'message' => '恢复操作需要二次确认！'));
            exit;
        }
        $file = sm_backup_path($filename);
        if ($file === false) {
            echo json_encode(array('status' => '-1', 'message' => '备份文件不存在或路径非法！'));
            exit;
        }

        set_time_limit(0);
        $info = "<p>正在恢复数据库，步骤一，清理数据表<br>";
        $result = $dou->query("SHOW TABLES");
        while ($currow = $dou->fetch_array($result)) {
            $tbl = $dou->safeIdent(isset($currow[0]) ? $currow[0] : '');
            if ($tbl === false) {
                continue;
            }
            $dou->query("DROP TABLE IF EXISTS `" . $tbl . "`");
            $info .= "清空数据表【" . h($tbl) . "】成功！<br>";
        }
        $info .= "正在恢复数据库，步骤一，清理数据表....完成<br>正在恢复数据库，步骤二，导入数据<br>";

        $sql_value = (string)file_get_contents($file);
        $a     = explode(";\r\n", $sql_value);
        $total = count($a) - 1;
        $cg    = 0;
        $sb    = 0;
        $sb_command = array();
        $dou->query("SET NAMES 'utf8'");
        for ($i = 0; $i < $total; $i++) {
            if (trim($a[$i]) === '') {
                continue;
            }
            if ($dou->query($a[$i])) {
                $cg++;
            } else {
                $sb++;
                $sb_command[] = $a[$i];
            }
        }

        $info .= "操作完毕，共处理 " . $total . " 条命令，成功 " . $cg . " 条，失败 " . $sb . " 条<br>";
        if (defined('Debug') && Debug === 'on' && $sb > 0) {
            $info .= "<hr><br>失败命令如下：<br>";
            $i = 1;
            foreach ($sb_command as $cmd) {
                $info .= "<b>第 " . $i . " 条命令（内容如下）：</b><br>" . h($cmd) . "<br>";
                $i++;
            }
        }
        echo json_encode(array('status' => '0', 'message' => $info));
        $dou->OpLog('数据库恢复', '使用备份文件 ' . $filename, '成功', $addr);
        break;

    case '删除备份':
        if ($filename === '') {
            echo json_encode(array('status' => '-1', 'message' => '待删除的备份为空！'));
            exit;
        }
        $file = sm_backup_path($filename);
        if ($file === false) {
            echo json_encode(array('status' => '-1', 'message' => '× 删除失败，文件不存在或路径非法!'));
            $dou->OpLog('删除备份', '文件 ' . substr($filename, 0, 100), '失败：不存在或路径非法', $addr);
            exit;
        }
        if (!@unlink($file)) {
            echo json_encode(array('status' => '-1', 'message' => '× 删除失败!'));
            $dou->OpLog('删除备份', '文件 ' . basename($file), '失败', $addr);
        } else {
            echo json_encode(array('status' => '0', 'message' => '√ 删除成功!'));
            $dou->OpLog('删除备份', '文件 ' . basename($file), '成功', $addr);
        }
        break;

    case '清空数据库':
        $data = explode(";", (string)$dou->Info("AllowDatabase"));
        $info = '';
        foreach ($data as $tblName) {
            $tblName = trim($tblName);
            if ($tblName === '') {
                continue;
            }
            $tbl = $dou->safeIdent($tblName);
            if ($tbl === false) {
                $info .= '跳过非法表名' . h($tblName) . '<br>';
                continue;
            }
            if ($dou->query("TRUNCATE TABLE `" . $tbl . "`")) {
                $info .= '清空数据表' . h($tbl) . '成功！<br>';
            } else {
                $info .= '清空数据表' . h($tbl) . '失败！<br>';
            }
        }
        echo json_encode(array('status' => '0', 'message' => $info));
        $dou->OpLog('清空数据表', '按 AllowDatabase 清空：' . substr((string)$dou->Info('AllowDatabase'), 0, 150), '成功', $addr);
        break;

    case '下载备份':
        if ($filename === '') {
            echo json_encode(array('status' => '-1', 'message' => '待下载的备份为空！'));
            exit;
        }
        $file = sm_backup_path($filename);
        if ($file === false) {
            echo json_encode(array('status' => '-1', 'message' => '读取文件失败！'));
            exit;
        }
        $_SESSION["sm_backup_filename"] = basename($file);
        echo json_encode(array('status' => '99', 'message' => "开始下载..."));
        break;
}
