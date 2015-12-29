CREATE TABLE IF NOT EXISTS `#__usernotify_u` (
  `uid` int(11) unsigned NOT NULL,
  `alt_email` text DEFAULT NULL,
  `sms_addr` text DEFAULT NULL,
  `oo_all` tinyint(1) DEFAULT '0',
  `oo_email` tinyint(1) DEFAULT '0',
  `sms_ok` tinyint(1) DEFAULT '0',
  `serdat` text DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__usernotify_c` (
  `cid` int(11) NOT NULL,
  `pub` tinyint(1) NOT NULL DEFAULT '0',
  `upd` tinyint(1) NOT NULL DEFAULT '0',
  `email_tmpl` text,
  `sms_tmpl` text,
  `checked_out` int(10) unsigned DEFAULT '0',
  `checked_out_time` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__usernotify_s` (
  `cid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `email` tinyint(1) NOT NULL,
  `sms` tinyint(1) NOT NULL,
  `update` tinyint(1) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
