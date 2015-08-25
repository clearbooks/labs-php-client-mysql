CREATE TABLE IF NOT EXISTS `group_policy` (
  `group_id` varchar(128) NOT NULL,
  `toggle_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`group_id`,`toggle_id`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `toggle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` enum('user','group') NOT NULL DEFAULT 'user',
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  `release_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `visible` (`visible`),
  KEY `release_id` (`release_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `user_policy` (
  `user_id` varchar(128) NOT NULL,
  `toggle_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`,`toggle_id`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
