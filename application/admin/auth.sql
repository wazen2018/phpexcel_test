
DROP TABLE IF EXISTS `pe_auth_group`;
CREATE TABLE `pe_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

#
# Data for table "pe_auth_group"
#

/*!40000 ALTER TABLE `pe_auth_group` DISABLE KEYS */;
INSERT INTO `pe_auth_group` VALUES (1,'超级管理员',1,'1,2,4,3,5,6,21,11,12,13,14,15,16,20,17'),(8,'普通管理员',1,'3,5,6,21,11,12,16,20,22,23,24,25,26,27,28,29,30'),(9,'123',1,'');
/*!40000 ALTER TABLE `pe_auth_group` ENABLE KEYS */;

#
# Structure for table "pe_auth_group_access"
#

DROP TABLE IF EXISTS `pe_auth_group_access`;
CREATE TABLE `pe_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "pe_auth_group_access"
#

/*!40000 ALTER TABLE `pe_auth_group_access` DISABLE KEYS */;
INSERT INTO `pe_auth_group_access` VALUES (9,1),(20,8);
/*!40000 ALTER TABLE `pe_auth_group_access` ENABLE KEYS */;

#
# Structure for table "pe_auth_rule"
#

DROP TABLE IF EXISTS `pe_auth_rule`;
CREATE TABLE `pe_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `pid` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
