<?php 
ob_start();
require("kernl/Init.php"); //初始化基础参数
$dou -> CheckServerState();//网站状态检查
$dou -> WSCS_Check();

//读取参数
if(empty($_SERVER['QUERY_STRING'])) 
{
	echo '<script language="JavaScript">window.alert("参数不能为空")</script>';
	echo '<script language="JavaScript">window.opener=null;window.open("","_self");window.close();</script>'; 
	
} else {
	
	$parameter = strtolower($_SERVER['QUERY_STRING']); //获取参数，并强制转换为小写
	$data = explode("=", $parameter);
}	

//判断ID是否为特殊ID	
if(floatval($data[1]) > 0)  //Client
{
	$Array = $dou -> query('select remark from zd_software Where id = '.floatval($data[1])); 
	$row = $dou->fetch_array($Array);
	if(!file_exists(LocalSource  . '/'. $row[0].'.zip' )) 
	{  //如果是服务器上存放的，判断文件是否存在
	
		echo '<script language="JavaScript">window.alert("文件无法读取，请与管理员联系！")</script>';
		header('HTTP/1.1 404 NOT FOUND');
		echo '<script language="JavaScript">history:go(-1)</script>'; 
		
	} else {  
		
		$url='http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]; 
		$weburl = dirname($url);
		$file = fopen(LocalSource  . '/'. $row[0].'.zip' ,"rb"); // 打开文件 
		$name = iconv('UTF-8', 'GBK//IGNORE', $row[0]);
		$size = filesize(LocalSource  . '/'. $row[0].'.zip' );
			// 输入文件标签 
		Header("Content-type: application/zip"); 
		Header("Accept-Ranges: bytes");
	    Header("Content-Transfer-Encoding: binary"); 		
		Header("Accept-Length: ".$size); 
		Header("Content-Disposition: attachment; filename=" . $name. ".zip"); 
			// 输出文件内容
		Header("Content-length: ".$size);
		ob_clean();
		flush();
		print_r( fread($file,filesize(LocalSource  . '/'. $row[0].'.zip'))); 
		fclose($file);
		$dou -> UpdateSoftwareDownloadCount(floatval($data[1]));
		exit;
	}
	
} else {
	
	echo '<script language="JavaScript">window.alert("ID非法，请与管理员联系！")</script>';
	echo '<script language="JavaScript">history:go(-1)</script>'; 

}
?>