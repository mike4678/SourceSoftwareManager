<?php
/* ---------------------------------------------------- */
/* 软件分类管理
/* 安全修订说明（2026）：
/*  1. 分类的增/改/删改用 quote() 转义，原代码 urldecode 后直拼 SQL 可注入
/*  2. 列表与输入框回显统一 h() 转义，消除存储型 XSS
/*  3. 修正 <<?php 造成的多余 < 与未初始化变量
/*  4. 未登录直接中断
/* ---------------------------------------------------- */
require("../../kernl/Init.php");

if (!defined('source')) {
    header("Location: ../login.php");
    exit;
}

$dou->FormCheck();

$DataValue    = "div class='form-group' style='display:none'";
$ControlValue = "div class=\"form-group\" style=\"text-align:center\"";
$oldType      = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submit = isset($_POST['submit']) ? (string)$_POST['submit'] : '';
    $selected = isset($_POST['tableSelect']) ? trim(urldecode((string)$_POST['tableSelect'])) : '';

    switch ($submit) {
        case 'add':
            $DataValue    = "div class='form-group'";
            $ControlValue = "div class=\"form-group\" style='display:none'";
            break;

        case 'edit':
            if ($selected === '') {
                echo '<script language="JavaScript">window.alert("未选择需要修改的分类名称！")</script>';
            } else {
                $DataValue    = "div class='form-group'";
                $ControlValue = "div class=\"form-group\" style='display:none'";
                $oldType      = $selected;
            }
            break;

        case 'del':
            if ($selected === '') {
                echo '<script language="JavaScript">window.alert("未选择需要删除的分类名称！")</script>';
                break;
            }
            $sql = "DELETE FROM `zd_type` WHERE `type` = " . $dou->quote($selected);
            if (!$dou->query($sql)) {
                echo '<script language="JavaScript">window.alert("删除失败！")</script>';
            } else {
                echo '<script language="JavaScript">self.location=document.referrer;</script>';
            }
            break;

        case 'success':
            $actionType = isset($_POST['action_type']) ? (string)$_POST['action_type'] : '';
            $typeData   = isset($_POST['type_data']) ? trim(urldecode((string)$_POST['type_data'])) : '';
            if ($typeData === '' || !in_array($actionType, array('add', 'edit'), true)) {
                echo '<script language="JavaScript">window.alert("参数异常！")</script>';
                $DataValue    = "div class='form-group'";
                $ControlValue = "div class=\"form-group\" style='display:none'";
                break;
            }
            if (mb_strlen($typeData, 'UTF-8') > 30) {
                echo '<script language="JavaScript">window.alert("分类名称过长！")</script>';
                break;
            }
            if ($actionType === 'add') {
                $sql = "INSERT INTO `zd_type` (`type`) VALUES (" . $dou->quote($typeData) . ")";
            } else {
                $old = isset($_POST['old_type']) ? trim(urldecode((string)$_POST['old_type'])) : '';
                $sql = "UPDATE `zd_type` SET `type` = " . $dou->quote($typeData)
                    . " WHERE `type` = " . $dou->quote($old);
            }
            if (!$dou->query($sql)) {
                echo '<script language="JavaScript">window.alert("操作失败！")</script>';
            } else {
                echo '<script language="JavaScript">self.location=document.referrer;</script>';
            }
            break;

        case 'cancel':
            $DataValue    = "div class='form-group' style='display:none'";
            $ControlValue = "div class=\"form-group\" style=\"text-align:center\"";
            break;
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
</head>
<body><div id="row">
      <div id="box-content">
         	<form method="post" id="contact" action="#">
			<input type="hidden" name="action_type" value="<?php echo h(isset($_POST['submit']) ? $_POST['submit'] : ''); ?>">
			<input type="hidden" name="old_type" value="<?php echo h($oldType); ?>">
			<h4 class="box-title" style="text-align:center">软件分类列表</h4>
                <div class="form-group">
                        <select name="tableSelect" size="10" id="tableSelect" class="form-control">
           				 <?php
						$UData = $dou->fetch_array_all('zd_type');
						foreach ($UData as $value) {
						    $t = isset($value['type']) ? (string)$value['type'] : '';
						    if ($t === '') {
						        continue;
						    }
						    echo '<option value="' . h($t) . '">' . h($t) . '</option>';
						}
						?>
            			</select>
                </div>
				<<?php echo $DataValue; ?>>
					<div class="form-group">
					<label for="sitename" name="Address">分类名称</label>
					<input name="type_data" class="form-control" type="text" tabindex="1" value="<?php echo h($oldType); ?>"/>
					</div>
					<div class="form-group" style="text-align:center">
					<button name="submit" type="submit" class="btn btn-xs waves-effect waves-light" value="success">确定</button>
					<button name="submit" type="submit" class="btn btn-xs waves-effect waves-light" value="cancel">取消</button>
					</div>
				</div>
				<<?php echo $ControlValue; ?>>
					<button name="submit" type="submit" class="btn btn-xs waves-effect waves-light" value="add">新增</button>
					<button name="submit" type="submit" class="btn btn-xs waves-effect waves-light" value="edit">编辑</button>
					<button name="submit" type="submit" class="btn btn-xs waves-effect waves-light" value="del">删除</button>
				</div>
         	</form>
        </div></div>
</body>
</html>
