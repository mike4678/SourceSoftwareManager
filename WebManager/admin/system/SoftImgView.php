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
	if(empty($_GET['m']) || empty($_GET['id']) )
	{
		echo '<script language="JavaScript">window.alert("参数异常！0x0000000b4")</script>';
		exit;
	}
	
	if($_GET['m'] == "imgview" )
	{
		$type = '运行截图';
		$query = $dou -> select('zd_software', 'runpic,runpictype' ,'id = '.floatval($_GET['id']) );
		$row = $dou->fetch_array($query);
		if(empty($row))
		{
			echo '<script language="JavaScript">window.alert("参数异常！0x0000000b5")</script>无效的软件ID';
			exit;
		}
		$mode = $row['runpictype'];
		if(empty($mode))
		{
			$localsource = 'option value="1" selected';
			$outsid = 'option value="2"';
		} 
		if($mode != NULL && $mode == 1 ) //外部连接
		{ 
				if(!empty($row['runpic']))
				{
					$count = 1;
					$outside =  explode(',', $row['runpic']);
					foreach ($outside as $x) 
					{
						$imglistdata = $imglistdata . '<option value="'.$count.'"  >软件截图</option>';
						$count = $count + 1;
					} 
					$localsource = 'option value="1"';
					$outsid = 'option value="2" selected';
				} else {
					$localsource = 'option value="1"';
					$outsid = 'option value="2" selected';
				}
		} 		
		if($mode != NULL && $mode == 0 ) //外部连接 {		
		{
			if(!empty($row['runpic']))
			{
				$outside =  explode(',', $row['runpic']);
				foreach ($outside as $x) 
				{
					if($x != NULL)
					{
						$imglistdata = $imglistdata . '<option value="'.$x.'"  >软件截图</option>';
					}
				} 
					$localsource = 'option value="1" selected';
					$outsid = 'option value="2" ';
				} else {
					$localsource = 'option value="1" selected';
					$outsid = 'option value="2"';
				}
		}		
	}
	
	if($_GET['m'] == "logoview" )
	{
		$type = 'Logo截图';
		$query = $dou -> select('zd_software', 'logodata,logotype' ,'id = '.floatval($_GET['id']) );
		$row = $dou->fetch_array($query);
		if(empty($row))
		{
			echo '<script language="JavaScript">window.alert("参数异常！0x0000000b5")</script>无效的软件ID';
			exit;
		}
		$mode = $row['logotype'];
		if(empty($mode))
		{
			$localsource = 'option value="1" selected';
			$outsid = 'option value="2"';
		} 
		if($mode != NULL && $mode == 1) //外部连接
		{ 
				$outside =  $row['logodata'];
				$localsource = 'option value="1"';
				$outsid = 'option value="2" selected';
		} 		
		if($mode != NULL && $mode == 0 && !empty($row['logodata'])) //外部连接 {		
		{
				$query = $dou -> select('zd_imgdata', '*' ,'querycode = "'.$row['logodata'].'" AND type = "0" AND softwareid = ' . floatval($_GET['id']));
				$row = $dou->fetch_array($query);
				$imglistdata = '<option value="'.$row['querycode'].'"  >logo数据</option>';
				$localsource = 'option value="1" selected';
				$outsid = 'option value="2"';
		}
	}
	
}
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	if($_POST['action_type'] == NULL)
	{
		echo '<script language="JavaScript">window.alert("参数异常！0x0000000b1")</script>';
		exit;
	}
	if($_POST['action_type'] == 'logoview')
	{
		if($_POST['type'] == 1) 
		{
			switch($_POST['submit'])
			{
				case 'del':
					$dou -> DelSoftwareLogoData(0, $_POST['tableSelect'] , floatval($_GET['id']) );
					$type = 'Logo截图';
					$localsource = 'option value="1" selected';
					$outsid = 'option value="2"';
					//echo '<script>history.go(-1);</script>';
					break;
					
				case 'add':
					$dou -> UpdateSoftwareLogoData( 'local','' , floatval($_GET['id']) );
					$type = 'Logo截图';
					$localsource = 'option value="1" selected';
					$outsid = 'option value="2"';
					break;
			}
						
		} else {

			if($_POST['size_data'] != NULL)
			{
				$dou -> UpdateSoftwareLogoData('network', $_POST['size_data'] , floatval($_GET['id']));
				$type = 'Logo截图';
				$localsource = 'option value="1" ';
				$outsid = 'option value="2" selected';
				echo '<script>history.go(-1);</script>';
			} else {
				echo '<script>alert("图片地址数据不能为空!");</script>';
				$type = 'Logo截图';
				$localsource = 'option value="1" ';
				$outsid = 'option value="2" selected';
			}
		}	
			
	}
	
	if($_POST['action_type'] == 'imgview')
	{
		if($_POST['type'] == 1) 
		{
			switch($_POST['submit'])
			{
				case 'del':
					$dou -> DelSoftwareImgData(1, $_POST['tableSelect'] , floatval($_GET['id']) );
					$type = '软件截图';
					$localsource = 'option value="1" selected';
					$outsid = 'option value="2"';
					echo '<script>history.go(-1);</script>';
					break;
					
				case 'add':
					$dou -> UpdateSoftwareImgData( 'local','' , floatval($_GET['id']) );
					$type = '软件截图';
					$localsource = 'option value="1" selected';
					$outsid = 'option value="2"';
					break;
			}
						
		} else {
		
			switch($_POST['submit'])
			{
				case 'del':
					$dou -> DelSoftwareImgData(2, $_POST['tableSelect'] , floatval($_GET['id']) );
					$type = '软件截图';
					$localsource = 'option value="1" ';
					$outsid = 'option value="2" selected';
					echo '<script>history.go(-1);</script>';
					break;
					
				case 'add':
					if($_POST['size_data'] != NULL)
					{
						$dou -> UpdateSoftwareImgData('network', $_POST['size_data'] , floatval($_GET['id']));
						$type = '软件截图';
						$localsource = 'option value="1" ';
						$outsid = 'option value="2" selected';
						echo '<script>history.go(-1);</script>';
				
					} else {
						
						echo '<script>alert("图片地址数据不能为空!");</script>';
						$type = '软件截图';
						$localsource = 'option value="1" ';
						$outsid = 'option value="2" selected';
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
					if(document.getElementById('tableSelect').options.length < 1)
					{
						document.getElementById('Local_Data_1').style.display = '';
						document.getElementById('Local_Data_2').style.display = 'none';
						document.getElementById('outside_Data').style.display = '';
						document.getElementById('del').style.display = 'none';
						document.getElementById('add').style.display = '';
						document.getElementById('add').innerHTML = '新增';
					} else {
						document.getElementById('Local_Data_1').style.display = '';
						document.getElementById('Local_Data_2').style.display = 'none';
						document.getElementById('outside_Data').style.display = '';
						document.getElementById('del').style.display = '';
						document.getElementById('add').style.display = '';
						document.getElementById('add').innerHTML = '新增';
					}
			
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
	
function ImgView()
{
			$.ajax({
			url: 'imgview.php?m=softlogo&id='+<?php echo floatval($_GET['id']);?>,
			type: 'POST',
			dataType: 'json',
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
		$("#fileupload").wrap("<form id='myupload' action='upload.php?act=add&ifr=<?php echo $_GET['m'];?>&id=<?php echo floatval($_GET['id']);?>' method='post' enctype='multipart/form-data' style='margin-left:65px;margin-top:-25px'></form>");
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
					bar.width('0')
					files.html(data.message);
					$("#fileupload").show();
					progress.hide();
					files.show();
				}

			},
		});
		
	});
}); 
</script>
</head>
<body>
<div class="admin">
      <div id="line-big">
         	<form method="post" id="contact" action="#">
			<input type="hidden" name="action_type" id="data" value="<?php echo $_GET['m']; ?>">
			<input type="hidden" name="action_mode" id="mode" value="<?php echo $mode; ?>">
			<div class="form-group">
				<div class="label"><label>图片类型</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label style="color:green"><?php echo $type; ?></label></div>
				<div class="label" style="margin-top:10px"><label>链接方式</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><select name='type' style="width:70%;height:36px" id="SoftSource" onchange=Select()><<?php echo $localsource; ?>>本地源</option><<?php echo $outsid; ?>>网络源</option></select></label></div>
				<div class="label" style="margin-top:10px" id='Local_Data_1'><div style="width:50px" ondblclick=ImgView()>图片数据 <select name="tableSelect" size="10" id="tableSelect" class='select' style="width:200px;margin-left:65px;margin-top:-30px;"><?php echo $imglistdata; ?></select></div></div>
				<div class="label" style="margin-top:10px" id='outside_Data'><label>网络路径</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input name="size_data" type="text" tabindex="1" value="<?php echo $outside; ?>" style="width:70%"/></label></div>
				<div class="label" style="margin-top:10px" id='Local_Data_2'><label>上传文件</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input id="fileupload" type="file" name="mypic" style="width:200px"><div class="progress" style="display:none;margin-left:280px;margin-top:-25px"><span class="bar"></span><span class="percent">0%</span ></div><input type="hidden" id="file" class="type" name="mypic" value="file"><div id="showimg"></div><div class="files"></div></label></div>
			</div>
				    <div class="label"><label>操作</label></div>
					<button name="submit" type="submit"  value="add" id="add">新增</button>
					<button name="submit" type="submit"  value="del" id="del">删除</button>
         	</form>	
        </div>
</div>	
<script>
Select();
var selectlist = document.getElementById('SoftSource').options.selectedIndex;
var selectdata = '<?php echo $imglistdata; ?>';
var list = true;
</script>	
</body>

</html>