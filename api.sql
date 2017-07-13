/*
Navicat MySQL Data Transfer

Source Server         : 121.43.166.231
Source Server Version : 50718
Source Host           : localhost:3306
Source Database       : api

Target Server Type    : MYSQL
Target Server Version : 50718
File Encoding         : 65001

Date: 2017-07-13 18:41:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for c_activity
-- ----------------------------
DROP TABLE IF EXISTS `c_activity`;
CREATE TABLE `c_activity` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `isJoin` int(11) DEFAULT NULL,
  `qrcode` varchar(100) DEFAULT NULL,
  `groupName` varchar(100) DEFAULT NULL,
  `uid` bigint(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '活动主题',
  `cover` varchar(255) DEFAULT NULL COMMENT '活动封面',
  `startTime` bigint(20) DEFAULT NULL,
  `endTime` bigint(20) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `activityPlace` varchar(255) DEFAULT NULL COMMENT '活动地点',
  `activityDesc` text COMMENT '活动详情描述',
  `activityType` varchar(50) DEFAULT NULL COMMENT '活动类型',
  `enteredSettings` varchar(255) DEFAULT NULL COMMENT '报名设置',
  `activityCost` decimal(20,2) DEFAULT NULL COMMENT '费用',
  `activityPeoples` int(10) DEFAULT NULL COMMENT '人数',
  `time` int(11) DEFAULT NULL,
  `activityLat` varchar(64) DEFAULT '0',
  `activityLng` varchar(64) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `activityType` (`activityType`) USING BTREE,
  KEY `qrcode` (`qrcode`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=159 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for c_activity_clock
-- ----------------------------
DROP TABLE IF EXISTS `c_activity_clock`;
CREATE TABLE `c_activity_clock` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `aid` bigint(20) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `sex` varchar(32) DEFAULT NULL,
  `type` varchar(32) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `proxyclockuid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for c_activity_comments
-- ----------------------------
DROP TABLE IF EXISTS `c_activity_comments`;
CREATE TABLE `c_activity_comments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `aid` bigint(20) DEFAULT NULL,
  `uid` bigint(20) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `zid` (`aid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for c_activity_comments_praises
-- ----------------------------
DROP TABLE IF EXISTS `c_activity_comments_praises`;
CREATE TABLE `c_activity_comments_praises` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `acid` bigint(20) DEFAULT NULL,
  `uid` bigint(20) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acid` (`acid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for c_activity_comments_reply
-- ----------------------------
DROP TABLE IF EXISTS `c_activity_comments_reply`;
CREATE TABLE `c_activity_comments_reply` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `acid` bigint(20) DEFAULT NULL,
  `uid` bigint(20) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `zid` (`acid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for c_activity_comments_reply_praises
-- ----------------------------
DROP TABLE IF EXISTS `c_activity_comments_reply_praises`;
CREATE TABLE `c_activity_comments_reply_praises` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `acrid` bigint(20) DEFAULT NULL,
  `uid` bigint(20) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acrid` (`acrid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for c_activity_join
-- ----------------------------
DROP TABLE IF EXISTS `c_activity_join`;
CREATE TABLE `c_activity_join` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `aid` bigint(20) DEFAULT NULL,
  `userId` bigint(20) DEFAULT NULL,
  `usertel` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `beizhu` varchar(255) DEFAULT NULL,
  `state` int(1) DEFAULT '1',
  `isEat` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for c_activity_type
-- ----------------------------
DROP TABLE IF EXISTS `c_activity_type`;
CREATE TABLE `c_activity_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for c_area
-- ----------------------------
DROP TABLE IF EXISTS `c_area`;
CREATE TABLE `c_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for c_auth_groups
-- ----------------------------
DROP TABLE IF EXISTS `c_auth_groups`;
CREATE TABLE `c_auth_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for c_auth_login_attempts
-- ----------------------------
DROP TABLE IF EXISTS `c_auth_login_attempts`;
CREATE TABLE `c_auth_login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for c_auth_session
-- ----------------------------
DROP TABLE IF EXISTS `c_auth_session`;
CREATE TABLE `c_auth_session` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `id` (`id`),
  KEY `timestamp` (`timestamp`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for c_auth_users
-- ----------------------------
DROP TABLE IF EXISTS `c_auth_users`;
CREATE TABLE `c_auth_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `region` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for c_auth_users_groups
-- ----------------------------
DROP TABLE IF EXISTS `c_auth_users_groups`;
CREATE TABLE `c_auth_users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `c_auth_users_groups_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `c_auth_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `c_auth_users_groups_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `c_auth_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for c_black
-- ----------------------------
DROP TABLE IF EXISTS `c_black`;
CREATE TABLE `c_black` (
  `uid` bigint(20) NOT NULL COMMENT '用户',
  `friend` bigint(20) DEFAULT NULL COMMENT '好友'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for c_device
-- ----------------------------
DROP TABLE IF EXISTS `c_device`;
CREATE TABLE `c_device` (
  `userId` bigint(20) NOT NULL,
  `deviceId` text,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for c_friend
-- ----------------------------
DROP TABLE IF EXISTS `c_friend`;
CREATE TABLE `c_friend` (
  `uid` bigint(20) NOT NULL COMMENT '用户',
  `friend` bigint(20) DEFAULT NULL COMMENT '好友'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for c_plugin
-- ----------------------------
DROP TABLE IF EXISTS `c_plugin`;
CREATE TABLE `c_plugin` (
  `uid` int(11) NOT NULL COMMENT '用户',
  `name` varchar(255) NOT NULL COMMENT '插件',
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台导航';

-- ----------------------------
-- Table structure for c_session
-- ----------------------------
DROP TABLE IF EXISTS `c_session`;
CREATE TABLE `c_session` (
  `uid` bigint(20) NOT NULL AUTO_INCREMENT,
  `session` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=10001156 DEFAULT CHARSET=utf8 COMMENT='用户session';

-- ----------------------------
-- Table structure for c_users
-- ----------------------------
DROP TABLE IF EXISTS `c_users`;
CREATE TABLE `c_users` (
  `userId` bigint(20) NOT NULL AUTO_INCREMENT,
  `tel` varchar(15) DEFAULT NULL COMMENT '手机号',
  `password` varchar(40) DEFAULT NULL COMMENT '密码',
  `usernick` varchar(255) DEFAULT '' COMMENT '昵称',
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `time` int(11) DEFAULT NULL COMMENT '注册时间',
  `hxpassword` varchar(32) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL COMMENT '性别',
  `sign` varchar(255) DEFAULT NULL COMMENT '签名',
  `type` enum('qq','weixin','weibo') DEFAULT NULL,
  `openID` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `fxid` varchar(255) DEFAULT NULL,
  `role` int(11) DEFAULT '1',
  `fatherId` int(11) DEFAULT '0',
  `group_id` int(11) DEFAULT '0',
  `area_id` int(11) DEFAULT '0',
  `meetingAuth` tinyint(1) DEFAULT '0',
  `activityAuth` tinyint(1) DEFAULT '0',
  `cardId` varchar(64) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `en_show_tel` tinyint(1) DEFAULT '1',
  `en_s_fxid` tinyint(1) DEFAULT '1',
  `en_s_tel` tinyint(1) DEFAULT '1',
  `lastloginTimes` int(11) DEFAULT '0' COMMENT '最近上线时间',
  PRIMARY KEY (`userId`),
  KEY `tel` (`tel`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=10001156 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Table structure for c_users_attribute
-- ----------------------------
DROP TABLE IF EXISTS `c_users_attribute`;
CREATE TABLE `c_users_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for c_users_group
-- ----------------------------
DROP TABLE IF EXISTS `c_users_group`;
CREATE TABLE `c_users_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for c_users_identity
-- ----------------------------
DROP TABLE IF EXISTS `c_users_identity`;
CREATE TABLE `c_users_identity` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `userTel` varchar(255) DEFAULT NULL,
  `cardId` varchar(255) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `fatherTel` varchar(255) DEFAULT NULL,
  `fatherName` varchar(255) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for c_zone
-- ----------------------------
DROP TABLE IF EXISTS `c_zone`;
CREATE TABLE `c_zone` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) DEFAULT NULL COMMENT '用户id',
  `category` varchar(255) DEFAULT NULL COMMENT '社区分类，拓展的时候会用到，作为一个查询条件',
  `content` text COMMENT '动态内容',
  `imagestr` varchar(255) DEFAULT NULL COMMENT '图片',
  `coordinate` varchar(255) DEFAULT NULL COMMENT '经纬度',
  `location` varchar(255) DEFAULT NULL COMMENT '位置',
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=198 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for c_zone_comments
-- ----------------------------
DROP TABLE IF EXISTS `c_zone_comments`;
CREATE TABLE `c_zone_comments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `zid` bigint(20) DEFAULT NULL,
  `uid` bigint(20) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `replyUid` bigint(20) DEFAULT NULL,
  `replyContent` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `replyTime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `zid` (`zid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=257 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for c_zone_praises
-- ----------------------------
DROP TABLE IF EXISTS `c_zone_praises`;
CREATE TABLE `c_zone_praises` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `zid` bigint(20) DEFAULT NULL,
  `uid` bigint(20) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `zid` (`zid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=328 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
