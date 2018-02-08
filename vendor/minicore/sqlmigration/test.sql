/*
Navicat MySQL Data Transfer

Source Server         : vsnmp
Source Server Version : 50716
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50716
File Encoding         : 65001

Date: 2018-02-01 15:05:32
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ciku_keyword
-- ----------------------------
DROP TABLE IF EXISTS `ciku_keyword`;
CREATE TABLE `ciku_keyword` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9766459 DEFAULT CHARSET=latin1;
