<?php 
require("../kernl/Init.php"); //初始化基础参数

//判断是否初次使用
if($dou -> Info('Is_FirstRun') == '0')
{
	header("Location: First.php"); //重定向浏览器
}

//判断之前的登陆状态
$state = $dou -> AccountState();
if ($state != 'Access denied') 
{
	header("Location: index.php"); //重定向浏览器到播放界面
}

//基础网页内容

$var = $dou -> LoadingBingBackground() . '<div class="login-page">
  <div class="login-container">
    <div class="login-form"> <a class="brand"><span class="brand-text">&nbsp&nbsp&nbsp&nbsp&nbsp'. $dou -> Info('corp').'后台管理系统</span> </a>
      <div class="form-login">
        <div class="input-container">
          <div class="input-group user-icon">
	  <input type="hidden" id="return" name="return" value="'.$_GET['ref'].'">
            <input class="cbi-input-user" id="cbi-input-user" type="text" name="luci_username" value="admin">
            <label class="border" for="cbi-input-user"></label>
          </div>
          <div class="input-group pass-icon">
            <input class="cbi-input-password" id="cbi-input-password" type="password" name="luci_password">
            <label class="border" for="cbi-input-password"></label>
          </div>
                          <div class="input-group user-icon" id="code">
            <input class="cbi-input-user" id="vaildcode" type="text" name="vaildcode" style="width:80%;height:30px;display:inline"><img src="code.php" id="showcode" onclick="GetCode();">
          </div>
            <div class="rem_sub" id="rem_sub" style=\'margin-top: -10px;\'>
		<input type="checkbox" name="save_me" id="save_me">
		<label for="checkbox">记住登陆信息</label>
	</div>
        </div>
        <div>
          <input type="submit" value="登录" class="cbi-button cbi-button-apply sub_button">
        </div>
      </div>
      <script type="text/javascript">
				var input = document.getElementsByName(\'luci_password\')[0];
				if (input)
					input.focus();</script>    <footer>
      <div> <a class="luci-link">'.$dou -> Info('bottom').'</a></div>
    </footer> 
</div></div></div>';
	

//判断登陆失败次数，后台增加设置尝试次数，超过则跳转到错误页，超过3次则加载验证码
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $dou -> Info('corp'); ?>后台管理系统</title>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<meta name="format-detection" content="telephone=no, email=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="x5-fullscreen" content="true">
<meta name="full-screen" content="yes">
<meta name="x5-page-mode" content="app">
<meta name="browsermode" content="application">
<meta name="msapplication-tap-highlight" content="no">
<meta name="msapplication-TileColor" content="#5e72e4">
<link rel="manifest" href="../images/icon/manifest.json" crossorigin="use-credentials">
<meta name="msapplication-TileColor" content="#5e72e4">
<meta name="msapplication-TileImage" content="../images/icon/ms-icon-144x144.png">
<meta name="theme-color" content="#5e72e4">
<link rel="stylesheet" href="../css/cascade.css">
<script src="../js/jquery.min.js"></script>
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
		var user = $('#cbi-input-user').val();
		var pass = $('#cbi-input-password').val();
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
      <script type="text/javascript">
				var input = document.getElementsByName('luci_password')[0];
				if (input)
					input.focus();</script> 
    </div>
  </div>
</div>
<script>
	var luciLocation = [];
	var winHeight = $(window).height();
	$(window).resize(function () {
		var winWidth = $(window).width()
		if(winWidth < 600){
			var newHeight = $(this).height();
			var keyboradHeight = newHeight - winHeight;
			$(".ftc").css("bottom", keyboradHeight + 30);
		}
	})
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
