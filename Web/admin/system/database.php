<?php
/* ---------------------------------------------------- */
/* 数据库备份管理
/* 安全修订说明（2026）：
/*  1. 备份列表改为 glob 只取 *.sql 文件（原 readdir 会把任意文件列出来）
/*  2. 文件名输出统一 h() 转义，避免备份文件被写入特殊字符后形成 XSS
/*  3. 恢复/清空数据库前增加二次确认，避免误点一击清库
/* ---------------------------------------------------- */
if (!defined('source')) {
    header("Location: ../login.php");
    exit;
}

$data = array(
    "TabName" => array("TabName" => "数据库设置"),
    array("Name" => "数据库备份管理", "tab" => '#tab-set', "active" => 'active'),
);
$dou->FormCreate($data);
?>
      <div class="tab-content" id="myTabContent">
        <br />
        <div class="tab-pane fade in active" id="tab-set">
        	<form method="post" class="form-x" action="#">
            <div class="form-group">
                        <div class="button-group button-group-small radio">
                        <select name="tableSelect" size="10" id="tableSelect" class='form-control' style="margin-top:6px">
            <?php
			$backupDir = ROOT_PATH . 'admin/backup';
			if (!is_dir($backupDir)) {
			    @mkdir($backupDir, 0755, true);
			    echo '<option value="">第一次使用请先备份数据</option>';
			} else {
			    $files = glob($backupDir . '/*.sql');
			    $files = is_array($files) ? $files : array();
			    $names = array();
			    foreach ($files as $f) {
			        $base = basename($f);
			        if (preg_match('/^[A-Za-z0-9_\-\.]{1,120}$/', $base)) {
			            $names[] = $base;
			        }
			    }
			    rsort($names);
			    if (!empty($names)) {
			        foreach ($names as $a) {
			            echo '<option value="' . h($a) . '">' . h($a) . '</option>';
			        }
			    } else {
			        echo '<option value="">无可用备份数据</option>';
			    }
			}
			?>
            </select></div>
                </div>
				<div class="form-group" >
                       <input name="databasebak" type="button" class="btn btn-xs waves-effect waves-light" value="备份数据库" onclick="javascript:DatabaseControl(this);"/>&nbsp;&nbsp;<input name="databasebak" type="button" class="btn btn-xs waves-effect waves-light" value="恢复数据库" onclick="javascript:DatabaseControl(this);"/>&nbsp;&nbsp;<input name="databasebak" type="button" class="btn btn-xs waves-effect waves-light" value="清空数据库" onclick="javascript:DatabaseControl(this);"/>&nbsp;&nbsp;<input name="databasebak" type="button" class="btn btn-xs waves-effect waves-light" value="删除备份" onclick="javascript:DatabaseControl(this);"/>&nbsp;&nbsp;<input name="databasebak" type="button" class="btn btn-xs waves-effect waves-light" value="下载备份" onclick="javascript:DatabaseControl(this);" style="display:none"/>
                </div>
        </div>
      </div>
</form>
<script>
function DatabaseControl(el)
{
	var control = $(el).val();
	var name = $('#tableSelect').val();
	var confirmFlag = '0';
	if (control === '恢复数据库') {
		if (!confirm('恢复数据库会先删除所有现有数据表再导入备份，确定继续？')) { return; }
		confirmFlag = '1';
	}
	if (control === '清空数据库') {
		if (!confirm('确定要清空指定数据表？此操作不可恢复！')) { return; }
		confirmFlag = '1';
	}
	if ((control === '恢复数据库' || control === '删除备份' || control === '下载备份') && !name) {
		SystemBox(3, '请先选择一个备份文件');
		return;
	}
	$.ajax({
			url: 'system/databasecontrol.php',
			type: 'POST',
			dataType: 'json',
			data: {control: control, filename: name, confirm: confirmFlag},
			success: function(res)
			{
				var code = res.status;
				var message = res.message;
				if (code == 99) {
					SystemBox(2, 'index.php?/downbackup', '', '', '', '', '100');
					return;
				}
				SystemBox(3, message, '', '', '', '', 30);
				if (code == 0) {
					setTimeout(function(){ history.go(0); }, 300);
				}
			}
		});
}

</script>
