
CREATE TABLE IF NOT EXISTS `private_messages` (
  `id` int(11) NOT NULL auto_increment,
  `private_message_thread_id` int(11) default NULL,
  `sender_id` int(11) NOT NULL COMMENT 'users',
  `body` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `sender_id` (`sender_id`,`created_at`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;


CREATE TABLE IF NOT EXISTS `private_message_recipients` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `private_message_id` int(11) NOT NULL,
  `read_at` datetime default NULL,
  `delivered_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`,`private_message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


CREATE TABLE IF NOT EXISTS `private_message_threads` (
  `id` int(11) NOT NULL auto_increment,
  `subject` varchar(500) default NULL,
  `created_at` datetime NOT NULL,
  `most_recent_private_message_id` int(11) NOT NULL COMMENT 'private_messages',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;
