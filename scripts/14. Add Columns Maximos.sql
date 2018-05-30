ALTER TABLE dplanificacion 
  ADD COLUMN maximo_plan_anual DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Plan Anual' AFTER minimo_rp_s2,
  
  ADD COLUMN maximo_real_anual DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Real Anual' AFTER maximo_plan_anual,
  
  ADD COLUMN maximo_rp_anual DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo RP Anual' AFTER maximo_real_anual,
  
  ADD COLUMN maximo_plan_t1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Plan Trimestre 1' AFTER maximo_rp_anual,
  
  ADD COLUMN maximo_real_t1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Real Trimestre 1' AFTER maximo_plan_t1,
  
  ADD COLUMN maximo_rp_t1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo RP Trimestre 1' AFTER maximo_real_t1,
  
  ADD COLUMN maximo_plan_t2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Plan Trimestre 2' AFTER maximo_rp_t1,
  
  ADD COLUMN maximo_real_t2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Real Trimestre 2' AFTER maximo_plan_t2,
  
  ADD COLUMN maximo_rp_t2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo RP Trimestre 2' AFTER maximo_real_t2,
  
  ADD COLUMN maximo_plan_t3 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER maximo_rp_t2,
  
  ADD COLUMN maximo_real_t3 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER maximo_plan_t3,
  
  ADD COLUMN maximo_rp_t3 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER maximo_real_t3,
  
  ADD COLUMN maximo_plan_t4 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER maximo_rp_t3,
  
  ADD COLUMN maximo_real_t4 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER maximo_plan_t4,
  
  ADD COLUMN maximo_rp_t4 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER maximo_real_t4,
  
  ADD COLUMN maximo_plan_s1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Plan Semestre 1' AFTER maximo_rp_t4,
  
  ADD COLUMN maximo_real_s1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Real Semestre 1' AFTER maximo_plan_s1,
  
  ADD COLUMN maximo_rp_s1 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER maximo_real_s1,
  
  ADD COLUMN maximo_plan_s2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Plan Semestre 2' AFTER maximo_rp_s1,
  
  ADD COLUMN maximo_real_s2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Maximo Real Semestre 2' AFTER maximo_plan_s2,
  
  ADD COLUMN maximo_rp_s2 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER maximo_real_s2

