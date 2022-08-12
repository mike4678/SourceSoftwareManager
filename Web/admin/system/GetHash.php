<?php
require("../../kernl/Init.php"); 
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器
$dou -> WSCS_Check();       //安全检查，防护系统
$state = $dou -> AccountState();
if ($state == 'Access denied') 
{
	if( count($addr) > 0 && $addr[1] != 'exit') 
	{
		echo json_encode(array('status'=>'-2','message'=>''));
		exit;
		
	} else { 
		
		echo json_encode(array('status'=>'-2','message'=>''));
		exit;
	}
	
} 

if ($_SERVER["REQUEST_METHOD"] == "GET") 
{
	echo json_encode(array('status'=>'-1','message'=>'无效的请求操作！'));
	exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	if(empty($_POST['Filename'] ))
	{
		
		echo json_encode(array('status'=>'-1','message'=>'无效的请求操作！'));
		exit;
		
	} else {
		$tmppath = explode('、', $fileico[$key]);
		echo json_encode(array('status'=>'0','message'=>strtoupper(hash_file('crc32b', LocalSource . '\/' . $_POST['Filename'] )),'Path'=>basename($_POST['Filename'],'.zip'),'Size'=>filesize(LocalSource . '\/' . $_POST['Filename'])));
		exit;
		
	}
}             
?>