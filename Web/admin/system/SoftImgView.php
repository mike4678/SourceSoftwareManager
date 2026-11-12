<?php
/* ---------------------------------------------------- */
/* 软件 Logo / 运行截图 管理
/* 安全修订说明（2026）：
/*  1. 补齐所有未初始化变量（原代码在空分支下会输出 Undefined variable 警告）
/*  2. 查询 zd_imgdata 的 querycode 改为 quote() 转义
/*  3. 图片列表与表单回显统一 h()，并把注入 JS 字符串的部分改为 json_encode
/*  4. $_GET['m'] 只允许 imgview / logoview，未登录直接中断
/* ---------------------------------------------------- */
require("../../kernl/Init.php");

if (!defined('source')) {
    header("Location: ../login.php");
    exit;
}

$dou->FormCheck();
$dou->WSCS_Check();

if ($dou->AccountState() === 'Access denied') {
    $addr = $dou->AddrConvery($_GET);
    if (count($addr) > 0 && isset($addr[1]) && $addr[1] !== 'exit') {
        header("Location: ../login.php?ref=" . urlencode('/' . $addr[1] . '/' . (isset($addr[2]) ? $addr[2] : '')));
    } else {
        header("Location: ../login.php");
    }
    exit;
}

$mode   = isset($_GET['m']) ? (string)$_GET['m'] : '';
$softId = isset($_GET['id']) ? to_int($_GET['id'], 0) : 0;

$imglistdata = '';
$localsource = 'option value="1" selected';
$outsid      = 'option value="2"';
$outside     = '';
$imgMode     = '';
$type        = '';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!in_array($mode, array('imgview', 'logoview'), true) || $softId <= 0) {
        echo '<script language="JavaScript">window.alert("参数异常！0x0000000b4")</script>';
        exit;
    }

    if ($mode === 'imgview') {
        $type  = '运行截图';
        $query = $dou->select('zd_software', 'runpic,runpictype', 'id = ' . $softId);
        $row   = $dou->fetch_array($query);
        if (empty($row)) {
            echo '<script language="JavaScript">window.alert("参数异常！0x0000000b5")</script>无效的软件ID';
            exit;
        }
        $imgMode = isset($row['runpictype']) ? (string)$row['runpictype'] : '';

        if ($imgMode === '1') {   // 网络源
            if (!empty($row['runpic'])) {
                $count = 1;
                foreach (explode(',', (string)$row['runpic']) as $x) {
                    $imglistdata .= '<option value="' . $count . '">软件截图</option>';
                    $count++;
                }
                $localsource = 'option value="1"';
                $outsid      = 'option value="2" selected';
            } else {
                $localsource = 'option value="1"';
                $outsid      = 'option value="2" selected';
            }
        } elseif ($imgMode === '0') { // 本地源
            if (!empty($row['runpic'])) {
                foreach (explode(',', (string)$row['runpic']) as $x) {
                    $x = trim((string)$x);
                    if ($x !== '') {
                        $imglistdata .= '<option value="' . h($x) . '">软件截图</option>';
                    }
                }
                $localsource = 'option value="1" selected';
                $outsid      = 'option value="2"';
            } else {
                $localsource = 'option value="1" selected';
                $outsid      = 'option value="2"';
            }
        }
    }

    if ($mode === 'logoview') {
        $type  = 'Logo截图';
        $query = $dou->select('zd_software', 'logodata,logotype', 'id = ' . $softId);
        $row   = $dou->fetch_array($query);
        if (empty($row)) {
            echo '<script language="JavaScript">window.alert("参数异常！0x0000000b5")</script>无效的软件ID';
            exit;
        }
        $imgMode = isset($row['logotype']) ? (string)$row['logotype'] : '';

        if ($imgMode === '1') {
            $outside     = isset($row['logodata']) ? (string)$row['logodata'] : '';
            $localsource = 'option value="1"';
            $outsid      = 'option value="2" selected';
        } elseif ($imgMode === '0' && !empty($row['logodata'])) {
            $qc    = (string)$row['logodata'];
            $query = $dou->select('zd_imgdata', '*',
                'querycode = ' . $dou->quote($qc) . ' AND type = "0" AND softwareid = ' . $softId);
            $r2 = $dou->fetch_array($query);
            if ($r2 && isset($r2['querycode'])) {
                $imglistdata = '<option value="' . h($r2['querycode']) . '">logo数据</option>';
            }
            $localsource = 'option value="1" selected';
            $outsid      = 'option value="2"';
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $actionType = isset($_POST['action_type']) ? (string)$_POST['action_type'] : '';
    if (!in_array($actionType, array('imgview', 'logoview'), true) || $softId <= 0) {
        echo '<script language="JavaScript">window.alert("参数异常！0x0000000b1")</script>';
        exit;
    }
    $submit = isset($_POST['submit']) ? (string)$_POST['submit'] : '';
    $typeSel = isset($_POST['type']) ? (string)$_POST['type'] : '';
    $tableSel = isset($_POST['tableSelect']) ? (string)$_POST['tableSelect'] : '';
    $sizeData = isset($_POST['size_data']) ? (string)$_POST['size_data'] : '';

    if ($actionType === 'logoview') {
        $type = 'Logo截图';
        if ($typeSel === '1') {
            switch ($submit) {
                case 'del':
                    $dou->DelSoftwareLogoData(0, $tableSel, $softId);
                    $localsource = 'option value="1" selected';
                    $outsid      = 'option value="2"';
                    break;
                case 'add':
                    $dou->UpdateSoftwareLogoData('local', '', $softId);
                    $localsource = 'option value="1" selected';
                    $outsid      = 'option value="2"';
                    break;
            }
        } else {
            if ($sizeData !== '') {
                $dou->UpdateSoftwareLogoData('network', $sizeData, $softId);
                $type        = 'Logo截图';
                $localsource = 'option value="1"';
                $outsid      = 'option value="2" selected';
                echo '<script>history.go(-1);</script>';
            } else {
                echo '<script>alert("图片地址数据不能为空!");</script>';
                $type        = 'Logo截图';
                $localsource = 'option value="1"';
                $outsid      = 'option value="2" selected';
            }
        }
    }

    if ($actionType === 'imgview') {
        $type = '软件截图';
        if ($typeSel === '1') {
            switch ($submit) {
                case 'del':
                    $dou->DelSoftwareImgData(1, $tableSel, $softId);
                    $localsource = 'option value="1" selected';
                    $outsid      = 'option value="2"';
                    echo '<script>history.go(-1);</script>';
                    break;
                case 'add':
                    $dou->UpdateSoftwareImgData('local', '', $softId);
                    $localsource = 'option value="1" selected';
                    $outsid      = 'option value="2"';
                    break;
            }
        } else {
            switch ($submit) {
                case 'del':
                    $dou->DelSoftwareImgData(2, $tableSel, $softId);
                    $type        = '软件截图';
                    $localsource = 'option value="1"';
                    $outsid      = 'option value="2" selected';
                    echo '<script>history.go(-1);</script>';
                    break;
                case 'add':
                    if ($sizeData !== '') {
                        $dou->UpdateSoftwareImgData('network', $sizeData, $softId);
                        $type        = '软件截图';
                        $localsource = 'option value="1"';
                        $outsid      = 'option value="2" selected';
                        echo '<script>history.go(-1);</script>';
                    } else {
                        echo '<script>alert("图片地址数据不能为空!");</script>';
                        $type        = '软件截图';
                        $localsource = 'option value="1"';
                        $outsid      = 'option value="2" selected';
                    }
                    break;
            }
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
	<link rel="stylesheet" href="../../css/style.min.css">
	<link rel="stylesheet" href="../../fonts/material-design/css/materialdesignicons.css">
	<link rel="stylesheet" href="../../plugin/mCustomScrollbar/jquery.mCustomScrollbar.min.css">
	<link rel="stylesheet" href="../../plugin/waves/waves.min.css">
	<link rel="stylesheet" href="../../plugin/sweet-alert/sweetalert.css">
	<link rel="stylesheet" href="../../css/style-dark.min.css">
<script src="../../js/jquery-1.8.3.min.js"></script>
<style>
.xm3,.xm9{float:left;}
.xm3{width:50%;}
.xm9{width:50%;}
.xm9input{width:80%;}
.panel{border:solid 0px #ddd;border-radius:4px;}
.xmtd{width:110px;text-align:right;padding:5px; }
.delimg{margin-left:20px; color:#090; cursor:pointer}
</style>
<script>
function Select() {
		switch (document.getElementById('data').value)
		{
			case 'imgview':
				if(list == true)
				{
					if(document.getElementById('SoftSource').options.selectedIndex != selectlist)
					{
						document.getElementById('tableSelect').innerHTML = "";
					} else {
					document.getElementById('tableSelect').innerHTML = selectdata;
					}
				}
				if (document.getElementById('SoftSource').options[1].selected == true) {
					document.getElementById('Local_Data_1').style.display = '';
					document.getElementById('Local_Data_2').style.display = 'none';
					document.getElementById('outside_Data').style.display = '';
					document.getElementById('del').style.display = 'none';
					document.getElementById('add').style.display = '';
					document.getElementById('add').innerHTML = '新增';
				} else if (document.getElementById('SoftSource').options[0].selected == true) {
					if(document.getElementById('tableSelect').options.length < 1)
					{
						document.getElementById('add').innerHTML = '应用';
						document.getElementById('add').style.display = '';
						document.getElementById('del').style.display = 'none';
						document.getElementById('Local_Data_1').style.display = '';
						document.getElementById('Local_Data_2').style.display = '';
						document.getElementById('outside_Data').style.display = 'none';
					} else {
						document.getElementById('add').innerHTML = '新增';
						document.getElementById('add').style.display = 'none';
						document.getElementById('del').style.display = '';
						document.getElementById('Local_Data_1').style.display = '';
						document.getElementById('Local_Data_2').style.display = '';
						document.getElementById('outside_Data').style.display = 'none';
					}
				}
				break;

			case 'logoview':
				if (document.getElementById('SoftSource').options[1].selected == true) {
					document.getElementById('Local_Data_1').style.display = 'none';
					document.getElementById('Local_Data_2').style.display = 'none';
					document.getElementById('outside_Data').style.display = '';
					document.getElementById('del').style.display = 'none';
					document.getElementById('add').style.display = '';
					document.getElementById('add').innerHTML = '保存';
				} else if (document.getElementById('SoftSource').options[0].selected == true) {
					document.getElementById('outside_Data').style.display = 'none';
					if(document.getElementById('tableSelect').options.length < 1)
					{
						document.getElementById('add').innerHTML = '应用';
						document.getElementById('add').style.display = '';
						document.getElementById('del').style.display = 'none';
						document.getElementById('Local_Data_1').style.display = '';
						document.getElementById('Local_Data_2').style.display = '';
					} else {
						document.getElementById('add').innerHTML = '新增';
						document.getElementById('add').style.display = 'none';
						document.getElementById('del').style.display = '';
						document.getElementById('Local_Data_1').style.display = '';
						document.getElementById('Local_Data_2').style.display = 'none';
					}
				}
				break;
		}
}
</script>
<script type="text/javascript" src="../../js/jquery.form.js"></script>
<script>
$(function () { //文件上传处理
    $("#fileupload").change(function(){
		var bar = $('.bar');
		var percent = $('.percent');
		var showimg = $('#showimg');
		var progress = $(".progress");
		var files = $(".files");
		var btn = $(".btn span");
		// 只包装一次：重复 wrap 会造成嵌套表单 / 重复 id，第二次上传时服务端取不到文件
		if (!$("#fileupload").closest("#myupload").length) {
			$("#myupload").remove();
			$("#fileupload").wrap("<form id='myupload' action='upload.php?act=add&ifr=<?php echo h($mode); ?>&id=<?php echo (int)$softId; ?>' method='post' enctype='multipart/form-data' style='margin-left:65px;margin-top:-25px'></form>");
		}
		$("#myupload").ajaxSubmit({
			dataType:  'json',
			beforeSend: function() {
				showimg.empty();
				progress.show();
				var percentVal = '0%';
				bar.width(percentVal);
				percent.html(percentVal);
				btn.html("上传中...");
			},
			uploadProgress: function(event, position, total, percentComplete) {
				var percentVal = percentComplete + '%';
				bar.width(percentVal);
				percent.html(percentVal);
			},
			success:function(data) {
				if(data.status == '0' || data.status == null)
				{
					location.reload();
				} else {
					btn.html("上传失败");
					bar.width('0');
					files.html($('<span>').text(data.message));
					$("#fileupload").show();
					progress.hide();
					files.show();
					// 清空选择框，允许再次选择同一个文件重传
					$("#fileupload").val('');
				}
			}
		});
	});
});
</script>
</head>
<body>
      <div class='box-content'>
         	<form method="post" id="contact" action="#">
			<input type="hidden" name="action_type" id="data" value="<?php echo h($mode); ?>">
			<input type="hidden" name="action_mode" id="mode" value="<?php echo h($imgMode); ?>">
			<div class="form-group">
				<label>图片类型</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label style="color:green"><?php echo h($type); ?></label>
			</div>
			<div class="form-group">
				<label>链接方式</label>
				<select name='type' style="width:70%;height:36px" class="form-control" id="SoftSource" onchange="Select()"><<?php echo $localsource; ?>>本地源</option><<?php echo $outsid; ?>>网络源</option></select>
			</div>
			<div class="form-group" id='Local_Data_1'>
				<label>图片数据</label>
				<select name="tableSelect" size="10" id="tableSelect" class="form-control" ><?php echo $imglistdata; ?></select>
			</div>
			<div class="form-group" id='outside_Data'>
				<label>网络路径</label>
				<input name="size_data" type="text" class="form-control" tabindex="1" value="<?php echo h($outside); ?>" style="width:70%"/>
			</div>
			<div class="form-group" id='Local_Data_2'>
				<label>上传文件</label>
				<input id="fileupload" type="file" class="form-control" name="mypic" style="width:200px">
				<div class="progress" style="display:none;margin-left:280px;margin-top:-25px"><span class="bar"></span><span class="percent">0%</span></div><input type="hidden" id="file" class="type" name="mypic" value="file"><div id="showimg"></div><div class="files"></div>
			</div>
			<div class="form-group">
				<button name="submit" type="submit"  Class="btn btn-primary btn-sm waves-effect waves-light" value="add" id="add">新增</button>
				<button name="submit" type="submit"  Class="btn btn-primary btn-sm waves-effect waves-light" value="del" id="del">删除</button>
			</div>
         	</form>
        </div>
<script>
Select();
var selectlist = document.getElementById('SoftSource').options.selectedIndex;
var selectdata = <?php echo json_encode($imglistdata, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
var list = true;
</script>
</body>
</html>
