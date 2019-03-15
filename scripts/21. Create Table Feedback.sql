
CREATE TABLE feedback (
   id INT(10) NOT NULL AUTO_INCREMENT,
   id_usuario INT(10) NOT NULL COMMENT 'Id Usurio',
   nombre_usuario VARCHAR(255) NOT NULL COMMENT 'Nombre del usuario',
   fecha_hora DATETIME NOT NULL COMMENT 'Fecha del feedback',
   feedback MEDIUMTEXT NOT NULL COMMENT 'Mensaje de feedback',
   foto_usuario VARCHAR(255) NOT NULL COMMENT 'Foto del usuario',
   date_insert DATETIME NOT NULL COMMENT 'Date insert',
   date_update DATETIME DEFAULT NULL COMMENT 'last date update',
   deleted INT(1) DEFAULT NULL COMMENT 'Deleted',
  PRIMARY KEY (id)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Table of feedbacks';