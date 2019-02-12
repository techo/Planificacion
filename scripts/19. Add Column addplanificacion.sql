
ALTER TABLE indicador
ADD COLUMN addplanificacion VARCHAR(255) DEFAULT 0 COMMENT 'adicionado na planificacion do ano corrente 1 sim 0 Nao' AFTER date_update;

UPDATE indicador
SET addplanificacion = 1
WHERE id_pais = 0; 