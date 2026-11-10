<?php
/* 验证码生成（与 kernl/Init.php 保持同一会话名，否则登录校验读不到验证码） */
header("Content-Type: image/png");
header("Cache-Control: no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("X-Content-Type-Options: nosniff");

require_once("../kernl/Caption.Class.php");

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name('SMSESSID');
    @session_start();
}

$rsi            = new Utils_Caption();
$rsi->TFontSize = array(15, 17);
$rsi->Width     = 50;
$rsi->Height    = 20;
$code           = $rsi->RandRSI();
$_SESSION["VaildCode"] = $code;
$rsi->Draw();
exit;
