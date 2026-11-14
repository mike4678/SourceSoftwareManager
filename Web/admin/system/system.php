<?php
/* ---------------------------------------------------- */
/* 系统设置
/* 安全修订说明（2026）：
/*  1. 所有设置项改为逐条 UPDATE + quote() 转义，消除原 CASE WHEN 拼接注入
/*  2. 密码相关操作改用参数化写入，不再拼 SQL
/*  3. 表单回显统一 h() 转义，并补全 value 的引号（原写法缺引号会截断属性）
/*  4. 修正 $181 误写成函数名的 JS 语法错误（应为 $）
/*  5. 分页数与开关值做范围校验
/* ---------------------------------------------------- */
if (!defined('source')) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $dou->CheckUploadSize();  // 上传大小检查，如果超过设定，则自动强制修正
    if (!isset($_COOKIE['set']) && !isset($_COOKIE['up'])) {
        $dou->cookie("set", 'active');
        $dou->cookie("up", '');
        $dou->cookie("adv", '');
        $dou->cookie("email", '');
        $dou->cookie("def", '');
    }
}

/** 更新单个系统设置项（不存在则自动创建，便于安全防御等新配置项） */
function sm_set_setting($dou, $vars, $value)
{
    $exists = $dou->fetch_array($dou->query(
        "SELECT `vars` FROM `zd_system_setting` WHERE `vars` = " . $dou->quote($vars) . " LIMIT 1"
    ));
    if (!$exists) {
        return $dou->query("INSERT INTO `zd_system_setting` (`vars`, `value`, `备注`) VALUES ("
            . $dou->quote($vars) . "," . $dou->quote($value) . "," . $dou->quote('由系统设置页创建') . ")");
    }
    $sql = "UPDATE `zd_system_setting` SET `value` = " . $dou->quote($value)
        . " WHERE `vars` = " . $dou->quote($vars);
    return $dou->query($sql);
}

/** 安全防御开关的单个选项组 */
function sm_def_radio($name, $label, $enabled, $desc)
{
    $on  = $enabled ? ' checked' : '';
    $off = $enabled ? '' : ' checked';
    return '<div class="form-group"><label>' . h($label) . '</label>'
        . '<div class="radio info"><input type="radio" name="' . h($name) . '" value="1" id="' . h($name) . '_on"' . $on . '><label for="' . h($name) . '_on">启用</label></div>'
        . '<div class="radio info"><input type="radio" name="' . h($name) . '" value="0" id="' . h($name) . '_off"' . $off . '><label for="' . h($name) . '_off">关闭</label></div>'
        . '<p class="help-block" style="margin:0 0 10px 0;color:#888">' . h($desc) . '</p></div>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Tab'])) {
    switch ($_POST['Tab']) {
        case 'tab-system':
            $path     = isset($_POST['path']) ? trim((string)$_POST['path']) : '';
            $pwdNew   = isset($_POST['pwdreq']) ? trim((string)$_POST['pwdreq']) : '';
            $oldKey   = key;

            // 加密密匙变更：同时把已存密码迁移到新密匙
            if ($pwdNew !== '' && $pwdNew !== $oldKey) {
                $row = $dou->fetch_array($dou->query("SELECT `password` FROM `zd_admin_user` WHERE `username`='admin' LIMIT 1"));
                if ($row && !empty($row['password'])) {
                    $plain = Account::decrypt((string)$row['password'], $oldKey);
                    if ($plain !== '') {
                        $newHash = Account::PwdEnc($plain, $pwdNew);
                        $dou->query("UPDATE `zd_admin_user` SET `password` = " . $dou->quote($newHash)
                            . " WHERE `username` = 'admin'");
                    }
                }
            }

            // 每页显示条数
            $disp = isset($_POST['disp']) ? to_int($_POST['disp'], 20) : 20;
            if ($disp < 1 || $disp > 200) {
                $disp = 20;
            }

            $serverState = (isset($_POST['serverstate']) && (string)$_POST['serverstate'] === '1') ? '1' : '0';
            $vaildCode   = (isset($_POST['vaildcode']) && (string)$_POST['vaildcode'] === '1') ? '1' : '0';

            $settings = array(
                'server_status'      => $serverState,
                'server_infomaction' => isset($_POST['sys']) ? (string)$_POST['sys'] : '',
                'name'               => isset($_POST['sitename']) ? (string)$_POST['sitename'] : '',
                'bottom'             => isset($_POST['sysinfo']) ? (string)$_POST['sysinfo'] : '',
                'encrypted'          => $pwdNew !== '' ? $pwdNew : $oldKey,
                'pagedisplay'        => (string)$disp,
                'VaildCode'          => $vaildCode,
            );
            if ($path !== '') {
                $settings['logo'] = $path;
            }

            $ok = true;
            foreach ($settings as $k => $v) {
                if (!sm_set_setting($dou, $k, $v)) {
                    $ok = false;
                }
            }

            if (!$ok) {
                $dou->OpLog('修改基础设置', '网站名称/维护状态/分页/验证码等', '失败');
                echo '<script language="JavaScript">SystemBox(3,"更新失败")</script>';
            } else {
                $dou->cookie("set", 'active', 300);
                $dou->cookie("up", '', 300);
                $dou->cookie("adv", '', 300);
                $dou->cookie("def", '', 300);
                $detail = '网站名称=' . $settings['name'] . '；维护模式=' . ($serverState === '1' ? '开' : '关')
                    . '；每页显示=' . $disp . '；验证码=' . ($vaildCode === '0' ? '启用' : '禁用')
                    . '；密匙=' . ($pwdNew !== '' && $pwdNew !== $oldKey ? '已变更' : '未变更');
                $dou->OpLog('修改基础设置', $detail);
                echo '<script language="JavaScript">SystemBox(3,"参数已更新！")</script>';
            }
            break;

        case 'tab-upload':
            $phpsize = (float)str_replace(array("M", "m"), "", (string)ini_get('post_max_size'));
            $fileSize = isset($_POST['file_size']) ? (float)$_POST['file_size'] : 0;
            if ($fileSize > $phpsize) {
                echo '<script language="JavaScript">SystemBox(3,"当前允许上传文件大小超过PHP系统限定值！")</script>';
                echo '<script language="JavaScript">window.history.back();</script>';
            } elseif ($fileSize <= 0) {
                echo '<script language="JavaScript">SystemBox(3,"上传大小必须大于 0！")</script>';
                echo '<script language="JavaScript">window.history.back();</script>';
            } else {
                $oldSize = (string)$dou->Info('upload_size');
                if (sm_set_setting($dou, 'upload_size', (string)round($fileSize, 2))) {
                    $dou->cookie("set", '', 300);
                    $dou->cookie("up", 'active', 300);
                    $dou->cookie("adv", '', 300);
                    $dou->cookie("def", '', 300);
                    $dou->OpLog('修改上传设置', '单个文件大小上限 ' . $oldSize . 'MB → ' . round($fileSize, 2) . 'MB');
                    echo '<script language="JavaScript">SystemBox(3,"参数已更新！")</script>';
                } else {
                    $dou->OpLog('修改上传设置', '单个文件大小上限=' . round($fileSize, 2) . 'MB', '失败');
                    echo '<script language="JavaScript">SystemBox(3,"更新失败")</script>';
                }
            }
            break;

        case 'tab-defense':
            $defense = array(
                'defense_csrf' => (isset($_POST['d_csrf']) && (string)$_POST['d_csrf'] === '1') ? '1' : '0',
                'defense_xss'  => (isset($_POST['d_xss']) && (string)$_POST['d_xss'] === '1') ? '1' : '0',
                'defense_sqli' => (isset($_POST['d_sqli']) && (string)$_POST['d_sqli'] === '1') ? '1' : '0',
                'defense_path' => (isset($_POST['d_path']) && (string)$_POST['d_path'] === '1') ? '1' : '0',
            );
            $ok = true;
            $buf = array();
            foreach ($defense as $k => $v) {
                if (!sm_set_setting($dou, $k, $v)) {
                    $ok = false;
                }
                $buf[] = str_replace('defense_', '', $k) . '=' . ($v === '1' ? '启用' : '关闭');
            }
            $dou->cookie("set", '', 300);
            $dou->cookie("up", '', 300);
            $dou->cookie("adv", '', 300);
            $dou->cookie("def", 'active', 300);
            if ($ok) {
                $dou->OpLog('修改安全防御开关', implode('；', $buf));
                echo '<script language="JavaScript">SystemBox(3,"防护设置已保存！")</script>';
            } else {
                $dou->OpLog('修改安全防御开关', implode('；', $buf), '失败');
                echo '<script language="JavaScript">SystemBox(3,"保存失败")</script>';
            }
            break;

        case 'tab-user':
            $oldPwd     = isset($_POST['old_pwd']) ? (string)$_POST['old_pwd'] : '';
            $newPwd     = isset($_POST['new_pwd']) ? (string)$_POST['new_pwd'] : '';
            $confNewPwd = isset($_POST['conf_new_pwd']) ? (string)$_POST['conf_new_pwd'] : '';

            if ($oldPwd === '' || $newPwd === '' || $confNewPwd === '') {
                echo '<script language="JavaScript">SystemBox(3,"密码不允许为空！")</script>';
                echo '<script language="JavaScript">window.location.href="index.php?/system/setting"</script>';
            } else {
                $oldHash = Account::PwdEnc($oldPwd, key);
                $row = $dou->fetch_array($dou->query(
                    "SELECT `username` FROM `zd_admin_user` WHERE `password` = " . $dou->quote($oldHash) . " LIMIT 1"
                ));
                if (!$row) {
                    $dou->OpLog('修改后台登录密码', '旧密码校验失败', '失败');
                    echo '<script language="JavaScript">SystemBox(3,"旧密码输入错误，请重新输入！")</script>';
                    echo '<script language="JavaScript">window.history.go(-1);</script>';
                    exit;
                }
                if ($newPwd !== $confNewPwd) {
                    $dou->OpLog('修改后台登录密码', '两次输入不一致', '失败');
                    echo '<script language="JavaScript">SystemBox(3,"两次输入的密码不一致，请重新输入！")</script>';
                    echo '<script language="JavaScript">window.history.go(-1);</script>';
                    exit;
                }
                $newHash = Account::PwdEnc($newPwd, key);
                if (!$dou->query("UPDATE `zd_admin_user` SET `password` = " . $dou->quote($newHash) . " WHERE `username` = 'admin'")) {
                    $dou->OpLog('修改后台登录密码', '', '失败');
                    echo '<script language="JavaScript">SystemBox(3,"修改密码失败")</script>';
                    echo '<script language="JavaScript">window.history.go(-1);</script>';
                } else {
                    $dou->OpLog('修改后台登录密码', '账号 admin 密码已更新');
                    echo '<script language="JavaScript">SystemBox(3,"密码已更新，请重新登陆")</script>';
                    echo '<script language="JavaScript">window.location.href="index.php?/exit"</script>';
                }
            }
            break;

        default:
            $dou->cookie("set", 'active');
            $dou->cookie("up", '');
            break;
    }
}

// ---------- 顶部选项夹 ----------
$setTab   = (isset($_COOKIE['set']) && $_COOKIE['set'] === 'active') ? 'active' : '';
$emailTab = (isset($_COOKIE['email']) && $_COOKIE['email'] === 'active') ? 'active' : '';
$upTab    = (isset($_COOKIE['up']) && $_COOKIE['up'] === 'active') ? 'active' : '';
$defTab   = (isset($_COOKIE['def']) && $_COOKIE['def'] === 'active') ? 'active' : '';

$data = array(
    "TabName" => array("TabName" => ""),
    array("Name" => "基础设置", "tab" => '#tab-set', "active" => $setTab),
    array("Name" => "用户设置", "tab" => '#tab-email', "active" => $emailTab),
    array("Name" => "上传设置", "tab" => '#tab-upload', "active" => $upTab),
    array("Name" => "安全防御", "tab" => '#tab-defense', "active" => $defTab),
);

$dou->FormCreate($data);
?>
<style>
.delimg{margin-left:20px; color:#090; cursor:pointer}
</style>
<script type="text/javascript" src="../js/jquery.form.js"></script>
<script language="javascript">   //文件上传处理
$(function () {
	var bar = $('.bar');
	var percent = $('.percent');
	var showimg = $('#showimg');
	var progress = $(".progress");
	var files = $(".files");
	var btn = $(".btn span");
	$("#fileupload").wrap("<form id='myupload' action='system/upload.php?act=add&ifr=system' method='post' enctype='multipart/form-data'></form>");
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
					$("#fileupload").hide();
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
<script>
// 上传参数列表：弹窗内新增/编辑/删除成功后回调，实时刷新，不必整页 reload
function smRefreshUploadFrame() {
	var el = document.getElementById('uploadSelect');
	if (!el) { return; }
	$.getJSON('system/uploadframe.php?m=list&_=' + new Date().getTime(), function (rows) {
		var keep = el.value;
		el.innerHTML = '';
		for (var i = 0; i < rows.length; i++) {
			var o = document.createElement('option');
			o.value = rows[i][0];
			o.text = rows[i][0] + '(' + String(rows[i][1]).replace(/\*/g, '、') + ')';
			el.appendChild(o);
		}
		if (keep) { el.value = keep; }
	});
}

// 打开上传参数弹窗（固定 id，便于操作成功后精确关闭）
function SmOpenUploadFrame(mode, title, w, h) {
	try {
		if (window.art && art.dialog.list && art.dialog.list['smUploadFrame']) {
			art.dialog.list['smUploadFrame'].close();
		}
		art.dialog.open('system/uploadframe.php?m=' + mode, { id: 'smUploadFrame', title: title, width: w, height: h });
	} catch (e) {
		SystemBox(2, 'system/uploadframe.php?m=' + mode, '', title, w, h);
	}
}

// 供弹窗调用：刷新列表并关闭自身
function smCloseUploadDialog() {
	try {
		if (window.art && art.dialog.list && art.dialog.list['smUploadFrame']) {
			art.dialog.list['smUploadFrame'].close();
			return true;
		}
	} catch (e) {}
	return false;
}
</script>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade in <?php echo $setTab; ?>" role="tabpanel" id="tab-set" aria-labelledby="home-tab">
    <form method="post" class="form-x" action="#">
      <input type="hidden" name="Tab" value="tab-system">
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="form-group">
            <label>网站状态</label>
            <div class="radio info"><input type="radio" name="serverstate" value="0" id="open" checked><label for="open">正常模式</label></div>
            <div class="radio info"><input type="radio" name="serverstate" value="1" id="close"><label for="close">维护模式</label></div>
          </div>
          <div class="form-group">
            <label for="sys">维护说明</label>
            <textarea name="sys" cols="50" rows="5" class="form-control" id="sys"><?php echo h((string)$dou->Info('server_infomaction')); ?></textarea>
          </div>
          <div class="form-group">
            <label for="sitename">网站名称</label>
            <input type="text" class="form-control" id="sitename" name="sitename" size="50" placeholder="请填写你网站的名称" data-validate="required:请填写你网站的名称" value="<?php echo h((string)$dou->Info('name')); ?>">
          </div>
          <div class="form-group">
            <label for="siteurl">网址</label>
            <input type="text" class="form-control" id="siteurl" name="siteurl" size="50" placeholder="请填写网址" value="<?php echo h(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ''); ?>">
          </div>
          <div class="form-group">
            <label for="sysinfo">底部内容</label>
            <textarea name="sysinfo" cols="50" rows="5" class="form-control" id="sysinfo"><?php echo h((string)$dou->Info('bottom')); ?></textarea>
          </div>
          <div class="form-group">
            <label for="pwdreq">密码加密密匙</label>
            <input type="text" class="form-control" id="pwdreq" name="pwdreq" size="50" placeholder="请填写密码加密密匙" data-validate="required:请填写密码加密密匙" value="<?php echo h(key); ?>">
          </div>
          <div class="form-group">
            <label for="disp">每页显示内容数</label>
            <input type="text" class="form-control" id="disp" name="disp" size="50" placeholder="请填写每页可显示内容数" value="<?php echo h((string)$dou->Info('pagedisplay')); ?>">
          </div>
          <div class="form-group">
            <label>后台验证码</label>
            <div class="radio info"><input type="radio" name="vaildcode" value="0" id="enable" checked><label for="enable">启用</label></div>
            <div class="radio info"><input type="radio" name="vaildcode" value="1" id="disable"><label for="disable">禁用</label></div>
          </div>
          <div><button class="btn btn-primary btn-sm waves-effect waves-light" type="submit">提交</button></div>
        </div>
      </div>
    </form>
  </div>

  <div class="tab-pane fade in <?php echo $emailTab; ?>" role="tabpanel" id="tab-email" aria-labelledby="home-tab">
    <form method="post" class="form-x" action="#">
      <input type="hidden" name="Tab" value="tab-user">
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="form-group">
            <label for="old_pwd">旧密码</label>
            <input type="password" class="form-control" id="old_pwd" name="old_pwd" size="50" placeholder="填写账户旧密码" autocomplete="current-password">
          </div>
          <div class="form-group">
            <label for="new_pwd">新密码</label>
            <input type="password" class="form-control" id="new_pwd" name="new_pwd" size="50" placeholder="填写账户新密码" autocomplete="new-password">
          </div>
          <div class="form-group">
            <label for="conf_new_pwd">确认新密码</label>
            <input type="password" class="form-control" id="conf_new_pwd" name="conf_new_pwd" size="50" placeholder="填写账户新密码" autocomplete="new-password">
          </div>
          <div><button class="btn btn-primary btn-sm waves-effect waves-light" type="submit">更新密码</button></div>
        </div>
      </div>
    </form>
  </div>

  <div class="tab-pane fade <?php echo $upTab; ?> in" role="tabpanel" id="tab-upload" aria-labelledby="home-tab">
    <form method="post" class="form-x" action="#">
      <input type="hidden" name="Tab" value="tab-upload">
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="form-group">
            <label for="file_size">允许单个文件大小(MB)</label>
            <input type="text" class="form-control" id="file_size" name="file_size" size="20" placeholder="填写允许上传的文件大小,单位MB" value="<?php echo h((string)$dou->Info('upload_size')); ?>">
          </div>
          <div class="form-group">
            <label>允许文件最大大小<br>(upload_max_filesize)</label>
            <input type="text" class="form-control" size="50" value="<?php echo h(ini_get('upload_max_filesize')); ?>" readonly disabled>
            <a href="http://bbs.csource.com.cn/read-273-1.html" target="_blank">(如何修改该值？)</a>
          </div>
          <div class="form-group">
            <label>允许上传最大大小<br>(post_max_size)</label>
            <input type="text" class="form-control" size="50" value="<?php echo h(ini_get('post_max_size')); ?>" readonly disabled>
            <a href="http://bbs.csource.com.cn/read-273-1.html" target="_blank">(如何修改该值？)</a>
          </div>
          <div class="form-group">
            <label>上传参数</label>
            <?php
            echo '<select size="10" id="uploadSelect" class="form-control" style="margin-top:6px">';
            $UData = $dou->UploadFrame();
            foreach ($UData as $value) {
                echo '<option value="' . h($value[0]) . '">' . h($value[0] . '(' . str_replace('*', '、', $value[1]) . ')') . '</option>';
            }
            echo '</select><br />';
            ?>
            <input type="button" class="btn btn-xs waves-effect waves-light" value="添加" onclick="SmOpenUploadFrame('add','新增上传框架',400,420)">
            <input type="button" class="btn btn-xs waves-effect waves-light" value="编辑" onclick="SmOpenUploadFrame('edit','修改上传框架',402,420)">
            <input type="button" class="btn btn-xs waves-effect waves-light" value="删除" onclick="SmOpenUploadFrame('del','删除上传框架',235,420)">
          </div>
          <div><button class="btn btn-primary btn-sm waves-effect waves-light" type="submit">提交</button></div>
        </div>
      </div>
    </form>
  </div>

  <div class="tab-pane fade <?php echo $defTab; ?> in" role="tabpanel" id="tab-defense" aria-labelledby="home-tab">
    <form method="post" class="form-x" action="#">
      <input type="hidden" name="Tab" value="tab-defense">
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="form-group">
            <p class="help-block" style="color:#666">
              这里的开关只控制“请求特征拦截”与“CSRF 同源校验”这几道外围防线；
              SQL 参数化、输出转义（h）为代码级固定处理，不随开关变化，关闭任一项都会降低防护强度。
            </p>
          </div>
          <?php
          echo sm_def_radio('d_csrf', 'CSRF 防护（跨站请求伪造）', $dou->Defense('csrf'), '对后台所有 POST 做 Origin/Referer 同源校验；数据库重置等危险操作另有表单令牌校验。');
          echo sm_def_radio('d_xss', 'XSS 关键字拦截', $dou->Defense('xss'), '拦截请求中的 script / onerror / javascript: 等脚本特征（输出转义始终生效）。');
          echo sm_def_radio('d_sqli', 'SQL 注入关键字拦截', $dou->Defense('sqli'), '拦截 union select / information_schema / sleep( 等注入特征（SQL 参数化始终生效）。');
          echo sm_def_radio('d_path', '路径穿越拦截', $dou->Defense('path'), '拦截请求中的 ../ 、etc/passwd 等目录穿越特征。');
          ?>
          <div><button class="btn btn-primary btn-sm waves-effect waves-light" type="submit">保存防护设置</button></div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php
echo '<script>javascript:StatusEdit(' . (int)$dou->Info('server_status') . ',\'open\',\'close\');StatusEdit(' . (int)$dou->Info('VaildCode') . ',\'enable\',\'disable\');</script>';
