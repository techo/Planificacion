
CREATE TABLE dashboardpaises (
   id INT(10) NOT NULL AUTO_INCREMENT,
   id_dashboard INT(10) UNSIGNED NOT NULL COMMENT 'Id dashboard',
   id_pais INT(10) UNSIGNED NOT NULL COMMENT 'Id pais',
   id_creator INT(10) UNSIGNED NOT NULL COMMENT 'Id creator',
   deleted INT(1) DEFAULT NULL COMMENT 'Deleted',
  PRIMARY KEY (id)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Table of Dashboard Paises';