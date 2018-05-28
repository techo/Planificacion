ALTER TABLE dplanificacion 
  ADD COLUMN promedio_plan_anual DECIMAL(10,2) DEFAULT NULL COMMENT 'Promedio Plan Anual' AFTER acumulado_rp_s2,
  
  ADD COLUMN promedio_real_anual DECIMAL(10,2) DEFAULT NULL COMMENT 'Promedio Real Anual' AFTER promedio_plan_anual,
  
  ADD COLUMN promedio_rp_anual DECIMAL(10,2) DEFAULT NULL COMMENT 'Promedio RP Anual' AFTER promedio_real_anual,
  
  ADD COLUMN promedio_plan_t1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Promedio Plan Trimestre 1' AFTER promedio_rp_anual,
  
  ADD COLUMN promedio_real_t1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Promedio Real Trimestre 1' AFTER promedio_plan_t1,
  
  ADD COLUMN promedio_rp_t1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Promedio RP Trimestre 1' AFTER promedio_real_t1,
  
  ADD COLUMN promedio_plan_t2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Promedio Plan Trimestre 2' AFTER promedio_rp_t1,
  
  ADD COLUMN promedio_real_t2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Promedio Real Trimestre 2' AFTER promedio_plan_t2,
  
  ADD COLUMN promedio_rp_t2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Promedio RP Trimestre 2' AFTER promedio_real_t2,
  
  ADD COLUMN promedio_plan_t3 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER promedio_rp_t2,
  
  ADD COLUMN promedio_real_t3 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER promedio_plan_t3,
  
  ADD COLUMN promedio_rp_t3 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER promedio_real_t3,
  
  ADD COLUMN promedio_plan_t4 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER promedio_rp_t3,
  
  ADD COLUMN promedio_real_t4 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER promedio_plan_t4,
  
  ADD COLUMN promedio_rp_t4 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER promedio_real_t4,
  
  ADD COLUMN promedio_plan_s1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Promedio Plan Semestre 1' AFTER promedio_rp_t4,
  
  ADD COLUMN promedio_real_s1 DECIMAL(10,2) DEFAULT NULL COMMENT 'Promedio Real Semestre 1' AFTER promedio_plan_s1,
  
  ADD COLUMN promedio_rp_s1 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER promedio_real_s1,
  
  ADD COLUMN promedio_plan_s2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Promedio Plan Semestre 2' AFTER promedio_rp_s1,
  
  ADD COLUMN promedio_real_s2 DECIMAL(10,2) DEFAULT NULL COMMENT 'Promedio Real Semestre 2' AFTER promedio_plan_s2,
  
  ADD COLUMN promedio_rp_s2 DECIMAL(10,2) DEFAULT NULL COMMENT 'valores calculados' AFTER promedio_real_s2

