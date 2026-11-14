<?php
/* ---------------------------------------------------- */
/* 程序名称: 软件 Logo / 运行截图 输出接口（前台公开）
/* 用途：后台把 Logo、运行截图 存进 zd_imgdata（BLOB），
/*       zd_software.logodata / runpic 里只保存 5 位随机码。
/*       本文件按随机码把图片二进制读出来输出，供前台列表展示。
/* 安全说明：
/*  1. code 只允许字母数字，sid 强制为整数，查询全部走参数化 mysqli
/*  2. 只输出真实图片（getimagesizefromstring 校验），非法内容一律 404
/*  3. 强制 Content-Type 由检测结果决定，并附 nosniff，避免被当作脚本解析
/*  4. 不使用会话/不加载完整框架，避免图片并发请求被 session 锁串行化
/* ---------------------------------------------------- */

$confFile = dirname(__FILE__) . '/kernl/conf.php';
if (!is_file($confFile)) {
    $confFile = dirname(__FILE__) . '/kernl/Conf.php';
}
if (!is_file($confFile)) {
    http_response_code(404);
    exit;
}
require_once $confFile;

$code = isset($_GET['code']) ? (string)$_GET['code'] : '';
$sid  = isset($_GET['sid']) ? (int)$_GET['sid'] : 0;

if ($code === '' || !preg_match('/^[A-Za-z0-9]{1,40}$/', $code)) {
    http_response_code(404);
    exit;
}

/* 输出 1x1 透明 GIF，作为“无图”占位，避免浏览器出现破图 */
function sm_pic_placeholder()
{
    $gif = base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
    header('Content-Type: image/gif');
    header('Content-Length: ' . strlen($gif));
    header('Cache-Control: public, max-age=300');
    echo $gif;
    exit;
}

$conn = @mysqli_connect(DBSERVER, USER, PASSWORD, DB, 3306);
if (!$conn) {
    http_response_code(404);
    exit;
}
@mysqli_set_charset($conn, 'utf8mb4');

$sql = "SELECT `data` FROM `zd_imgdata` WHERE `querycode` = ? AND `type` IN (0,1)";
if ($sid > 0) {
    $sql .= " AND `softwareid` = " . $sid;
}
$sql .= " ORDER BY `id` DESC LIMIT 1";

$stmt = @mysqli_prepare($conn, $sql);
if (!$stmt) {
    http_response_code(404);
    exit;
}
mysqli_stmt_bind_param($stmt, 's', $code);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = $res ? mysqli_fetch_assoc($res) : null;
mysqli_stmt_close($stmt);
@mysqli_close($conn);

if (!$row || !isset($row['data']) || $row['data'] === '') {
    sm_pic_placeholder();
}

$blob = $row['data'];
$info = @getimagesizefromstring($blob);
if ($info === false) {
    http_response_code(404);
    exit;
}

$mimeMap = array(
    IMAGETYPE_GIF  => 'image/gif',
    IMAGETYPE_JPEG => 'image/jpeg',
    IMAGETYPE_PNG  => 'image/png',
    IMAGETYPE_BMP  => 'image/bmp',
    IMAGETYPE_WEBP => 'image/webp',
);
$mime = isset($mimeMap[$info[2]]) ? $mimeMap[$info[2]] : '';
if ($mime === '') {
    http_response_code(404);
    exit;
}

$etag = '"' . md5($blob) . '"';
if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) === $etag) {
    header('ETag: ' . $etag);
    header('Cache-Control: public, max-age=86400');
    http_response_code(304);
    exit;
}

if (!headers_sent()) {
    header('Content-Type: ' . $mime);
    header('Content-Length: ' . strlen($blob));
    header('ETag: ' . $etag);
    header('Cache-Control: public, max-age=86400');
    header('X-Content-Type-Options: nosniff');
    header('Content-Disposition: inline');
}
echo $blob;
