<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class TInforme extends BaseModel
{
    protected $table = "ano";
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function ListAnos()
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "cplanificacion.id,";
        $sql .= "cplanificacion.id_ano, ";
        $sql .= "ano.ano, ";
        $sql .= "cplanificacion.situation, ";
        $sql .= "cplanificacion.id_creator, ";
        $sql .= "cplanificacion.id_updater, ";
        $sql .= "cplanificacion.date_insert, ";
        $sql .= "cplanificacion.date_update ";
        $sql .= " FROM cplanificacion";
        $sql .= " INNER JOIN ano ON ano.id = cplanificacion.id_ano ";
        $sql .= "WHERE cplanificacion.deleted = 0 and cplanificacion.situation = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaPaises($idplanificacion)
    {
        $sql  = "";
        $sql .= "SELECT * ";
        $sql .= " FROM dplanificacion ";
        $sql .= "WHERE dplanificacion.situation = 1 and id_cplanificacion = ". $idplanificacion;
        if($_SESSION['Planificacion']['pais_id'] != 5)
        {
            $sql  .= " and dplanificacion.id_pais = ". $_SESSION['Planificacion']['pais_id'];
        }
        $sql  .= " GROUP BY id_pais";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaSedes($idplanificacion, $idpais)
    {
        $sql  = "";
        $sql .= "SELECT * ";
        $sql .= " FROM dplanificacion ";
        $sql .= "WHERE dplanificacion.situation = 1 and id_cplanificacion = ". $idplanificacion . " and dplanificacion.id_pais = " . $idpais." GROUP BY id_sede";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaIndicadores($idplanificacion, $idpais, $idsede)
    {
        $sql  = "";
        $sql .= "SELECT  ";
        $sql .= "dplanificacion.id,  ";
        $sql .= "dplanificacion.id_indicador,  ";
        $sql .= "indicador.indicador  ";
        $sql .= " FROM dplanificacion ";
        $sql .= " INNER JOIN indicador on indicador.id = dplanificacion.id_indicador ";
        $sql .= "WHERE dplanificacion.situation = 1 and id_cplanificacion = ". $idplanificacion . " and dplanificacion.id_pais = " . $idpais."  and dplanificacion.id_sede = ". $idsede;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    // 3 Querys Iguais para caso necessite uma modificacao expecifica em cada relatorio
    public function BuscaTrimestre($idplanificacion, $idpais, $idsede, $idIndicador)
    {
        $sql  = "";
        $sql .= "SELECT  ";
        $sql .= "dplanificacion.*,  ";
        $sql .= "indicador.indicador  ";
        $sql .= " FROM dplanificacion ";
        $sql .= " INNER JOIN indicador on indicador.id = dplanificacion.id_indicador ";
        $sql .= "WHERE dplanificacion.situation = 1 and id_cplanificacion = ". $idplanificacion . " and dplanificacion.id_pais = " . $idpais."  and dplanificacion.id_sede = ". $idsede . " and id_indicador =" . $idIndicador;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaMensual($idplanificacion, $idpais, $idsede, $idIndicador)
    {
        $sql  = "";
        $sql .= "SELECT  ";
        $sql .= "dplanificacion.*,  ";
        $sql .= "indicador.indicador  ";
        $sql .= " FROM dplanificacion ";
        $sql .= " INNER JOIN indicador on indicador.id = dplanificacion.id_indicador ";
        $sql .= "WHERE dplanificacion.situation = 1 and id_cplanificacion = ". $idplanificacion . " and dplanificacion.id_pais = " . $idpais."  and dplanificacion.id_sede = ". $idsede . " and id_indicador =" . $idIndicador;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaAnual($idplanificacion, $idpais, $idsede, $idIndicador)
    {
        $sql  = "";
        $sql .= "SELECT  ";
        $sql .= "dplanificacion.*,  ";
        $sql .= "indicador.indicador  ";
        $sql .= " FROM dplanificacion ";
        $sql .= " INNER JOIN indicador on indicador.id = dplanificacion.id_indicador ";
        $sql .= "WHERE dplanificacion.situation = 1 and id_cplanificacion = ". $idplanificacion . " and dplanificacion.id_pais = " . $idpais."  and dplanificacion.id_sede = ". $idsede . " and id_indicador =" . $idIndicador;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaMonitoreo($idplanificacion, $idpais, $idsede)
    {
        $sql  = "";
        $sql .= "SELECT  ";
        $sql .= "dplanificacion.*,  ";
        $sql .= "indicador.indicador,  ";
        $sql .= "indicador.formato,  ";
        $sql .= "tipo.tipo  ";
        $sql .= " FROM dplanificacion ";
        $sql .= " INNER JOIN indicador on indicador.id = dplanificacion.id_indicador ";
        $sql .= " INNER JOIN tipo ON indicador.id_tipo = tipo.id ";
        $sql .= "WHERE dplanificacion.situation = 1 and id_cplanificacion = ". $idplanificacion . " and dplanificacion.id_pais = " . $idpais."  and dplanificacion.id_sede = ". $idsede . ' and indicador.deleted = 0';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaDadosGerais($idPais, $idcplanificacion)
    {
        $sql  =  "SELECT
                  indicador,
                  formato,
                  tipo,
                  id_indicador,
                  id_sede,
                  SUM(acumulado_plan_anual) AS acumulado_plan_anual,
                  SUM(acumulado_real_anual) AS acumulado_real_anual,
                  (SUM(acumulado_real_anual) / SUM(acumulado_plan_anual) * 100) AS acumulado_rp_anual,
                  SUM(acumulado_plan_s1) AS acumulado_plan_s1,
                  SUM(acumulado_real_s1) AS acumulado_real_s1,
                  (SUM(acumulado_real_s1) / SUM(acumulado_plan_s1) * 100) AS acumulado_rp_s1,
                  SUM(acumulado_plan_s2) AS acumulado_plan_s2,
                  SUM(acumulado_real_s2) AS acumulado_real_s2,
                  (SUM(acumulado_real_s2) / SUM(acumulado_plan_s2) * 100) AS acumulado_rp_s2,
                  SUM(acumulado_plan_t1) AS acumulado_plan_t1,
                  SUM(acumulado_real_t1) AS acumulado_real_t1,
                  (SUM(acumulado_real_t1) / SUM(acumulado_plan_t1) * 100) AS acumulado_rp_t1,
                  SUM(acumulado_plan_t2) AS acumulado_plan_t2,
                  SUM(acumulado_real_t2) AS acumulado_real_t2,
                  (SUM(acumulado_real_t2) / SUM(acumulado_plan_t2) * 100) AS acumulado_rp_t2,
                  SUM(acumulado_plan_t3) AS acumulado_plan_t3,
                  SUM(acumulado_real_t3) AS acumulado_real_t3,
                  (SUM(acumulado_real_t3) / SUM(acumulado_plan_t3) * 100) AS acumulado_rp_t3,
                  SUM(acumulado_plan_t4) AS acumulado_plan_t4,
                  SUM(acumulado_real_t4) AS acumulado_real_t4,
                  (SUM(acumulado_real_t4) / SUM(acumulado_plan_t4) * 100) AS acumulado_rp_t4,
                  SUM(promedio_plan_anual) AS promedio_plan_anual,
                  SUM(promedio_real_anual) AS promedio_real_anual,
                  (SUM(promedio_real_anual) / SUM(promedio_plan_anual) * 100) AS promedio_rp_anual,
                  SUM(promedio_plan_s1) AS promedio_plan_s1,
                  SUM(promedio_real_s1) AS promedio_real_s1,
                  (SUM(promedio_real_s1) / SUM(promedio_plan_s1) * 100) AS promedio_rp_s1,
                  SUM(promedio_plan_s2) AS promedio_plan_s2,
                  SUM(promedio_real_s2) AS promedio_real_s2,
                  (SUM(promedio_real_s2) / SUM(promedio_plan_s2) * 100) AS promedio_rp_s2,
                  SUM(promedio_plan_t1) AS promedio_plan_t1,
                  SUM(promedio_real_t1) AS promedio_real_t1,
                  (SUM(promedio_real_t1) / SUM(promedio_plan_t1) * 100) AS promedio_rp_t1,
                  SUM(promedio_plan_t2) AS promedio_plan_t2,
                  SUM(promedio_real_t2) AS promedio_real_t2,
                  (SUM(promedio_real_t2) / SUM(promedio_plan_t2) * 100) AS promedio_rp_t2,
                  SUM(promedio_plan_t3) AS promedio_plan_t3,
                  SUM(promedio_real_t3) AS promedio_real_t3,
                  (SUM(promedio_real_t3) / SUM(promedio_plan_t3) * 100) AS promedio_rp_t3,
                  SUM(promedio_plan_t4) AS promedio_plan_t4,
                  SUM(promedio_real_t4) AS promedio_real_t4,
                  (SUM(promedio_real_t4) / SUM(promedio_plan_t4) * 100) AS promedio_rp_t4,
                  SUM(minimo_plan_anual) AS minimo_plan_anual,
                  SUM(minimo_real_anual) AS minimo_real_anual,
                  (SUM(minimo_real_anual) / SUM(minimo_plan_anual) * 100) AS minimo_rp_anual,
                  SUM(minimo_plan_s1) AS minimo_plan_s1,
                  SUM(minimo_real_s1) AS minimo_real_s1,
                  (SUM(minimo_real_s1) / SUM(minimo_plan_s1) * 100) AS minimo_rp_s1,
                  SUM(minimo_plan_s2) AS minimo_plan_s2,
                  SUM(minimo_real_s2) AS minimo_real_s2,
                  (SUM(minimo_real_s2) / SUM(minimo_plan_s2) * 100) AS minimo_rp_s2,
                  SUM(minimo_plan_t1) AS minimo_plan_t1,
                  SUM(minimo_real_t1) AS minimo_real_t1,
                  (SUM(minimo_real_t1) / SUM(minimo_plan_t1) * 100) AS minimo_rp_t1,
                  SUM(minimo_plan_t2) AS minimo_plan_t2,
                  SUM(minimo_real_t2) AS minimo_real_t2,
                  (SUM(minimo_real_t2) / SUM(minimo_plan_t2) * 100) AS minimo_rp_t2,
                  SUM(minimo_plan_t3) AS minimo_plan_t3,
                  SUM(minimo_real_t3) AS minimo_real_t3,
                  (SUM(minimo_real_t3) / SUM(minimo_plan_t3) * 100) AS minimo_rp_t3,
                  SUM(minimo_plan_t4) AS minimo_plan_t4,
                  SUM(minimo_real_t4) AS minimo_real_t4,
                  (SUM(minimo_real_t4) / SUM(minimo_plan_t4) * 100) AS minimo_rp_t4,
                  SUM(maximo_plan_anual) AS maximo_plan_anual,
                  SUM(maximo_real_anual) AS maximo_real_anual,
                  (SUM(maximo_real_anual) / SUM(maximo_plan_anual) * 100) AS maximo_rp_anual,
                  SUM(maximo_plan_s1) AS maximo_plan_s1,
                  SUM(maximo_real_s1) AS maximo_real_s1,
                  (SUM(maximo_real_s1) / SUM(maximo_plan_s1) * 100) AS maximo_rp_s1,
                  SUM(maximo_plan_s2) AS maximo_plan_s2,
                  SUM(maximo_real_s2) AS maximo_real_s2,
                  (SUM(maximo_real_s2) / SUM(maximo_plan_s2) * 100) AS maximo_rp_s2,
                  SUM(maximo_plan_t1) AS maximo_plan_t1,
                  SUM(maximo_real_t1) AS maximo_real_t1,
                 (SUM(maximo_real_t1) / SUM(maximo_plan_t1) * 100) AS maximo_rp_t1,
                  SUM(maximo_plan_t2) AS maximo_plan_t2,
                  SUM(maximo_real_t2) AS maximo_real_t2,
                  (SUM(maximo_real_t2) / SUM(maximo_plan_t2) * 100) AS maximo_rp_t2,
                  SUM(maximo_plan_t3) AS maximo_plan_t3,
                  SUM(maximo_real_t3) AS maximo_real_t3,
                  (SUM(maximo_real_t3) / SUM(maximo_plan_t3) * 100) AS maximo_rp_t3,
                  SUM(maximo_plan_t4) AS maximo_plan_t4,
                  SUM(maximo_real_t4) AS maximo_real_t4,
                  (SUM(maximo_real_t4) / SUM(maximo_plan_t4) * 100) AS maximo_rp_t4,
                  SUM(ultimo_plan_anual) AS ultimo_plan_anual,
                  SUM(ultimo_real_anual) AS ultimo_real_anual,
                  (SUM(ultimo_real_anual) / SUM(ultimo_plan_anual) * 100) AS ultimo_rp_anual,
                  SUM(ultimo_plan_s1) AS ultimo_plan_s1,
                  SUM(ultimo_real_s1) AS ultimo_real_s1,
                  (SUM(ultimo_real_s1) / SUM(ultimo_plan_s1) * 100) AS ultimo_rp_s1,
                  SUM(ultimo_plan_s2) AS ultimo_plan_s2,
                  SUM(ultimo_real_s2) AS ultimo_real_s2,
                  (SUM(ultimo_real_s2) / SUM(ultimo_plan_s2) * 100) AS ultimo_rp_s2,
                  SUM(ultimo_plan_t1) AS ultimo_plan_t1,
                  SUM(ultimo_real_t1) AS ultimo_real_t1,
                  (SUM(ultimo_real_t1) / SUM(ultimo_plan_t1) * 100) AS ultimo_rp_t1,
                  SUM(ultimo_plan_t2) AS ultimo_plan_t2,
                  SUM(ultimo_real_t2) AS ultimo_real_t2,
                  (SUM(ultimo_real_t2) / SUM(ultimo_plan_t2) * 100) AS ultimo_rp_t2,
                  SUM(ultimo_plan_t3) AS ultimo_plan_t3,
                  SUM(ultimo_real_t3) AS ultimo_real_t3,
                  (SUM(ultimo_real_t3) / SUM(ultimo_plan_t3) * 100) AS ultimo_rp_t3,
                  SUM(ultimo_plan_t4) AS ultimo_plan_t4,
                  SUM(ultimo_real_t4) AS ultimo_real_t4,
                  (SUM(ultimo_real_t4) / SUM(ultimo_plan_t4) * 100) AS ultimo_rp_t4,
                  id_indicador
                FROM ( ";
        $sql .= "SELECT ";
        $sql .= "dplanificacion.id, ";
        $sql .= "dplanificacion.id_pais, ";
        $sql .= "dplanificacion.id_sede, ";
        $sql .= "dplanificacion.id_indicador, ";
        $sql .= "SUM(dplanificacion.enero_plan), ";
        $sql .= "SUM(dplanificacion.enero_real), ";
        $sql .= "SUM(dplanificacion.febrero_plan), ";
        $sql .= "SUM(dplanificacion.febrero_real), ";
        $sql .= "SUM(dplanificacion.marzo_plan), ";
        $sql .= "SUM(dplanificacion.marzo_real), ";
        $sql .= "SUM(dplanificacion.abril_plan), ";
        $sql .= "SUM(dplanificacion.abril_real), ";
        $sql .= "SUM(dplanificacion.mayo_plan), ";
        $sql .= "SUM(dplanificacion.mayo_real), ";
        $sql .= "SUM(dplanificacion.junio_plan), ";
        $sql .= "SUM(dplanificacion.junio_real), ";
        $sql .= "SUM(dplanificacion.julio_plan), ";
        $sql .= "SUM(dplanificacion.julio_real), ";
        $sql .= "SUM(dplanificacion.agosto_plan), ";
        $sql .= "SUM(dplanificacion.agosto_real), ";
        $sql .= "SUM(dplanificacion.septiembre_plan), ";
        $sql .= "SUM(dplanificacion.septiembre_real), ";
        $sql .= "SUM(dplanificacion.octubre_plan), ";
        $sql .= "SUM(dplanificacion.octubre_real), ";
        $sql .= "SUM(dplanificacion.noviembre_plan), ";
        $sql .= "SUM(dplanificacion.noviembre_real), ";
        $sql .= "SUM(dplanificacion.diciembre_plan), ";
        $sql .= "SUM(dplanificacion.diciembre_real), ";
        
        $sql .= "SUM(dplanificacion.acumulado_plan_anual) as acumulado_plan_anual, ";
        $sql .= "SUM(dplanificacion.acumulado_real_anual) as acumulado_real_anual, ";
        $sql .= "SUM(dplanificacion.acumulado_rp_anual) as acumulado_rp_anual, ";
        $sql .= "SUM(dplanificacion.acumulado_plan_s1) as acumulado_plan_s1, ";
        $sql .= "SUM(dplanificacion.acumulado_real_s1) as acumulado_real_s1, ";
        $sql .= "SUM(dplanificacion.acumulado_rp_s1) as acumulado_rp_s1, ";
        $sql .= "SUM(dplanificacion.acumulado_plan_s2) as acumulado_plan_s2, ";
        $sql .= "SUM(dplanificacion.acumulado_real_s2) as acumulado_real_s2, ";
        $sql .= "SUM(dplanificacion.acumulado_rp_s2) as acumulado_rp_s2, ";
        $sql .= "SUM(dplanificacion.acumulado_plan_t1) AS acumulado_plan_t1, ";
        $sql .= "SUM(dplanificacion.acumulado_real_t1) AS acumulado_real_t1, ";
        $sql .= "SUM(dplanificacion.acumulado_rp_t1) AS acumulado_rp_t1, ";
        $sql .= "SUM(dplanificacion.acumulado_plan_t2) AS acumulado_plan_t2, ";
        $sql .= "SUM(dplanificacion.acumulado_real_t2) AS acumulado_real_t2, ";
        $sql .= "SUM(dplanificacion.acumulado_rp_t2) AS acumulado_rp_t2, ";
        $sql .= "SUM(dplanificacion.acumulado_plan_t3) AS acumulado_plan_t3, ";
        $sql .= "SUM(dplanificacion.acumulado_real_t3) AS acumulado_real_t3, ";
        $sql .= "SUM(dplanificacion.acumulado_rp_t3) AS acumulado_rp_t3, ";
        $sql .= "SUM(dplanificacion.acumulado_plan_t4) AS acumulado_plan_t4, ";
        $sql .= "SUM(dplanificacion.acumulado_real_t4) AS acumulado_real_t4, ";
        $sql .= "SUM(dplanificacion.acumulado_rp_t4) AS acumulado_rp_t4, ";
        
        
        $sql .= "SUM(dplanificacion.promedio_plan_anual) as promedio_plan_anual, ";
        $sql .= "SUM(dplanificacion.promedio_real_anual) as promedio_real_anual, ";
        $sql .= "SUM(dplanificacion.promedio_rp_anual) as promedio_rp_anual, ";
        $sql .= "SUM(dplanificacion.promedio_plan_s1) as promedio_plan_s1, ";
        $sql .= "SUM(dplanificacion.promedio_real_s1) as promedio_real_s1, ";
        $sql .= "SUM(dplanificacion.promedio_rp_s1) as promedio_rp_s1, ";
        $sql .= "SUM(dplanificacion.promedio_plan_s2) as promedio_plan_s2, ";
        $sql .= "SUM(dplanificacion.promedio_real_s2) as promedio_real_s2, ";
        $sql .= "SUM(dplanificacion.promedio_rp_s2) as promedio_rp_s2, ";
        $sql .= "SUM(dplanificacion.promedio_plan_t1) AS promedio_plan_t1, ";
        $sql .= "SUM(dplanificacion.promedio_real_t1) AS promedio_real_t1, ";
        $sql .= "SUM(dplanificacion.promedio_rp_t1) AS promedio_rp_t1, ";
        $sql .= "SUM(dplanificacion.promedio_plan_t2) AS promedio_plan_t2, ";
        $sql .= "SUM(dplanificacion.promedio_real_t2) AS promedio_real_t2, ";
        $sql .= "SUM(dplanificacion.promedio_rp_t2) AS promedio_rp_t2, ";
        $sql .= "SUM(dplanificacion.promedio_plan_t3) AS promedio_plan_t3, ";
        $sql .= "SUM(dplanificacion.promedio_real_t3) AS promedio_real_t3, ";
        $sql .= "SUM(dplanificacion.promedio_rp_t3) AS promedio_rp_t3, ";
        $sql .= "SUM(dplanificacion.promedio_plan_t4) AS promedio_plan_t4, ";
        $sql .= "SUM(dplanificacion.promedio_real_t4) AS promedio_real_t4, ";
        $sql .= "SUM(dplanificacion.promedio_rp_t4) AS promedio_rp_t4, ";
        
        $sql .= "SUM(dplanificacion.minimo_plan_anual) as minimo_plan_anual, ";
        $sql .= "SUM(dplanificacion.minimo_real_anual) as minimo_real_anual, ";
        $sql .= "SUM(dplanificacion.minimo_rp_anual) as minimo_rp_anual, ";
        $sql .= "SUM(dplanificacion.minimo_plan_s1) as minimo_plan_s1, ";
        $sql .= "SUM(dplanificacion.minimo_real_s1) as minimo_real_s1, ";
        $sql .= "SUM(dplanificacion.minimo_rp_s1) as minimo_rp_s1, ";
        $sql .= "SUM(dplanificacion.minimo_plan_s2) as minimo_plan_s2, ";
        $sql .= "SUM(dplanificacion.minimo_real_s2) as minimo_real_s2, ";
        $sql .= "SUM(dplanificacion.minimo_rp_s2) as minimo_rp_s2, ";
        $sql .= "SUM(dplanificacion.minimo_plan_t1) AS minimo_plan_t1, ";
        $sql .= "SUM(dplanificacion.minimo_real_t1) AS minimo_real_t1, ";
        $sql .= "SUM(dplanificacion.minimo_rp_t1) AS minimo_rp_t1, ";
        $sql .= "SUM(dplanificacion.minimo_plan_t2) AS minimo_plan_t2, ";
        $sql .= "SUM(dplanificacion.minimo_real_t2) AS minimo_real_t2, ";
        $sql .= "SUM(dplanificacion.minimo_rp_t2) AS minimo_rp_t2, ";
        $sql .= "SUM(dplanificacion.minimo_plan_t3) AS minimo_plan_t3, ";
        $sql .= "SUM(dplanificacion.minimo_real_t3) AS minimo_real_t3, ";
        $sql .= "SUM(dplanificacion.minimo_rp_t3) AS minimo_rp_t3, ";
        $sql .= "SUM(dplanificacion.minimo_plan_t4) AS minimo_plan_t4, ";
        $sql .= "SUM(dplanificacion.minimo_real_t4) AS minimo_real_t4, ";
        $sql .= "SUM(dplanificacion.minimo_rp_t4) AS minimo_rp_t4, ";
        
        $sql .= "SUM(dplanificacion.maximo_plan_anual) as maximo_plan_anual, ";
        $sql .= "SUM(dplanificacion.maximo_real_anual) as maximo_real_anual, ";
        $sql .= "SUM(dplanificacion.maximo_rp_anual) as maximo_rp_anual, ";
        $sql .= "SUM(dplanificacion.maximo_plan_s1) as maximo_plan_s1, ";
        $sql .= "SUM(dplanificacion.maximo_real_s1) as maximo_real_s1, ";
        $sql .= "SUM(dplanificacion.maximo_rp_s1) as maximo_rp_s1, ";
        $sql .= "SUM(dplanificacion.maximo_plan_s2) as maximo_plan_s2, ";
        $sql .= "SUM(dplanificacion.maximo_real_s2) as maximo_real_s2, ";
        $sql .= "SUM(dplanificacion.maximo_rp_s2) as maximo_rp_s2, ";
        $sql .= "SUM(dplanificacion.maximo_plan_t1) AS maximo_plan_t1, ";
        $sql .= "SUM(dplanificacion.maximo_real_t1) AS maximo_real_t1, ";
        $sql .= "SUM(dplanificacion.maximo_rp_t1) AS maximo_rp_t1, ";
        $sql .= "SUM(dplanificacion.maximo_plan_t2) AS maximo_plan_t2, ";
        $sql .= "SUM(dplanificacion.maximo_real_t2) AS maximo_real_t2, ";
        $sql .= "SUM(dplanificacion.maximo_rp_t2) AS maximo_rp_t2, ";
        $sql .= "SUM(dplanificacion.maximo_plan_t3) AS maximo_plan_t3, ";
        $sql .= "SUM(dplanificacion.maximo_real_t3) AS maximo_real_t3, ";
        $sql .= "SUM(dplanificacion.maximo_rp_t3) AS maximo_rp_t3, ";
        $sql .= "SUM(dplanificacion.maximo_plan_t4) AS maximo_plan_t4, ";
        $sql .= "SUM(dplanificacion.maximo_real_t4) AS maximo_real_t4, ";
        $sql .= "SUM(dplanificacion.maximo_rp_t4) AS maximo_rp_t4, ";
        
        $sql .= "SUM(dplanificacion.ultimo_plan_anual) as ultimo_plan_anual, ";
        $sql .= "SUM(dplanificacion.ultimo_real_anual) as ultimo_real_anual, ";
        $sql .= "SUM(dplanificacion.ultimo_rp_anual) as ultimo_rp_anual, ";
        $sql .= "SUM(dplanificacion.ultimo_plan_s1) as ultimo_plan_s1, ";
        $sql .= "SUM(dplanificacion.ultimo_real_s1) as ultimo_real_s1, ";
        $sql .= "SUM(dplanificacion.ultimo_rp_s1) as ultimo_rp_s1, ";
        $sql .= "SUM(dplanificacion.ultimo_plan_s2) as ultimo_plan_s2, ";
        $sql .= "SUM(dplanificacion.ultimo_real_s2) as ultimo_real_s2, ";
        $sql .= "SUM(dplanificacion.ultimo_rp_s2) as ultimo_rp_s2, ";
        $sql .= "SUM(dplanificacion.ultimo_plan_t1) AS ultimo_plan_t1, ";
        $sql .= "SUM(dplanificacion.ultimo_real_t1) AS ultimo_real_t1, ";
        $sql .= "SUM(dplanificacion.ultimo_rp_t1) AS ultimo_rp_t1, ";
        $sql .= "SUM(dplanificacion.ultimo_plan_t2) AS ultimo_plan_t2, ";
        $sql .= "SUM(dplanificacion.ultimo_real_t2) AS ultimo_real_t2, ";
        $sql .= "SUM(dplanificacion.ultimo_rp_t2) AS ultimo_rp_t2, ";
        $sql .= "SUM(dplanificacion.ultimo_plan_t3) AS ultimo_plan_t3, ";
        $sql .= "SUM(dplanificacion.ultimo_real_t3) AS ultimo_real_t3, ";
        $sql .= "SUM(dplanificacion.ultimo_rp_t3) AS ultimo_rp_t3, ";
        $sql .= "SUM(dplanificacion.ultimo_plan_t4) AS ultimo_plan_t4, ";
        $sql .= "SUM(dplanificacion.ultimo_real_t4) AS ultimo_real_t4, ";
        $sql .= "SUM(dplanificacion.ultimo_rp_t4) AS ultimo_rp_t4, ";
        
        $sql .= "indicador.indicador,  ";
        $sql .= "indicador.formato,  ";
        $sql .= "tipo.tipo  ";
        $sql .= " FROM dplanificacion ";
        $sql .= " INNER JOIN indicador on indicador.id = dplanificacion.id_indicador ";
        $sql .= " INNER JOIN tipo ON indicador.id_tipo = tipo.id ";
        $sql .= "WHERE dplanificacion.id_cplanificacion = ". $idcplanificacion." AND dplanificacion.id_pais = " . $idPais;
        $sql .= " GROUP BY dplanificacion.id_indicador";
        $sql .= " ) soma GROUP BY id_indicador ";
        
//          die(print_r($sql, true));
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
}
