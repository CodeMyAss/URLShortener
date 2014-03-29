CREATE TABLE IF NOT EXISTS `urls` (
  `code` varchar(20) COLLATE utf8_bin NOT NULL,
  `url` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;