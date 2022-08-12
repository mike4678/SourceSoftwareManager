<?php 
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器

//初始化相关参数信息
if ($_SERVER["REQUEST_METHOD"] == "GET") {

	$dou->cookie("set", 'active');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	switch($_POST['Tab'])
	{
		case 'tab-system':
			$_POST['versionnumber'] = empty($_POST['versionnumber']) ? '' : $_POST['versionnumber'];	
			$_POST['Nversion'] = empty($_POST['Nversion']) ? '' : $_POST['Nversion'];
			$_POST['UpdateDownloadLink'] = empty($_POST['UpdateDownloadLink']) ? '' : $_POST['UpdateDownloadLink'];
			$_POST['Downloadlink'] = empty($_POST['Downloadlink']) ? '' : $_POST['Downloadlink'];
			$query = $dou -> select_all('zd_config');
			if( $dou->num_rows($query) > 0)
			{
				$sql = "UPDATE zd_config 
				  	   SET `AnnouncementContent`='".$_POST['AnnouncementContent']."',
					   `versionnumber`='".$_POST['versionnumber']."',
					   `Nversion`='".$_POST['Nversion']."',
					   `UpdateDownloadLink`='".$_POST['UpdateDownloadLink']."',
					   `Downloadlink`='".$_POST['Downloadlink']."'";
			} else {
				$sql = "Insert into zd_config (AnnouncementContent,versionnumber,Nversion,UpdateDownloadLink,Downloadlink) 
						VALUES ('".$_POST['AnnouncementContent']."','".$_POST['versionnumber']."','".$_POST['Nversion']."','".$_POST['UpdateDownloadLink']."','".$_POST['Downloadlink']."')";
			}
			if (!$dou->query($sql)) 
				{
					echo '<script language="JavaScript">SystemBox(3,"更新失败")</script>';
					} else {
						echo '<script language="JavaScript">SystemBox(3,"参数已更新！")</script>';
						$dou->cookie("set", 'active' );
					}
			break;
			
		default:
			$dou->cookie("set", 'active');
			break;
			
			
	}
}

//生成顶部选项夹
$data = array
(
"TabName"=>array("TabName"=>"软件管家设置"), //第一个为标题
		   array("Name"=>"基础设置","tab"=>'#tab-set',"active"=>$_COOKIE['set']) //往后的为选项夹

);

$dou->FormCreate($data);
?>
<script type="text/javascript" src="../js/jquery.form.js"></script>
<script language=javascript>   //文件上传处理
$(function () {
	var bar = $('.bar');
	var percent = $('.percent');
	var showimg = $('#showimg');
	var progress = $(".progress");
	var files = $(".files");
	var btn = $(".btn span");
	$181("#fileupload").wrap("<form id='myupload' action='system/upload.php?act=add&ifr=softlogo' method='post' enctype='multipart/form-data'></form>");
    $181("#fileupload").change(function(){
		$181("#myupload").ajaxSubmit({
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
					var img = "../images/"+data.pic;
					showimg.html("<input type='hidden' name='path' value='"+img+"'><img src='"+img+"'>");
					$("#fileupload").show();
					progress.hide();
					files.show();
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
      <div class="tab-content" id="myTabContent">
        <br />
        <div class="tab-panel fade in active" id="tab-set">
        	<form method="post" class="form-x" action="#">
        		<input type="hidden" value="tab-system" id="Tab" name="Tab">
				<div class="form-group">
                	<label>服务状态</label>
					<?php
					$fp = fsockopen("127.0.0.1", 7777, $errno, $errstr, 30);
					if (!$fp)
					{
						echo "<a style=\"font-color:red;\"> &nbsp&nbsp未运行</a>";
						
					}else{
						
						echo "<a style=\"font-color:green;\"> &nbsp&nbsp 正在运行</a>";
					}
					?>
                </div>
                <div class="form-group">
                    <label for="readme">软件公告</label>
                    	<textarea name="AnnouncementContent" cols="50" rows="5" class="form-control" id="AnnouncementContent" ><?php echo $dou->SInfo('AnnouncementContent'); ?></textarea>
                </div>
                    <label for="readme">软件主版本号</label>
					    <input type="text" class="form-control" id="versionnumber" name="versionnumber" size="50"  value=<?php echo $dou->SInfo('versionnumber'); ?> />
                </div>
                <div class="form-group">
					<label for="sitename">软件子版本号</label>
                    	<input type="text" class="form-control" id="Nversion" name="Nversion" size="50"  value=<?php echo $dou->SInfo('Nversion'); ?> />
                </div>
                <div class="form-group">
                    <label for="siteurl">更新服务器</label>
                    	<input type="text" class="form-control" id="UpdateDownloadLink" name="UpdateDownloadLink" size="50" value=<?php echo $dou->SInfo('UpdateDownloadLink'); ?>>
                </div>
                <div class="form-group">
                    <label for="readme">软件服务器</label>
						<input type="text" class="form-control" id="Downloadlink" name="Downloadlink" size="50" value=<?php echo $dou->SInfo('Downloadlink'); ?>>
                </div>
                <div class="form-group">
                    <label for="logo">软件Logo<br />(即时生效)</label>
            <input id="fileupload" type="file" name="mypic" class="form-control">
        <div class="progress" style="display:none;position:relative;top:5px;height:18px">
    		<span class="bar"></span><span class="percent">0%</span >
		</div>
        <div id="showimg"><iframe src="system/imgView.php?m=logosetting" style="weight:100px;height:100px"></iframe></div>
                    <div class="files"></div>
                </div>
				<div class="form-group">
                    <label for="readme">系统重置 &nbsp&nbsp&nbsp </label>
						<button class="btn btn-xs waves-effect waves-light" type="button" href='#' onclick="javascript:SystemBox(2,'system/reset.php','','系统重置')">立即重置</button>
                </div>
                <div><button class="btn btn-primary btn-sm waves-effect waves-light" type="submit" style="margin-top:30px;">提交</button></div>
            </form>
        </div>
        </div>
      </div>
    </div>
      