<?php 
require("../kernl/Init.php"); //初始化基础参数

//判断之前的登陆状态
$state = $dou -> AccountState();
if ($state != 'Access denied') 
{
	header("Location: index.php"); //重定向浏览器到播放界面
}

//基础网页内容
$var = '<div class="login_m">
			<div class="login_padding login_title">
	  			<div align="center"><strong>'.$dou -> Info('corp').'中央认证系统</strong></div>
			</div>
			<div id="login_boder" class="login_boder">
				<div class="login_padding">
					<label>
						<h2>用户名</h2>
						<input type="hidden" id="return" name="return" value="'.$_GET['ref'].'">
						<input type="text" id="username" name="username" class="txt_input txt_input2" >
					</label>
					<label>
						<h2>密码</h2>
						<input type="password" name="password" id="password" class="txt_input" >
					</label>
					<label id=\'code\'>
						<h2>验证码</h2>
						<input type="text" id="vaildcode" name="vaildcode" class="txt_input txt_input2" style=\'width: 235px; height: 38px;\'>
						<img src = \'code.php\' id=\'showcode\' onclick=\'GetCode();\' style=\'top: -5px;\'>
					</label>
					<p class="forgot"></p>
					<div id="rem_sub" class="rem_sub" style=\'margin-top: -10px;\'>
						<div class="rem_sub_l">
							<input type="checkbox" name="save_me" id="save_me">
							<label for="checkbox">记住登陆信息</label>
						</div>
						<label>
							<input type="submit" class="sub_button" name="button" id="button" value="登录" style="opacity: 0.7;">
						</label>
					</form>
					</div>
				</div>
			</div>
		</div>
		<div id=\'corp\' align="center"><strong>'.$dou -> Info('bottom').'</strong></div>';
	

//判断登陆失败次数，后台增加设置尝试次数，超过则跳转到错误页，超过3次则加载验证码
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php $dou -> Info('corp'); ?>后台管理系统</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script src="../js/global.js"></script>
<script src="../js/jquery-1.8.3.min.js"></script>
<script src="../js/artDialog.js?skin=default"></script>	
<script src="../js/iframeTools.js"></script>	
</head>
<body class="login">
<?php echo $var; ?>
<script>
$(function(){
	$(".sub_button").on('click',  function(event) {
		event.preventDefault();
		var user = $('#username').val();
		var pass = $('#password').val();
		var code = $('#vaildcode').val();
		var saveme = $('#save_me').prop('checked');
		var ref = $('#return').val();
		
		if(user == ''){
			SystemBox(3,'用户名不能为空！'); 
			return false;
		}
		if(pass == ''){
			SystemBox(3,'密码不能为空！'); 
			return false;
		}
		if(Vaild == true){
			if(code == ''){
				SystemBox(3,'验证码不能为空！'); 
				return false;
			}
		}
		$.ajax({
			url: 'login_check.php',
			type: 'POST',
			dataType: 'json',
			data: {username: user,password: pass,code: code,save: saveme},
			beforeSend: function(){
				$('#button').attr("value",'正在登录...');
			},
			success: function(res){
				var errcode = res.status;
				var errmessage = res.message;
				if(res.status == 0){ //登录成功
					window.location.href="index.php?" + ref;
				}else{
					SystemBox(3,errmessage);
					GetCode();
					$('#button').attr("value",'登录');
				}
			}
		});
	});
});
</script>	
</body>
</html>
<?php 
//判断验证码是否启用
if ($dou -> Info('VaildCode') == 0) 
{
	echo "<script>var Vaild = true;javascript:LoginStatus(2);</script>";
} else {
	echo "<script>var Vaild = false;javascript:LoginStatus(1);</script>";
}

//if($_COOKIE["SourceTryCount"] == 0 || $_COOKIE["SourceTryCount"] <= 3 )
//{
	//echo "<script>javascript:LoginStatus(1);</script>";
//} else {
	//echo "<script>javascript:LoginStatus(2);</script>";
//}
?>
