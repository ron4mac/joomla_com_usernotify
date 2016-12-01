CREATE TABLE IF NOT EXISTS `#__usernotify_u` (
  `id` int(11) NOT NULL,
  `uid` int(11) unsigned NOT NULL,
  `alt_email` varchar(255) DEFAULT NULL,
  `sms_addr` varchar(255) DEFAULT NULL,
  `oo_all` tinyint(1) DEFAULT '0',
  `oo_email` tinyint(1) DEFAULT '0',
  `sms_ok` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__usernotify_c` (
  `nid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `grps` varchar(255) NOT NULL DEFAULT '2',
  `pub` tinyint(1) NOT NULL DEFAULT '0',
  `upd` tinyint(1) NOT NULL DEFAULT '0',
  `email_tmpl` text,
  `sms_tmpl` text,
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`nid`),
  UNIQUE KEY `cid` (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
--CREATE TABLE IF NOT EXISTS `#__usernotify_s` (
--  `cid` int(11) NOT NULL,
--  `uid` int(11) NOT NULL,
--  `email` tinyint(1) NOT NULL,
--  `sms` tinyint(1) NOT NULL,
--  `update` tinyint(1) NOT NULL,
--  PRIMARY KEY (`cid`)
--) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__usernotify_uc` (
  `uid` int(11) NOT NULL,
  `catid` int(11) NOT NULL,
  `eml` tinyint(1) DEFAULT NULL,
  `sms` tinyint(1) DEFAULT NULL,
  `upd` tinyint(1) DEFAULT NULL,
  UNIQUE KEY `uid` (`uid`,`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
