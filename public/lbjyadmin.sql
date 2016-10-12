/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : lbjyadmin

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-10-12 10:05:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for la_admin_navs
-- ----------------------------
DROP TABLE IF EXISTS `la_admin_navs`;
CREATE TABLE `la_admin_navs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单表',
  `pid` int(11) unsigned DEFAULT '0' COMMENT '所属菜单',
  `name` varchar(15) DEFAULT '' COMMENT '菜单名称',
  `mca` varchar(255) DEFAULT '' COMMENT '模块、控制器、方法',
  `ico` varchar(20) DEFAULT '' COMMENT 'font-awesome图标',
  `order_number` int(11) unsigned DEFAULT NULL COMMENT '排序',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of la_admin_navs
-- ----------------------------
INSERT INTO `la_admin_navs` VALUES ('1', '0', '系统设置', 'admin/shownav/config', 'cog', '1', null, '2016-09-21 06:16:22', null);
INSERT INTO `la_admin_navs` VALUES ('2', '1', '菜单管理', 'admin/admin_nav/index', null, null, null, '2016-09-21 06:16:22', null);
INSERT INTO `la_admin_navs` VALUES ('7', '4', '权限管理', 'admin/auth_rule/index', '', '1', null, '2016-09-21 06:16:22', null);
INSERT INTO `la_admin_navs` VALUES ('4', '0', '权限控制', 'admin/shownav/rule', 'expeditedssl', '2', null, '2016-09-21 06:16:22', null);
INSERT INTO `la_admin_navs` VALUES ('8', '4', '用户组管理', 'admin/auth_group/index', '', '2', null, '2016-09-21 06:16:22', null);
INSERT INTO `la_admin_navs` VALUES ('9', '4', '管理员列表', 'admin/auth_group_access/index', '', '3', null, '2016-09-21 06:16:22', null);
INSERT INTO `la_admin_navs` VALUES ('16', '0', '会员管理', 'admin/shownav/', 'users', '4', null, '2016-09-21 06:16:22', null);
INSERT INTO `la_admin_navs` VALUES ('17', '16', '会员列表', 'admin/user/index', '', null, null, '2016-09-21 06:16:22', null);
INSERT INTO `la_admin_navs` VALUES ('36', '0', '文章管理', 'admin/shownav/posts', 'th', '6', null, '2016-09-21 06:16:22', null);
INSERT INTO `la_admin_navs` VALUES ('37', '36', '文章列表', 'admin/posts/index', '', null, null, '2016-09-21 06:16:22', null);

-- ----------------------------
-- Table structure for la_auth_groups
-- ----------------------------
DROP TABLE IF EXISTS `la_auth_groups`;
CREATE TABLE `la_auth_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` text NOT NULL COMMENT '规则id',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='用户组表';

-- ----------------------------
-- Records of la_auth_groups
-- ----------------------------
INSERT INTO `la_auth_groups` VALUES ('1', '超级管理员', '1', '6,96,20,1,2,3,4,5,64,21,7,8,9,10,11,12,13,14,15,19,16,123,124,125,142,143,144,145,104,105,106,107,108,118,109,110,111,112,117', null, '2016-10-11 10:18:45', null);
INSERT INTO `la_auth_groups` VALUES ('2', '产品管理员', '1', '6,96', null, '2016-09-24 09:44:37', null);
INSERT INTO `la_auth_groups` VALUES ('4', '文章编辑', '1', '6,96,57,60,61,63,71,72,65,67,74,75,66,68,69,73,79,80,78,82,83,88,89,90,99,100,97,98,104,105,106,107,108,118,109,110,111,112,117,113,114', null, null, null);

-- ----------------------------
-- Table structure for la_auth_group_accesses
-- ----------------------------
DROP TABLE IF EXISTS `la_auth_group_accesses`;
CREATE TABLE `la_auth_group_accesses` (
  `uid` int(11) unsigned NOT NULL COMMENT '用户id',
  `group_id` int(11) unsigned NOT NULL COMMENT '用户组id',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组明细表';

-- ----------------------------
-- Records of la_auth_group_accesses
-- ----------------------------
INSERT INTO `la_auth_group_accesses` VALUES ('88', '1', null, null, null);
INSERT INTO `la_auth_group_accesses` VALUES ('89', '2', null, null, null);
INSERT INTO `la_auth_group_accesses` VALUES ('89', '4', null, '2016-09-22 08:50:18', null);

-- ----------------------------
-- Table structure for la_auth_rules
-- ----------------------------
DROP TABLE IF EXISTS `la_auth_rules`;
CREATE TABLE `la_auth_rules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=148 DEFAULT CHARSET=utf8 COMMENT='规则表';

-- ----------------------------
-- Records of la_auth_rules
-- ----------------------------
INSERT INTO `la_auth_rules` VALUES ('1', '20', 'admin/shownav/nav', '菜单管理', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('2', '1', 'admin/admin_nav/index', '菜单列表', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('3', '1', 'admin/admin_nav/store', '添加菜单', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('4', '1', 'admin/admin_nav/update', '修改菜单', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('5', '1', 'admin/admin_nav/destroy', '删除菜单', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('21', '0', 'admin/shownav/rule', '权限控制', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('7', '21', 'admin/auth_rule/index', '权限列表', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('8', '7', 'admin/auth_rule/store', '添加权限', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('9', '7', 'admin/auth_rule/update', '修改权限', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('10', '7', 'admin/auth_rule/destroy', '删除权限', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('11', '21', 'admin/auth_group/index', '用户组列表', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('12', '11', 'admin/auth_group/store', '添加用户组', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('13', '11', 'admin/auth_group/update', '修改用户组', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('14', '11', 'admin/auth_group/destroy', '删除用户组', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('15', '11', 'admin/auth_group/rule_group_show', '分配权限页面', '1', '1', '', null, '2016-09-24 09:16:38', null);
INSERT INTO `la_auth_rules` VALUES ('16', '19', 'admin/auth_group_access/search_user', '搜索用户', '1', '1', '', null, '2016-09-24 09:18:59', null);
INSERT INTO `la_auth_rules` VALUES ('19', '21', 'admin/auth_group_access/index', '管理员列表', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('20', '0', 'admin/shownav/config', '系统设置', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('6', '0', 'admin/index/index', '后台首页', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('64', '1', 'admin/admin_nav/order', '菜单排序', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('96', '6', 'admin/index/welcome', '欢迎界面', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('104', '0', 'admin/shownav/posts', '文章管理', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('105', '104', 'admin/posts/index', '文章列表', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('106', '105', 'admin/posts/add_posts', '添加文章', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('107', '105', 'admin/posts/edit_posts', '修改文章', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('108', '105', 'admin/posts/delete_posts', '删除文章', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('109', '104', 'admin/posts/category_list', '分类列表', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('110', '109', 'admin/posts/add_category', '添加分类', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('111', '109', 'admin/posts/edit_category', '修改分类', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('112', '109', 'admin/posts/delete_category', '删除分类', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('117', '109', 'admin/posts/order_category', '分类排序', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('118', '105', 'admin/posts/order_posts', '文章排序', '1', '1', '', null, null, null);
INSERT INTO `la_auth_rules` VALUES ('123', '19', 'admin/auth_group_access/add_user_to_group', '添加用户到用户组', '1', '1', '', null, '2016-09-24 09:34:16', null);
INSERT INTO `la_auth_rules` VALUES ('124', '19', 'admin/auth_group_access/create', '添加管理员页面', '1', '1', '', null, '2016-09-24 09:36:31', null);
INSERT INTO `la_auth_rules` VALUES ('125', '19', 'admin/auth_group_access/edit', '修改管理员页面', '1', '1', '', null, '2016-09-24 09:37:13', null);
INSERT INTO `la_auth_rules` VALUES ('141', '11', 'admin/auth_group/rule_group_update', '分配权限功能', '1', '1', '', '2016-09-24 09:17:06', '2016-09-24 09:17:06', null);
INSERT INTO `la_auth_rules` VALUES ('142', '19', 'admin/auth_group_access/delete_user_from_group', '从用户组中删除用户', '1', '1', '', '2016-09-24 09:34:33', '2016-09-24 09:34:33', null);
INSERT INTO `la_auth_rules` VALUES ('143', '19', 'admin/auth_group_access/store', '添加管理员功能', '1', '1', '', '2016-09-24 09:36:50', '2016-09-24 09:36:50', null);
INSERT INTO `la_auth_rules` VALUES ('144', '19', 'admin/auth_group_access/update', '修改管理员功能', '1', '1', '', '2016-09-24 09:37:29', '2016-09-24 09:37:29', null);
INSERT INTO `la_auth_rules` VALUES ('145', '19', 'admin/auth_group/rule_group_show/22', 'test', '1', '1', '', null, null, null);

-- ----------------------------
-- Table structure for la_password_resets
-- ----------------------------
DROP TABLE IF EXISTS `la_password_resets`;
CREATE TABLE `la_password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of la_password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for la_users
-- ----------------------------
DROP TABLE IF EXISTS `la_users`;
CREATE TABLE `la_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '登录邮箱',
  `password` varchar(60) NOT NULL DEFAULT '' COMMENT '登录密码；mb_password加密',
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像，相对于upload/avatar目录',
  `email_code` varchar(60) DEFAULT NULL COMMENT '激活码',
  `phone` bigint(11) unsigned DEFAULT NULL COMMENT '手机号',
  `status` tinyint(1) NOT NULL DEFAULT '2' COMMENT '用户状态 0：禁用； 1：正常 ；2：未验证',
  `last_login_ip` varchar(16) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `last_login_time` int(10) unsigned NOT NULL COMMENT '最后登录时间',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_login_key` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of la_users
-- ----------------------------
INSERT INTO `la_users` VALUES ('88', 'admin', 'baijunyao@baijunyao.com', '$2y$10$62PoswJIay0xaMR5BAyrHez64qydRoZ25RrNg1JyIycbRt5kfqCPu', null, '/Upload/avatar/user1.jpg', '', '0', '1', '', '0', null, null, null);
INSERT INTO `la_users` VALUES ('89', 'admin2', 'test@baijunyao.com', '$2y$10$62PoswJIay0xaMR5BAyrHez64qydRoZ25RrNg1JyIycbRt5kfqCPu', null, '/Upload/avatar/user2.jpg', '', '0', '1', '', '0', null, null, null);
