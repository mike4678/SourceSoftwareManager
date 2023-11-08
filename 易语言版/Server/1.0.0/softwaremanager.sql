/*
Navicat MySQL Data Transfer

Source Server         : localhost_3307
Source Server Version : 50527
Source Host           : localhost:3307
Source Database       : softwaremanager

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2021-07-15 10:21:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for zd_config
-- ----------------------------
DROP TABLE IF EXISTS `zd_config`;
CREATE TABLE `zd_config` (
  `versionnumber` text,
  `Forcedupdate` int(11) DEFAULT NULL,
  `Downloadlink` text,
  `Updatetime` text,
  `Updatecontent` text,
  `AnnouncementContent` text,
  `Nversion` text
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for zd_software
-- ----------------------------
DROP TABLE IF EXISTS `zd_software`;
CREATE TABLE `zd_software` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `softname` text NOT NULL,
  `version` text NOT NULL,
  `size` bigint(11) NOT NULL,
  `synopsis` text NOT NULL,
  `updatetime` text NOT NULL,
  `logo` text,
  `hash` text NOT NULL,
  `run` text,
  `type` text,
  `introduce` text NOT NULL,
  `remark` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for zd_type
-- ----------------------------
DROP TABLE IF EXISTS `zd_type`;
CREATE TABLE `zd_type` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `type` text NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
