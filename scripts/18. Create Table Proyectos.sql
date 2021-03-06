
CREATE TABLE proyecto (
   id INT(10) NOT NULL AUTO_INCREMENT,
   proyecto VARCHAR(255) NOT NULL COMMENT 'Nombre Proyecto',
   responsable VARCHAR(255) NOT NULL COMMENT 'Responsables por el Proyecto',
   id_indicador_1 INT(10) NOT NULL COMMENT 'Id Indicador 1',
   ponderacion_1 DECIMAL(10,2) NOT NULL COMMENT 'Ponderacion Indicador',
   id_indicador_2 INT(10) DEFAULT NULL COMMENT 'Id Indicador 2',
   ponderacion_2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Ponderacion Indicador',
   id_indicador_3 INT(10) DEFAULT NULL COMMENT 'Id Indicador 3',
   ponderacion_3 DECIMAL(10,2) DEFAULT NULL COMMENT 'Ponderacion Indicador',
   id_indicador_4 INT(10) DEFAULT NULL COMMENT 'Id Indicador 4',
   ponderacion_4 DECIMAL(10,2) DEFAULT NULL COMMENT 'Ponderacion Indicador',
   id_indicador_5 INT(10) DEFAULT NULL COMMENT 'Id Indicador 5',
   ponderacion_5 DECIMAL(10,2) DEFAULT NULL COMMENT 'Ponderacion Indicador',
   id_indicador_6 INT(10) DEFAULT NULL COMMENT 'Id Indicador 6',
   ponderacion_6 DECIMAL(10,2) DEFAULT NULL COMMENT 'Ponderacion Indicador',
   id_indicador_7 INT(10) DEFAULT NULL COMMENT 'Id Indicador 7',
   ponderacion_7 DECIMAL(10,2) DEFAULT NULL COMMENT 'Ponderacion Indicador',
   id_indicador_8 INT(10) DEFAULT NULL COMMENT 'Id Indicador 8',
   ponderacion_8 DECIMAL(10,2) DEFAULT NULL COMMENT 'Ponderacion Indicador',
   id_indicador_9 INT(10) DEFAULT NULL COMMENT 'Id Indicador 9',
   ponderacion_9 DECIMAL(10,2) DEFAULT NULL COMMENT 'Ponderacion Indicador',
   id_indicador_10 INT(10) DEFAULT NULL COMMENT 'Id Indicador 10',
   ponderacion_10 DECIMAL(10,2) DEFAULT NULL COMMENT 'Ponderacion Indicador',
   id_ano INT(10) NOT NULL COMMENT 'Id ano',
   id_pais INT(10) NOT NULL COMMENT 'Id pais',
   id_sede INT(10) NOT NULL COMMENT 'Id sede',
   id_cplanificacion INT(10) NOT NULL COMMENT 'Id cplanificacion',
   id_creator INT(10) UNSIGNED NOT NULL COMMENT 'Id creator',
   id_updater INT(10) UNSIGNED NOT NULL COMMENT 'Id updater',
   date_insert DATETIME NOT NULL COMMENT 'Date insert',
   date_update DATETIME DEFAULT NULL COMMENT 'last date update',
   deleted INT(1) DEFAULT NULL COMMENT 'Deleted',
  PRIMARY KEY (id)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Table of proyectos';