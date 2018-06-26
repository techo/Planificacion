<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class Dashboard extends BaseModel
{
    protected $table = "dashboard";
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function GravaDashboard($aParam)
    {
        $sql  = "";
        $sql .= "INSERT INTO {$this->table} (";
        $sql .= "id, ";
        $sql .= "dashboard, ";
        $sql .= "id_creator, ";
        $sql .= "deleted) VALUES (";
        $sql .= " NULL, ";
        $sql .= "'". $aParam['nome']."', ";
        $sql .= "'". $_SESSION['Planificacion']['user_id']."', ";
        $sql .= " 0)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
        $stmt->closeCursor();
        
        return $result;
    }
    
    public function BuscaDashboard($idUser)
    {
        $sql  = "";
        $sql .= "SELECT * ";
        $sql .= " FROM {$this->table} ";
        $sql .= "WHERE deleted = 0 AND id_creator = " . $idUser;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function GuardarDashPaises($pais, $dash)
    {
        $sql  = "";
        $sql .= "INSERT INTO dashboardpaises (";
        $sql .= "id, ";
        $sql .= "id_dashboard, ";
        $sql .= "id_pais, ";
        $sql .= "id_creator, ";
        $sql .= "deleted) VALUES (";
        $sql .= " NULL, ";
        $sql .= "'". $dash."', ";
        $sql .= "'". $pais."', ";
        $sql .= "'". $_SESSION['Planificacion']['user_id']."', ";
        $sql .= " 0)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
        $stmt->closeCursor();
        
        return $result;
    }
    
    public function BuscaDashPaises($id)
    {
        $sql  = "";
        $sql .= "SELECT * ";
        $sql .= " FROM dashboardpaises ";
        $sql .= "WHERE deleted = 0 AND id_dashboard = " . $id . " AND id_creator = " . $_SESSION['Planificacion']['user_id'];
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaDadosGerais($idPais, $idcplanificacion, $idSede=0)
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
                  SUM(promedio_plan_anual) AS promedio_plan_anual,
                  SUM(promedio_real_anual) AS promedio_real_anual,
                  (SUM(promedio_real_anual) / SUM(promedio_plan_anual) * 100) AS promedio_rp_anual,
                  SUM(promedio_plan_s1) AS promedio_plan_s1,
                  SUM(promedio_real_s1) AS promedio_real_s1,
                  (SUM(promedio_real_s1) / SUM(promedio_plan_s1) * 100) AS promedio_rp_s1,
                  SUM(promedio_plan_s2) AS promedio_plan_s2,
                  SUM(promedio_real_s2) AS promedio_real_s2,
                  (SUM(promedio_real_s2) / SUM(promedio_plan_s2) * 100) AS promedio_rp_s2,
                  SUM(minimo_plan_anual) AS minimo_plan_anual,
                  SUM(minimo_real_anual) AS minimo_real_anual,
                  (SUM(minimo_real_anual) / SUM(minimo_plan_anual) * 100) AS minimo_rp_anual,
                  SUM(minimo_plan_s1) AS minimo_plan_s1,
                  SUM(minimo_real_s1) AS minimo_real_s1,
                  (SUM(minimo_real_s1) / SUM(minimo_plan_s1) * 100) AS minimo_rp_s1,
                  SUM(minimo_plan_s2) AS minimo_plan_s2,
                  SUM(minimo_real_s2) AS minimo_real_s2,
                  (SUM(minimo_real_s2) / SUM(minimo_plan_s2) * 100) AS minimo_rp_s2,
                  SUM(maximo_plan_anual) AS maximo_plan_anual,
                  SUM(maximo_real_anual) AS maximo_real_anual,
                  (SUM(maximo_real_anual) / SUM(maximo_plan_anual) * 100) AS maximo_rp_anual,
                  SUM(maximo_plan_s1) AS maximo_plan_s1,
                  SUM(maximo_real_s1) AS maximo_real_s1,
                  (SUM(maximo_real_s1) / SUM(maximo_plan_s1) * 100) AS maximo_rp_s1,
                  SUM(maximo_plan_s2) AS maximo_plan_s2,
                  SUM(maximo_real_s2) AS maximo_real_s2,
                  (SUM(maximo_real_s2) / SUM(maximo_plan_s2) * 100) AS maximo_rp_s2,
                  SUM(ultimo_plan_anual) AS ultimo_plan_anual,
                  SUM(ultimo_real_anual) AS ultimo_real_anual,
                  (SUM(ultimo_real_anual) / SUM(ultimo_plan_anual) * 100) AS ultimo_rp_anual,
                  SUM(ultimo_plan_s1) AS ultimo_plan_s1,
                  SUM(ultimo_real_s1) AS ultimo_real_s1,
                  (SUM(ultimo_real_s1) / SUM(ultimo_plan_s1) * 100) AS ultimo_rp_s1,
                  SUM(ultimo_plan_s2) AS ultimo_plan_s2,
                  SUM(ultimo_real_s2) AS ultimo_real_s2,
                  (SUM(ultimo_real_s2) / SUM(ultimo_plan_s2) * 100) AS ultimo_rp_s2,
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
        
        
        $sql .= "SUM(dplanificacion.promedio_plan_anual) as promedio_plan_anual, ";
        $sql .= "SUM(dplanificacion.promedio_real_anual) as promedio_real_anual, ";
        $sql .= "SUM(dplanificacion.promedio_rp_anual) as promedio_rp_anual, ";
        $sql .= "SUM(dplanificacion.promedio_plan_s1) as promedio_plan_s1, ";
        $sql .= "SUM(dplanificacion.promedio_real_s1) as promedio_real_s1, ";
        $sql .= "SUM(dplanificacion.promedio_rp_s1) as promedio_rp_s1, ";
        $sql .= "SUM(dplanificacion.promedio_plan_s2) as promedio_plan_s2, ";
        $sql .= "SUM(dplanificacion.promedio_real_s2) as promedio_real_s2, ";
        $sql .= "SUM(dplanificacion.promedio_rp_s2) as promedio_rp_s2, ";
        
        $sql .= "SUM(dplanificacion.minimo_plan_anual) as minimo_plan_anual, ";
        $sql .= "SUM(dplanificacion.minimo_real_anual) as minimo_real_anual, ";
        $sql .= "SUM(dplanificacion.minimo_rp_anual) as minimo_rp_anual, ";
        $sql .= "SUM(dplanificacion.minimo_plan_s1) as minimo_plan_s1, ";
        $sql .= "SUM(dplanificacion.minimo_real_s1) as minimo_real_s1, ";
        $sql .= "SUM(dplanificacion.minimo_rp_s1) as minimo_rp_s1, ";
        $sql .= "SUM(dplanificacion.minimo_plan_s2) as minimo_plan_s2, ";
        $sql .= "SUM(dplanificacion.minimo_real_s2) as minimo_real_s2, ";
        $sql .= "SUM(dplanificacion.minimo_rp_s2) as minimo_rp_s2, ";
        
        $sql .= "SUM(dplanificacion.maximo_plan_anual) as maximo_plan_anual, ";
        $sql .= "SUM(dplanificacion.maximo_real_anual) as maximo_real_anual, ";
        $sql .= "SUM(dplanificacion.maximo_rp_anual) as maximo_rp_anual, ";
        $sql .= "SUM(dplanificacion.maximo_plan_s1) as maximo_plan_s1, ";
        $sql .= "SUM(dplanificacion.maximo_real_s1) as maximo_real_s1, ";
        $sql .= "SUM(dplanificacion.maximo_rp_s1) as maximo_rp_s1, ";
        $sql .= "SUM(dplanificacion.maximo_plan_s2) as maximo_plan_s2, ";
        $sql .= "SUM(dplanificacion.maximo_real_s2) as maximo_real_s2, ";
        $sql .= "SUM(dplanificacion.maximo_rp_s2) as maximo_rp_s2, ";
        
        $sql .= "SUM(dplanificacion.ultimo_plan_anual) as ultimo_plan_anual, ";
        $sql .= "SUM(dplanificacion.ultimo_real_anual) as ultimo_real_anual, ";
        $sql .= "SUM(dplanificacion.ultimo_rp_anual) as ultimo_rp_anual, ";
        $sql .= "SUM(dplanificacion.ultimo_plan_s1) as ultimo_plan_s1, ";
        $sql .= "SUM(dplanificacion.ultimo_real_s1) as ultimo_real_s1, ";
        $sql .= "SUM(dplanificacion.ultimo_rp_s1) as ultimo_rp_s1, ";
        $sql .= "SUM(dplanificacion.ultimo_plan_s2) as ultimo_plan_s2, ";
        $sql .= "SUM(dplanificacion.ultimo_real_s2) as ultimo_real_s2, ";
        $sql .= "SUM(dplanificacion.ultimo_rp_s2) as ultimo_rp_s2, ";
        $sql .= "indicador.indicador,  ";
        $sql .= "indicador.formato,  ";
        $sql .= "tipo.tipo  ";
        $sql .= " FROM dplanificacion ";
        $sql .= " INNER JOIN indicador on indicador.id = dplanificacion.id_indicador ";
        $sql .= " INNER JOIN tipo ON indicador.id_tipo = tipo.id ";
        $sql .= "WHERE dplanificacion.id_cplanificacion = ". $idcplanificacion." AND dplanificacion.id_pais = " . $idPais;
        if($idSede != 0)
        {
            $sql .= " AND dplanificacion.id_sede = " . $idSede;
        }
       
        $sql .= " AND dplanificacion.id_indicador IN ('5','6','7','8','9','10','11','12','13','14','15','16','17','18') GROUP BY dplanificacion.id_indicador";
        $sql .= " ) soma GROUP BY id_indicador ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaAno($ano)
    {
        $sql  = "";
        $sql .= "SELECT * ";
        $sql .= " FROM ano ";
        $sql .= "WHERE deleted = 0 AND ano = '" . $ano . "'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaPlanificacion($idAno)
    {
        $sql  = "";
        $sql .= "SELECT * ";
        $sql .= " FROM cplanificacion ";
        $sql .= "WHERE cplanificacion.deleted = 0 AND cplanificacion.id_ano = " . $idAno;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $ret = $stmt->fetchAll();
        $stmt->closeCursor();
        return $ret;
    }
}
