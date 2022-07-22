/*
Navicat MySQL Data Transfer

Source Server         : LOCALHOST
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : softmanager1

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2022-07-22 15:03:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `adminlist`
-- ----------------------------
DROP TABLE IF EXISTS `adminlist`;
CREATE TABLE `adminlist` (
  `t_e` text NOT NULL,
  `m_e` text NOT NULL,
  `table` text NOT NULL,
  `menu` text NOT NULL,
  `url` text NOT NULL,
  `page` text NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of adminlist
-- ----------------------------
INSERT INTO `adminlist` VALUES ('start', 'index', '系统', '关于', 'index.php', 'system/main.php', '5');
INSERT INTO `adminlist` VALUES ('system', 'setting', '系统', '系统设置', 'index.php?/system/setting', 'system/system.php', '2');
INSERT INTO `adminlist` VALUES ('system', 'log', '系统', '系统日志', 'index.php?/system/log', 'system/content.php', '4');
INSERT INTO `adminlist` VALUES ('system', 'info', '系统', '系统信息', 'index.php?/system/info', 'system/info.php', '4');
INSERT INTO `adminlist` VALUES ('system', 'database', '系统', '数据库管理', 'index.php?/system/database', 'system/database.php', '2');
INSERT INTO `adminlist` VALUES ('system', 'soft', '系统', '软件管家软件管理', 'index.php?/system/soft', 'system/content.php', '1');
INSERT INTO `adminlist` VALUES ('system', 'softinfo', '系统', '软件管家基础管理', 'index.php?/system/softinfo', 'system/softinfo.php', '0');

-- ----------------------------
-- Table structure for `admin_user`
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `username` text NOT NULL,
  `password` text NOT NULL,
  `lastip` text,
  `lasttime` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_user
-- ----------------------------
INSERT INTO `admin_user` VALUES ('admin', 'k5WfnKA=', '220.173.24.85', '22/07/22 15:02:53');

-- ----------------------------
-- Table structure for `content_data`
-- ----------------------------
DROP TABLE IF EXISTS `content_data`;
CREATE TABLE `content_data` (
  `list` text NOT NULL COMMENT '瀵瑰簲鑿滃崟椤圭洰',
  `list_name` text NOT NULL,
  `script` text NOT NULL COMMENT '椤甸潰閲岀殑鑴氭湰',
  `table_head` text NOT NULL COMMENT '鍒楄〃椤堕儴',
  `table` text NOT NULL COMMENT '鍒楄〃鍐呭'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of content_data
-- ----------------------------
INSERT INTO `content_data` VALUES ('log', 'system_log', 'function Del(addr) \r\n{\r\n	art.dialog.confirm(\'你确定要删除这条消息吗？\', function () {\r\n		window.location.href=\'http://\' + window.location.host + addr;\r\n		//art.dialog.content(\'http://\' + window.location.host + addr);// 填充对话框内容\r\n		//art.dialog.open(\'http://\' + window.location.host + addr)\r\n		//myDialog.dialog.close();\r\n    //art.dialog.tips(\'执行确定操作\');\r\n}, function () {\r\n	art.dialog.close();\r\n    art.dialog.tips(\'操作被用户取消！\');\r\n});\r\n}\r\n\r\nfunction info(message) {\r\n		art.dialog.tips(message,10);}', '<div class=\"panel-head\"><strong>系统日志</strong></div>\r\n        <div class=\"padding border-bottom\">\r\n        	<input type=\"button\" class=\"button button-small checkall\" name=\"checkall\" checkfor=\"id[]\" value=\"全选\">\r\n            <input type=\"submit\" class=\"button button-small border-yellow\" value=\"批量删除\"  />\r\n        </div>\r\n        <table class=\"table table-hover\">\r\n        	<tr><th width=\"5%\">选择</th><th width=\"10%\">请求方式</th><th width=\"25%\" style=\"text-align:center\">操作内容</th><th width=\"14%\" style=\"text-align:center\">操作ip</th><th width=\"8%\" >&nbsp;&nbsp;&nbsp;时间</th><th width=\"8%\">&nbsp;操作</th></tr>', '<tr><td>&nbsp;<input type=\'checkbox\' name=\'id[]\' value=\'{id}\'><input name=\'d\' type=\'hidden\' value=\'systemlog\'></td><td>&nbsp;&nbsp;{method}</td><td align=center><a href=\'javascript:info(\"{data}<br/>操作IP：{ip^&ipdata}&nbsp;&nbsp;操作时间：{time}\")\'>点击查看</td><td style=\'text-align:center\'>{ip^&ipdata}</td><td>{time}</td><td>&nbsp;<a class=\'button border-yellow button-little\' href=\'#\' onclick=\"javascript:Del(\'$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]/id{id} \')\">删除</a></td></tr>');
INSERT INTO `content_data` VALUES ('report', 'report', 'function info(message) { art.dialog.tips(message,5); }\r\n	\r\nfunction Del(addr) \r\n{\r\n	art.dialog.confirm(\'你确定要删除这条内容吗？\', function () {\r\n		window.location.href=\'http://\' + window.location.host + addr;\r\n		//art.dialog.content(\'http://\' + window.location.host + addr);// 填充对话框内容\r\n		//art.dialog.open(\'http://\' + window.location.host + addr)\r\n		//myDialog.dialog.close();\r\n    //art.dialog.tips(\'执行确定操作\');\r\n}, function () {\r\n	art.dialog.close();\r\n    art.dialog.tips(\'操作被用户取消！\');\r\n});\r\n}', '<div class=\"panel-head\"><strong>建议与意见</strong></div>\r\n        <div class=\"padding border-bottom\">\r\n            <input type=\"button\" class=\"button button-small checkall\" name=\"checkall\" checkfor=\"id[]\" value=\"全选\" />\r\n            <input type=\"submit\" class=\"button button-small border-yellow\" value=\"批量删除\" />\r\n        </div>\r\n        <table class=\"table table-hover\">\r\n        	<tr><th width=\"1%\"></th><th width=\"8%\">ID</th><th width=\"13%\">提交时间</th><th width=\"13%\">联系方式</th><th width=\"16%\">类型</th><th width=\"14%\">内容</th><th width=\"14%\">操作</th></tr>', '<tr><td></td><td><input type=\'checkbox\' name=\'id[]\' value=\'{id}\'>&nbsp;&nbsp;{id}</td><td>{time}</td><td>{address}</td><td>{type}</td><td><a href=\'javascript:info(\"{data}\")\'>点击查看</td><td>&nbsp;<a class=\'button border-yellow button-little\' href=# onclick=\"javascript:Del(\'$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]/id{id}\')\\\">删除</a>\";');
INSERT INTO `content_data` VALUES ('soft', 'zd_software', 'function Del(addr) \r\n{\r\n	art.dialog.confirm(\'你确定要删除这条消息吗？\', function () {\r\n		window.location.href=\'http://\' + window.location.host + addr;\r\n		//art.dialog.content(\'http://\' + window.location.host + addr);// 填充对话框内容\r\n		//art.dialog.open(\'http://\' + window.location.host + addr)\r\n		//myDialog.dialog.close();\r\n    //art.dialog.tips(\'执行确定操作\');\r\n}, function () {\r\n	art.dialog.close();\r\n    art.dialog.tips(\'操作被用户取消！\');\r\n});\r\n}\r\n\r\nfunction info(message) {\r\n		art.dialog.tips(message,10);}\r\n\r\nfunction SoftManager(action,softid)\r\n{\r\n		if(action == \'\' || softid == \'\')\r\n		{ info(\'参数错误！\'); }\r\n		\r\n		switch(action)\r\n		{\r\n			case \'add\':\r\n				art.dialog.open(\'system/SoftManager.php?m=add\', {title: \'新增软件\',width: 900 , height: 455});\r\n				break;\r\n				\r\n			case \'edit\':\r\n				art.dialog.open(\'system/SoftManager.php?m=edit&id=\'+softid, {title: \'修改软件\',width: 900, height: 455});\r\n				break;\r\n				\r\n			case \'type_list\':\r\n				art.dialog.open(\'system/soft_typelist.php\', {title: \'分类管理\',width: 420,});\r\n				break;\r\n				\r\n			case \'logoview\':\r\n				art.dialog.open(\'system/softimgview.php?m=logoview&id=\'+softid, {title: \'软件Logo\',width: 420,});\r\n				break;\r\n				\r\n			case \'imgview\':\r\n				art.dialog.open(\'system/softimgview.php?m=imgview&id=\'+softid, {title: \'运行截图管理\',width: 420,});\r\n				break;\r\n		\r\n		}\r\n}', '<div class=\"panel-head\"><strong>软件管理</strong></div>\r\n        <div class=\"padding border-bottom\">\r\n        	<input type=\"button\" class=\"button button-small checkall\" name=\"checkall\" checkfor=\"id[]\" value=\"全选\">\r\n                   <input type=\"button\" class=\"button button-small cborder-green\" name=\"Add\" value=\"刷新\" onclick=\"location.reload();\" >\r\n                   <input type=\"button\" class=\"button button-small border-green\" name=\"Add\"  value=\"新增\"  onclick=\"SoftManager(\'add\')\" />\r\n                   <input type=\"button\" class=\"button button-small border-green\" name=\"Add\"  value=\"分类管理\"  onclick=\"SoftManager(\'type_list\')\" />\r\n                   <input type=\"submit\" class=\"button button-small border-yellow\" value=\"删除\"  />\r\n                   <input type=\"submit\" class=\"button button-small border-yellow\" value=\"批量删除\"  />\r\n        </div>\r\n        <table class=\"table table-hover\">\r\n        	<tr><th width=\"2%\"></th><th width=\"10%\" style=\"text-align:center\">软件名</th><th width=\"7%\" style=\"text-align:center\">分类</th><th width=\"5%\" style=\"text-align:center\">版本</th><th width=\"7%\" style=\"text-align:center\">容量</th><th width=\"25%\" style=\"text-align:center\">简介</th><th width=\"10%\" style=\"text-align:center\">更新时间</th><th width=\"5%\" style=\"text-align:center\">下载数</th><th width=\"20%\" style=\"text-align:center\">操作</th></tr>', '<tr><td>&nbsp;<input type=\'checkbox\' name=\'id[]\' value=\'{id}\'><input name=\'d\' type=\'hidden\' value=\'lrc\'></td><td>{softname}</td><td style=\"text-align:center\">{type}</td><td style=\"text-align:center\">{version}</td><td style=\"text-align:center\">{size} KB</td><td>{synopsis}</td><td>{updatetime^&data}</td><td style=\"text-align:center\">{downloadcount}</td><td style=\"text-align:center\"><a class=\'button border-green button-little\' href=\"javascript:SoftManager(\'logoview\',\'{id}\')\">软件Logo</a>&nbsp;<a class=\'button border-green button-little\' href=\"javascript:SoftManager(\'imgview\',\'{id}\')\">运行截图</a>&nbsp;<a class=\'button border-yellow button-little\' href=\"javascript:SoftManager(\'edit\',\'{id}\')\">编辑</a>&nbsp;<a class=\'button border-yellow button-little\' href=\'#\' onclick=\"javascript:Del(\'$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]/id{id} \')\">删除</a></td></tr>');

-- ----------------------------
-- Table structure for `system_log`
-- ----------------------------
DROP TABLE IF EXISTS `system_log`;
CREATE TABLE `system_log` (
  `id` int(11) NOT NULL,
  `method` text,
  `ip` text NOT NULL,
  `data` text NOT NULL,
  `addr` text NOT NULL,
  `time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `system_setting`
-- ----------------------------
DROP TABLE IF EXISTS `system_setting`;
CREATE TABLE `system_setting` (
  `vars` text NOT NULL,
  `value` text NOT NULL,
  `备注` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of system_setting
-- ----------------------------
INSERT INTO `system_setting` VALUES ('server_status', '0', '系统状态');
INSERT INTO `system_setting` VALUES ('corp', 'Source软件管家', '版权');
INSERT INTO `system_setting` VALUES ('version', '1.0.0', '版本号');
INSERT INTO `system_setting` VALUES ('logo', '../images/main.png', 'logo');
INSERT INTO `system_setting` VALUES ('name', 'Source软件管家后台管理系统', null);
INSERT INTO `system_setting` VALUES ('upload_size', '29', '上传大小(MB)');
INSERT INTO `system_setting` VALUES ('bottom', 'Copyright © 2001-2029 Source. All Rights Reserved.', '页面底部信息');
INSERT INTO `system_setting` VALUES ('server_infomaction', 'The system is under maintenance. Please visit later.<br>', '系统维护显示信息');
INSERT INTO `system_setting` VALUES ('encrypted', 'admin', '密码加密字符串');
INSERT INTO `system_setting` VALUES ('bugreport', '2', 'Bug提交方式');
INSERT INTO `system_setting` VALUES ('reportaddress', '', '外部提交地址');
INSERT INTO `system_setting` VALUES ('pagedisplay', '20', '列表每页显示数量');
INSERT INTO `system_setting` VALUES ('index_status', '1', '是否启用首页模块，0为启用，1为禁用');
INSERT INTO `system_setting` VALUES ('index_page', '', '默认显示首页内容');
INSERT INTO `system_setting` VALUES ('index_page_all', '', '已安装首页模块\r\n模块模板信息：uid;name;addr|uid;name;addr');
INSERT INTO `system_setting` VALUES ('update_status', 'custom', '更新状态，用于判断是否为定制版,null 为通用版，custom为定制版');
INSERT INTO `system_setting` VALUES ('system_table', '系统;icon-cog;admin.php|', '后台顶部夹显示部分,格式：name;logo;addr 用|分割');
INSERT INTO `system_setting` VALUES ('upload_frame', 'system;png、jpg、gif;../../images/|module;zip;../../module/|softlogo;png;../../images/|program;zip;../../file/|logoview;png、ico;../../file/| imgview;png、jpg、bmp;../../file/|', '上传框架,格式：框架名;允许文件类型，多个用、隔开;要上传到的目录，多个框架用|分割');
INSERT INTO `system_setting` VALUES ('MaxCount', '4', '后台登陆界面最大尝试次数');
INSERT INTO `system_setting` VALUES ('VaildCode', '0', '后台登陆是否启用验证码，0为启用，1为关闭');
INSERT INTO `system_setting` VALUES ('AllowDatabase', 'system_log;', '可清空的数据库表名');
INSERT INTO `system_setting` VALUES ('Index_head', '<!DOCTYPE html>\r\n<html lang=\"zh-cn\">\r\n<head>\r\n    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\" />\r\n    <meta name=\"renderer\" content=\"webkit\">\r\n    <title>{corp}后台管理系统</title>\r\n    <link rel=\"stylesheet\" href=\"../css/pintuer.css\">\r\n    <link rel=\"stylesheet\" href=\"../css/admin.css\">\r\n    <link rel=\"stylesheet\" href=\"../css/popup.css\">\r\n    <link rel=\"stylesheet\" href=\"../css/puyuetian.css\">\r\n    <script src=\"../js/jquery-1.8.3.min.js\"></script>\r\n    <script src=\"../js/pintuer.js\"></script>\r\n    <script src=\"../js/respond.js\"></script>\r\n    <script src=\"../js/global.js\"></script>\r\n    <script src=\"../js/artDialog.js?skin=default\"></script>	\r\n    <script src=\"../js/iframeTools.js\"></script>\r\n    <script type=\"text/javascript\" src=\"../js/jquery-1.8.1.min.js\"></script>\r\n     <script type=\"text/javascript\">\r\n        var $181 = $;\r\n     </script>\r\n</head>\r\n<body>\r\n<div class=\"lefter\">\r\n    <div class=\"logo\">\r\n    <a href=\'#\' target=\'_blank\'><img src=\'../images/logo.png\' alt=\'Logo\' width=\'94\' height=\'40\'/></a></div>	\r\n</div>\r\n<div class=\"righter nav-navicon\" id=\"admin-nav\">\r\n    <div class=\"mainer\">\r\n        <div class=\"admin-navbar\">\r\n            <span class=\"float-right\">\r\n            	<a class=\"button button-little bg-main\" href=\"../index.php\" target=\"_blank\">前台首页</a>\r\n                <a class=\"button button-little bg-yellow\" href=\"?/exit\">注销登录</a>\r\n            </span>\r\n            <ul class=\"nav nav-inline admin-nav\">\r\n            {table_list}\r\n            </ul>\r\n        </div>\r\n        <div class=\"admin-bread\">\r\n            <ul class=\"bread\">', '后台界面头部');
INSERT INTO `system_setting` VALUES ('BackupFilePath', 'backup', '备份文件存放路径');