<?php
require("../../kernl/Init.php"); 
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器

//判断是否在框架内，防止跨域
$dou -> FormCheck('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);


//初始化接口列表
$select = '<select name="attrib" id="attrib" Class="form-control" onchange="SelectEdit();" >';
$UData = $dou -> UploadFrame();
$x=0;
foreach ($UData as $value)
{
	
	$select.='<option value='.$x.'>'.$value[0].'('.$value[1].')</option>';
	$x++;
	
}
$select.='</select>';

//传递参数到js
$UFData = json_encode($UData);
echo '<script> var data= '.$UFData.';</script>';

//请求方式处理
switch($_GET['m']) 
{	
	case 'add':
		$buttom = '新增';
		$Title = '新增上传参数';
		$UData = '';
	break;
	
	case 'edit':
		$buttom = '修改';	
		$Title = '修改上传参数设置';
	break;
	
	case 'del':
		$buttom = '删除';
		$Title = '删除上传参数';
	break;		
			
	default: 
		echo '<script language="JavaScript">window.alert("无效的参数请求")</script>';
		exit;
	break;
} 

if($_SERVER["REQUEST_METHOD"] == "POST") 
{
	switch($_GET['m']) {	
	case 'add':
		$data = $_POST['path_address'] . ';' . 	$_POST['musicname'] .  ';' . $_POST['singername'] .  '|';
		if($dou -> UploadFrameServicing('add',$data) != 'failed')
		{
			echo '<script language="JavaScript">parent.location.reload()</script>';
		}
		break;
	
	case 'edit':
		$data = $_POST['attrib'] . ';' . 	$_POST['musicname'] .  ';' . $_POST['singername'] .  '|';
		if($dou -> UploadFrameServicing('edit',$data) != 'failed')
		{
			echo '<script language="JavaScript">parent.location.reload()</script>';
		}		
		break;
	
	case 'del':
		if($dou -> UploadFrameServicing('del',$_POST['attrib']) != 'failed')
		{
			echo '<script language="JavaScript">parent.location.reload()</script>';
		}	
		break;		
	} 
}

//生成页面代码
$content = "<div class=\"box-content\">
   			<form id=\"contact\" action=\"\" method=\"post\" >  
    		<h4 class=\"box-title\">".$Title."</h4>
			<div class=\"form-group\">
    		<label for=\"sitename\">上传接口名</label>
			".$select."
        	<input name=\"path_address\" class=\"form-control\" type=\"text\" placeholder=\"上传接口名\" tabindex=\"1\" />
			</div>  
    		<div class=\"form-group\" name=\"name\">
			<label for=\"sitename\">支持后缀名</label>
      		<input name=\"musicname\" class=\"form-control\" type=\"text\" required=\"required\" id=\"music\" placeholder=\"支持后缀名，格式为.xxx，多个用、分割\" tabindex=\"2\" value=".$UData[0][1].">
			</div>
    		<div class=\"form-group\" name=\"path\">
			<label for=\"sitename\">存储路径</label>
      		<input name=\"singername\" class=\"form-control\" type=\"text\" id=\"singer\" placeholder=\"存储路径\" tabindex=\"3\" value=".$UData[0][2].">
    		</div>
  			<div class=\"form-group\">
      		<button name=\"submit\" type=\"submit\" id=\"contact-submit\" data-submit=\"...Sending\" Class=\"btn btn-primary btn-sm waves-effect waves-light\" value=\"".$buttom."\">".$buttom."</button>
    		</div>
  			</form>
			</div>";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!-- Main Styles -->
	<link rel="stylesheet" href="../assets/styles/style.min.css">
	
	<!-- Material Design Icon -->
	<link rel="stylesheet" href="../assets/fonts/material-design/css/materialdesignicons.css">

	<!-- mCustomScrollbar -->
	<link rel="stylesheet" href="../assets/plugin/mCustomScrollbar/jquery.mCustomScrollbar.min.css">

	<!-- Waves Effect -->
	<link rel="stylesheet" href="../assets/plugin/waves/waves.min.css">

	<!-- Sweet Alert -->
	<link rel="stylesheet" href="../assets/plugin/sweet-alert/sweetalert.css">
	
	<!-- Jquery UI -->
	<link rel="stylesheet" href="../assets/plugin/jquery-ui/jquery-ui.min.css">
	<link rel="stylesheet" href="../assets/plugin/jquery-ui/jquery-ui.structure.min.css">
	<link rel="stylesheet" href="../assets/plugin/jquery-ui/jquery-ui.theme.min.css">

	<!-- Dark Themes -->
	<link rel="stylesheet" href="../assets/styles/style-dark.min.css">
</head>
<script>
function SelectEdit() 
{
	 var rtl = document.getElementById("attrib").value; 
	 document.getElementsByName("musicname")[0].value = data[rtl][1];
	 document.getElementsByName("singername")[0].value = data[rtl][2];

}
	
var $_GET = (function(){
    var url = window.document.location.href.toString();
    var u = url.split("?");
    if(typeof(u[1]) == "string"){
        u = u[1].split("&");
        var get = {};
        for(var i in u){
            var j = u[i].split("=");
            get[j[0]] = j[1];
        }
        return get;
    } else {
        return {};
    }
})();	
</script>	
<body>
<?php echo $content; ?>
<script>
//界面显示方式处理	
if ($_GET['m'] == 'edit')
{
	document.getElementsByName("path_address")[0].style.display = "none";
	
}	else if ($_GET['m'] == 'del') 
	
{
	document.getElementsByName("path_address")[0].style.display = "none";
	document.getElementsByTagName("fieldset")[1].style = 'display:none';
	document.getElementsByTagName("fieldset")[2].style = 'display:none';
	
} 	else 
{
	document.getElementById("attrib").style.display = "none";
}
</script>
</body>
</html>