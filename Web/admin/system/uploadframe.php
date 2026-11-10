<?php
/* ---------------------------------------------------- */
/* 上传框架（上传接口名 / 后缀 / 存储路径）管理
/* 安全修订说明（2026）：
/*  1. 新增/编辑的三个字段做格式校验（接口名只允许字母数字下划线，
/*     路径只允许图片/文件目录形式），并统一 quote() 入库
/*  2. 页面回显全部 h() 转义，消除反射型 XSS
/*  3. 未登录直接中断，不再仅发 Location 头继续执行
/* ---------------------------------------------------- */
require("../../kernl/Init.php");

if (!defined('source')) {
    header("Location: ../login.php");
    exit;
}

$dou->FormCheck();
$dou->WSCS_Check();

if ($dou->AccountState() === 'Access denied') {
    header("Location: ../login.php");
    exit;
}

// 初始化接口列表
$select = '<select name="attrib" id="attrib" Class="form-control" onchange="SelectEdit();" >';
$UData  = $dou->UploadFrame();
$x = 0;
foreach ($UData as $value) {
    $select .= '<option value="' . $x . '">' . h($value[0] . '(' . str_replace('*', '、', $value[1]) . ')') . '</option>';
    $x++;
}
$select .= '</select>';

// 传递参数到 js（json 编码后仍防止 </script> 闭合）
$UFData = json_encode($UData, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
echo '<script> var data = ' . $UFData . ';</script>';

$mode = isset($_GET['m']) ? (string)$_GET['m'] : '';
switch ($mode) {
    case 'add':
        $buttom = '新增';
        $Title  = '新增上传参数';
        $UDataRow = array('', '', '');
        break;

    case 'edit':
        $buttom = '修改';
        $Title  = '修改上传参数设置';
        $UDataRow = array('', '', '');
        break;

    case 'del':
        $buttom = '删除';
        $Title  = '删除上传参数';
        $UDataRow = array('', '', '');
        break;

    default:
        echo '<script language="JavaScript">window.alert("无效的参数请求")</script>';
        exit;
}

if (isset($_GET['i']) && is_numeric($_GET['i'])) {
    $i = (int)$_GET['i'];
    if (isset($UData[$i])) {
        $UDataRow = $UData[$i];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['path_address']) ? trim((string)$_POST['path_address']) : '';
    $ext  = isset($_POST['musicname']) ? trim((string)$_POST['musicname']) : '';
    $path = isset($_POST['singername']) ? trim((string)$_POST['singername']) : '';
    $attrib = isset($_POST['attrib']) ? (string)$_POST['attrib'] : '';

    switch ($mode) {
        case 'add':
            if (!preg_match('/^[A-Za-z0-9_]{1,32}$/', $name)) {
                echo '<script language="JavaScript">window.alert("上传接口名只允许字母、数字与下划线")</script>';
                break;
            }
            if (!preg_match('/^[A-Za-z0-9、\.]{1,60}$/u', $ext)) {
                echo '<script language="JavaScript">window.alert("支持后缀名格式不正确")</script>';
                break;
            }
            if (!preg_match('#^\.\./\.\./[A-Za-z0-9_\-/]{1,60}/?$#', $path)) {
                echo '<script language="JavaScript">window.alert("存储路径必须为 ../../目录/ 形式")</script>';
                break;
            }
            $data = $name . ';' . $ext . ';' . $path . '|';
            if ($dou->UploadFrameServicing('add', $data) != 'failed') {
                echo '<script language="JavaScript">parent.location.reload()</script>';
            }
            break;

        case 'edit':
            if (!preg_match('/^\d{1,3}$/', $attrib)) {
                echo '<script language="JavaScript">window.alert("无效的接口编号")</script>';
                break;
            }
            if (!preg_match('/^[A-Za-z0-9、\.]{1,60}$/u', $ext) || !preg_match('#^\.\./\.\./[A-Za-z0-9_\-/]{1,60}/?$#', $path)) {
                echo '<script language="JavaScript">window.alert("参数格式不正确")</script>';
                break;
            }
            $data = (int)$attrib . ';' . $ext . ';' . $path . '|';
            if ($dou->UploadFrameServicing('edit', $data) != 'failed') {
                echo '<script language="JavaScript">parent.location.reload()</script>';
            }
            break;

        case 'del':
            if (!preg_match('/^\d{1,3}$/', $attrib)) {
                echo '<script language="JavaScript">window.alert("无效的接口编号")</script>';
                break;
            }
            if ($dou->UploadFrameServicing('del', $attrib) != 'failed') {
                echo '<script language="JavaScript">parent.location.reload()</script>';
            }
            break;
    }
}

// 生成页面代码
$content = "<div class=\"box-content\">
   			<form id=\"contact\" action=\"\" method=\"post\" >
    		<h4 class=\"box-title\">" . h($Title) . "</h4>
			<div class=\"form-group\">
    		<label for=\"sitename\">上传接口名</label>
			" . $select . "
        	<input name=\"path_address\" class=\"form-control\" type=\"text\" placeholder=\"上传接口名\" tabindex=\"1\" />
			</div>
    		<div class=\"form-group\" name=\"name\">
			<label for=\"sitename\">支持后缀名</label>
      		<input name=\"musicname\" class=\"form-control\" type=\"text\" required=\"required\" id=\"music\" placeholder=\"支持后缀名，格式为.xxx，多个用、分割\" tabindex=\"2\" value=\"" . h(isset($UDataRow[1]) ? $UDataRow[1] : '') . "\">
			</div>
    		<div class=\"form-group\" name=\"path\">
			<label for=\"sitename\">存储路径</label>
      		<input name=\"singername\" class=\"form-control\" type=\"text\" id=\"singer\" placeholder=\"存储路径\" tabindex=\"3\" value=\"" . h(isset($UDataRow[2]) ? $UDataRow[2] : '') . "\">
    		</div>
  			<div class=\"form-group\">
      		<button name=\"submit\" type=\"submit\" id=\"contact-submit\" data-submit=\"...Sending\" Class=\"btn btn-primary btn-sm waves-effect waves-light\" value=\"" . h($buttom) . "\">" . h($buttom) . "</button>
    		</div>
  			</form>
			</div>";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="../assets/styles/style.min.css">
	<link rel="stylesheet" href="../assets/fonts/material-design/css/materialdesignicons.css">
	<link rel="stylesheet" href="../assets/plugin/mCustomScrollbar/jquery.mCustomScrollbar.min.css">
	<link rel="stylesheet" href="../assets/plugin/waves/waves.min.css">
	<link rel="stylesheet" href="../assets/plugin/sweet-alert/sweetalert.css">
	<link rel="stylesheet" href="../assets/plugin/jquery-ui/jquery-ui.min.css">
	<link rel="stylesheet" href="../assets/plugin/jquery-ui/jquery-ui.structure.min.css">
	<link rel="stylesheet" href="../assets/plugin/jquery-ui/jquery-ui.theme.min.css">
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
	document.getElementsByName("musicname")[0].style.display = "none";
	document.getElementsByName("singername")[0].style.display = "none";
} 	else
{
	document.getElementById("attrib").style.display = "none";
}
</script>
</body>
</html>
