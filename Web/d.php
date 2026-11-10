<?php
/* ---------------------------------------------------- */
/* 软件下载入口
/* 安全修订说明（2026）：
/*  1. 参数不再直接使用 QUERY_STRING，改为读取 $_GET['pid'] 并做整数校验
/*  2. 文件名取自数据库 remark 字段，必须通过 basename + 字符白名单校验，
/*     并确认最终路径仍在 LocalSource 目录内，杜绝目录穿越读取任意文件
/*  3. 下载文件名做头注入过滤（去除换行与引号）
/*  4. 用 fpassthru 流式输出，避免 print_r + 一次性读入内存
/* ---------------------------------------------------- */
require("kernl/Init.php"); // 初始化基础参数
$dou->CheckServerState();  // 网站状态检查
$dou->WSCS_Check();

$pid = isset($_GET['pid']) ? to_int($_GET['pid']) : 0;

if ($pid <= 0) {
    header('HTTP/1.1 400 Bad Request');
    echo '<script language="JavaScript">window.alert("ID非法，请与管理员联系！")</script>';
    echo '<script language="JavaScript">window.opener=null;window.open("","_self");window.close();</script>';
    exit;
}

$row = $dou->fetch_array($dou->query("SELECT `remark`, `softname` FROM `zd_software` WHERE `id` = " . $pid . " LIMIT 1"));
if (!$row) {
    header('HTTP/1.1 404 Not Found');
    echo '<script language="JavaScript">window.alert("文件无法读取，请与管理员联系！")</script>';
    exit;
}

// ---------- 文件名安全校验 ----------
$baseName = basename(str_replace('\\', '/', (string)$row['remark']));
if ($baseName === '' || !preg_match('/^[\p{Han}A-Za-z0-9_\-\. ]{1,120}$/u', $baseName)) {
    $dou->WriteLog('GET', '下载请求文件名非法：' . substr($baseName, 0, 100), 'd.php');
    header('HTTP/1.1 400 Bad Request');
    echo '<script language="JavaScript">window.alert("文件无法读取，请与管理员联系！")</script>';
    exit;
}

$sourceDir = rtrim(str_replace('\\', '/', LocalSource), '/');
$realDir   = realpath($sourceDir);
$file      = $sourceDir . '/' . $baseName . '.zip';

if ($realDir === false || !is_file($file)) {
    header('HTTP/1.1 404 Not Found');
    echo '<script language="JavaScript">window.alert("文件无法读取，请与管理员联系！")</script>';
    exit;
}

// 确认最终文件仍在安装源目录内（防符号链接/短名绕过）
$realFile = realpath($file);
if ($realFile === false || strpos(str_replace('\\', '/', $realFile), str_replace('\\', '/', $realDir) . '/') !== 0) {
    $dou->WriteLog('GET', '下载请求路径越界：' . $baseName, 'd.php');
    header('HTTP/1.1 403 Forbidden');
    echo '<script language="JavaScript">window.alert("文件无法读取，请与管理员联系！")</script>';
    exit;
}

// ---------- 输出下载 ----------
$size = filesize($realFile);
$name = $baseName;
// 过滤头注入字符
$name = str_replace(array("\r", "\n", '"', "'"), '', $name);
$filenameGbk = @iconv('UTF-8', 'GBK//IGNORE', $name . '.zip');

while (ob_get_level() > 0) {
    ob_end_clean();
}

header("Content-Type: application/zip");
header("Accept-Ranges: bytes");
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . $size);
header("Content-Disposition: attachment; filename=\"" . ($filenameGbk !== false ? $filenameGbk : 'download.zip') . "\"");
header("X-Content-Type-Options: nosniff");

$fp = fopen($realFile, 'rb');
if ($fp) {
    fpassthru($fp);
    fclose($fp);
}

$dou->UpdateSoftwareDownloadCount($pid);
$dou->WriteLog('GET', '下载软件：' . $name, 'd.php?id=' . $pid);
exit;
