<?php
/* ---------------------------------------------------- */
/* 软件新增 / 编辑
/* 安全修订说明（2026）：
/*  1. 原代码把 urldecode($_POST[...]) 十数个字段直接拼进 SQL，
/*     存在典型 SQL 注入；现全部改为 quote() 转义后写入
/*  2. 原编辑语句缺少 WHERE id，会把所有软件记录覆盖成同一份数据；
/*     现补齐条件并限定为整数 id
/*  3. 表单回显（软件名/简介/详细介绍/Hash 等）统一 h() 转义，消除存储型 XSS
/*  4. $_GET['m'] 只允许 add/edit 白名单，避免任意反射到 hidden 字段
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

$mode = isset($_GET['m']) ? (string)$_GET['m'] : '';
if (!in_array($mode, array('add', 'edit'), true)) {
    $mode = 'add';
}
$softId = isset($_GET['id']) ? to_int($_GET['id'], 0) : 0;

// ---------- 请求处理 ----------
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($mode === 'edit' && $softId <= 0) {
        echo '<script language="JavaScript">window.alert("参数异常！0x0000000b4")</script>';
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postMode = isset($_POST['action_type']) ? (string)$_POST['action_type'] : '';
    if (!in_array($postMode, array('add', 'edit'), true)) {
        echo '<script language="JavaScript">window.alert("参数异常！0x0000000b1")</script><a href="javascript:history.go(-1);">返回</a>';
        exit;
    }

    $name     = isset($_POST['name']) ? (string)$_POST['name'] : '';
    $type     = isset($_POST['type']) ? (string)$_POST['type'] : '';
    $version  = isset($_POST['version']) ? (string)$_POST['version'] : '';
    $sizeData = isset($_POST['size_data']) ? $_POST['size_data'] : '';
    $intro    = isset($_POST['intro_Content']) ? (string)$_POST['intro_Content'] : '';
    $detail   = isset($_POST['detail_Content']) ? (string)$_POST['detail_Content'] : '';
    $source   = isset($_POST['SoftSource']) ? (string)$_POST['SoftSource'] : '';

    if ($name === '' || $type === '' || $version === '' || $sizeData === '' || $intro === '' || $detail === '' || $source === '') {
        echo '<script language="JavaScript">window.alert("参数异常！0x0000000b1")</script><a href="javascript:history.go(-1);">返回</a>';
        exit;
    }

    if ($source === 'local') {
        if (empty($_POST['pathdef']) || empty($_POST['hash'])) {
            echo '<script language="JavaScript">window.alert("参数异常！0x0000000b2")</script><a href="javascript:history.go(-1);">返回</a>';
            exit;
        }
    } else {
        if (empty($_POST['fileoutsidedata'])) {
            echo '<script language="JavaScript">window.alert("参数异常！0x0000000b3")</script><a href="javascript:history.go(-1);">返回</a>';
            exit;
        }
    }

    $name     = substr(urldecode($name), 0, 100);
    $intro    = substr(urldecode($intro), 0, 500);
    $detail   = urldecode(str_replace(PHP_EOL, '@#cr#@', $detail));
    $exec     = isset($_POST['exec']) ? substr(urldecode((string)$_POST['exec']), 0, 200) : '';
    $preExec  = isset($_POST['pre_exec']) ? substr((string)$_POST['pre_exec'], 0, 200) : '';
    $hash     = isset($_POST['hash']) ? substr((string)$_POST['hash'], 0, 100) : '';
    $pathdef  = isset($_POST['pathdef']) ? substr(urldecode((string)$_POST['pathdef']), 0, 200) : '';
    $outAddr  = isset($_POST['fileoutsidedata']) ? substr((string)$_POST['fileoutsidedata'], 0, 500) : '';
    $softType = isset($_POST['softwaretype']) && $_POST['softwaretype'] === 'mobile' ? 'mobile' : 'pc';
    $sizeKb   = round((float)$sizeData, 2);

    $downloadType = $source === 'local' ? 0 : 1;
    $downloadAddr = $source === 'local' ? '' : $outAddr;
    $remark       = $source === 'local' ? $pathdef : '';
    $nowRunFile   = $source === 'local' ? $preExec : '';

    $d = $dou;

    if ($postMode === 'add') {
        $sql = "INSERT INTO `zd_software`
                (`softname`,`version`,`size`,`synopsis`,`updatetime`,`hash`,`run`,`type`,`introduce`,
                 `downloadtype`,`downloadaddr`,`remark`,`nowrunfile`,`softwaretype`)
                VALUES ("
            . $d->quote($name) . ","
            . $d->quote($version) . ","
            . $d->quote((string)$sizeKb) . ","
            . $d->quote($intro) . ","
            . $d->quote((string)time()) . ","
            . $d->quote($hash) . ","
            . $d->quote($exec) . ","
            . $d->quote($type) . ","
            . $d->quote($detail) . ","
            . $d->quote((string)$downloadType) . ","
            . $d->quote($downloadAddr) . ","
            . $d->quote($remark) . ","
            . $d->quote($nowRunFile) . ","
            . $d->quote($softType) . ")";

        if (!$d->query($sql)) {
            $d->OpLog('新增软件', $name . ' ' . $version, '失败');
            echo '<script language="JavaScript">window.alert("新增失败！")</script>';
            exit;
        }
        $d->OpLog('新增软件', $name . ' ' . $version . '（分类：' . $type . '，模式：' . $postMode . '）');
        echo '<script language="JavaScript">window.alert("新增成功!")</script>';
        echo '<script language="JavaScript">self.location=document.referrer;</script>';
        exit;
    }

    // 编辑：必须有合法 id
    if ($softId <= 0) {
        echo '<script language="JavaScript">window.alert("参数异常！0x0000000b4")</script>';
        exit;
    }

    $sql = "UPDATE `zd_software` SET "
        . "`softname` = " . $d->quote($name) . ","
        . "`version` = " . $d->quote($version) . ","
        . "`size` = " . $d->quote((string)$sizeKb) . ","
        . "`synopsis` = " . $d->quote($intro) . ","
        . "`updatetime` = " . $d->quote((string)time()) . ","
        . "`hash` = " . $d->quote($hash) . ","
        . "`run` = " . $d->quote($exec) . ","
        . "`type` = " . $d->quote($type) . ","
        . "`introduce` = " . $d->quote($detail) . ","
        . "`softwaretype` = " . $d->quote($softType) . ","
        . "`downloadtype` = " . $d->quote((string)$downloadType) . ","
        . "`downloadaddr` = " . $d->quote($downloadAddr) . ","
        . "`remark` = " . $d->quote($remark) . ","
        . "`nowrunfile` = " . $d->quote($nowRunFile)
        . " WHERE `id` = " . $softId;

    if (!$d->query($sql)) {
        $d->OpLog('修改软件', 'id=' . $softId . ' ' . $name, '失败');
        echo '<script language="JavaScript">window.alert("修改失败！")</script>';
        exit;
    }
    $d->OpLog('修改软件', 'id=' . $softId . ' ' . $name . ' ' . $version . '（分类：' . $type . '）');
    echo '<script language="JavaScript">window.alert("修改成功!")</script>';
    echo '<script language="JavaScript">self.location=document.referrer;</script>';
    exit;
}

// ---------- 回显数据 ----------
$softName = h((string)$dou->SoftwareDataInfo('softname', $softId));
$softVer  = h((string)$dou->SoftwareDataInfo('version', $softId));
$softSize = h((string)$dou->SoftwareDataInfo('size', $softId));
$softSyn  = h((string)$dou->SoftwareDataInfo('synopsis', $softId));
$softIntr = h(str_replace('@#cr#@', PHP_EOL, (string)$dou->SoftwareDataInfo('introduce', $softId)));
$softHash = h((string)$dou->SoftwareDataInfo('hash', $softId));
$softExec = h((string)$dou->SoftwareDataInfo('run', $softId));
$softPre  = h((string)$dou->SoftwareDataInfo('nowrunfile', $softId));
$softPath = h((string)$dou->SoftwareDataInfo('remark', $softId));
$softOut  = h((string)$dou->SoftwareDataInfo('downloadaddr', $softId));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<link href="../../css/setting.css" rel="stylesheet" type="text/css" />
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
        if (document.getElementById('SoftSource').options[1].selected == true) {
            document.getElementById('Local_Data_1').style.display = 'none';
			document.getElementById('Local_Data_2').style.display = 'none';
			document.getElementById('Local_Data_3').style.display = 'none';
			document.getElementById('Local_Data_4').style.display = 'none';
			document.getElementById('Local_Data_5').style.display = 'none';
			document.getElementById('Local_Data_6').style.display = 'none';
			document.getElementById('outside_Data').style.display = '';
			document.getElementById('fileoutsidedata').required=true;
			document.getElementById('pathdef').required=false;
			document.getElementById('hash').required=false;
        } else if (document.getElementById('SoftSource').options[0].selected == true) {
			document.getElementById('Local_Data_1').style.display = '';
			document.getElementById('Local_Data_2').style.display = '';
			document.getElementById('Local_Data_3').style.display = '';
			document.getElementById('Local_Data_4').style.display = '';
			document.getElementById('Local_Data_5').style.display = '';
			document.getElementById('Local_Data_6').style.display = '';
			document.getElementById('outside_Data').style.display = 'none';
			document.getElementById('fileoutsidedata').required=false;
			document.getElementById('pathdef').required=true;
			document.getElementById('hash').required=true;
        }
}
function Hash()
{
	document.getElementById('hash').value = '读取中.....';
	document.getElementById('pathdef').value = '读取中.....';
	document.getElementById('size_data').value = '读取中.....';
	var SelectData = document.getElementById('SoftwareList').options[document.getElementById('SoftwareList').selectedIndex].text;
	$.ajax({
		url: 'GetHash.php',
		type: 'POST',
		dataType: 'json',
		data: {Filename: SelectData},
		success: function(res){
			var code = res.status;
			switch(code)
			{
				case '-1':
					SystemBox(3, res.message);
					document.getElementById('hash').value = '';
					document.getElementById('pathdef').value = '';
					document.getElementById('size_data').value = '';
					break;
				case '-2':
					window.location.href='../login.php';
					break;
				case '0':
					document.getElementById('hash').value = res.message;
					document.getElementById('pathdef').value = res.Path;
					document.getElementById('size_data').value = Math.ceil(res.Size / 1024);
					break;
			}
		}
	});
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
		// 只在第一次上传时包装表单：原来每次 change 都 wrap，会生成嵌套表单 /
		// 重复的 #myupload，第二次起提交的就不是含文件的那个表单，服务端收到空 $_FILES
		if (!$("#fileupload").closest("#myupload").length) {
			$("#myupload").remove();
			$("#fileupload").wrap("<form id='myupload' action='upload.php?act=add&ifr=program' method='post' enctype='multipart/form-data'></form>");
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
					showimg.html($("<input type='hidden' name='path'>").val(data.pic).after($('<span class="delimg">').attr('rel', data.pic).text('删除')));
					$("#fileupload").hide();
					progress.hide();
					files.hide();
					$.ajax({
						url: 'GetHash.php',
						type: 'POST',
						dataType: 'json',
						data: {Filename: data.pic},
						success: function(res){
							if(res.status == '0') {
								document.getElementById('hash').value = res.message;
								document.getElementById('pathdef').value = res.Path;
							} else {
								SystemBox(3, res.message);
							}
						}
					});
				} else {
					btn.html("上传失败");
					bar.width('0');
					files.html($('<span>').text(data.message));
					// 清空选择框，保证再次选择同一个文件时也能触发 change 重新上传
					$("#fileupload").val('');
				}
			}
		});
	});

	$(document).on('click', '.delimg', function(){
		var pic = $(this).attr("rel");
		$.post("upload.php?act=del&ifr=program", {imagename: pic}, function(msg){
			if(msg.status == '0'){
				$('.files').html('删除成功.&nbsp;&nbsp;<a href="" onclick="history.go(0);return false;">刷新</a>');
				$('#showimg').empty();
			} else {
				alert(msg.message);
			}
		}, 'json');
	});
});
</script>
</head>
<body>
<div class="admin">
      <div id="line-big">
         	<form method="post" id="contact" action="#">
			<input type="hidden" name="action_type" value="<?php echo h($mode); ?>">
			<div class="xm3">
				<div class="panel">
				<table class="table">
				<tr><td class="xmtd">软件名称</td><td><input name="name" type="text" tabindex="1" value="<?php echo $softName; ?>" required="required"/>
				<tr><td class="xmtd">软件类别</td><td>
					<select name='softwaretype'>
					 <?php
						$stype = (string)$dou->SoftwareDataInfo('softwaretype', $softId);
						if ($stype === 'mobile') {
						    echo '<option value="pc">PC</option><option value="mobile" selected="selected">安卓</option>';
						} else {
						    echo '<option value="pc" selected="selected">PC</option><option value="mobile">安卓</option>';
						}
					?>
					</select></td></tr>
				<tr><td class="xmtd">软件分类</td><td>
					<select name='type'>
					 <?php
						$tmpType = (string)$dou->SoftwareDataInfo('type', $softId);
						$UData   = $dou->fetch_array_all('zd_type');
						foreach ($UData as $value) {
						    $t = isset($value['type']) ? (string)$value['type'] : '';
						    if ($t === '') {
						        continue;
						    }
						    $sel = ($t === $tmpType) ? ' selected="selected"' : '';
						    echo '<option value="' . h($t) . '"' . $sel . '>' . h($t) . '</option>';
						}
					?>
					</select></td></tr>
				<tr><td class="xmtd">软件版本</td><td class='xm9input'><input name="version" type="text" tabindex="1" value="<?php echo $softVer; ?>" required="required"/>
				<tr><td class="xmtd">容量(KB)</td><td class='xm9input'><input name="size_data" id="size_data" type="text" tabindex="1" value="<?php echo $softSize; ?>" required="required"/>
				<tr><td class="xmtd">软件简介</td><td class='xm9input'><input name="intro_Content" type="text" tabindex="1" value="<?php echo $softSyn; ?>" required="required"/>
				<tr><td class="xmtd">详细介绍</td><td class='xm9input'><textarea name="detail_Content" cols="50" rows="5" class="input" id="detail_Content" required="required"><?php echo $softIntr; ?></textarea>
				</table>
				</div></div>
				<div class="xm9">
				<div class="panel">
				<table class="table">
					<tr><td class="xmtd">文件来源</td><td class='xm9input'>
					<?php
					$isLocal = true;
					if ($mode === 'edit') {
					    $isLocal = ((string)$dou->SoftwareDataInfo('downloadtype', $softId) !== '1');
					}
					?>
					<select name='SoftSource' id='SoftSource' onchange="Select();"> <option value='local' <?php echo $isLocal ? 'selected="selected"' : ''; ?>>本地源</option><option value='outside' <?php echo $isLocal ? '' : 'selected="selected"'; ?>>外部连接</option></select> </td></tr>
					<tr id="Local_Data_1"><td class="xmtd">当前文件</td><td class='xm9input'><select name='SoftwareList' id='SoftwareList' onchange="Hash();">
					 <?php
						$tmpFile = (string)$dou->SoftwareDataInfo('remark', $softId) . '.zip';
						$UData   = $dou->getFileList3(LocalSource);
						if (empty($UData)) {
						    echo '<option value="">本地源目录暂无文件</option>';
						}
						foreach ($UData as $value) {
						    $sel = ($value === $tmpFile) ? ' selected="selected"' : '';
						    echo '<option value="' . h($value) . '"' . $sel . '>' . h($value) . '</option>';
						}
					?>
					</select></td></tr>
					<tr id="Local_Data_5"><td class="xmtd">上传文件</td><td><input id="fileupload" type="file" name="mypic" style="width:200px"><input type="hidden" id="file" class="type" name="mypic" value="file"><div id="showimg"></div><div class="progress" style="display:none;position:relative;top:5px;height:18px"><span class="bar"></span><span class="percent">0%</span></div><div class="files"></div></td></tr>
                    <tr id="Local_Data_2"><td class="xmtd">软件Hash</td><td class='xm9input'><input name="hash" type="text" tabindex="1" value="<?php echo $softHash; ?>" id="hash"/></td></tr>
                    <tr id="Local_Data_6"><td class="xmtd">目录标识</td><td class='xm9input'><input name="pathdef" type="text" tabindex="1" value="<?php echo $softPath; ?>" id="pathdef"/></td></tr>
                    <tr id="Local_Data_3"><td class="xmtd">执行程式</td><td class='xm9input'><input name="exec" type="text" tabindex="1" value="<?php echo $softExec; ?>" id="exec"/></td></tr>
                    <tr id="Local_Data_4"><td class="xmtd">预执行程式</td><td class='xm9input'><input name="pre_exec" type="text" tabindex="1" value="<?php echo $softPre; ?>" id="pre_exec"/></td></tr>
					<tr id="outside_Data" style="display:none"><td class="xmtd">文件数据</td><td class='xm9input'><input name="fileoutsidedata" id="fileoutsidedata" type="text" tabindex="1" value="<?php echo $softOut; ?>"/></td></tr>
                </table>
				</div></div>
					<button name="submit" type="submit" id="contact-submit" value="add" style="margin:10px 0px 10px 0px">新增/保存</button>
         	</form>
        </div>
</div>
<script>
Select();
</script>
</body>
</html>
