
CREATE TABLE foco (
   id INT(10) NOT NULL AUTO_INCREMENT,
   nombre VARCHAR(255) DEFAULT NULL COMMENT 'Nombre del Foco',
   descripcion VARCHAR(900) DEFAULT NULL COMMENT 'Descripcion del Foco',
   obs VARCHAR(900) DEFAULT NULL COMMENT 'Obs del Foco',
   pasos MEDIUMTEXT DEFAULT NULL COMMENT 'Proximos pasos del Foco',
   id_ano INT(10) NOT NULL COMMENT 'Id Año',
   id_pais INT(10) NOT NULL COMMENT 'Id Pais',
   id_sede INT(10) NOT NULL COMMENT 'Id Sede',
   id_creator INT(10) UNSIGNED NOT NULL COMMENT 'Id creator',
   id_updater INT(10) UNSIGNED NOT NULL COMMENT 'Id updater',
   date_insert DATETIME NOT NULL COMMENT 'Date insert',
   date_update DATETIME DEFAULT NULL COMMENT 'last date update',
   deleted INT(1) DEFAULT NULL COMMENT 'Deleted',
  PRIMARY KEY (id)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Tabla de los focos';