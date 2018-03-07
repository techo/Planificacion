
CREATE TABLE indicador (
   id INT(10) NOT NULL AUTO_INCREMENT,
   indicador VARCHAR(255) NOT NULL COMMENT 'Indicador',
   id_ano INT(10) NOT NULL COMMENT 'Id Ano',
   id_temporalidad INT(10) NOT NULL COMMENT 'Id Temporalidad',
   id_tipo INT(10) NOT NULL COMMENT 'Id Tipo',
   id_pilar INT(10) NOT NULL COMMENT 'Id Pilar',
   id_pais INT(10) DEFAULT NULL COMMENT 'Id Pais',
   id_area INT(10) DEFAULT NULL COMMENT 'Id Area',
   id_sede INT(10) DEFAULT NULL COMMENT 'Id Sede',
   id_creator INT(10) UNSIGNED NOT NULL COMMENT 'Id creator',
   id_updater INT(10) UNSIGNED NOT NULL COMMENT 'Id updater',
   date_insert DATETIME NOT NULL COMMENT 'Date insert',
   date_update DATETIME DEFAULT NULL COMMENT 'last date update',
   deleted INT(1) DEFAULT NULL COMMENT 'Deleted',
  PRIMARY KEY (id),
  FOREIGN KEY (id_ano) REFERENCES ano(id),
  FOREIGN KEY (id_temporalidad) REFERENCES temporalidad(id),
  FOREIGN KEY (id_tipo) REFERENCES tipo(id),
  FOREIGN KEY (id_pilar) REFERENCES pilar(id)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Table of Indicator';