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
        $sql .= "indicador.indicador, ";
        $sql .= "indicador.id_tipo  ";
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
        $sql .= "indicador.indicador,  ";
        $sql .= "indicador.formato,  ";
        $sql .= "tipo.tipo  ";
        $sql .= " FROM dplanificacion ";
        $sql .= " INNER JOIN indicador on indicador.id = dplanificacion.id_indicador ";
        $sql .= " INNER JOIN tipo ON indicador.id_tipo = tipo.id ";
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
        $sql .= "dplanificacion.id,  ";
        $sql .= "dplanificacion.id_cplanificacion,  ";
        $sql .= "dplanificacion.id_pais,  ";
        $sql .= "dplanificacion.id_sede,  ";
        $sql .= "dplanificacion.id_indicador,  ";
        $sql .= "dplanificacion.enero_plan,  ";
        $sql .= "dplanificacion.enero_real,  ";
        $sql .= "dplanificacion.febrero_plan,  ";
        $sql .= "dplanificacion.febrero_real,  ";
        $sql .= "dplanificacion.marzo_plan,  ";
        $sql .= "dplanificacion.marzo_real,  ";
        $sql .= "dplanificacion.abril_plan,  ";
        $sql .= "dplanificacion.abril_real,  ";
        $sql .= "dplanificacion.mayo_plan,  ";
        $sql .= "dplanificacion.mayo_real,  ";
        $sql .= "dplanificacion.junio_plan,  ";
        $sql .= "dplanificacion.junio_real,  ";
        $sql .= "dplanificacion.julio_plan,  ";
        $sql .= "dplanificacion.julio_real,  ";
        $sql .= "dplanificacion.agosto_plan,  ";
        $sql .= "dplanificacion.agosto_real,  ";
        $sql .= "dplanificacion.septiembre_plan,  ";
        $sql .= "dplanificacion.septiembre_real,  ";
        $sql .= "dplanificacion.octubre_plan,  ";
        $sql .= "dplanificacion.octubre_real,  ";
        $sql .= "dplanificacion.noviembre_plan,  ";
        $sql .= "dplanificacion.noviembre_real,  ";
        $sql .= "dplanificacion.diciembre_plan,  ";
        $sql .= "dplanificacion.diciembre_real,  ";
        $sql .= "dplanificacion.acumulado_plan_anual,  ";
        $sql .= "dplanificacion.acumulado_real_anual,  ";
        $sql .= "(dplanificacion.acumulado_rp_anual * 100) as 'acumulado_rp_anual',  ";
        $sql .= "dplanificacion.acumulado_plan_t1,  ";
        $sql .= "dplanificacion.acumulado_real_t1,  ";
        $sql .= "(dplanificacion.acumulado_rp_t1 * 100) as 'acumulado_rp_t1',  ";
        $sql .= "dplanificacion.acumulado_plan_t2,  ";
        $sql .= "dplanificacion.acumulado_real_t2,  ";
        $sql .= "(dplanificacion.acumulado_rp_t2 * 100) as 'acumulado_rp_t2',  ";
        $sql .= "dplanificacion.acumulado_plan_t3,  ";
        $sql .= "dplanificacion.acumulado_real_t3,  ";
        $sql .= "(dplanificacion.acumulado_rp_t3 * 100) as 'acumulado_rp_t3',  ";
        $sql .= "dplanificacion.acumulado_plan_t4,  ";
        $sql .= "dplanificacion.acumulado_real_t4,  ";
        $sql .= "(dplanificacion.acumulado_rp_t4 * 100) as 'acumulado_rp_t4',  ";
        $sql .= "dplanificacion.acumulado_plan_s1,  ";
        $sql .= "dplanificacion.acumulado_real_s1,  ";
        $sql .= "(dplanificacion.acumulado_rp_s1 * 100) as 'acumulado_rp_s1',  ";
        $sql .= "dplanificacion.acumulado_plan_s2,  ";
        $sql .= "dplanificacion.acumulado_real_s2,  ";
        $sql .= "(dplanificacion.acumulado_rp_s2 * 100) as 'acumulado_rp_s2',  ";
        $sql .= "dplanificacion.promedio_plan_anual,  ";
        $sql .= "dplanificacion.promedio_real_anual,  ";
        $sql .= "(dplanificacion.promedio_rp_anual * 100) as 'promedio_rp_anual',  ";
        $sql .= "dplanificacion.promedio_plan_t1,  ";
        $sql .= "dplanificacion.promedio_real_t1,  ";
        $sql .= "(dplanificacion.promedio_rp_t1 * 100) as 'promedio_rp_t1',  ";
        $sql .= "dplanificacion.promedio_plan_t2,  ";
        $sql .= "dplanificacion.promedio_real_t2,  ";
        $sql .= "(dplanificacion.promedio_rp_t2 * 100) as 'promedio_rp_t2',  ";
        $sql .= "dplanificacion.promedio_plan_t3,  ";
        $sql .= "dplanificacion.promedio_real_t3,  ";
        $sql .= "(dplanificacion.promedio_rp_t3 * 100) as 'promedio_rp_t3',  ";
        $sql .= "dplanificacion.promedio_plan_t4,  ";
        $sql .= "dplanificacion.promedio_real_t4,  ";
        $sql .= "(dplanificacion.promedio_rp_t4 * 100) as 'promedio_rp_t4',  ";
        $sql .= "dplanificacion.promedio_plan_s1,  ";
        $sql .= "dplanificacion.promedio_real_s1,  ";
        $sql .= "(dplanificacion.promedio_rp_s1 * 100) as 'promedio_rp_s1',  ";
        $sql .= "dplanificacion.promedio_plan_s2,  ";
        $sql .= "dplanificacion.promedio_real_s2,  ";
        $sql .= "dplanificacion.minimo_plan_anual,  ";
        $sql .= "dplanificacion.minimo_real_anual,  ";
        $sql .= "(dplanificacion.minimo_rp_anual * 100) as 'minimo_rp_anual',  ";
        $sql .= "dplanificacion.minimo_plan_t1,  ";
        $sql .= "dplanificacion.minimo_real_t1,  ";
        $sql .= "(dplanificacion.minimo_rp_t1 * 100) as 'minimo_rp_t1',  ";
        $sql .= "dplanificacion.minimo_plan_t2,  ";
        $sql .= "dplanificacion.minimo_real_t2,  ";
        $sql .= "(dplanificacion.minimo_rp_t2 * 100) as 'minimo_rp_t2',  ";
        $sql .= "dplanificacion.minimo_plan_t3,  ";
        $sql .= "dplanificacion.minimo_real_t3,  ";
        $sql .= "(dplanificacion.minimo_rp_t3 * 100) as 'minimo_rp_t3',  ";
        $sql .= "dplanificacion.minimo_plan_t4,  ";
        $sql .= "dplanificacion.minimo_real_t4,  ";
        $sql .= "(dplanificacion.minimo_rp_t4 * 100) as 'minimo_rp_t4',  ";
        $sql .= "dplanificacion.minimo_plan_s1,  ";
        $sql .= "dplanificacion.minimo_real_s1,  ";
        $sql .= "(dplanificacion.minimo_rp_s1 * 100) as 'minimo_rp_s1',  ";
        $sql .= "dplanificacion.minimo_plan_s2,  ";
        $sql .= "dplanificacion.minimo_real_s2,  ";
        $sql .= "(dplanificacion.minimo_rp_s2 * 100) as 'minimo_rp_s2',  ";
        $sql .= "dplanificacion.maximo_plan_anual,  ";
        $sql .= "dplanificacion.maximo_real_anual,  ";
        $sql .= "(dplanificacion.maximo_rp_anual * 100) as 'maximo_rp_anual',  ";
        $sql .= "dplanificacion.maximo_plan_t1,  ";
        $sql .= "dplanificacion.maximo_real_t1,  ";
        $sql .= "(dplanificacion.maximo_rp_t1 * 100) as 'maximo_rp_t1',  ";
        $sql .= "dplanificacion.maximo_plan_t2,  ";
        $sql .= "dplanificacion.maximo_real_t2,  ";
        $sql .= "(dplanificacion.maximo_rp_t2 * 100) as 'maximo_rp_t2',  ";
        $sql .= "dplanificacion.maximo_plan_t3,  ";
        $sql .= "dplanificacion.maximo_real_t3,  ";
        $sql .= "(dplanificacion.maximo_rp_t3 * 100) as 'maximo_rp_t3',  ";
        $sql .= "dplanificacion.maximo_plan_t4,  ";
        $sql .= "dplanificacion.maximo_real_t4,  ";
        $sql .= "(dplanificacion.maximo_rp_t4 * 100) as 'maximo_rp_t4',  ";
        $sql .= "dplanificacion.maximo_plan_s1,  ";
        $sql .= "dplanificacion.maximo_real_s1,  ";
        $sql .= "(dplanificacion.maximo_rp_s1 * 100) as 'maximo_rp_s1',  ";
        $sql .= "dplanificacion.maximo_plan_s2,  ";
        $sql .= "dplanificacion.maximo_real_s2,  ";
        $sql .= "(dplanificacion.maximo_rp_s2 * 100) as 'maximo_rp_s2',  ";
        $sql .= "dplanificacion.ultimo_plan_anual,  ";
        $sql .= "dplanificacion.ultimo_real_anual,  ";
        $sql .= "(dplanificacion.ultimo_rp_anual * 100) as 'ultimo_rp_anual',  ";
        $sql .= "dplanificacion.ultimo_plan_t1,  ";
        $sql .= "dplanificacion.ultimo_real_t1,  ";
        $sql .= "(dplanificacion.ultimo_rp_t1 * 100) as 'ultimo_rp_t1',  ";
        $sql .= "dplanificacion.ultimo_plan_t2,  ";
        $sql .= "dplanificacion.ultimo_real_t2,  ";
        $sql .= "(dplanificacion.ultimo_rp_t2 * 100) as 'ultimo_rp_t2',  ";
        $sql .= "dplanificacion.ultimo_plan_t3,  ";
        $sql .= "dplanificacion.ultimo_real_t3,  ";
        $sql .= "(dplanificacion.ultimo_rp_t3 * 100) as 'ultimo_rp_t3',  ";
        $sql .= "dplanificacion.ultimo_plan_t4,  ";
        $sql .= "dplanificacion.ultimo_real_t4,  ";
        $sql .= "(dplanificacion.ultimo_rp_t4 * 100) as 'ultimo_rp_t4',  ";
        $sql .= "dplanificacion.ultimo_plan_s1,  ";
        $sql .= "dplanificacion.ultimo_real_s1,  ";
        $sql .= "(dplanificacion.ultimo_rp_s1 * 100) as 'ultimo_rp_s1',  ";
        $sql .= "dplanificacion.ultimo_plan_s2,  ";
        $sql .= "dplanificacion.ultimo_real_s2,  ";
        $sql .= "(dplanificacion.ultimo_rp_s2 * 100) as 'ultimo_rp_s2',  ";
        $sql .= "(dplanificacion.promedio_rp_s2 * 100) as 'promedio_rp_s2',  ";
        $sql .= "dplanificacion.id_creator,  ";
        $sql .= "dplanificacion.id_updater,  ";
        $sql .= "dplanificacion.date_insert,  ";
        $sql .= "dplanificacion.date_update,  ";
        $sql .= "dplanificacion.situation,  ";
        $sql .= "dplanificacion.deleted,  ";
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
    
    public function BuscaDadosGerais($idPais, $idcplanificacion, $idIndicador = 0, $idSede = 0)
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
        
        if($idIndicador != 0)
        {
            $sql .= " AND dplanificacion.id_indicador =  " . $idIndicador;
        }
        
        if($idSede!= 0)
        {
            $sql .= " AND dplanificacion.id_sede =  " . $idSede;
        }
        
        $sql .= " GROUP BY dplanificacion.id_indicador";
        $sql .= " ) soma GROUP BY id_indicador ";
        
//          die(print_r($sql, true));
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaProyectos($cplanificacion, $idpais, $idsede = 0, $idproyecto = 0)
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= " proyecto.id,";
        $sql .= " ano.ano as 'ano',";
        $sql .= " proyecto.id_pais,";
        $sql .= " proyecto.id_ano,";
        $sql .= " proyecto.proyecto, ";
        $sql .= " proyecto.responsable,";
        $sql .= " proyecto.id_cplanificacion AS 'cplanificacion',";
        $sql .= " proyecto.id_indicador_1 AS 'Id_1',";
        $sql .= " proyecto.id_indicador_2 AS 'Id_2',";
        $sql .= " proyecto.id_indicador_3 AS 'Id_3',";
        $sql .= " proyecto.id_indicador_4 AS 'Id_4',";
        $sql .= " proyecto.id_indicador_5 AS 'Id_5',";
        $sql .= " proyecto.id_indicador_6 AS 'Id_6',";
        $sql .= " proyecto.id_indicador_7 AS 'Id_7',";
        $sql .= " proyecto.id_indicador_8 AS 'Id_8',";
        $sql .= " proyecto.id_indicador_9 AS 'Id_9',";
        $sql .= " proyecto.id_indicador_10 AS 'Id_10',";
        $sql .= " I1.indicador AS 'Indicador1', ";
        $sql .= " T1.tipo AS 'Tipo1',";
        $sql .= " proyecto.ponderacion_1 AS 'Ponderacion1',";
        $sql .= " I2.indicador AS 'Indicador2',";
        $sql .= " T2.tipo AS 'Tipo2',";
        $sql .= " proyecto.ponderacion_2 AS 'Ponderacion2',";
        $sql .= " I3.indicador AS 'Indicador3',";
        $sql .= " T3.tipo AS 'Tipo3',";
        $sql .= " proyecto.ponderacion_3 AS 'Ponderacion3',";
        $sql .= " I4.indicador AS 'Indicador4',";
        $sql .= " T4.tipo AS 'Tipo4',";
        $sql .= " proyecto.ponderacion_4 AS 'Ponderacion4',";
        $sql .= " I5.indicador AS 'Indicador5',";
        $sql .= " T5.tipo AS 'Tipo5',";
        $sql .= " proyecto.ponderacion_5 AS 'Ponderacion5',";
        $sql .= " I6.indicador AS 'Indicador6',";
        $sql .= " T6.tipo AS 'Tipo6',";
        $sql .= " proyecto.ponderacion_6 AS 'Ponderacion6',";
        $sql .= " I7.indicador AS 'Indicador7',";
        $sql .= " T7.tipo AS 'Tipo7',";
        $sql .= " proyecto.ponderacion_7 AS 'Ponderacion7',";
        $sql .= " I8.indicador AS 'Indicador8',";
        $sql .= " T8.tipo AS 'Tipo8',";
        $sql .= " proyecto.ponderacion_8 AS 'Ponderacion8',";
        $sql .= " I9.indicador AS 'Indicador9',";
        $sql .= " T9.tipo AS 'Tipo9',";
        $sql .= " proyecto.ponderacion_9 AS 'Ponderacion9',";
        $sql .= " I10.indicador AS 'Indicador10',";
        $sql .= " T10.tipo AS 'Tipo10',";
        $sql .= " proyecto.ponderacion_10 AS 'Ponderacion10'";
        $sql .= " FROM  proyecto";
        $sql .= " LEFT JOIN indicador I1 ON I1.id = proyecto.id_indicador_1";
        $sql .= " LEFT JOIN tipo T1 ON I1.id_tipo = T1.id";
        $sql .= " LEFT JOIN indicador I2 ON I2.id = proyecto.id_indicador_2";
        $sql .= " LEFT JOIN tipo T2 ON I2.id_tipo = T2.id";
        $sql .= " LEFT JOIN indicador I3 ON I3.id = proyecto.id_indicador_3";
        $sql .= " LEFT JOIN tipo T3 ON I3.id_tipo = T3.id";
        $sql .= " LEFT JOIN indicador I4 ON I4.id = proyecto.id_indicador_4";
        $sql .= " LEFT JOIN tipo T4 ON I4.id_tipo = T4.id";
        $sql .= " LEFT JOIN indicador I5 ON I5.id = proyecto.id_indicador_5";
        $sql .= " LEFT JOIN tipo T5 ON I5.id_tipo = T5.id";
        $sql .= " LEFT JOIN indicador I6 ON I6.id = proyecto.id_indicador_6";
        $sql .= " LEFT JOIN tipo T6 ON I6.id_tipo = T6.id";
        $sql .= " LEFT JOIN indicador I7 ON I7.id = proyecto.id_indicador_7";
        $sql .= " LEFT JOIN tipo T7 ON I7.id_tipo = T7.id";
        $sql .= " LEFT JOIN indicador I8 ON I8.id = proyecto.id_indicador_8";
        $sql .= " LEFT JOIN tipo T8 ON I8.id_tipo = T8.id";
        $sql .= " LEFT JOIN indicador I9 ON I9.id = proyecto.id_indicador_9";
        $sql .= " LEFT JOIN tipo T9 ON I9.id_tipo = T9.id";
        $sql .= " LEFT JOIN indicador I10 ON I10.id = proyecto.id_indicador_10";
        $sql .= " LEFT JOIN tipo T10 ON I10.id_tipo = T10.id";
        $sql .= " LEFT JOIN ano ON ano.id = proyecto.id_ano";
        $sql .= " WHERE proyecto.deleted = 0 and proyecto.id_cplanificacion =  ". $cplanificacion. " and proyecto.id_pais = " . $idpais;
        
        if($idsede!= 0)
        {
            $sql .= " AND proyecto.id_sede = " . $idsede;
        }
        
        if($idproyecto != 0)
        {
            $sql .= " AND proyecto.id = " . $idproyecto;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaTipo($idIndicador)
    {
        $sql  = "";
        $sql .= "SELECT  ";
        $sql .= "indicador.indicador,  ";
        $sql .= "LOWER(tipo.tipo) as 'tipo' ";
        $sql .= " FROM indicador ";
        $sql .= " INNER JOIN tipo ON indicador.id_tipo = tipo.id ";
        $sql .= "WHERE indicador.id = ". $idIndicador . ' and indicador.deleted = 0';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function SelectBoxAnos()
    {
        $sql .= "SELECT ";
        $sql .= "ano.id, ";
        $sql .= "ano.ano ";
        $sql .= " FROM ano ";
        $sql .= "WHERE ano.deleted = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        $stmt->closeCursor();
        return $result;
    }
}
