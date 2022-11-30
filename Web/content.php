<?php
if($_COOKIE["setclient"] == 'android')
{
	$table = "<tr><td class=\"mailbox-subject\"><span class=\"mailbox-subject-title\" >{softname}(版本号:{version} 大小:{size} KB)</span><br><br>简介：{synopsis}</td><td>{updatetime^&data}</td><td style=\"text-align:center\"><a class='ico-item mdi mdi-download' href='d.php?pid={id}')>下载</a></td></tr>";
} else {
	$table = "<tr><td class=\"mailbox-subject\"><span class=\"mailbox-subject-title\" >{softname}</span><br><br>简介：{synopsis}</td><td style=\"text-align:center\">{version}</td><td style=\"text-align:center\">{size} KB</td><td>{updatetime^&data}</td><td style=\"text-align:center\"><a class='ico-item mdi mdi-download' href='d.php?pid={id}')>下载</a></td></tr>";
}

//处理页码
$PageNum = $dou->AddrConvery( $_GET );
if ( strstr( $PageNum[ 3 ], 'id' ) != "" || is_numeric( $PageNum[ 3 ] ) ) {
	$PageCount = "http://" . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'PHP_SELF' ] . '?/' . $PageNum[ 1 ] . '/' . $PageNum[ 2 ];
} else {
	$PageCount = "http://" . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'PHP_SELF' ] . '?' . $_SERVER[ 'QUERY_STRING' ];
}

?>
<form method="POST" action="#">
	<div class="row">
	<div class="box"><div class="box-header with-border"><h3 class="box-title">软件下载</h3><div class="box-tools"><div class="has-feedback"><input type="text" class="form-control input-sm" name='search'><span class="fa fa-search form-control-feedback"></span></div></div></div>
          <div class="box-body no-padding"><div class="mailbox-controls">
                <button type="button" class="btn btn-default btn-sm waves-effect waves-light" title="刷新" onclick="location.reload();"><i class="fa fa-refresh"></i></button>
        </div>
        <div class="table-responsive mailbox-messages">
        <table class="table table-hover table-striped">
		<?php
		if($_COOKIE["setclient"] == 'android')
		{
			echo '<thead><tr><th style="text-align:center">软件名</th><th style="text-align:center">更新时间</th><th>操作</th></tr></thead>';
		} else {
			echo '<thead><tr><th style="text-align:center">软件名</th><th style="text-align:center">版本</th><th style="text-align:center">容量</th><th style="text-align:center">更新时间</th><th>操作</th></tr></thead>';
		} 
$Page_size = $dou->Info('pagedisplay'); 
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	if($_COOKIE["setclient"] == 'android')
	{
		$sql = 'select * from zd_software Where softname Like "%'.$_POST['search'].'%" AND softwaretype = "mobile"' ; 
	} else {
		$sql = 'select * from zd_software Where softname Like "%'.$_POST['search'].'%" AND softwaretype = "pc"' ; 
	}

}
if($_SERVER["REQUEST_METHOD"] == "GET")
{
	if( count($addr) > 1 && is_numeric($addr[1]) != True)
	{
		if($_COOKIE["setclient"] == 'android')
		{
			$sql = 'select * from zd_software Where type = \''.$addr[1].'\' AND softwaretype = "mobile"';  
		} else {
			$sql = 'select * from zd_software Where type = \''.$addr[1].'\' AND softwaretype = "pc"'; 
		}

	} else {

		if($_COOKIE["setclient"] == 'android')
		{
			$sql = 'select * from zd_software Where softwaretype = "mobile"';  
		} else {
			$sql = 'select * from zd_software Where softwaretype = "pc"'; 
		}
	}
}
//print_r($sql);
$result = $dou -> query($sql); 
$count = $dou -> num_rows($result); 
if($count < 1)
{  //如果获取到的数据小于1，则表示没有数据
	
	echo '<tr><td>&nbsp;</td><td>&nbsp;&nbsp;没有更多的数据了</td></tr>'; 
	
} else {	
	
	$page_count = ceil($count/$Page_size); 

	$init = 1; 
	$page_len = 7; 
	$max_p = $page_count; 
	$pages = $page_count; 

//判断当前页码 
	if( is_numeric($addr[1]) == True )
	{ 
		$page = $addr[1]; 
		
	}else { 
		
		if(is_numeric($addr[2]) == True )
		{
			$page = $addr[2]; 
		}
		$page = 1; 
	} 


	$offset = $Page_size * ( $page - 1 ); 
	$sql = $sql ." limit $offset,$Page_size";
	$result = $dou->query($sql); 
	while ($row = $dou->fetch_array($result)) 
	{ 
		//处理值的带入
		preg_match_all("|{(.*)}|U", $table, $out, PREG_PATTERN_ORDER); //寻找文本中的{}字段内容
		$tlist = 0;
		$data = array();
		$name = array();
		$value = $table;
		while ($tlist <= count($out[1]) - 1)  
		{
			if(substr_count($out[1][$tlist],"^&") > 0)
			{
				$data1 = explode('^&',$out[1][$tlist]);
				switch($data1[1])
				{
			
					case 'data':
						$value = str_ireplace("{".$out[1][$tlist]."}",date('Y-m-d H:i:s',$row[$data1[0]]),$value);
						break;
				
					case 'ipdata':
						$value = str_ireplace("{".$out[1][$tlist]."}",$row[$data1[0]]." ( ".$dou -> Get_IPData($row[$data1[0]])." )",$value);
						break;
			
				}

			} else {
				
				$name[] = "{".$out[1][$tlist]."}";
				$data[] = $row[$out[1][$tlist]];
				$value = str_ireplace("{".$out[1][$tlist]."}",$row[$out[1][$tlist]],$value);
		
			}
			
			$tlist = $tlist + 1;
		
		} 
		$value = str_ireplace('$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]',$_SERVER[PHP_SELF]."?".$_SERVER[QUERY_STRING],$value);
	
	//$value = preg_replace($name,$data,$table);
		echo $value;

	}	
	$page_len = ($page_len%2)?$page_len:$pagelen+1;//页码个数 
	$pageoffset = ($page_len-1)/2;//页码个数左右偏移量 
	$key = '<ul class="pagination">';  
	if( $page != 1)
	{ 
		
		$key.="<li><a href=\"".$PageCount."/".($page-1)."\">上一页</a></li>"; 
		
	}else { 
		//$key.="第一页 ";//第一页 
		$key.='<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">上一页</span></a></li>'; //上一页 
	} 
	if($pages>$page_len)
	{ 
		//如果当前页小于等于左偏移 
		if($page<=$pageoffset)
		{ 
			$init=1; 
			$max_p = $page_len; 
			
		} else {//如果当前页大于左偏移 
			//如果当前页码右偏移超出最大分页数 
			if($page+$pageoffset>=$pages+1)
			{ 
				
				$init = $pages-$page_len+1; 
				
			}else{ 
				//左右偏移都存在时的计算 
				$init = $page-$pageoffset; 
				$max_p = $page+$pageoffset; 
			} 
		} 
	} 
	for($i=$init;$i<=$max_p;$i++)
	{ 
		
		if($i==$page)
		{ 
			
			$key.=' <li class="active"><a>'.$i.'</a></li>';  
			
		} else { 
			
			$key.="<li><a href=\"".$PageCount."/".$i."\">".$i."</a></li>"; 
		} 
	} 
	if($page!=$pages)
	{ 
		
		$key.="<li><a href=\"".$PageCount."/".($page+1)."\">下一页 </span></a></li>";//下一页
		
	}else { 
		
		$key.='<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">下一页 </span></a></li>';//下一页  
	} 
	$key.='</ul>'; 
}
?>
		</table>
		<nav style="text-align:center;">
			<?php echo $key; ?>
		</nav>
	</div>
</form>
</div>