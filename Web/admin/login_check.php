<?php 
//载入函数PHP
require("../kernl/Init.php"); //初始化基础参数
$dou -> WSCS_Check();
//来路判断


//初始化变量
$method = $_SERVER['REQUEST_METHOD']; //操作方式，post/GET
$addr = $_SERVER['PHP_SELF'].'?'.file_get_contents('php://input'); //提交地址
$username = $_POST['username'];  //用户名
$PWD = $_POST['password'];  //密码
$ref = empty($_POST['return']) ? '' : $_POST['return']; //跳转地址

if( $_COOKIE["SourceTryCount"] == NULL) 
{
	$dou->cookie("SourceTryCount", 0, time()+36000);	
	
} elseif($_COOKIE["SourceTryCount"] >= $_G['Login']['MaxNumber']) {
	
	echo json_encode(array('status'=>'-1','message'=>'超过最大尝试次数！'));
	exit;
	
}

if ($dou -> Info('VaildCode') == 0)   //启用验证码
{
	session_start(); //初始化验证码Session
	if(empty($_POST['code']) || $_POST['code'] != $_SESSION["VaildCode"])
	{
		$data = $_COOKIE["SourceTryCount"] + 1;
		$dou->cookie("SourceTryCount", $data , time()+36000);
		echo json_encode(array('status'=>'-1','message'=>'验证码错误'));
		exit;
	}
	session_destroy(); //验证码Session销毁
} 


if( key == NULL) 
{
	echo $dou -> Sys_ErrorPage(432);
	exit;
}

//判断最基本的两个值是否为空
if (empty($username) || empty($PWD) )  //判断POST回来的用户名或密码是否为空
{ 
	$data = $_COOKIE["SourceTryCount"] + 1;
	$dou->cookie("SourceTryCount", $data , time()+36000);
	echo json_encode(array('status'=>'-2','message'=>'用户名或密码不能为空'));
	exit;
} 

//首先更改用户tocket
$passcode = Account::PwdEnc($PWD, key); //加密密码，同时将明文密码清除掉
$PWD = "";

//判断密码是否正确
$dou -> query("select * from zd_admin_user where username = '$username' and password = '$passcode'"); //执行登陆操作
if( $dou -> affected_rows() == NULL)
{
	$data = $_COOKIE["SourceTryCount"] + 1;
	$dou->cookie("SourceTryCount", $data , time()+36000);
	echo json_encode(array('status'=>'-3','message'=>'密码错误','test'=>$passcode));
	$dou -> WriteLog('POST', '用户尝试登陆，但密码错误！','Login.php');
	exit;
	
} else {
	session_start(); //标志Session的开始 
	$_COOKIE["SourceTryCount"] = 0;
	if($_POST['save'] = 'true')   //判断是否记住登陆信息
	{
		$dou->cookie("usr", $username, time()+36000);
		$dou->cookie("pwd", $passcode, time()+36000); //一个小时3600*一天24小时*365天
		$dou->cookie("state", time(), time()+36000);		
		$_SESSION['username'] = $username; 
		$iipp = $_G['IPS']['ClientIP']; //获取登录者ip
		$time = constant("Time"); //获取登录时间
		$_SESSION['time'] = $time;
		$dou -> query("update zd_admin_user set lasttime = '$time' , lastip = '$iipp' where username = '$username';");
		if($dou -> affected_rows() == NULL)
		{
			$dou -> WriteLog('POST', '用户登陆成功，但登陆状态更新失败！','Login.php');
			echo json_encode(array('status'=>'-4','message'=>'状态更新失败'));
			
		}  else { 						
			$dou -> WriteLog('POST', '用户登陆成功','Login.php');
			echo json_encode(array('status'=>'0','message'=>'success'));

			}
		
	} else {
			
		$dou -> query("update zd_admin_user set lasttime = '$time' , lastip = '$iipp' where username = '$username';");
		if($dou -> affected_rows() == NULL)
		{
			$dou -> WriteLog('POST', '用户登陆成功，但登陆状态更新失败！','Login.php');
			echo json_encode(array('status'=>'-4','message'=>'状态更新失败'));
			
		}  else { 						
			$dou -> WriteLog('POST', '用户登陆成功','Login.php');
			echo json_encode(array('status'=>'0','message'=>'success'));//不存在返回nameerror
								}
					
						}
				
				} 
?>