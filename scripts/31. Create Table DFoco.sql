
CREATE TABLE dfoco (
   id INT(10) NOT NULL AUTO_INCREMENT,
   id_foco INT(10) NOT NULL COMMENT 'Id del encabezado Foco',
   id_indicador INT(10) NOT NULL COMMENT 'Id Indicador del Foco',
   ponderacion  DECIMAL(10,2) DEFAULT NULL COMMENT 'Ponderacion',
   id_creator INT(10) UNSIGNED NOT NULL COMMENT 'Id creator',
   id_updater INT(10) UNSIGNED NOT NULL COMMENT 'Id updater',
   date_insert DATETIME NOT NULL COMMENT 'Date insert',
   date_update DATETIME DEFAULT NULL COMMENT 'last date update',
   deleted INT(1) DEFAULT NULL COMMENT 'Deleted',
  PRIMARY KEY (id)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Tabla de los focos';