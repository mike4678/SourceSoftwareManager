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
			$sql = "UPDATE zd_config 
				  	   SET `AnnouncementContent`='".$_POST['AnnouncementContent']."',
					   `versionnumber`='".$_POST['versionnumber']."',
					   `Nversion`='".$_POST['Nversion']."',
					   `UpdateDownloadLink`='".$_POST['UpdateDownloadLink']."',
					   `Downloadlink`='".$_POST['Downloadlink']."'";
			
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
      <div class="tab-body">
        <br />
        <div class="tab-panel <?php echo $_COOKIE['set']; ?>" id="tab-set">
        	<form method="post" class="form-x" action="#">
        		<input type="hidden" value="tab-system" id="Tab" name="Tab">
				<div class="form-group">
                	<div class="label"><label>服务状态</label></div>
                	<div class="field" style="top:7px">
					<?php
					$fp = fsockopen("127.0.0.1", 7777, $errno, $errstr, 30);
					if (!$fp)
					{
						echo "未运行";
						
					}else{
						
						echo "正在运行";
					}
					?>
                    </div>
                </div>
                <div class="form-group">
                <div class="form-group">
                    <div class="label"><label for="readme">软件公告</label></div>
                    <div class="field">
                    	<textarea name="AnnouncementContent" cols="50" rows="5" class="input" id="AnnouncementContent" ><?php echo $dou->SInfo('AnnouncementContent'); ?></textarea>
                    </div>
                </div>
                    <div class="label"><label for="readme">软件主版本号</label></div>
                    <div class="field">
					    <input type="text" class="input" id="versionnumber" name="versionnumber" size="50"  value=<?php echo $dou->SInfo('versionnumber'); ?> />
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"><label for="sitename">软件子版本号</label></div>
                    <div class="field">
                    	<input type="text" class="input" id="Nversion" name="Nversion" size="50"  value=<?php echo $dou->SInfo('Nversion'); ?> />
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"><label for="siteurl">更新服务器</label></div>
                    <div class="field">
                    	<input type="text" class="input" id="UpdateDownloadLink" name="UpdateDownloadLink" size="50" value=<?php echo $dou->SInfo('UpdateDownloadLink'); ?>>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"><label for="readme">软件服务器</label></div>
                    <div class="field">
						<input type="text" class="input" id="Downloadlink" name="Downloadlink" size="50" value=<?php echo $dou->SInfo('Downloadlink'); ?>>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"><label for="logo">软件Logo<br />(即时生效)</label></div>
                    <div class="field">
            <input id="fileupload" type="file" name="mypic">
        <div class="progress" style="display:none;position:relative;top:5px;height:18px">
    		<span class="bar"></span><span class="percent">0%</span >
		</div>
        <div id="showimg"><iframe src="system/imgView.php?m=logosetting" style="weight:100px;height:100px"></iframe></div>
                    <div class="files"></div>

                    </div>
                </div>
				<div class="form-group">
                    <div class="label"><label for="readme">系统重置</label></div>
                    <div class="field">
						<button class="button" type="button" href='#' onclick="javascript:SystemBox(2,'system/reset.php','','系统重置')">立即重置</button>
                    </div>
                </div>
                <div class="form-button"><button class="button bg-main" type="submit" style="margin-top:30px;">提交</button></div>
            </form>
        </div>
        </div>
      </div>
    </div>
      