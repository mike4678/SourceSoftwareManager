<?php 
require("../../kernl/Init.php"); 
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器

//判断是否在框架内，防止跨域
$dou -> FormCheck();

//初始化相关参数信息
if ($_SERVER["REQUEST_METHOD"] == "GET") 
{
	$DataValue = "div class='form-group' style='display:none'";
	$ControlValue = "div class=\"form-group\" style=\"text-align:center\"" ;

}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	switch($_POST['submit'])
	{
		case 'add':
			$DataValue = "div class='form-group'";
			$ControlValue = "div class=\"form-group\" style='display:none'";
			break;
		
		case 'edit':
			if($_POST['tableSelect'] == NULL)
			{
				$DataValue = "div class='form-group' style='display:none'";
				$ControlValue = "div class=\"form-group\" style=\"text-align:center\"";
				echo '<script language="JavaScript">window.alert("未选择需要修改的分类名称！")</script>';
				break;
				
			} else {
			
				$DataValue = "div class='form-group'";
				$ControlValue = "div class=\"form-group\" style='display:none'";
				break;
			}
	
		case 'del':
			if($_POST['tableSelect'] == NULL)
			{
				$DataValue = "div class='form-group' style='display:none'";
				$ControlValue = "div class=\"form-group\" style=\"text-align:center\"";
				echo '<script language="JavaScript">window.alert("未选择需要删除的分类名称！")</script>';
				break;
				
			} else {
				$url = urldecode($_POST['tableSelect']);
				$sql = "delete from zd_type where type = '" .$url. "';";
				if (!$dou->query($sql)) 
				{
   					echo '<script language="JavaScript">window.alert("删除失败！")</script>';
					$DataValue = "div class='form-group' style='display:none'";
				    $ControlValue = "div class=\"form-group\" style=\"text-align:center\"";
     			}
    			echo '<script language="JavaScript">self.location=document.referrer;</script>';
				break;
			}
			break;
			
		case 'success':
			if($_POST['action_type'] == NULL || $_POST['type_data'] == NULL)
			{
				echo '<script language="JavaScript">window.alert("参数异常！")</script>';
				$DataValue = "div class='form-group' ";
				$ControlValue = "div class=\"form-group\" style='display:none'";
			} else {
				switch ($_POST['action_type'])
				{
					case 'add':
					$url = urldecode($_POST['type_data']);
					$sql = "insert into `zd_type` (`type`) VALUES ('" .$url. "');";
					if (!$dou->query($sql)) 
					{
						echo '<script language="JavaScript">window.alert("新增失败！")</script>';
						$DataValue = "div class='form-group' style='display:none'";
						$ControlValue = "div class=\"form-group\" style=\"text-align:center\"";
					}
					echo '<script language="JavaScript">self.location=document.referrer;</script>';
					break;
					
					case 'edit':
					$url = urldecode($_POST['type_data']);
					$sql = "UPDATE zd_type 
							SET `Type`='".$url."' Where `Type`='".urldecode($_POST['old_type']). "'";
					if (!$dou->query($sql)) 
					{
						echo '<script language="JavaScript">window.alert("修改失败！")</script>';
						$DataValue = "div class='form-group' style='display:none'";
						$ControlValue = "div class=\"form-group\" style=\"text-align:center\"";
					}
					echo '<script language="JavaScript">self.location=document.referrer;</script>';
					
					break;
				
				}
			}
			break;	
			
		case 'cancel':
			$DataValue = "div class='Frame' style='display:none'";
			$ControlValue = "div class=\"form-group\" style=\"text-align:center\"";
			break;	
	}
		
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">

	<!-- Main Styles -->
	<link rel="stylesheet" href="../../css/style.min.css">
	
	<!-- Material Design Icon -->
	<link rel="stylesheet" href="../../fonts/material-design/css/materialdesignicons.css">

	<!-- mCustomScrollbar -->
	<link rel="stylesheet" href="../../plugin/mCustomScrollbar/jquery.mCustomScrollbar.min.css">

	<!-- Waves Effect -->
	<link rel="stylesheet" href="../../plugin/waves/waves.min.css">

	<!-- Sweet Alert -->
	<link rel="stylesheet" href="../../plugin/sweet-alert/sweetalert.css">

	<!-- Dark Themes -->
	<link rel="stylesheet" href="../../css/style-dark.min.css">
</head>
<body><div id="row">
      <div id="box-content">
         	<form method="post" id="contact" action="#">
			<input type="hidden" name="action_type" value="<?php echo $_POST['submit']; ?>">
			<input type="hidden" name="old_type" value="<?php echo $_POST['tableSelect']; ?>">
			<h4 class="box-title" style="text-align:center">软件分类列表</h4>
                <div class="form-group">
                        <select name="tableSelect" size="10" id="tableSelect" class="form-control">
           				 <?php
							$UData = $dou->fetch_array_all('zd_type');
							foreach ($UData as $value)
							{
								{
									echo '<option value='.$value['type'].'>'.$value['type'].'</option>';
								} 
								
							}
							?>
            			</select>
                </div>
				<<?php echo $DataValue; ?>> 
					<div class="form-group">
					<label for="sitename" name="Address">分类名称</label>
					<input name="type_data" class="form-control" type="text" tabindex="1" value="<?php echo $_POST['tableSelect']; ?>"/>
					</div>
					<div class="form-group" style="text-align:center">
					<button name="submit" type="submit" class="btn btn-xs waves-effect waves-light" id="contact-submit" value="success">确定</button>
					<button name="submit" type="submit" class="btn btn-xs waves-effect waves-light" id="contact-submit" value="cancel">取消</button>
					</div>
				</div>
				<<?php echo $ControlValue; ?>>
					<button name="submit" type="submit" class="btn btn-xs waves-effect waves-light" id="contact-submit" value="add" >新增</button>
					<button name="submit" type="submit" class="btn btn-xs waves-effect waves-light" id="contact-submit" value="edit">编辑</button>
					<button name="submit" type="submit" class="btn btn-xs waves-effect waves-light" id="contact-submit" value="del">删除</button>
				</div>
         	</form>	
        </div></div>
</body>

</html>