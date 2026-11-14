<?php
/* ---------------------------------------------------- */
/* 软件管家设置（更新公告 / 版本号 / 更新服务器 / Logo）
/* 安全修订说明（2026）：
/*  1. UPDATE / INSERT 全部改为 quote() 转义，消除公告内容等字段的注入
/*  2. 回显统一 h() 转义，并在 value 属性上补齐引号
/*  3. fsockopen 连接本机端口改为短超时并抑制告警，避免页面卡死
/*  4. 系统重置改为 POST + CSRF 令牌的独立表单，不再用 GET 直接触发
/* ---------------------------------------------------- */
if (!defined('source')) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $dou->cookie("set", 'active');
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Tab'])) {
    switch ($_POST['Tab']) {
        case 'tab-system':
            $fields = array(
                'AnnouncementContent' => isset($_POST['AnnouncementContent']) ? (string)$_POST['AnnouncementContent'] : '',
                'versionnumber'       => isset($_POST['versionnumber']) ? (string)$_POST['versionnumber'] : '',
                'Nversion'            => isset($_POST['Nversion']) ? (string)$_POST['Nversion'] : '',
                'UpdateDownloadLink'  => isset($_POST['UpdateDownloadLink']) ? (string)$_POST['UpdateDownloadLink'] : '',
                'Downloadlink'        => isset($_POST['Downloadlink']) ? (string)$_POST['Downloadlink'] : '',
            );

            $query = $dou->select_all('zd_config');
            if ($dou->num_rows($query) > 0) {
                $sets = array();
                foreach ($fields as $k => $v) {
                    $sets[] = "`" . $k . "` = " . $dou->quote($v);
                }
                $sql = "UPDATE `zd_config` SET " . implode(', ', $sets);
            } else {
                $vals = array();
                foreach ($fields as $v) {
                    $vals[] = $dou->quote($v);
                }
                $sql = "INSERT INTO `zd_config` (`" . implode('`,`', array_keys($fields)) . "`) VALUES (" . implode(',', $vals) . ")";
            }

            if (!$dou->query($sql)) {
                $dou->OpLog('修改软件管家设置', '公告/版本号/下载链接', '失败');
                echo '<script language="JavaScript">SystemBox(3,"更新失败")</script>';
            } else {
                $dou->OpLog('修改软件管家设置', '公告/版本号/下载链接 已更新');
                echo '<script language="JavaScript">SystemBox(3,"参数已更新！")</script>';
                $dou->cookie("set", 'active');
            }
            break;

        default:
            $dou->cookie("set", 'active');
            break;
    }
}

$data = array(
    "TabName" => array("TabName" => "软件管家设置"),
    array("Name" => "基础设置", "tab" => '#tab-set', "active" => (isset($_COOKIE['set']) && $_COOKIE['set'] === 'active') ? 'active' : ''),
);
$dou->FormCreate($data);
?>
<script type="text/javascript" src="../js/jquery.form.js"></script>
<script language="javascript">   //文件上传处理
$(function () {
	var bar = $('.bar');
	var percent = $('.percent');
	var showimg = $('#showimg');
	var progress = $(".progress");
	var files = $(".files");
	var btn = $(".btn span");
	$("#fileupload").wrap("<form id='myupload' action='system/upload.php?act=add&ifr=softlogo' method='post' enctype='multipart/form-data'></form>");
    $("#fileupload").change(function(){
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
					var img = "../images/" + data.pic;
					showimg.html($("<input type='hidden' name='path'>").val(img).after($('<img>').attr('src', img)));
					$("#fileupload").show();
					progress.hide();
					files.hide();
				} else {
					btn.html("上传失败");
					bar.width('0');
					files.html($('<span>').text(data.message));
				}
			}
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
					$fp = @fsockopen("127.0.0.1", 7777, $errno, $errstr, 1);
					if (!$fp) {
					    echo '<a style="color:#c00;"> &nbsp;&nbsp;未运行</a>';
					} else {
					    echo '<a style="color:#090;"> &nbsp;&nbsp;正在运行</a>';
					    fclose($fp);
					}
					?>
                </div>
                <div class="form-group">
                    <label for="readme">软件公告</label>
                    <textarea name="AnnouncementContent" cols="50" rows="5" class="form-control" id="AnnouncementContent"><?php echo h((string)$dou->SInfo('AnnouncementContent')); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="versionnumber">软件主版本号</label>
                    <input type="text" class="form-control" id="versionnumber" name="versionnumber" size="50" value="<?php echo h((string)$dou->SInfo('versionnumber')); ?>" />
                </div>
                <div class="form-group">
                    <label for="Nversion">软件子版本号</label>
                    <input type="text" class="form-control" id="Nversion" name="Nversion" size="50" value="<?php echo h((string)$dou->SInfo('Nversion')); ?>" />
                </div>
                <div class="form-group">
                    <label for="UpdateDownloadLink">更新服务器</label>
                    <input type="text" class="form-control" id="UpdateDownloadLink" name="UpdateDownloadLink" size="50" value="<?php echo h((string)$dou->SInfo('UpdateDownloadLink')); ?>">
                </div>
                <div class="form-group">
                    <label for="Downloadlink">软件服务器</label>
                    <input type="text" class="form-control" id="Downloadlink" name="Downloadlink" size="50" value="<?php echo h((string)$dou->SInfo('Downloadlink')); ?>">
                </div>
                <div class="form-group">
                    <label for="logo">软件Logo<br />(即时生效)</label>
                    <input id="fileupload" type="file" name="mypic" class="form-control">
                    <div class="progress" style="display:none;position:relative;top:5px;height:18px"><span class="bar"></span><span class="percent">0%</span></div>
                    <div id="showimg"><iframe src="system/imgview.php?m=logosetting" style="width:100px;height:100px;border:0"></iframe></div>
                    <div class="files"></div>
                </div>
                <div><button class="btn btn-primary btn-sm waves-effect waves-light" type="submit" style="margin-top:30px;">提交</button></div>
            </form>

            <form method="post" action="system/reset.php" onsubmit="return confirm('系统重置会清空软件、分类、反馈与配置数据（含网站 Logo），且不可恢复，确定继续？');">
                <?php echo sm_csrf_field(); ?>
                <div class="form-group">
                    <label>系统重置 &nbsp;&nbsp;&nbsp;</label>
                    <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit">立即重置</button>
                </div>
            </form>
        </div>
      </div>
</div>
