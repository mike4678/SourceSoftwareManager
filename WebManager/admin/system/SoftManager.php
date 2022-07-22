<?php 
require("../../kernl/Init.php"); 
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器

//判断是否在框架内，防止跨域
$dou -> FormCheck();
$dou -> WSCS_Check();                    //安全检查，防护系统
$state = $dou -> AccountState();
$addr = $dou -> AddrConvery($_GET);	 //初始化参数
if ($state == 'Access denied') 
{
	if( count($addr) > 0 && $addr[1] != 'exit') 
	{
		header("Location: ../login.php?ref=/".$addr[1]."/".$addr[2]);
		
	} else { 
		
		header("Location: ../login.php"); }
	
}

//初始化相关参数信息
if ($_SERVER["REQUEST_METHOD"] == "GET") 
{
	if($_GET['m'] == "edit" && empty($_GET['id']))
	{
		echo '<script language="JavaScript">window.alert("参数异常！0x0000000b4")</script>';
		exit;
	}
}
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	if(empty($_POST['name']) || empty($_POST['type']) || empty($_POST['version']) || empty($_POST['size_data']) || empty($_POST['intro_Content']) || empty($_POST['detail_Content']) || empty($_POST['SoftSource']))
	{
		echo '<script language="JavaScript">window.alert("参数异常！0x0000000b1")</script><a href="javascript:history:go(-1);">返回</a>';
		exit;
				
	}
	if($_POST['SoftSource'] == 'local')
	{
		if(empty($_POST['pathdef']) || empty($_POST['hash'])) 
		{
					
			echo '<script language="JavaScript">window.alert("参数异常！0x0000000b2")</script><a href="javascript:history:go(-1);">返回</a>';
			exit;
			
		}				
	} else {
				
		if(empty($_POST['fileoutsidedata'])) 
		{
					
			echo '<script language="JavaScript">window.alert("参数异常！0x0000000b3")</script><a href="javascript:history:go(-1);">返回</a>';
			exit;
						
		}
	}
			
	switch($_POST['action_type'])
	{
		case 'add':
			//检查是否通过异常方式提交
			if($_POST['SoftSource'] == 'local')
			{
				$sql = "insert into `zd_software`(`softname`, `version`, `size`, `synopsis`, `updatetime`, `hash`, `run`, `type`, `introduce`, `downloadtype`, `downloadaddr`, `remark`, `nowrunfile`) VALUES ('".urldecode($_POST['name'])."','".$_POST['version']."','".floatval($_POST['size_data'])."','".urldecode($_POST['intro_Content'])."','".time()."','".$_POST['hash']."','".urldecode($_POST['exec'])."','".$_POST['type']."','".urldecode($_POST['detail_Content'])."','0','','".$_POST['pathdef']."','".$_POST['pre_exec']."');";
				
			} else {
			
				$sql = "insert into `zd_software`(`softname`, `version`, `size`, `synopsis`, `updatetime`, `hash`, `run`, `type`, `introduce`, `downloadtype`, `downloadaddr`, `remark`, `nowrunfile`) VALUES ('".urldecode($_POST['name'])."','".$_POST['version']."','".floatval($_POST['size_data'])."','".urldecode($_POST['intro_Content'])."','".time()."','".$_POST['hash']."','".urldecode($_POST['exec'])."','".$_POST['type']."','".urldecode($_POST['detail_Content'])."','1','".$_POST['fileoutsidedata']."','','');";
			}			
			if (!$dou->query($sql)) 
			{
				echo '<script language="JavaScript">window.alert("新增失败！")</script>';
				
				
			}
				echo '<script language="JavaScript">window.alert("新增成功!")</script>';
				echo '<script language="JavaScript">self.location=document.referrer;</script>';
			
			break;
			
		case 'edit':
			//检查是否通过异常方式提交
			if($_POST['SoftSource'] == 'local')
			{
				$sql =  "UPDATE zd_software 
				  	   SET `softname`='".urldecode($_POST['name'])."',
					   `version`='".$_POST['version']."',
					   `size`='".floatval($_POST['size_data'])."',
					   `synopsis`='".urldecode($_POST['intro_Content'])."',
					   `updatetime`='".time()."',
					   `hash`='".$_POST['hash']."',
					   `run`='".urldecode($_POST['exec'])."',
					   `type`='".$_POST['type']."',
					   `introduce`='".urldecode(str_replace(PHP_EOL,'@#cr#@',$_POST['detail_Content']))."',
					   `type`='0',
					   `remark`='".$_POST['pathdef']."',
					   `nowrunfile`='".$_POST['pre_exec']."'";
				
			} else {
			
				$sql =  "UPDATE zd_software 
				  	   SET `softname`='".urldecode($_POST['name'])."',
					   `version`='".$_POST['version']."',
					   `size`='".floatval($_POST['size_data'])."',
					   `synopsis`='".urldecode($_POST['intro_Content'])."',
					   `updatetime`='".time()."',
					   `hash`='".$_POST['hash']."',
					   `run`='".urldecode($_POST['exec'])."',
					   `type`='".$_POST['type']."',
					   `introduce`='".urldecode($_POST['detail_Content'])."',
					   `type`='1',
					   `downloadaddr`='".$_POST['fileoutsidedata']."';";
			}			
			if (!$dou->query($sql)) 
			{
				echo '<script language="JavaScript">window.alert("修改失败！")</script>';
				
			}
				echo '<script language="JavaScript">window.alert("修改成功!")</script>';
				echo '<script language="JavaScript">self.location=document.referrer;</script>';
				
			break;
	}

}
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
	var SelectData =  document.getElementById('SoftwareList').options[document.getElementById('SoftwareList').selectedIndex].text;
			$.ajax({
			url: 'GetHash.php',
			type: 'POST',
			dataType: 'json',
			data: {Filename: SelectData},
			success: function(res){
					var code = res.status;
					var message = res.message;
					var pathdef = res.Path;
					var size = Math.ceil(res.Size / 1024)
					switch(code) 
					{
						case '-1':
							SystemBox(3,message);
							break;
						
						case '-2':
							window.location.href='../login.php';
							break;
							
						case '0':
							document.getElementById('hash').value = message;
							document.getElementById('pathdef').value = pathdef;
							document.getElementById('size_data').value = size;
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
		$("#fileupload").wrap("<form id='myupload' action='upload.php?act=add&ifr=program' method='post' enctype='multipart/form-data'></form>");
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
					showimg.html("<input type='hidden' name='path' value='"+data.pic+"'><span class='delimg' rel='"+data.pic+"'>删除</span>");
					$("#fileupload").show();
					progress.hide();
					files.show();
					$.ajax({
					url: 'GetHash.php',
					type: 'POST',
					dataType: 'json',
					data: {Filename: data.pic},
					success: function(res){
						var code = res.status;
						var message = res.message;
						var pathdef = res.Path;
						switch(code) 
						{
							case '-1':
								SystemBox(3,message);
								break;
						
							case '-2':
								window.location.href='../login.php';
								break;
							
							case '0':
								document.getElementById('hash').value = message;
								document.getElementById('pathdef').value = pathdef;
								break;

						}
					}
				});	} else {
					btn.html("上传失败");
					bar.width('0')
					files.html(data.message);
					$("#fileupload").show();
					progress.hide();
					files.show();
				}

			},
		});
		
	});
	
	$(".delimg").live('click',function(){
		var pic = $(this).attr("rel");
		$.post("upload.php?act=del&ifr=program",{imagename:pic},function(msg){
			if(msg == 0){
				files.html("删除成功.&nbsp;&nbsp;<a href='javascript:history.go(0)'>刷新</a>");
				showimg.empty();
				progress.hide();
			}else{
				alert(msg);
			}
		});
	});
}); 
</script>
</head>
<body>
<div class="admin">
      <div id="line-big">
         	<form method="post" id="contact" action="#">
			<input type="hidden" name="action_type" value="<?php echo $_GET['m']; ?>">
			<div class="xm3">
				<div class="panel">
				<table class="table">
				<tr><td class="xmtd">软件名称</td><td><input name="name" type="text" tabindex="1" value="<?php echo $dou -> SoftwareDataInfo('softname',floatval($_GET['id']))?>" required="required"/>
				<tr><td class="xmtd">软件分类</td><td>					<select name='type'> 
					 <?php
						$tmp_type = $dou -> SoftwareDataInfo('type',floatval($_GET['id']));
						$UData = $dou->fetch_array_all('zd_type');
						foreach ($UData as $value)
						{
							if($value['type'] != $tmp_type){
								echo '<option value="'.$value['type'].'">'.$value['type'].'</option>';
							} else {
								echo '<option value="'.$value['type'].'" selected="selected" >'.$value['type'].'</option>';
							}	
						}
					?> 
					</select></td></tr>
				<tr><td class="xmtd">软件版本</td><td class='xm9input'><input name="version" type="text" tabindex="1" value="<?php echo $dou -> SoftwareDataInfo('version',floatval($_GET['id']))?>" required="required"/>
				<tr><td class="xmtd">容量(KB)</td><td class='xm9input'><input name="size_data" id="size_data" type="text" tabindex="1" value="<?php echo $dou -> SoftwareDataInfo('size',floatval($_GET['id']))?>" required="required"/>
				<tr><td class="xmtd">软件简介</td><td class='xm9input'><input name="intro_Content" type="text" tabindex="1" value="<?php echo $dou -> SoftwareDataInfo('synopsis',floatval($_GET['id']))?>" required="required"/>
				<tr><td class="xmtd">详细介绍</td><td class='xm9input'><textarea name="detail_Content" cols="50" rows="5" class="input" id="detail_Content" required="required"><?php echo str_replace('@#cr#@',PHP_EOL,$dou -> SoftwareDataInfo('introduce',floatval($_GET['id'])))?></textarea>
				</table>
				</div></div>
				<div class="xm9">
				<div class="panel">
				<table class="table">
					<tr><td class="xmtd">文件来源</td><td class='xm9input'>
					<?php 
					if($_GET['m'] == 'edit')
					{
						if(floatval($dou -> SoftwareDataInfo('downloadtype',floatval($_GET['id']))) == 0)
						{
							$local = 'selected="selected"';
							$out = '';
						} else {
							$local = '';
							$out = 'selected="selected"';
						}
					} else {
					
						$local = 'selected="selected"';
						$out = '';
					}
					?>
					<select name='SoftSource' id='SoftSource' onchange="Select();"> <option value='local' <?php echo $local;?>>本地源</option><option value='outside' <?php echo $out;?>>外部连接</option></select> </td></tr>
					<tr id="Local_Data_1"><td class="xmtd">当前文件</td><td class='xm9input'><select name='SoftwareList' id='SoftwareList' onchange="Hash();"> 
					 <?php
						$tmp_file = $dou -> SoftwareDataInfo('remark',floatval($_GET['id'])) . '.zip';
						$UData = $dou->getFileList3(LocalSource);
						foreach ($UData as $value)
						{
							if($value != $tmp_file){
								echo '<option value='.$value.'>'.$value.'</option>';
							} else {
								echo '<option value='.$value.'" selected="selected" >'.$value.'</option>';
							}
						}
					?> 
					</select></td></tr>
					<tr id="Local_Data_5"><td class="xmtd">上传文件</td><td><input id="fileupload" type="file" name="mypic" style="width:200px"><input type="hidden" id="file" class="type" name="mypic" value="file"><div id="showimg"></div><div class="progress" style="display:none;position:relative;top:5px;height:18px"><span class="bar"></span><span class="percent">0%</span ></div><div class="files"></div></td></tr>
                    <tr id="Local_Data_2"><td class="xmtd">软件Hash</td><td class='xm9input'><input name="hash" type="text" tabindex="1" value="<?php echo $dou -> SoftwareDataInfo('hash',floatval($_GET['id']))?>" id="hash"/></td></tr>
                    <tr id="Local_Data_6"><td class="xmtd">目录标识</td><td class='xm9input'><input name="pathdef" type="text" tabindex="1" value="<?php echo $dou -> SoftwareDataInfo('remark',floatval($_GET['id']))?>" id="pathdef"/></td></tr>					
                    <tr id="Local_Data_3"><td class="xmtd">执行程式</td><td class='xm9input'><input name="exec" type="text" tabindex="1" value="<?php echo $dou -> SoftwareDataInfo('run',floatval($_GET['id']))?>" id="exec"/></td></tr>
                    <tr id="Local_Data_4"><td class="xmtd">预执行程式</td><td class='xm9input'><input name="pre_exec" type="text" tabindex="1" value="<?php echo $dou -> SoftwareDataInfo('nowrunfile',floatval($_GET['id']))?>" id="pre_exec"/></td></tr>
					<tr id="outside_Data" style="display:none"><td class="xmtd">文件数据</td><td class='xm9input'><input name="fileoutsidedata" id="fileoutsidedata" type="text" tabindex="1" value="<?php echo $dou -> SoftwareDataInfo('downloadaddr',floatval($_GET['id']))?>"/></td></tr>	
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