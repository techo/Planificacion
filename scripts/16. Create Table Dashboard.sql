
CREATE TABLE dashboard (
   id INT(10) NOT NULL AUTO_INCREMENT,
   dashboard VARCHAR(255) NOT NULL COMMENT 'Name Of Dashboard',
   id_creator INT(10) UNSIGNED NOT NULL COMMENT 'Id creator',
   deleted INT(1) DEFAULT NULL COMMENT 'Deleted',
  PRIMARY KEY (id)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Table of Dashboard';