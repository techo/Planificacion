ALTER TABLE ano
ADD COLUMN situation INT(1) DEFAULT 1 COMMENT 'Activo ou Inactivo' AFTER date_update;

ALTER TABLE temporalidad
ADD COLUMN situation INT(1) DEFAULT 1 COMMENT 'Activo ou Inactivo' AFTER date_update;

ALTER TABLE tipo
ADD COLUMN situation INT(1) DEFAULT 1 COMMENT 'Activo ou Inactivo' AFTER date_update;

ALTER TABLE pilar
ADD COLUMN situation INT(1) DEFAULT 1 COMMENT 'Activo ou Inactivo' AFTER date_update;

ALTER TABLE indicador
ADD COLUMN situation INT(1) DEFAULT 1 COMMENT 'Activo ou Inactivo'AFTER date_update;
