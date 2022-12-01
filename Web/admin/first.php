<?php 
require("../kernl/Init.php"); //初始化基础参数

//判断是否初次使用
if($dou -> Info('Is_FirstRun') != '0')
{
	$var = $dou -> LoadingBingBackground() . '<div class="login-page">
  <div class="login-container">
    <div class="login-form"> <a class="brand"><span class="brand-text">&nbsp&nbsp&nbsp&nbsp&nbsp'. $dou -> Info('corp').'后台管理系统<br/>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp初始化程序</span> </a>
      <div class="form-login">
        <div class="input-container">
		&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp初始化已完成!
        </div>
        <div>
		  <form action="#" method="POST">	
		  <input type="hidden" id="return" name="return" value="success">
          <input type="submit" value="登录" class="cbi-button cbi-button-apply sub_button">
		  </form>
        </div>
      </div>
	  <footer>
      <div> <a class="luci-link">'.$dou -> Info('bottom').'</a></div>
    </footer> 
</div></div></div>';
} else {

//基础网页内容

$var = $dou -> LoadingBingBackground() . '<div class="login-page">
  <div class="login-container">
    <div class="login-form"> <a class="brand"><span class="brand-text">&nbsp&nbsp&nbsp&nbsp&nbsp'. $dou -> Info('corp').'后台管理系统<br/>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp初始化程序</span> </a>
	<form action="#" method="POST">
      <div class="form-login">
		<input type="hidden" id="return" name="return" value="first">
        <div class="input-container">
          <div class="input-group user-icon">
            <input class="cbi-input-user" id="cbi-input-user" type="text" name="luci_username" value="admin">
            <label for="cbi-input-user">设定登陆用户名</label>
          </div>
          <div class="input-group pass-icon">
            <input class="cbi-input-user" id="cbi-input-password" type="text" name="luci_password" value="password">
            <label for="cbi-input-password">设定登陆密码</label>
          </div>
		   <div class="input-group user-icon">
            <input class="cbi-input-user" id="cbi-input-user" type="text" name="luci_encryption" value="encryption">
            <label for="cbi-input-user">设定密码加密字符串</label>
          </div>
		  	</div>
        <div>
          <input type="submit" value="登录" class="cbi-button cbi-button-apply sub_button">
        </div>
		</form>
      </div>
	<footer>
      <div> <a class="luci-link">'.$dou -> Info('bottom').'</a></div>
    </footer> 
</div></div></div>';
}	

if($_SERVER["REQUEST_METHOD"] == "POST")
{	
	if($dou -> Info('Is_FirstRun') == '0' && $_POST['return'] == 'first')
	{
		if(empty($_POST['luci_username']) || empty($_POST['luci_password']) || empty($_POST['luci_encryption']) )
		{
			echo "<script>alert('用户名/密码/加密字符串不能为空！'); history.go(-1);</script>";
			return;
		}
		
		$dou -> query("INSERT INTO `zd_admin_user` (`username`, `password`) VALUES ('".$_POST['luci_username']."', '".Account::PwdEnc($_POST['luci_password'], $_POST['luci_encryption'])."');");
		$dou -> query("INSERT INTO `zd_system_setting` (`vars`, `value`, `备注`) VALUES ('encrypted', '".$_POST['luci_encryption']."','密码加密字符串');");
		$dou -> query("UPDATE `zd_system_setting` SET `value`='1' WHERE (`vars`='Is_FirstRun') AND (`value`='0') AND (`备注`='初次运行');");
		rename('first.php',rand().'f#ir$st.php');
		header("Location: login.php"); //重定向浏览器到播放界面
	
	} else if($dou -> Info('Is_FirstRun') != '0' || $_POST['return'] != 'first') 
	{
		rename('first.php',rand().'f#ir$st.php');
		header("Location: login.php"); //重定向浏览器到播放界面
	}

}
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

