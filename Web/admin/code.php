<?php 
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
require_once("../kernl/Caption.Class.php");
$rsi = "";
$code = "";
$rsi = new Utils_Caption();
$rsi -> TFontSize=array(15,17);
$rsi -> Width=50;
$rsi -> Height=20;
$code = $rsi -> RandRSI();
session_start();
$_SESSION["VaildCode"] = $code;
$rsi -> Draw();
exit;
?>