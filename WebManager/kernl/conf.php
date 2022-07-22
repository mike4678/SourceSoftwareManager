<?php
date_default_timezone_set("Asia/Shanghai"); //时区设定
define("DBSERVER", ""); //你的MySQL主机
define("USER",""); //你的MySQL帐户
define("PASSWORD",""); //你的MySQL密码
define("DB", ""); //你的数据库名
define("Time",date("y/m/d H:i:s",time()));
define("Debug","off");   //调试模式
define("LocalSource","")  //对应软件管家本地源文件路径，例如：F:\SourceInc\installpack
?>