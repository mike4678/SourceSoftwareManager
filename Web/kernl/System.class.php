<?php
/* ---------------------------------------------------- */
/* 程序名称: 核心函数
/* 程序功能: 所有核心函数的调用均在此页面中
/* 程序开发: Source
/* 联系方式: 542112943@qq.com
/* Date: 1970-01-01 / 2019-01-01
/* ---------------------------------------------------- */
/* 使用条款:
/* 1.该软件免费使用.
/* 2.禁止任何衍生版本.
/* ---------------------------------------------------- */

class System extends DbMysql 
{
	//系统设置表信息
	/* ---------------------------------------------------- */
	function Info($data) {                  
		$query = $this->select_all('zd_system_setting');
		while ($row = $this->fetch_array($query)) 
		{
			
			if ($row[0] == $data)
			{
				return $row[1];
				break;
				}
			}

		}
	/* ---------------------------------------------------- */
	
		//软件设置表信息
	/* ---------------------------------------------------- */
	function SInfo($data) {                  
		$query = $this->select_all('zd_config');
		$row = $this->fetch_array($query);
		return( $row[$data]);
		break;
		}
	/* ---------------------------------------------------- */
		
		//软件信息
	/* ---------------------------------------------------- */
	function SoftwareDataInfo($various,$id) {                  
		$query = $this->select('zd_software', $various, 'id = ' . $id);
		$row = $this->fetch_array($query);
		//print_r($row );
		return( $row[$various]);
		break;
		}
	/* ---------------------------------------------------- */
	
	//删除一条或多条数据
	/* ---------------------------------------------------- */
	function DelData($table,$hterm,$term,$method)    //参数：表$table,条件头$hterm,条件$term,操作方式$method
	{ 
   		if(empty($table) || empty($hterm) || empty($term) || empty($method))  //五个变量任意一个如果为空
		{     
			echo "<script language='JavaScript'>window.alert('操作请求所需要的值错误，请检查！')</script>";
			
		} else {
			switch ($method) {
					
				default:   //请求无效
					echo '<script language="JavaScript">window.alert("无效的操作请求")</script>';
				break;
		
				case 'POST':    //处理多个删除任务
					$sql = "delete from ".$table." where ".$hterm." in ('".$term."');";
					if (!$this->query($sql)) 
					{
   						echo '<script language="JavaScript">window.alert("删除失败！")</script>';
     				}
					echo '<script language="JavaScript">window.alert("删除成功！")</script>';
    				echo '<script language="JavaScript">self.location=document.referrer;</script>';
    			break;
		
				case 'GET':    //处理单个删除任务
					if (count(explode("%",$term)) >= 1)  //一般认为一个中文字会转换成3个类似%D8%E5%C3的代码，因此这里以3为判断标准
					{  
						$url = urldecode($term);
						$sql = "delete from ".$table." where ".$hterm." = '" .$url. "';";
						//echo '<script language="JavaScript">window.alert("'.$sql.'")</script>';
						if (!$this->query($sql)) 
						{
   							echo '<script language="JavaScript">window.alert("删除失败！")</script>';
     					}
						echo '<script language="JavaScript">window.alert("删除成功！")</script>';
    					echo '<script language="JavaScript">self.location=document.referrer;</script>';
						
					} 
				break;
				} 
		}
	}
	/* ---------------------------------------------------- */
	
	//页面功能生成
	/* ---------------------------------------------------- */	
	function table_list_New($table,$table_list) //自动生成左边列表
	{  
		if( empty($table) && empty($table_list) )   //检查，如果这两个参数都为空，则返回错误信息，
		{ 
			
			echo '<script language="JavaScript">window.alert("初始化页面失败！");history.back(-1);</script>';
			
 	 	} else { 
			$tab = ""; //初始化变量
			$TableData = explode("|", $this -> Info("system_table"));
			foreach($TableData as $val)
			{
				$row = explode(";", $val);
				$tab.="<li><a class='waves-effect parent-item js__control' href='#'><i class='menu-icon mdi mdi-desktop-mac'></i><span>".$row[0]."</span><span class='menu-arrow fa fa-angle-down'></span></a><ul class='sub-menu js__content'>";
				$list = $this->select('zd_adminlist', '*', "zd_adminlist.table = '".$row[0]."' ORDER BY count ASC;", $debug = ''); //生成左边列表部分
				while ( $row1 = $this->fetch_array($list) )  
				{
					$tab.= "<li><a href='".$row1['url']."'>".$row1['menu']."</a></li>";			
				}
				$tab.="</ul></li>";
			}
   		}
		return $tab;
	}
	
	function front_table_list() //自动生成左边列表
	{  
		if($_COOKIE['setclient'] == 'android')
		{
			if(strstr($_SERVER["QUERY_STRING"],"?/") == false)
			{
				$index_d = "index.php?".$_SERVER["QUERY_STRING"];
			} else {
				$index_d = "index.php?".$this -> strip_comments("?","/",$_SERVER["QUERY_STRING"]);
			}
			
		} else {
		
			$index_d = "index.php?";
		}
		$tab = "<li><a class='waves-effect parent-item js__control' href='".$index_d."'><i class='menu-icon mdi mdi-desktop-mac' style='top:13px;left:5px'></i><span>软件分类</span><span class='menu-arrow fa fa-angle-down'></span></a><ul class='sub-menu js__content'><li><a href='".$index_d."'> |- 全部软件 </a></li>"; //初始化变量
		$sql = "select * from zd_type;"; 
		$result = $this -> query($sql); 
		while ($row = $this -> fetch_array($result)) 
		{
			$tab.="<li><a href='".$index_d."/".$row['type']."'> |- ".$row['type']."</a></li>";
			
		}
		$tab.="</ul></li>";
		return $tab;
	}
	
	function navigation ($table,$table_list)   //导航栏内容
	{   
		if( empty($table) || empty($table_list) )   //检查
		{ 
			echo '<script language="JavaScript">window.alert("初始化导航栏失败！");history.back(-1);</script>';
			
		} else { 
			$infor = array(); 
			$query = $this->select('zd_adminlist', '*', "zd_adminlist.table='".$table."'  AND zd_adminlist.menu = '".$table_list."' UNION ALL SELECT * FROM `zd_adminlist` where adminlist.table = '".$table."' ORDER BY count ASC limit 2;", $debug = '');
			while (	$row = $this->fetch_array($query))   
			{
				$TaskBar = "<a href='admin.php' class='icon-home'> 首页</a> > ";
				$TaskBar.= "<ui>".$row[2]."管理</ui> > "; 
				$TaskBar.="".$table_list."";
				break;
			}
		}
		return $TaskBar;
	}

	function convert($table,$table_list)  //将英文名称转换为中文
	{  
		$query = $this->select('zd_Adminlist', '*', "zd_Adminlist.t_e = '".$table."' AND m_e = '".$table_list."'", $debug = '');
		$row = $this->fetch_array($query);
		return $row;
	}
	
	function AddrConvery($data)  //处理请求
	{  
		if(count($data) > 1)
		{
			//获取第一个主Key值
			reset($data);
			$first_key = key($data);
			$arr = explode("/",$first_key);
			return $arr;
		}
		
		foreach ($data as $key=>$value) //把参数传入变量key中
		$arr = explode("/",$key);
		return $arr;
		
	}	
	
	function PageLoading($table,$table_list = '')    //载入框架页面
	{  
		$query = $this->select('zd_adminlist', '*', "zd_adminlist.table = '".$table."' AND zd_adminlist.menu = '".$table_list."'", $debug = '');
		$row = $this->fetch_array($query);
		return $row['page'];
	}
	
	function FormCheck($address)  //检查框架页面是否存在，即不允许直接访问
	{   
		echo '<script>if(window.top==window.self){ window.alert("请勿试图在非授权区域运行！")'.$this -> WriteLog('Get','试图从外部访问地址:'.$address.'已被拦截',$address).';var browserName=navigator.appName; if (browserName=="Netscape") {window.opener = null; window.open("","_self");window.close(); } else {open(location, "_self").close();window.location.href = "about:blank"; window.close();}  }</script>';
		
	}

	function FormCreate($data)  //多选项夹生成
	{ 
		$form = '<div class="col-xs-12"><div class="box-content"><div class="row"><div class="col-md-12"><ul class="nav nav-tabs" id="myTabs" role="tablist">';
		unset($data['TabName']); //删除标题数组
		foreach ($data as $row)   
		{
			if($row['active'] != 'active') 
			{
				$form.= "<li role=\"presentation\"><a href=".$row['tab']." role=\"tab\" id=".$row['tab']." data-toggle=\"tab\" aria-controls=".$row['tab'].">".$row['Name']."</a></li>";
				} else {
					$form.= "<li role=\"presentation\" class=\"active\"><a href=".$row['tab']." role=\"tab\" id=".$row['tab']." data-toggle=\"tab\" aria-controls=".$row['tab'].">".$row['Name']."</a></li>";
					}
		}
		$form.= "</ul>"; 
		echo $form;
	}
	
	function PageValue($table,$table_list = '')  //读入页面参数
	{  
		$query = $this->select('zd_adminlist', '*', "zd_adminlist.table = '".$table."' AND zd_adminlist.menu = '".$table_list."'", $debug = '');
		$row = $this->fetch_array($query);
		return $row['value'];
	}
	
	function content($data,$value)
	{                     //内容页面相关参数返回
		$query = $this -> query("select * from zd_content_data where list = '$data'");	
		if($this -> affected_rows() == NULL )  
		{
			return 'error';
		} else {
			$row = $this->fetch_array($query);
			return $row[$value];
		}

	}
	/* ---------------------------------------------------- */
	
	//写入系统日志
	/* ---------------------------------------------------- */
	function WriteLog($method,$data,$addr)     //参数：请求方式、操作内容、操作页面
	{    
		$ip = $_SERVER["REMOTE_ADDR"]; //获取IP
		$time = date("y/m/d",time());  //获取现在时间
		$query = $this->select('zd_system_log', 'max(id)', "", $debug = '');
		while ($row = $this->fetch_array($query)) 
		{ 
			$id = $row['max(id)'] + 1;
		}
		$this->query("INSERT INTO zd_system_log (id, method, ip, data, addr, time) VALUES ('$id','$method','$ip','$data','$addr','$time')");
 	 	if ($this->affected_rows() == NULL) 
		{
      		echo '<script language="JavaScript">window.alert("写入日志失败！")</script>';
    	}
	} 
	/* ---------------------------------------------------- */
	
		//上传大小检查
	/* ---------------------------------------------------- */
	function CheckUploadSize() 
	{
		$File_size = $this->Info('upload_size');
		$PHP_Size = str_replace("M","",ini_get('post_max_size'));
		if($File_size == NULL || $File_size == 0 || $File_size > $PHP_Size) 
		{
			$size = $PHP_Size - 1;
			$sql = "update zd_system_setting set value = '". $size ."' where vars = 'upload_size';";
			if(!$this->query($sql))
			{
				echo '参数检测发现异常，但尝试修复失败！';
			}
		} 
	}

	/* ---------------------------------------------------- */
	
		
		//系统状态检查
	/* ---------------------------------------------------- */
	function CheckServerState() 
	{
		$staus = $this->Info('server_status');
		if($staus == "1") 
		{
			echo $this->Sys_ErrorPage(503);
			exit;
		}
	}

	/* ---------------------------------------------------- */
	
		
		
		//登陆状态
	/* ---------------------------------------------------- */
	function AccountState() 
	{
		if(isset($_COOKIE['state']))
		{
			if($_COOKIE['state'] != 'Access denied'  )  //已经登陆过，且记录还存在
			{
				$user = $_COOKIE['usr'];
				$pwd = $_COOKIE['pwd'];
				$time = $_COOKIE['state'];
				$now = time();
				if($time > $now - 3600) 
				{
					$this -> query("select * from zd_admin_user where username = '$user' and password = '$pwd';");
					if( $this -> affected_rows() != 1 ) 
					{
						echo '<script language="JavaScript">window.alert("账户信息验证失败，请重新登陆！")</script>';
						return 'Access denied';
					} 
				} else {
					echo '<script language="JavaScript">window.alert("账户session校验失败，请重新登陆！")</script>';
					$this -> cookie("usr", '', time()-3600*24*365);
					$this -> cookie("pwd", '', time()-3600*24*365);    //一个小时3600*一天24小时*365天
					$this -> cookie("state", '', time()-3600*24*365);
					return 'Access denied';
				}
			} else {
				
				return 'Access denied';
			}	
			
		} else {
			
			return 'Access denied';
		}
	}
	
	/* ---------------------------------------------------- */
	
		
		//PHP COOKIE设置函数立即生效，支持数组
	/* ---------------------------------------------------- */
	function cookie($var, $value = '', $time = 0, $path = '', $domain = '', $s = false)
	{
    	$_COOKIE[$var] = $value;
    	if (is_array($value)) 
		{
        	foreach ($value as $k => $v)
			{
            	setcookie($var . '[' . $k . ']', $v, $time, $path, $domain, $s);
        	}
			
    	} else {
			
        	setcookie($var, $value, $time, $path, $domain, $s);
    	}
	}
	
	/* ---------------------------------------------------- */
		
	
		
		//在线检查更新
	/* ---------------------------------------------------- */
	function CheckUpdate()
	{
		
		if(strtolower($this -> Info("update_status")) == 'custom')  //定制版
		{
			echo '定制版请联系开发者获取更新';
			
		} else {
			
			$opts = array(
							'http'=>array(
							'method'=>"GET",
							'timeout'=>600,
							)
						);
		
			$context = stream_context_create($opts);
			$url = 'http://service.csource.com.cn/update/check.php?product=' . $this -> Info("update_status"); 
			$html = file_get_contents($url,false, $context); 
			$str = strtr($html, "\t", ' ');
			$encode = mb_detect_encoding($str, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
				if($encode != "UTF-8")
				{
  					$str = iconv("GBK","UTF-8",$str);
				}
			$return_data = json_decode($str,true);
			echo '<a href="javascript:SystemBox(2,\'http://service.csource.com.cn/update/update.php?product=' . $this -> Info("update_status") . '\',\'\',\'系统更新\',400,420)" >' . $return_data['version'] . '</a>'; 
			
			}
	}
	
	
	/* ---------------------------------------------------- */
	
			
	
		
		//数据表检查(参数：需要检查的表名)
	/* ---------------------------------------------------- */
	function TableCheck($table)   
	{
		
		$result = $dou -> query("SELECT * FROM ".$table );
  		while($row = $dou -> fetch_array($result))
  		{     
			if(!$row)
			{         
				die('系统初始化出现异常错误，请删除kernl目录下config文件后，尝试重新安装，如果仍看到此提示，请与管理员联系！');
				
			}    
  		}
		
	}
	
	/* ---------------------------------------------------- */

	
		
		//IP管理核心部分
		//type 定义
		// 0   白名单
		// 1   黑名单
		// 2   双向
	/* ---------------------------------------------------- */
	function Get_LocalIP()          //获取客户端IP
	{
		
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
			$ip = getenv("HTTP_CLIENT_IP"); 
		else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
			$ip = getenv("HTTP_X_FORWARDED_FOR"); 
		else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
			$ip = getenv("REMOTE_ADDR"); 
		else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
			$ip = $_SERVER['REMOTE_ADDR']; 
		else 
			$ip = "unknown"; 
		return($ip); 
		
	}
	
	function Check_IPStatus()     //检查当前IP是否被限制
	{
		
		if($this -> Info('ipfirewall_status') == 0)
		{
			
			$Data = $this -> Get_IpList(); //服务端IP
			$Check_IP_Arrary = explode('.',$this -> Get_LocalIP()); //当前客户端IP
			$List_IP = ''; //黑白名单列表
			$Allow = false;
			foreach ($Data as $value)
			{
				if($value['type'] == '2' || $value['type'] == $this -> Info('ipfirewall_mode'))
				{
					$List_IP[] = explode('.',$value['iptable']);
				} 	
			}

			foreach ($List_IP as $value)
			{
				$Allow_Number = 0; //匹配次数
				$TDF_Number = 0;  //替代符出现次数				
				for ($i=0;$i<4;$i++)
				{
					if($value[$i] != '*')
					{

          				if($Check_IP_Arrary[$i] == $value[$i])
						{
									
							$Allow_Number++;
						}
						
        			} else {  //发现*号，记录该符号出现次数
								
						$TDF_Number++;
					}
      			}
				if($TDF_Number != 0) 
				{
					if($Allow_Number + $TDF_Number == 4)
					{
						$Allow = 'TRUE';

					} 
						
				} elseif($Allow_Number == 4) 
				{
					$Allow = 'TRUE';
					
				} 

			}
			
			switch ($this -> Info('ipfirewall_mode'))
			{
				case '0':
					if($Allow != 'TRUE') 
					{
						$return = array(
       									'status' => 2,
       									'msg' => '该IP无权限访问',
       									'data' => $Check_IP_Arrary
       									);
    					return json_encode($return);
						exit();
					}
					break;
					
				case '1':
					if($Allow == 'TRUE') 
					{
						$return = array(
       									'status' => 2,
       									'msg' => '该IP无权限访问',
       									'data' => $Check_IP_Arrary
       									);
    					return json_encode($return);
						exit();
					}
					break;
			}
		}
	}
	
	function IPFirewallControl($method, $ip , $mode)    //IP新增删除修改
	{
		if($method != "" && $ip != "")
		{
			
			switch($method)
			{
				case 'add':
					$sql = "INSERT INTO `system_ips` (`iptable`, `type`) VALUES ('".$ip."', '".$mode."');";
					break;
				
				case 'edit':
					$sql = "UPDATE `system_ips` SET `type`='".$mode."' WHERE `iptable`='".$ip."';";	
					break;
					
				case 'del':
					$sql = "DELETE FROM `system_ips` WHERE `iptable`='".$ip."';";
					break;
					
			}
			
			if(!$this->query($sql))
			{
				return 'failed';
				
			} else {
				
				echo '<script language="JavaScript">window.alert("操作成功！")</script>';
			}
			
		} else {
			
			die("参数数据错误！<a href='javascript:history.go(-1)'>点击返回</a>");
			
		}
	
	}
	
	function Get_IpList()   //获取当前模式下的ip信息
	{
		
		$IPListRow = $this->fetch_array_all('system_ips');
		return $IPListRow;
		
	}	
	/* ---------------------------------------------------- */

		
		//随机字符生成
	/* ---------------------------------------------------- */	
	
	function generate_password( $length = 8 ) 
	{
    // 密码字符集，可任意添加你需要的字符
    	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#￥%&*()<>?{}[]|';

    	$password = '';
    	for ( $i = 0; $i < $length; $i++ ) 
    	{
        // 这里提供两种字符获取方式
        // 第一种是使用 substr 截取$chars中的任意一位字符；
        // 第二种是取字符数组 $chars 的任意元素
        // $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        	$password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
    	}

    return $password;
	}
	/* ---------------------------------------------------- */
			//首页错误页生成
	/* ---------------------------------------------------- */	
	function getNeedBetween($kw,$mark1,$mark2)
	{
		$st = stripos($kw,$mark1);
		$ed = stripos($kw,$mark2);
		if(($st == false || $ed == false) || $st >= $ed)
		{
			return 0;
		}
		$kw = substr($kw,($st+1),($ed-$st-1));
		return $kw;
	}
	/* ---------------------------------------------------- */
		//首页错误页生成
	/* ---------------------------------------------------- */	
	
	function Index_ErrorPage ( $code = 3 ) 
	{
    	// 根据错误码生成对应的错误文本
    	switch($code) //判断错误码
		{
			
			case '307':    
				$errorcode = "<span>3</span><span>0</span><span>7</span>";
				$data = "如果您看到此页面，是由于启用了首页模块，但所设置的页面系统未搜索到，如果您是网站管理员请检查所设置页面是否可以访问";
				$title = "";
				break;
			case '301':    
				$errorcode = "<span>3</span><span>0</span><span>1</span>";
				$data = "如果您看到此页面，是由于启用了首页模块，但并未设置相应页面，如果您是网站管理员可到系统设置中进行设置";
				$title = "";
				break;
			case '404':    
				$errorcode = "<span>4</span><span>0</span><span>4</span>";
				$data = "这是系统默认首页，如果您看到此页面说明当前网站服务是正常的，但未设置前端主页！";
				$title = "Page No Found!";
				break;	
		}
		
		$Page = '<!DOCTYPE html><html lang="en"><head><meta name="viewport" content="width=device-width, initial-scale=1" /><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><link href="../css/error.css" rel="stylesheet" type="text/css" media="all" /><body><div class="w3layouts-bg"><h1 class="header-w3ls">Error Page</h1><div class="agileits-content"><h2>' . $errorcode . '</h2></div><div class="w3layouts-right"><div class="w3ls-text"><h3>sorry !</h3><h4 class="w3-agileits2">' . $title . '</h4><p>' . $data . '</p><p class="copyright">'. $this->Info(bottom) . '</p></div></div><div class="clearfix"></div></div></body></html>';
		
		return $Page;
		
	}
		/* ---------------------------------------------------- */
	
			//后台404错误页生成
	/* ---------------------------------------------------- */	
	
	function Admin_ErrorPage ( $MainParameter , $SubParameter , $FilePath) 
	{
		
		$data = $this -> convert($MainParameter,$SubParameter);
		$this -> WriteLog('GET', '加载模块：' . $data[2] . '/' . $data[3] .'<br />实例对象：'. $FilePath . '失败','404.php'); //记录错误日志
	 	$Page ='<div id="main">
				<header id="header">
      			<h1><span class="sub">模块加载失败！</span></h1>
    			</header>
    			<div id="content">
      			<p>[ 主参数 ] ' . $data[2] . ' ( ' . $MainParameter . ' )<br />[ 子参数 ] ' . $data[3] . ' ( ' . $SubParameter . ' )<br />[ 模块名称 ] ' . $FilePath . '<br />[ 错误原因 ] 由于模块未找到或出现异常，加载失败！ (处理出现异常)<br /> [ 记录时间 ] ' . constant("Time") . ' [ 访问IP ] ' . $_SERVER["REMOTE_ADDR"] . '</p>
    			</div>
				</div>';    //输出错误信息	

		return $Page;
		
	}
		/* ---------------------------------------------------- */
		
		//系统错误页生成
	/* ---------------------------------------------------- */	
	
	function Sys_ErrorPage ( $code = 3 ) 
	{
    	// 根据错误码生成对应的错误文本
    	switch($code) //判断错误码
		{
			
			case '503':
				$title = '系统正在维护中！';
				$content = $this->Info('server_infomaction');
				$this -> WriteLog('GET', '访问请求由于 系统维护中 被拦截<br />','error.php');
				break;
			
			case '342':
				$title = '系统数据检查失败';
				$content = '检测到一个或多个核心数据字段丢失，请删除kernl目录下的conf文件，重新安装系统！';
				break;	
		
			case '336:1':
				$title = '操作非法';
				$content = '当前操作不在系统许可范围内，请检查后重试！';
				break;
	
			case '336:2':
				$title = '操作非法';
				$content = 'Session值校验异常，请检查后重试！';
				break;	
		
			case '336:3':
				$title = '操作非法';
				$content = '用户检查失败,系统安装未完成！';
				break;		
		
			case '336:4':
				$title = '路径检查失败';
				$content = '路径检查失败，系统仅支持在一级目录下安装！';
				break;	
		
			case '195':
				$title = '浏览器检查失败！';
				$content = '当前浏览器版本不受支持，请更新浏览器或更换为更安全的Google浏览器';
				break;		
		
			case '330':
				$title = '管理员已禁用留言板';
				$content = '管理员已禁用留言板，如需帮助请与网站管理员联系！&nbsp; &nbsp; <a href="../index.php">返回首页</a>';
				break;	
				
			case '500':
				$title = 'Access Denied';
				$content = '您无权使用所提供的凭据查看此目录或页面。';
				break;
				
			case '701':
				$title = 'Access Denied';
				$content = '当前请求包含违禁字符，已被系统拦截！';
				break;	
				
			case '999':
				$title = 'Access Denied';
				$content = '当前IP已被限制访问！';
				break;			
		
		}
		$time = date("y/m/d H:i:s",time());
		$Page = '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>' . $title . '</title></head><body><div id="main"><header id="header"><h1><span class="sub"> ' . $title . '</span></h1></header><div id="content"><p>[ 错误原因 ] ' . $content . ' <br /> [ 出错时间 ] ' . $time  . ' [ 访问IP ] ' . $_SERVER["REMOTE_ADDR"] . '</p>----------------------------------------------------------------<p class="copyright">'. $this->Info(bottom) . '</p></div></div></html>' ;
		
		return $Page;
		
	}
		/* ---------------------------------------------------- */
		
		//上传大小检查
		/* ---------------------------------------------------- */
		function UploadFrameFix() 
		{
			$UploadFrame = $this->Info('upload_frame');
			if($UploadFrame == NULL ) 
			{
				$sql = "update zd_system_setting set value = 'system;.png、.jpg、.gif;../../images/|module;.zip;../../module/|' where vars = 'upload_frame';";
				if(!$this->query($sql))
				{
					echo 'null';
				}
			} 
		}

		/* ---------------------------------------------------- */
			
		// 上传框架解析，返回数组
		/* ---------------------------------------------------- */
		function UploadFrame() 
		{
			if($this -> Info("upload_frame") == NULL)  //如果为空自动修复							 
			{
				if($this -> UploadFrameFix() == 'null') 
				{
					die("参数读取发生错误，请与管理员联系");
				}
						
			} else {
				
				$pieces = explode("|", $this ->Info("upload_frame"));
				foreach($pieces as $val)
				{
					if($val == NULL)
					{
						break;
					}
						$IndexData = explode(";", $val);
						$uploadData[] = array ($IndexData[0],$IndexData[1],$IndexData[2]);
				}
			
			}
			return $uploadData;
		}

		/* ---------------------------------------------------- */
				
		// 上传框架处理
		/* ---------------------------------------------------- */
		function UploadFrameServicing($method,$data) 
		{
			$ReturnData = $this -> UploadFrame();
			switch($method)
			{
				case 'add':
					$SystemUploadFrame = $this ->Info("upload_frame");
					$sql = "update zd_system_setting set value = '".$SystemUploadFrame.$data."' where vars = 'upload_frame';";
					break;
				
				case 'edit':
					$pieces = explode(";", $data);
					$EditData = str_replace($pieces[0],$ReturnData[$pieces[0]][0],$data); //第一次替换，将数值替换成框架名
					$pieces1 = explode(";", $EditData); //分割替换后的数据
					$ReturnData[$pieces[0]] = array($pieces1[0],$pieces1[1],$pieces1[2]); //写入替换数组
					$SystemUploadFrame = "";
					foreach($ReturnData as $val)  //输出成命令行形式
					{
	
						if(strpos($val[2], "|") === false) //确保单个框架结尾都有分隔符号
						{
							$val[2] = $val[2]."|";
						}
						
						$SystemUploadFrame.= $val[0].";".$val[1].";".$val[2];
					}
					$sql = "update zd_system_setting set value = '".$SystemUploadFrame."' where vars = 'upload_frame';";	
					break;
					
				case 'del':
					$SystemUploadFrame = "";
					unset($ReturnData[$data]);
					foreach ($ReturnData as $value)
					{
	
						$SystemUploadFrame.= $value[0].";".$value[1].";".$value[2]."|";

					}
					$sql = "update zd_system_setting set value = '".$SystemUploadFrame."' where vars = 'upload_frame';";
					break;
					
			}
			
			if(!$this->query($sql))
			{
				return 'failed';
				
			} else {
				
				echo '<script language="JavaScript">window.alert("操作成功！")</script>';
			}
			
		}

		/* ---------------------------------------------------- */
			
		// 模块安装与卸载
		/* ---------------------------------------------------- */
		function ModuleInstall($path) 
		{
			if(!file_exists('../../' . $path . '/install.xml')) 						 
			{

				return "Install Failed！The File Was Not Module.";
						
			} else { //解析install.xhr
				//初始化安装文件中的所有值
				$database = iconv("gb2312","utf-8", file_get_contents('../../' . $path . '/data.sql'));
    			$xml_array = simplexml_load_string(file_get_contents('../../' . $path . '/install.xml')); //将XML中的数据,读取到数组对象中
				//初始化结束，开始处理
				if($database != NULL)  //判断是否读入数据库
				{
					if($xml_array -> Type == 1) //
					{
						$InstallTable = $this -> Info("system_table");
						$InstallSqlData = str_replace("\$InstallSystemTable$",$InstallTable,$database);
						if($xml_array -> Index == 1) //是否存在前台模块
						{
							$InstallIndex = $this -> Info("index_page_all");
							if($InstallIndex != NULL)
							{
								$InstallIndexCount = sizeof(explode("|",$InstallIndex));
							}
							$InstallIndexCount = isset($InstallIndexCount)?$InstallIndexCount:1;
							$InstallSqlData = str_replace("\$InstallSystemIndex$",$InstallIndex,$InstallSqlData);
							$InstallSqlData = str_replace("\$InstallSystemIndexCount$",$InstallIndexCount,$InstallSqlData);
							
						}
						$InstallData = explode(";\r\n",$InstallSqlData);
						foreach ($InstallData as $value) 
						{
							$this -> query($value);
						}
					}
				}
				//数据库安装结束
				//处理文件操作
				include_once('FileUtil.Class.php');
				$FileControl = new FileUtil();
				$FileRootPath = str_replace('\\','/',realpath(dirname(__FILE__).'/../'));
				if($xml_array -> IndexFile != NULL && $xml_array -> Index == 1) //是否存在前台模块文件
				{
					$InstallFile = explode(";",$xml_array -> IndexFile);
					foreach ($InstallFile as $value) 
					{
						$FileControl -> copyDir($FileRootPath . '/' . $path . '/' . $value , $FileRootPath . '/' . $value );
					}
				}
				if($xml_array -> KernlFile != NULL) //是否存在Kernl核心文件
				{
					$InstallFile = explode(";",$xml_array -> KernlFile);
					foreach ($InstallFile as $value) 
					{
						$FileControl -> copyDir($FileRootPath . '/' . $path . '/' . $value , $FileRootPath . '/kernl/' . $value );
					}
				}
				if($xml_array -> ManagerFile != NULL) //是否存在后台管理文件
				{
					$InstallFile = explode(";",$xml_array -> ManagerFile);
					foreach ($InstallFile as $value) 
					{
						$FileControl -> copyDir($FileRootPath . '/' . $path . '/' . $value , $FileRootPath . '/admin/' . $value );
					}
				}
				rename($FileRootPath . '/' . $path . '/' .  'install.xml', $FileRootPath . '/' . $path . '/' . "uninstall.xml"); //执行重命名，将文件修改为卸载
				$FileControl -> createFile($FileRootPath . '/' . $path . '/' . $value . 'Init.Lock');   //创建安装锁
			return "Install Success!";
			}
		}	
		
		function ModuleUninstall($name)
		{
			
		}	
		/* ---------------------------------------------------- */
	
			
		//WebSite Safe Check System(wscs 网站安全检查系统)
		/* ---------------------------------------------------- */	
	
		function WSCS_Check( ) 
		{
			// 密码字符集，可任意添加你需要的字符
    		$CurrentAddr = HttpsCheck().$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
			foreach ($_GET as $key => $value) 
			{
				$check = array('"', '>', '<', '\'', '(', ')', '%27','‘','%E2%80%98');
				if (!empty($value) && !json_decode($value)) 
				{
					$value = strtoupper($value);
					foreach ($check as $_str) 
					{
						if (strpos($value, $_str) !== false) 
						{
							$this -> WriteLog('Get','请求存在违禁内容<br />'.'请求内容：' . $value ,$CurrentAddr);     
							echo $this -> Sys_ErrorPage (701);
							exit;
						}	
					}
				
				} else {
				
					foreach ($check as $_str) 
					{
						if (strpos($CurrentAddr, $_str) !== false) 
						{
							$this -> WriteLog('Get','请求存在违禁内容<br />'.'请求内容：' . $CurrentAddr ,$CurrentAddr);    
							echo $this -> Sys_ErrorPage (701);
							exit;
						}
					}
				}
			}
		}
		/* ---------------------------------------------------- */
		
			
		//取特定部分内容
		/* ---------------------------------------------------- */	
		function getSubstr($str, $leftStr, $rightStr)
		{
    		$left = strpos($str, $leftStr);
    		//echo '左边:'.$left;
    		$right = strpos($str, $rightStr,$left);
    		//echo '<br>右边:'.$right;
    		if($left < 0 or $right < $left) 
			{
				return '';
			}
    		return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
		}
		/* ---------------------------------------------------- */	
				
			
		//更新软件Logo
		/* ---------------------------------------------------- */	
		function UpdateSoftwareLogo($data)
		{
			if($data != NULL ) 
			{
				$sql = "update zd_config set `softwarelogo`='" . $data . "'";
				if(!$this->query($sql))
				{
					echo $sql;
					echo 'error,' . $this->SystemError() ;
				}
			} 
		}
		/* ---------------------------------------------------- */	
						
			
		//列出目录中的目录和文件
		/* ---------------------------------------------------- */	
		function getFileList3($directory) 
		{        
			$files = array();        
			try {        
				$dir = new DirectoryIterator($directory);        
				} catch (Exception $e) {        
					throw new Exception($directory . ' is not readable');        
				}        
			foreach($dir as $file) 
			{        
				if($file->isDot()) continue;
				if($file->isDir()) continue;			
				$files[] = $file->getFileName();        
			}        
			return $files;        
		}       
		/* ---------------------------------------------------- */							
			
		//生成随机字符串
		/* ---------------------------------------------------- */	
		function random_strings( $length_of_string ) 
		{        
			$str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' ;
			return substr ( str_shuffle ( $str_result ), 0, $length_of_string );	    
		}       
		/* ---------------------------------------------------- */	
					
		//处理软件LOGO图片数据
		/* ---------------------------------------------------- */	
		function UpdateSoftwareLogoData($datatype , $data , $sid ) 
		{        
			if($sid != NULL && $datatype != NULL) 
			{
				if($datatype == 'local')
				{
						$random = $this -> random_strings(5);
						if($data != NULL)
						{
							$sql = "insert into `zd_imgdata` (`type`,`data`,`querycode`,`softwareid`) values ('0','".$data ."','".$random."','".floatval($sid)."')";
							if(!$this->query($sql))
							{
								echo $sql;
								echo 'error,' . $this->SystemError() ;
							}
							$sql = "UPDATE `zd_software` SET `logotype`='0' , `logodata`='".$random."' WHERE id = '".$sid."'";
							if(!$this->query($sql))
							{
								echo $sql;
								echo 'error,' . $this->SystemError() ;
							}
							
						} else {
							$sql = "UPDATE `zd_software` SET `logotype`='0' , `logodata`='' WHERE id = '".$sid."'";
							if(!$this->query($sql))
							{
								echo $sql;
								echo 'error,' . $this->SystemError() ;
							}
							echo '<script>alert("已切换至本地源");</script>';
						}	
				} else {
						$sql = "UPDATE `zd_software` SET `logotype`='1' , `logodata`='".$data."' WHERE id = '".$sid."'";
						if(!$this->query($sql))
						{
							echo $sql;
							echo 'error,' . $this->SystemError() ;
						} 
						$this -> DelSoftwareLogoData(1,'' , $sid );
						echo '<script>alert("操作成功！");</script>';
				}
				
			}     
		} 
		
		function DelSoftwareLogoData($type , $code , $sid ) 
		{        

			if($type != NULL && $sid != NULL) 
			{
				if($type == 0)  //特定
				{
					$sql = "DELETE FROM `zd_imgdata` WHERE (`softwareid`='".floatval($sid)."' AND `querycode`='".$code."')";
					echo $sql;
					if(!$this->query($sql))
					{
						echo $sql;
						echo 'error,' . $this->SystemError() ;
					}
				
					$sql = "UPDATE `zd_software` SET `logotype`=NULL , `logodata`=NULL WHERE id = '".$sid."'";
					if(!$this->query($sql))
					{
						echo $sql;
						echo 'error,' . $this->SystemError() ;
					}
					
				} else {
				
					$sql = "DELETE FROM `zd_imgdata` WHERE (`softwareid`='".floatval($sid)."' AND `type`='0')";
					if(!$this->query($sql))
					{
						echo $sql;
						echo 'error,' . $this->SystemError() ;
					}
				
				}
			}     
		} 
		
		/* ---------------------------------------------------- */	
							
		//处理软件图片数据
		/* ---------------------------------------------------- */	
		function UpdateSoftwareImgData($datatype , $data , $sid ) 
		{        
			if($sid != NULL && $datatype != NULL) 
			{
				if($datatype == 'local')
				{
						$random = $this -> random_strings(5);
						if($data != NULL)
						{
							$sql = "insert into `zd_imgdata` (`type`,`data`,`querycode`,`softwareid`) values ('1','".$data ."','".$random."','".floatval($sid)."')";
							if(!$this->query($sql))
							{
								echo $sql;
								echo 'error,' . $this->SystemError() ;
							}
							$query = $this -> select('zd_software', 'runpic' ,'id = '.floatval($sid) );
							$row = $this -> fetch_array($query);
							$outside =  explode(',', $row['runpic']);
							if($outside != NULL)
							{
								foreach ($outside as $x) 
								{
									if($imglistdata != NULL)
									{
										$imglistdata = $imglistdata . ','.$x;
									} else {
										$imglistdata = $x;
									}
								} 
							} 
							$imglistdata = $imglistdata .','.$random;
							$sql = "UPDATE `zd_software` SET `runpictype`='0' , `runpic`='".$imglistdata."' WHERE id = '".$sid."'";
							if(!$this->query($sql))
							{
								echo $sql;
								echo 'error,' . $this->SystemError() ;
							}
							
						} else {
							$sql = "UPDATE `zd_software` SET `runpictype`='0' , `runpic`='' WHERE id = '".$sid."'";
							if(!$this->query($sql))
							{
								echo $sql;
								echo 'error,' . $this->SystemError() ;
							}
							echo '<script>alert("已切换至本地源");</script>';
						}	
				} else {
						$query = $this -> select('zd_software', 'runpic,runpictype' ,'id = '.floatval($sid) );
						$row = $this -> fetch_array($query);
						if($row['runpic'] != NULL)
						{
							$data =  $row['runpic'] . ',' . $data;
						} 
						$sql = "UPDATE `zd_software` SET `runpictype`='1' , `runpic`='".$data."' WHERE id = '".$sid."'";
						if(!$this->query($sql))
						{
							echo $sql;
							echo 'error,' . $this->SystemError() ;
						} 
						$this -> DelSoftwareImgData(1,'' , $sid );
						echo '<script>alert("操作成功！");</script>';
				}
				
			}     
		} 
		
		function DelSoftwareImgData($type , $code , $sid ) 
		{        

			if($type != NULL && $sid != NULL) 
			{
				switch($type)
				{
					case 1:
						$sql = "DELETE FROM `zd_imgdata` WHERE (`softwareid`='".floatval($sid)."' AND `querycode`='".$code."')";
						if(!$this->query($sql))
						{
							echo $sql;
							echo 'error,' . $this->SystemError() ;
						}
						$query = $this -> select('zd_software', 'runpic' ,'id = '.floatval($sid) );
						$row = $this -> fetch_array($query);
						$outside =  explode(',', $row['runpic']);
						if($outside != NULL)
						{
							foreach ($outside as $x) 
							{
								if($x != $code)
								{
									if($imglistdata != NULL)
									{
										$imglistdata = $imglistdata . ','.$x;
									} else {
										$imglistdata = $x;
									}
								} 
							} 
						} 				
						$sql = "UPDATE `zd_software` SET `runpictype`='0' , `runpic`='".$imglistdata."' WHERE id = '".$sid."'";
						if(!$this->query($sql))
						{
							echo $sql;
							echo 'error,' . $this->SystemError() ;
						}
						break;
					
					case 2:
						$query = $this -> select('zd_software', 'runpic' ,'id = '.floatval($sid) );
						$row = $this -> fetch_array($query);
						$outside =  explode(',', $row['runpic']);
						unset($outside [$code - 1]);
						if($outside != NULL)
						{
							foreach ($outside as $x) 
							{
								if($imglistdata != NULL)
								{
									$imglistdata = $imglistdata . ','.$x;
								} else {
									$imglistdata = $x;
								}
							} 
						} 
						$sql = "UPDATE `zd_software` SET `runpictype`='1' , `runpic`='".$imglistdata."' WHERE id = '".$sid."'";
						if(!$this->query($sql))
						{
							echo $sql;
							echo 'error,' . $this->SystemError() ;
						}
						break;
				}
			}     
		} 
		
		/* ---------------------------------------------------- */	
									
		//Get IP
		/* ---------------------------------------------------- */	
		function Get_IPData($ipdata)
		{
			if($ipdata != NULL)
			{
				$pattern = '/((2(5[0-5]|[0-4]\d))|[0-1]?\d{1,2})(\.((2(5[0-5]|[0-4]\d))|[0-1]?\d{1,2})){3}/'  ;
				if(!preg_match($pattern, $ipdata))
				{
					echo '不是一个有效的ip地址！';
					exit;
				}
				$IPQuery = new IPQueryEngine("../kernl/ipdata.dat");
				$detail = $IPQuery -> getDetail($ipdata); // 调用查询函数
				//print_r($detail);
				return $detail[dataA].$detail[dataB];// 输出查询结果
			}
		}
		
		/* ---------------------------------------------------- */	
									
		//Loading Bing Background 
		/* ---------------------------------------------------- */	
		function LoadingBingBackground()
		{
			$path = "../images/bing/" . date("Ym");
			if (!file_exists($path)) 
			{
				mkdir($path, 0777);
			}
			$pathurl = $path."/".date("d").".jpg";
			if (!is_file($pathurl)) 
			{
				$str=file_get_contents("https://cn.bing.com/HPImageArchive.aspx?idx=0&n=1");
				if (preg_match("/<urlBase>(.+?)<\/urlBase>/ies", $str, $matches)) 
				{
					$imgurl="https://cn.bing.com".$matches[1]."_1920x1080.jpg";
					copy($imgurl, $pathurl);
				}
			}
			
			return '<style>body.login{ background:url(' . $pathurl . ');}</style>';
		}
		
		/* ---------------------------------------------------- */	
									
		//处理下载数更新
		/* ---------------------------------------------------- */	
		function UpdateSoftwareDownloadCount($sid) 
		{  
			$query = $this -> select('zd_software', 'downloadcount' ,'id = '.floatval($sid) );
			$row = $this -> fetch_array($query); 
			if(floatval($row['downloadcount']) == NULL || floatval($row['downloadcount']) == 0)
			{
				$count = 0 + 1;
				
			} else {
			
				$count = floatval($row['downloadcount']) + 1;
			}
			$sql = "UPDATE `zd_software` SET `downloadcount`='" . $count . "'  WHERE id = '".$sid."'";
			if(!$this->query($sql))
			{
				echo $sql;
				echo 'error,' . $this->SystemError() ;
				
			} else {
			
				echo '<script>alert("操作成功！");</script>';
			} 
			
		}  
		/* ---------------------------------------------------- */	
									
		//获取指定位置内容
		/* ---------------------------------------------------- */	

		function strip_comments($start,$end,$input) 
		{ 
			$substr = substr($input, strlen($start)+strpos($input, $start)-1,(strlen($input) - strpos($input, $end))*(-1));
			return $substr;
		}		
}		
?>

