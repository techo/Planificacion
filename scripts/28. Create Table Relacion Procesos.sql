
CREATE TABLE rlproceso (
   id INT(10) NOT NULL AUTO_INCREMENT,
   kpi1 INT(10) NOT NULL COMMENT 'Kpi 1',
   ponderacion1  DECIMAL(10,2) DEFAULT NULL COMMENT 'Ponderacion 1',
   kpi2 INT(10) DEFAULT NULL COMMENT 'Kpi 2',
   ponderacion2  DECIMAL(10,2) DEFAULT NULL COMMENT 'Ponderacion 2',
   kpi3 INT(10) DEFAULT NULL COMMENT 'Kpi 3',
   ponderacion3  DECIMAL(10,2) DEFAULT NULL COMMENT 'Ponderacion 3',
   kpi4 INT(10) DEFAULT NULL COMMENT 'Kpi 4',
   ponderacion4  DECIMAL(10,2) DEFAULT NULL COMMENT 'Ponderacion 4',
   kpi5 INT(10) DEFAULT NULL COMMENT 'Kpi 5',
   ponderacion5  DECIMAL(10,2) DEFAULT NULL COMMENT 'Ponderacion 5',
   id_proceso INT(10) NOT NULL COMMENT 'Id Proceso',
   ids_propuestas VARCHAR(900) NOT NULL COMMENT 'Id Propuestas',
   ids_procesos VARCHAR(900) NOT NULL COMMENT 'Id Procesos',
   id_creator INT(10) UNSIGNED NOT NULL COMMENT 'Id creator',
   id_updater INT(10) UNSIGNED NOT NULL COMMENT 'Id updater',
   date_insert DATETIME NOT NULL COMMENT 'Date insert',
   date_update DATETIME DEFAULT NULL COMMENT 'last date update',
   deleted INT(1) DEFAULT NULL COMMENT 'Deleted',
  PRIMARY KEY (id)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='tabela de relacion de procesos com kpis';