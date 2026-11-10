<?php
/* ---------------------------------------------------- */
/* 计算安装包 Hash（供后台“软件管理”自动填充）
/* 安全修订说明（2026）：
/*  1. 原代码把 $_POST['Filename'] 直接拼进 LocalSource 路径，
/*     可用 ../../ 读取服务器任意文件（并回传 CRC32 与大小）；
/*     现改为 basename + 白名单 + realpath 目录校验
/*  2. 文件不存在时明确返回错误，不再触发 filesize 警告
/*  3. 输出统一 UTF-8，修复原文件为 GBK 导致的中文乱码
/* ---------------------------------------------------- */
require("../../kernl/Init.php");
$dou->WSCS_Check();

if ($dou->AccountState() === 'Access denied') {
    echo json_encode(array('status' => '-2', 'message' => ''));
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(array('status' => '-1', 'message' => '无效的参数请求'));
    exit;
}

$filename = isset($_POST['Filename']) ? basename(str_replace('\\', '/', (string)$_POST['Filename'])) : '';

if ($filename === '' || !preg_match('/^[\p{Han}A-Za-z0-9_\-\. ]{1,150}$/u', $filename) || strpos($filename, '..') !== false) {
    echo json_encode(array('status' => '-1', 'message' => '无效的参数请求'));
    exit;
}

$sourceDir = rtrim(str_replace('\\', '/', LocalSource), '/');
$realDir   = realpath($sourceDir);
$file      = $sourceDir . '/' . $filename;
$realFile  = realpath($file);

if ($realDir === false || $realFile === false || !is_file($realFile)
    || strpos($realFile, $realDir . DIRECTORY_SEPARATOR) !== 0) {
    echo json_encode(array('status' => '-1', 'message' => '文件不存在'));
    exit;
}

echo json_encode(array(
    'status'  => '0',
    'message' => strtoupper(hash_file('crc32b', $realFile)),
    'Path'    => basename($filename, '.zip'),
    'Size'    => filesize($realFile),
));
