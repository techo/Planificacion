
CREATE TABLE proposito (
   id INT(10) NOT NULL AUTO_INCREMENT,
   proposito VARCHAR(255) NOT NULL COMMENT 'Proposito',
   descripcion VARCHAR(900) NOT NULL COMMENT 'Descripcion',
   id_pais INT(10) NOT NULL COMMENT 'Id Pais',
   id_ano INT(10) NOT NULL COMMENT 'Id Ano',
   id_creator INT(10) UNSIGNED NOT NULL COMMENT 'Id creator',
   id_updater INT(10) UNSIGNED NOT NULL COMMENT 'Id updater',
   date_insert DATETIME NOT NULL COMMENT 'Date insert',
   date_update DATETIME DEFAULT NULL COMMENT 'last date update',
   deleted INT(1) DEFAULT NULL COMMENT 'Deleted',
  PRIMARY KEY (id),
  FOREIGN KEY (id_ano) REFERENCES ano(id)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='tabela de propositos';