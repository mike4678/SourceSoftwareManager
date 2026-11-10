<?php
/* ---------------------------------------------------- */
/* 系统重置
/* 安全修订说明（2026）：
/*  1. 原代码在未登录时仅发送 Location 头却不退出，请求会继续执行 DELETE/TRUNCATE，
/*     等于未授权即可清空全站数据；现改为未登录直接中断
/*  2. 只接受 POST 且必须携带 CSRF 令牌，防止被跨站触发的 GET 图片/链接清库
/*  3. 逐条执行并校验结果，错误写入系统日志而非直接回显
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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo '<meta charset="utf-8"><script>alert("系统重置必须通过后台按钮确认执行！");history.back(-1);</script>';
    exit;
}

$token = isset($_POST['csrf']) ? (string)$_POST['csrf'] : '';
$csrf  = isset($_SESSION['sm_csrf']) ? (string)$_SESSION['sm_csrf'] : '';
if ($csrf === '' || !hash_equals($csrf, $token)) {
    $dou->WriteLog('POST', '系统重置被拒绝：CSRF 令牌校验失败', 'reset.php');
    http_response_code(403);
    echo '<meta charset="utf-8"><script>alert("非法请求，已阻止重置操作！");history.back(-1);</script>';
    exit;
}

$tables = array('zd_imgdata', 'zd_type', 'zd_software', 'zd_feedback', 'zd_config');
$failed = array();
foreach ($tables as $t) {
    $tbl = $dou->safeIdent($t);
    if ($tbl === false || !$dou->query("TRUNCATE TABLE `" . $tbl . "`")) {
        $failed[] = $t;
    }
}

$dou->WriteLog('POST', '用户执行软件管家数据库重置，失败表：' . (empty($failed) ? '无' : implode(',', $failed)), 'reset.php');

if (!empty($failed)) {
    echo '<meta charset="utf-8"><script>alert("部分数据表重置失败：' . h(implode(',', $failed)) . '");history.back(-1);</script>';
    exit;
}
echo '<meta charset="utf-8"><script>alert("重置完成！");history.back(-1);</script>';
