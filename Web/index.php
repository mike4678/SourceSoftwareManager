<?php 
require("kernl/Init.php"); 

$dou -> WSCS_Check();                    //安全检查，防护系统
$addr = $dou -> AddrConvery($_GET);	 //初始化参数

//生成首页Head部分
$context = stream_context_create(array('http'=>array('ignore_errors'=>true)));
$value = file_get_contents(HttpsCheck(). $_SERVER['HTTP_HOST'] .  '/softmanager/template/index.html', FALSE, $context);
preg_match_all("|{(.*)}|U", $value, $out, PREG_PATTERN_ORDER); //寻找文本中的{}字段内容
$tlist = 0;
while ($tlist <= count($out[1]) - 1)  
{
	$name = "{".$out[1][$tlist]."}";
	switch($out[1][$tlist])
	{
		case 'table_list':
			$HeadData = $dou->front_table_list();
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
$file = dirname(__FILE__) . '/content.php'; 	

if(file_exists(strtolower($file)) != TRUE)  //检查页面是否存在
{  //不存在
	echo $dou -> Admin_ErrorPage ( $addr[1] , $addr[2] , $file); 
	
} else {    
		
	include $file;
	
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
	<script src="js/jquery.min1.js"></script>
	<script src="js/modernizr.min.js"></script>
	<script src="plugin/bootstrap/js/bootstrap.min.js"></script>
	<script src="plugin/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="plugin/nprogress/nprogress.js"></script>
	<script src="plugin/sweet-alert/sweetalert.min.js"></script>
	<script src="plugin/waves/waves.min.js"></script>
	<script src="plugin/moment/moment.js"></script>
	<script src="js/main.min.js"></script>
</body>
</html>
