ALTER TABLE dplanificacion 
  ADD COLUMN minimo_plan_anual DECIMAL(10,2) DEFAULT NULL COMMENT 'Minimo Plan Anual' AFTER promedio_real_s2,
  
  ADD COLUMN minimo_real_anual DECIMAL(10,2) DEFAULT NULL COMMENT 'Minimo Real Anual' AFTER minimo_plan_anual,
  
  ADD COLUMN minimo_rp_anual DECIMAL(10,2) DEFAULT NULL COMMENT 'Minimo RP Anual' AFTER minimo_real_anual,
  
  ADD COLUMN minimo_plan_t1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Minimo Plan Trimestre 1' AFTER minimo_rp_anual,
  
  ADD COLUMN minimo_real_t1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Minimo Real Trimestre 1' AFTER minimo_plan_t1,
  
  ADD COLUMN minimo_rp_t1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Minimo RP Trimestre 1' AFTER minimo_real_t1,
  
  ADD COLUMN minimo_plan_t2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Minimo Plan Trimestre 2' AFTER minimo_rp_t1,
  
  ADD COLUMN minimo_real_t2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Minimo Real Trimestre 2' AFTER minimo_plan_t2,
  
  ADD COLUMN minimo_rp_t2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Minimo RP Trimestre 2' AFTER minimo_real_t2,
  
  ADD COLUMN minimo_plan_t3 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER minimo_rp_t2,
  
  ADD COLUMN minimo_real_t3 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER minimo_plan_t3,
  
  ADD COLUMN minimo_rp_t3 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER minimo_real_t3,
  
  ADD COLUMN minimo_plan_t4 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER minimo_rp_t3,
  
  ADD COLUMN minimo_real_t4 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER minimo_plan_t4,
  
  ADD COLUMN minimo_rp_t4 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER minimo_real_t4,
  
  ADD COLUMN minimo_plan_s1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Minimo Plan Semestre 1' AFTER minimo_rp_t4,
  
  ADD COLUMN minimo_real_s1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Minimo Real Semestre 1' AFTER minimo_plan_s1,
  
  ADD COLUMN minimo_rp_s1 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER minimo_real_s1,
  
  ADD COLUMN minimo_plan_s2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Minimo Plan Semestre 2' AFTER minimo_rp_s1,
  
  ADD COLUMN minimo_real_s2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Minimo Real Semestre 2' AFTER minimo_plan_s2,
  
  ADD COLUMN minimo_rp_s2 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER minimo_real_s2

