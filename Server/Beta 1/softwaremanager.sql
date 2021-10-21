/*
Navicat MySQL Data Transfer

Source Server         : home
Source Server Version : 80012
Source Host           : 192.168.2.50:3306
Source Database       : softwaremanager

Target Server Type    : MYSQL
Target Server Version : 80012
File Encoding         : 65001

Date: 2021-07-13 19:52:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for zd_config
-- ----------------------------
DROP TABLE IF EXISTS `zd_config`;
CREATE TABLE `zd_config` (
  `versionnumber` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '更新_版本号',
  `Forcedupdate` int(11) DEFAULT NULL COMMENT '更新_强制更新',
  `Downloadlink` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '更新_下载直链',
  `Updatetime` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '更新_更新时间',
  `Updatecontent` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '更新_更新内容',
  `AnnouncementContent` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `Nversion` text CHARACTER SET utf8 COLLATE utf8_general_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for zd_feedback
-- ----------------------------
DROP TABLE IF EXISTS `zd_feedback`;
CREATE TABLE `zd_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` text NOT NULL,
  `software` text,
  `content` text NOT NULL,
  `tel` text,
  `time` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Table structure for zd_software
-- ----------------------------
DROP TABLE IF EXISTS `zd_software`;
CREATE TABLE `zd_software` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `softname` text NOT NULL COMMENT '游戏类型',
  `version` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '游戏大区',
  `size` bigint(11) NOT NULL COMMENT '账号',
  `synopsis` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '密码',
  `updatetime` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `logo` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `hash` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '游戏数据',
  `run` text,
  `type` text,
  `introduce` text NOT NULL,
  `remark` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for zd_type
-- ----------------------------
DROP TABLE IF EXISTS `zd_type`;
CREATE TABLE `zd_type` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `type` text NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
