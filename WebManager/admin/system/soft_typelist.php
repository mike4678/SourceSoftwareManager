<?php 
require("../../kernl/Init.php"); 
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器

//判断是否在框架内，防止跨域
$dou -> FormCheck();

//初始化相关参数信息
if ($_SERVER["REQUEST_METHOD"] == "GET") 
{
	$DataValue = "div class='Frame' style='display:none'";
	$ControlValue = "fieldset";

}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	switch($_POST['submit'])
	{
		case 'add':
			$DataValue = "div class='Frame'";
			$ControlValue = "fieldset style='display:none'";
			break;
		
		case 'edit':
			if($_POST['tableSelect'] == NULL)
			{
				$DataValue = "div class='Frame' style='display:none'";
				$ControlValue = "fieldset";
				echo '<script language="JavaScript">window.alert("未选择需要修改的分类名称！")</script>';
				break;
				
			} else {
			
				$DataValue = "div class='Frame'";
				$ControlValue = "fieldset style='display:none'";
				break;
			}
	
		case 'del':
			if($_POST['tableSelect'] == NULL)
			{
				$DataValue = "div class='Frame' style='display:none'";
				$ControlValue = "fieldset";
				echo '<script language="JavaScript">window.alert("未选择需要删除的分类名称！")</script>';
				break;
				
			} else {
				$url = urldecode($_POST['tableSelect']);
				$sql = "delete from zd_type where type = '" .$url. "';";
				if (!$dou->query($sql)) 
				{
   					echo '<script language="JavaScript">window.alert("删除失败！")</script>';
					$DataValue = "div class='Frame' style='display:none'";
				    $ControlValue = "fieldset";
     			}
    			echo '<script language="JavaScript">self.location=document.referrer;</script>';
				break;
			}
			break;
			
		case 'success':
			if($_POST['action_type'] == NULL || $_POST['type_data'] == NULL)
			{
				echo '<script language="JavaScript">window.alert("参数异常！")</script>';
				$DataValue = "div class='Frame'";
				$ControlValue = "fieldset style='display:none'";
			} else {
				switch ($_POST['action_type'])
				{
					case 'add':
					$url = urldecode($_POST['type_data']);
					$sql = "insert into `zd_type` (`type`) VALUES ('" .$url. "');";
					if (!$dou->query($sql)) 
					{
						echo '<script language="JavaScript">window.alert("新增失败！")</script>';
						$DataValue = "div class='Frame' style='display:none'";
						$ControlValue = "fieldset";
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
						$DataValue = "div class='Frame' style='display:none'";
						$ControlValue = "fieldset";
					}
					echo '<script language="JavaScript">self.location=document.referrer;</script>';
					
					break;
				
				}
			}
			break;	
			
		case 'cancel':
			$DataValue = "div class='Frame' style='display:none'";
			$ControlValue = "fieldset";
			break;	
	}
		
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<link href="../../css/setting.css" rel="stylesheet" type="text/css" />
</head>
<body>
      <div id="main">
         	<form method="post" id="contact" action="#">
			<input type="hidden" name="action_type" value="<?php echo $_POST['submit']; ?>">
			<input type="hidden" name="old_type" value="<?php echo $_POST['tableSelect']; ?>">
                <div class="form-group">
                	<div class="label"><label>软件分类列表</label></div>
                	<div class="field">
                        <div class="button-group button-group-small radio">
                        <select name="tableSelect" size="10" id="tableSelect" class='select' style="margin-top:6px">
           				 <?php
							$UData = $dou->fetch_array_all('zd_type');
							foreach ($UData as $value)
							{
								{
									echo '<option value='.$value['type'].'>'.$value['type'].'</option>';
								} 
								
							}
							?>
            			</select></div>
                    </div>
                </div>
				<<?php echo $DataValue; ?>> 
					<fieldset name="Address">分类名称
						<input name="type_data" type="text" tabindex="1" value="<?php echo $_POST['tableSelect']; ?>"/>
					</fieldset>  
					<fieldset>
					<button name="submit" type="submit" id="contact-submit" value="success">确定</button>
					<button name="submit" type="submit" id="contact-submit" value="cancel">取消</button>
    		</fieldset>
			</div>
				<<?php echo $ControlValue; ?>>
				    <div class="label"><label>操作</label></div>
					<button name="submit" type="submit" id="contact-submit" value="add" >新增</button>
					<button name="submit" type="submit" id="contact-submit" value="edit">编辑</button>
					<button name="submit" type="submit" id="contact-submit" value="del">删除</button>
				</fieldset>
         	</form>	
        </div>
</body>

</html>