<?php
date_default_timezone_set("Asia/Shanghai"); //时区设定
define("DBSERVER", "192.168.2.252"); //你的MySQL主机
define("USER","root"); //你的MySQL帐户
define("PASSWORD","root"); //你的MySQL密码
define("DB", "newsoftmanager"); //你的数据库名
define("Time",date("y/m/d H:i:s",time()));
define("Debug","off");   //调试模式
define("LocalSource","D:\SourceInc\installpack");   //软件安装源
define("Templater","/softmanager/template/index.html");    //首页模板路径
?>