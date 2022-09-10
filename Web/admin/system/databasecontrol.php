<?php 
require("../../kernl/Init.php"); //初始化基础参数
if (!defined('source'))
{
	echo json_encode(array('status'=>'-1','message'=>"账户状态异常，请重试！"));
	exit;
}
//账户状态
$state = $dou -> AccountState();	
if ($state == 'Access denied') 
{
	
	echo json_encode(array('status'=>'-1','message'=>"账户状态异常，请重试！"));
	exit;
	
} 
$method = $_SERVER['REQUEST_METHOD'];
$addr = $_SERVER['PHP_SELF'].'?'.file_get_contents('php://input');
$filename = $_POST['filename'];						
switch($_POST['control'])
{
	case '备份数据库': 
		$resu = $dou -> query("show tables");
		while($t = $dou -> fetch_array($resu))
		{
  			$table = $t[0];
  			$q2 = $dou -> query("show create table `$table`");
  			$sql = $dou -> fetch_array($q2);
  			$mysql.=$sql['Create Table'].";\r\n";
  			$q3 = $dou -> query("select * from `$table`");
  			while($data = $dou -> fetch_assoc($q3))
			{
    			$keys = array_keys($data);
    			$keys = array_map('addslashes',$keys);
    			$keys = join('`,`',$keys);
    			$keys = "`".$keys."`";
    			$vals = array_values($data);
    			$vals = array_map('addslashes',$vals);
    			$vals = join("','",$vals);
    			$vals = "'".$vals."'";
				$mysql.= "insert into `$table`($keys) values($vals);\r\n";
				}
		}
		
		$filename = "../backup/".date('YmdjGis').".sql"; //存放路径，默认存放到项目最外层
		$fp = fopen($filename,'w');
		fputs($fp,$mysql);
		fclose($fp);
		echo json_encode(array('status'=>'0','message'=>'数据备份成功<br>备份文件 [ ' .$filename.' ]'));
		$dou -> WriteLog('POST', '管理员执行数据库备份', $addr); 
		break;
			
	case '恢复数据库':
		if (empty($filename))
		{
			echo json_encode(array('status'=>'-1','message'=>'请选择需要恢复的备份！'));
				
		} else {
			
			set_time_limit(0); //设置超时时间为0，表示一直执行。当php在safe mode模式下无效，此时可能会导致导入超时，此时需要分段导入 
			$info = "<p>正在恢复数据库，步骤一，清理数据表<br>"; 
			$result = $dou -> query("SHOW tables"); 
			while ($currow=$dou -> fetch_array($result)) 
			{ 
				$dou -> query("drop TABLE IF EXISTS $currow[0]"); 
				$info.= "清空数据表【".$currow[0]."】成功！<br>"; 
			} 
			$info.= "正在恢复数据库，步骤一，清理数据表....完成<br>正在恢复数据库，步骤二，导入数据<br>"; 
			$mysql_file = "../backup/".$filename; //指定要恢复的MySQL备份文件路径,请自已修改此路径
			if(file_exists($mysql_file)) 
			{
				$sql_value = "";
  				$cg = 0;
  				$sb = 0;
  				$sqls = file($mysql_file);
  				foreach($sqls as $sql)
  				{
  					$sql_value.= $sql;
  				}
  				$a = explode(";\r\n", $sql_value); //根据";\r\n"条件对数据库中分条执行
  				$total = count($a) - 1;
  				$dou -> query("set names 'utf8'");
  				for ($i = 0; $i < $total ; $i++)
  				{
 					$dou -> query("set names 'utf8'");
  					//执行命令
  					if($dou -> query($a[$i]))
  					{
   						$cg+=1;
						
  					} else {
					
   						$sb+=1;
						$sb_command[$sb] = $a[$i];
  					}
  				}
			
  				$info.= "操作完毕，共处理 $total 条命令，成功 $cg 条，失败 $sb 条<br>";
  				//显示错误信息
				
				if(constant("Debug") == 'on' & $sb>0)   //调试模式开启，并且存在失败条数的时候才显示错误语句
  				{
  					$info.= "<hr><br>失败命令如下：<br>";
  					for ($ii = 1; $ii<= $sb; $ii++)
  					{
   						$info.= "<b>第 ".$ii." 条命令（内容如下）：</b><br>".$sb_command[$ii]."<br>";
  					}
										
  				}  
				
				echo json_encode(array('status'=>'0','message'=>$info));
				
			}  else {
				
  				echo json_encode(array('status'=>'-1','message'=>'备份文件不存在！'));
			}
		}
			
		$dou -> WriteLog('POST', '管理员执行恢复数据库', $addr); 
		break;
			
	case '删除备份':
		if (empty($filename))
		{
			echo json_encode(array('status'=>'-1','message'=>'待删除的备份为空！'));
				
		} else {
			
			$file = ROOT_PATH."admin/backup/".$filename;  
			$result = @unlink ($file); 
			if ($result == false) 
			{ 
				echo json_encode(array('status'=>'-1','message'=>'× 删除失败!'));
				$dou -> WriteLog('POST', "删除备份：".$filename."失败！", $addr); 
				
			} else { 
				
				echo json_encode(array('status'=>'0','message'=>'√ 删除成功!'));
				$dou -> WriteLog('POST', "删除备份：".$filename."成功！", $addr); 
			} 
		}
		break;
			
	case '清空数据库':
		$data = explode(";", $dou ->Info("AllowDatabase"));
		$num = 0;	
		while ($currow = $data) 
		{ 
			if($num > count($data) -2 ) 
			{
				break;
				
			} else {
				
				$dou -> query("truncate table ".$currow [ $num ] ); 
				$info.= '清空数据表'.$currow [ $num ].'成功！<br>';
				$num++;	
			}

		}
		echo json_encode(array('status'=>'0','message'=>$info));
		$dou -> WriteLog('POST', '管理员执行清空数据表操作', $addr); 
		
		break;
		
	case '下载备份':
		if (empty($filename))
		{
			echo json_encode(array('status'=>'-1','message'=>'待下载的备份为空！'));
				
		} else {
			
			$file = ROOT_PATH."admin/backup/".$filename; 
			
			if(!file_exists($file))     //判断文件是否存在
			{  
				echo json_encode(array('status'=>'-1','message'=>"读取文件失败！"));
				exit;
			}
				session_start();
				$_SESSION["filename"] = $filename;
				echo json_encode(array('status'=>'99','message'=>"开始下载..."));
		}
		break;	
} 	

?>
