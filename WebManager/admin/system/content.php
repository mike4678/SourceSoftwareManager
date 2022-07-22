<?php 
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器

$FilePath = str_replace('\\','/',__FILE__)?str_replace('\\','/',__FILE__):$_SERVER['SCRIPT_FILENAME'];

if($dou -> content($addr[2],'list_name') == 'error')
{
	echo $dou -> Admin_ErrorPage ( $addr[1] , $addr[2] , $FilePath) ;   //如果不存在则跳转到错误界面
	exit;
	
} else {
	
	$table_name = $dou->content($addr[2],'list_name');
	$table = $dou->content($addr[2],'table');
	
}

//处理页码
$PageNum = $dou->AddrConvery($_GET);
if(strstr($PageNum[3], 'id') != "" || is_numeric($PageNum[3]))
{
	$PageCount = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?/'.$PageNum[1].'/'.$PageNum[2];
	} else { 
	$PageCount = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	}

//页码处理完成
switch ($_SERVER['REQUEST_METHOD'])  //获取操作方式
{
	case 'GET':
	
	//判断数组第三个中是否带有id字样，如果没有则判断为页数
	if(count($PageNum) > 3) 
	{
		if(strstr($PageNum[count($addr) - 1], 'id') != "") //如果带有id字样
		{
			$dou->DelData($table_name,'id',str_replace('id','',$PageNum[count($addr) - 1]),'GET');
		}
	} else {
			if(strstr($PageNum[3], 'id') != "") //如果带有id字样
			{
			$dou->DelData($table_name,'id',str_replace('id','',$PageNum[3]),'GET');
			}
		}
		break;

	case 'POST':
	$ID_Dele = implode("','",$_POST['id']);  
	$dou->DelData($table_name,'id',$ID_Dele,'POST'); 
	break;	
}
?>

<script>
<?php echo $dou->content($addr[2],'script'); ?>	
</script>
<form method="post" action="#">
    <div class="panel admin-panel">
    	<?php print($dou->content($addr[2],'table_head')) ; 
$Page_size = $dou->Info('pagedisplay'); 

$result = $dou->query('select * from '. $table_name ); 
$count = $dou->num_rows($result); 
if($count < 1){  //如果获取到的数据小于1，则表示没有数据
	echo '<tr><td>&nbsp;</td><td>&nbsp;&nbsp;没有更多的数据了</td></tr>'; } 
	else {			
$page_count = ceil($count/$Page_size); 

$init = 1; 
$page_len = 7; 
$max_p = $page_count; 
$pages = $page_count; 

//判断当前页码 
if( empty( $addr[3] ) || $addr[3] < 0 ){ 
$page = 1; 
	}else { 
$page = $addr[3]; 
} 

$offset = $Page_size * ( $page - 1 ); 
$sql = "select * from $table_name limit $offset,$Page_size"; 
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
$key='<ul class="pagination">';  
if($page!=1){ 
$key.="<li><a href=\"".$PageCount."/".($page-1)."\">上一页</a></li></ul>"; 
$key.=' <ul class="pagination pagination-group">';//上一页 
}else { 
//$key.="第一页 ";//第一页 
$key.='<ul class="pagination"><li><a>上一页</a></li></ul>'; //上一页 
} 
if($pages>$page_len){ 
//如果当前页小于等于左偏移 
if($page<=$pageoffset){ 
$init=1; 
$max_p = $page_len; 
}else{//如果当前页大于左偏移 
//如果当前页码右偏移超出最大分页数 
if($page+$pageoffset>=$pages+1){ 
$init = $pages-$page_len+1; 
}else{ 
//左右偏移都存在时的计算 
$init = $page-$pageoffset; 
$max_p = $page+$pageoffset; 
} 
} 
} 
for($i=$init;$i<=$max_p;$i++){ 
if($i==$page){ 
$key.=' <li class="active"><a>'.$i.'</a></li>';  
} else { 
$key.="<li><a href=\"".$PageCount."/".$i."\">".$i."</a></li>"; 
} 
} 
if($page!=$pages){ 
$key.='</ul><ul class="pagination">'; 
$key.="&nbsp;<li><a href=\"".$PageCount."/".($page+1)."\">下一页</a></li>";//下一页 
}else { 
$key.='</ul><ul class="pagination">&nbsp;<li><a>下一页 </a></li></ul>';//下一页  
} 
$key.='</div>'; }
?>
        </table>
        <div class="panel-foot text-center">
            <?php echo $key; ?>
        </div>
    </div>
    </form>
</div>
