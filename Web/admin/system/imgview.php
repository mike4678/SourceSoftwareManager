<?php
/* ---------------------------------------------------- */
/* 软件 Logo 预览
/* 安全修订说明（2026）：
/*  1. 未登录仅发 Location 头未退出，请求继续写入临时文件；改为直接中断
/*  2. m 参数严格白名单，默认不再用 "w" 打开文件（原写法会把临时文件清空）
/*  3. 输出加禁止缓存头，避免浏览器缓存旧图
/* ---------------------------------------------------- */
require("../../kernl/Init.php");

if (!defined('source')) {
    header("Location: ../login.php");
    exit;
}

$dou->WSCS_Check();

if ($dou->AccountState() === 'Access denied') {
    header("Location: ../login.php");
    exit;
}

$mode = isset($_GET['m']) ? (string)$_GET['m'] : '';
if (!in_array($mode, array('logosetting', 'softlogo', 'softrunimg'), true)) {
    http_response_code(400);
    exit('参数非法');
}

$tempFile = ROOT_PATH . 'images/tmplogo.png';
$blob     = (string)$dou->SInfo('softwarelogo');
if ($blob === '') {
    http_response_code(404);
    exit('无图片数据');
}
@file_put_contents($tempFile, $blob);

header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
echo '<img src="../../images/tmplogo.png" alt="logo">';
