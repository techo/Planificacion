ALTER TABLE dplanificacion 
  ADD COLUMN ultimo_plan_anual DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Plan Anual' AFTER maximo_rp_s2,
  
  ADD COLUMN ultimo_real_anual DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Real Anual' AFTER ultimo_plan_anual,
  
  ADD COLUMN ultimo_rp_anual DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo RP Anual' AFTER ultimo_real_anual,
  
  ADD COLUMN ultimo_plan_t1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Plan Trimestre 1' AFTER ultimo_rp_anual,
  
  ADD COLUMN ultimo_real_t1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Real Trimestre 1' AFTER ultimo_plan_t1,
  
  ADD COLUMN ultimo_rp_t1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo RP Trimestre 1' AFTER ultimo_real_t1,
  
  ADD COLUMN ultimo_plan_t2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Plan Trimestre 2' AFTER ultimo_rp_t1,
  
  ADD COLUMN ultimo_real_t2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Real Trimestre 2' AFTER ultimo_plan_t2,
  
  ADD COLUMN ultimo_rp_t2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo RP Trimestre 2' AFTER ultimo_real_t2,
  
  ADD COLUMN ultimo_plan_t3 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER ultimo_rp_t2,
  
  ADD COLUMN ultimo_real_t3 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER ultimo_plan_t3,
  
  ADD COLUMN ultimo_rp_t3 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER ultimo_real_t3,
  
  ADD COLUMN ultimo_plan_t4 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER ultimo_rp_t3,
  
  ADD COLUMN ultimo_real_t4 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER ultimo_plan_t4,
  
  ADD COLUMN ultimo_rp_t4 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER ultimo_real_t4,
  
  ADD COLUMN ultimo_plan_s1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Plan Semestre 1' AFTER ultimo_rp_t4,
  
  ADD COLUMN ultimo_real_s1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Real Semestre 1' AFTER ultimo_plan_s1,
  
  ADD COLUMN ultimo_rp_s1 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER ultimo_real_s1,
  
  ADD COLUMN ultimo_plan_s2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Plan Semestre 2' AFTER ultimo_rp_s1,
  
  ADD COLUMN ultimo_real_s2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Real Semestre 2' AFTER ultimo_plan_s2,
  
  ADD COLUMN ultimo_rp_s2 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER ultimo_real_s2

