
ALTER TABLE indicador
ADD COLUMN descripcion VARCHAR(255) DEFAULT NULL COMMENT 'descripcion del indicador' AFTER formato;
