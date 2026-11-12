<?php
/* ---------------------------------------------------- */
/* 软件分类管理
/* 安全修订说明（2026）：
/*  1. 分类的增/改/删改用 quote() 转义，原代码 urldecode 后直拼 SQL 可注入
/*  2. 列表与输入框回显统一 h() 转义，消除存储型 XSS
/*  3. 修正 <<?php 造成的多余 < 与未初始化变量
/*  4. 未登录直接中断
/*  5. 【本轮修复】增加重名校验：新增/改名时若已存在同名分类则拒绝，
/*     避免出现同名分类；删除与改名改为按主键 uid 定位，
/*     原实现 DELETE ... WHERE type='名称' 会把所有同名分类一起删掉。
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
$oldUid       = 0;
$notice       = '';

/* 取单条分类（按 uid） */
function sm_type_by_uid($dou, $uid)
{
    $uid = to_int($uid, 0);
    if ($uid <= 0) {
        return null;
    }
    $row = $dou->fetch_array($dou->query("SELECT `uid`,`type` FROM `zd_type` WHERE `uid` = " . $uid . " LIMIT 1"));
    return empty($row) ? null : $row;
}

/* 判断同名分类是否已存在（$exceptUid 为改名时的自身 uid） */
function sm_type_exists($dou, $type, $exceptUid = 0)
{
    $type = trim($type);
    if ($type === '') {
        return false;
    }
    $row = $dou->fetch_array($dou->query("SELECT `uid` FROM `zd_type` WHERE `type` = " . $dou->quote($type) . " LIMIT 1"));
    if (empty($row)) {
        return false;
    }
    return !($exceptUid > 0 && (int)$row['uid'] === (int)$exceptUid);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submit   = isset($_POST['submit']) ? (string)$_POST['submit'] : '';
    $selected = isset($_POST['tableSelect']) ? to_int($_POST['tableSelect'], 0) : 0;

    switch ($submit) {
        case 'add':
            $DataValue    = "div class='form-group'";
            $ControlValue = "div class=\"form-group\" style='display:none'";
            break;

        case 'edit':
            if ($selected <= 0) {
                echo '<script language="JavaScript">window.alert("未选择需要修改的分类名称！")</script>';
            } else {
                $row = sm_type_by_uid($dou, $selected);
                if ($row === null) {
                    echo '<script language="JavaScript">window.alert("该分类不存在，可能已被删除！")</script>';
                } else {
                    $DataValue    = "div class='form-group'";
                    $ControlValue = "div class=\"form-group\" style='display:none'";
                    $oldType      = (string)$row['type'];
                    $oldUid       = (int)$row['uid'];
                }
            }
            break;

        case 'del':
            if ($selected <= 0) {
                echo '<script language="JavaScript">window.alert("未选择需要删除的分类名称！")</script>';
                break;
            }
            if (sm_type_by_uid($dou, $selected) === null) {
                echo '<script language="JavaScript">window.alert("该分类不存在，可能已被删除！")</script>';
                break;
            }
            // 按主键删除，避免同名分类被一起删掉
            $sql = "DELETE FROM `zd_type` WHERE `uid` = " . $selected;
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
                $DataValue    = "div class='form-group'";
                $ControlValue = "div class=\"form-group\" style='display:none'";
                break;
            }

            if ($actionType === 'add') {
                if (sm_type_exists($dou, $typeData, 0)) {
                    echo '<script language="JavaScript">window.alert("分类“' . js_text($typeData) . '”已存在，不能重复添加！")</script>';
                    $DataValue    = "div class='form-group'";
                    $ControlValue = "div class=\"form-group\" style='display:none'";
                    $oldType      = $typeData;
                    break;
                }
                $sql = "INSERT INTO `zd_type` (`type`,`application`) VALUES ("
                    . $dou->quote($typeData) . ",'pc')";
            } else {
                $oldU = isset($_POST['old_uid']) ? to_int($_POST['old_uid'], 0) : 0;
                $row  = sm_type_by_uid($dou, $oldU);
                if ($row === null) {
                    echo '<script language="JavaScript">window.alert("该分类不存在，可能已被删除！")</script>';
                    break;
                }
                if (sm_type_exists($dou, $typeData, $oldU)) {
                    echo '<script language="JavaScript">window.alert("分类“' . js_text($typeData) . '”已存在，不能重名！")</script>';
                    $DataValue    = "div class='form-group'";
                    $ControlValue = "div class=\"form-group\" style='display:none'";
                    $oldType      = (string)$row['type'];
                    $oldUid       = (int)$row['uid'];
                    break;
                }
                $sql = "UPDATE `zd_type` SET `type` = " . $dou->quote($typeData)
                    . " WHERE `uid` = " . (int)$row['uid'];
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
			<input type="hidden" name="old_uid" value="<?php echo (int)$oldUid; ?>">
			<h4 class="box-title" style="text-align:center">软件分类列表</h4>
                <div class="form-group">
                        <select name="tableSelect" size="10" id="tableSelect" class="form-control">
           				 <?php
						$UData = $dou->fetch_array_all('zd_type');
						foreach ($UData as $value) {
						    $t   = isset($value['type']) ? (string)$value['type'] : '';
						    $uid = isset($value['uid']) ? (int)$value['uid'] : 0;
						    if ($t === '' || $uid <= 0) {
						        continue;
						    }
						    // 选项值用主键 uid，显示文字为分类名，避免同名时无法区分
						    echo '<option value="' . $uid . '">' . h($t) . '</option>';
						}
						?>
            			</select>
                </div>
				<<?php echo $DataValue; ?>>
					<div class="form-group">
					<label for="sitename" name="Address">分类名称</label>
					<input name="type_data" class="form-control" type="text" tabindex="1" maxlength="30" value="<?php echo h($oldType); ?>"/>
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
