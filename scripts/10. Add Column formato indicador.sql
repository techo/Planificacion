ALTER TABLE indicador 
  ADD COLUMN formato VARCHAR(1) DEFAULT '' COMMENT 'Formato Indicador' AFTER id_sede;

