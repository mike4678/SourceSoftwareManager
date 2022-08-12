<?php 
require("../kernl/Init.php"); 

//************** 处理登陆状态
$dou -> WSCS_Check();                    //安全检查，防护系统
$state = $dou -> AccountState();
$addr = $dou -> AddrConvery($_GET);	 //初始化参数
if ($state == 'Access denied') 
{
	if( count($addr) > 0 && $addr[1] != 'exit') 
	{
		header("Location: login.php?ref=/".$addr[1]."/".$addr[2]);
		
	} else { 
		
		header("Location: login.php"); }
	
} else { 
	
	$dou->cookie("state", time(), time()+3600);  //更新时间
}
	
//************** 处理页面请求
switch ($addr[1])
{
	case 'exit':
		session_start();
		session_unset($Session);
		session_destroy();
		setcookie("usr", null, time()-3600);  
		setcookie("pwd", null, time()-3600);  
		setcookie("state", null, time()-3600); 
		//exit;
		echo '<script language="JavaScript">SystemBox(3,"您已成功退出系统！");</script>';
		echo '<script language="JavaScript">location.replace("login.php");</script>'; 	
	break;
		
	case 'phpinfo':
		phpinfo();
	exit();
	
	case 'Function':
		$arr = get_defined_functions();
		echo "<pre>";
		echo "当前系统所支持的所有函数,和自定义函数\n";
		print_r($arr);
		echo "</pre>";
	exit();
	
	case 'downbackup':
		session_start();
		$file = fopen($dou->info('BackupFilePath').'/'.$_SESSION["filename"] ,"rb"); // 打开文件 
		$name = iconv('UTF-8', 'GBK//IGNORE', $_SESSION["filename"]);
		$size = filesize($dou->info('BackupFilePath').'/'.$_SESSION["filename"] );
			// 输入文件标签 
		Header("Content-type: application/text"); 
		Header("Accept-Ranges: bytes");
	    Header("Content-Transfer-Encoding: binary"); 		
		Header("Accept-Length: ".$size); 
		Header("Content-Disposition: attachment; filename=" . $name); 
			// 输出文件内容
		Header("Content-length: ".$size);
		ob_clean();
		flush();
		print_r( fread($file,filesize($dou->info('BackupFilePath').'/'.$_SESSION["filename"]))); 
		fclose($file);
		exit;
		
	default:
		if ($addr[1] != "" && $addr[2] != "" )     //生成顶部导航和左边导航必须参数
		{ 
			$data = $dou->convert($addr[1],$addr[2]);
			if($data[2] != "" && $data[3] != "")  //判断当前要访问的变量是否存在，如
			{
				$tab = $data[2];      //如果存在，则继续执行当前变量
				$list = $data[3];
				
			} else {
				
				$data = $dou->convert('start','index');   //如果不存在，返回空则执行默认首页代码
				$tab = $data[2];
				$list = $data[3];
			}

		} else { 
			
			$data = $dou->convert('start','index');   //为空则判断为默认首页
			$tab = $data[2];
			$list = $data[3];
		}
}	

//生成首页Head部分
$value = $dou -> Info('Index_head_New');
preg_match_all("|{(.*)}|U", $value, $out, PREG_PATTERN_ORDER); //寻找文本中的{}字段内容
$tlist = 0;
while ($tlist <= count($out[1]) - 1)  
{
	$name = "{".$out[1][$tlist]."}";
	switch($out[1][$tlist])
	{
		case 'table_list':
			$HeadData = $dou->table_list_new($tab,$list);
			break;
			
		case 'table_name':
			$HeadData = $list;
			break;
		
		default:
			$HeadData = $dou -> Info($out[1][$tlist]);
			break;
	}
	//print_r($HeadData);
	$value = str_ireplace($name,$HeadData,$value);
	$tlist = $tlist + 1;
	//print_r($tlist);
} 
//生成结束
//print_r($value);
$PageData = $value;
echo $PageData;

//生成首页数据
$bottom = $dou->PageLoading($data[2],$data[3]);
$file = dirname(__FILE__) . '/' . $bottom; 
if(file_exists(strtolower($file)) != TRUE)  //检查页面是否存在
{  //不存在
	echo $dou -> Admin_ErrorPage ( $addr[1] , $addr[2] , $file); 
	
} else {    
		
	include $bottom;
	
}
//生成结束
?>

		<footer class="footer">
			<ul class="list-inline" style="text-align:center">
				<li ><?php echo $dou -> Info('bottom'); ?></li>
			</ul>
		</footer>
	</div>
</div>
	<script src="../js/jquery.min.js"></script>
	<script src="../js/modernizr.min.js"></script>
	<script src="../plugin/bootstrap/js/bootstrap.min.js"></script>
	<script src="../plugin/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="../plugin/nprogress/nprogress.js"></script>
	<script src="../plugin/sweet-alert/sweetalert.min.js"></script>
	<script src="../plugin/waves/waves.min.js"></script>
	<script src="../plugin/moment/moment.js"></script>
	<script src="../js/main.min.js"></script>
</body>
</html>
