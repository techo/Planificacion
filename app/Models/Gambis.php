<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class Gambis extends BaseModel
{
    protected $table = "indicador";
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function select()
    {
        $sql  = "";
        $sql .= "SELECT  *";
        $sql .= " FROM {$this->table} ";
        $sql .= "WHERE id_pais = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function Inserir($aParam)
    {
        $sql  = "";
        $sql .= "INSERT INTO dplanificacion (";
        $sql .= "id, ";
        $sql .= "id_cplanificacion, ";
        $sql .= "id_indicador, ";
        $sql .= "id_pais, ";
        $sql .= "id_sede, ";
        $sql .= "id_creator, ";
        $sql .= "id_updater, ";
        $sql .= "date_insert, ";
        $sql .= "date_update, ";
        $sql .= "situation, ";
        $sql .= "deleted) VALUES (";
        $sql .= " NULL, ";
        $sql .= "'". $aParam['id_cplanificacion']."', ";
        $sql .= "'". $aParam['indicador']."', ";
        $sql .= "'". $aParam['id_pais']."', ";
        $sql .= "'". $aParam['id_sede']."', ";
        $sql .= "'". $aParam['id_creador']."', ";
        $sql .= " 0, ";
        $sql .= " NOW(), ";
        $sql .= " NOW(), ";
        $sql .= "'". $aParam['situation']."', ";
        $sql .= " 0)";
        $stmt = $this->pdo->prepare($sql);
    //    $stmt->execute(); //Para nao afetar produccion
        $result = $stmt->rowCount();
        $stmt->closeCursor();
        
        return $result;
    }
    
    public function GetAno($ano)
    {
        $sql  = "";
        $sql .= "SELECT  *";
        $sql .= " FROM ano ";
        $sql .= "WHERE ano =  " . $ano;
        $sql .= " and situation = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function GetPlanificacion($id)
    {
        $sql  = "";
        $sql .= "SELECT  *";
        $sql .= " FROM cplanificacion ";
        $sql .= "WHERE id_ano =  " . $id;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function api($idcPlanificacion)
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "dplanificacion.id_indicador, ";
        $sql .="dplanificacion.id_pais, ";
        $sql .="dplanificacion.id_sede, ";
        $sql .="indicador.indicador, ";
		$sql .="tipo.tipo, ";
        $sql .="dplanificacion.enero_plan, ";
        $sql .="dplanificacion.enero_real, ";
        $sql .="dplanificacion.febrero_plan, ";
        $sql .="dplanificacion.febrero_real, ";
        $sql .="dplanificacion.marzo_plan, ";
        $sql .="dplanificacion.marzo_real, ";
        $sql .="dplanificacion.abril_plan, ";
        $sql .="dplanificacion.abril_real, ";
        $sql .="dplanificacion.mayo_plan, ";
        $sql .="dplanificacion.mayo_real, ";
        $sql .="dplanificacion.junio_plan, ";
        $sql .="dplanificacion.junio_real, ";
        $sql .="dplanificacion.julio_plan, ";
        $sql .="dplanificacion.julio_real, ";
        $sql .="dplanificacion.agosto_plan, ";
        $sql .="dplanificacion.agosto_real, ";
        $sql .="dplanificacion.septiembre_plan, ";
        $sql .="dplanificacion.septiembre_real, ";
        $sql .="dplanificacion.octubre_plan, ";
        $sql .="dplanificacion.octubre_real, ";
        $sql .="dplanificacion.noviembre_plan, ";
        $sql .="dplanificacion.noviembre_real,";
        $sql .="dplanificacion.diciembre_plan, ";
        $sql .="dplanificacion.diciembre_real, ";
        $sql .="dplanificacion.ultimo_plan_anual, ";
        $sql .="dplanificacion.ultimo_real_anual, ";
        $sql .="dplanificacion.acumulado_plan_anual, ";
        $sql .="dplanificacion.acumulado_real_anual ";
        $sql .=" FROM dplanificacion ";
        $sql .= " INNER JOIN indicador ON dplanificacion.id_indicador = indicador.id ";
		$sql .= " INNER JOIN tipo ON tipo.id = indicador.id_tipo ";
        $sql .= "WHERE id_cplanificacion = " . $idcPlanificacion . " AND dplanificacion.id_indicador IN ('5','6','7','8','9','10','11','12','13','14','15','16','17','18')";
       // $sql .= " and dplanificacion.id_pais = 1 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    function valores($idcPlanificacion)
    {
        $sql = " SELECT 
                	dplanificacion.id_indicador, 
                	dplanificacion.id_pais AS 'Pais', 
                	indicador.indicador, 
                	tipo.tipo, 
                	REPLACE(COALESCE(SUM(dplanificacion.ultimo_plan_anual),0),'.',',') AS 'Planificado',
                	REPLACE(COALESCE(SUM(dplanificacion.ultimo_real_anual),0),'.',',') AS 'Realizado'
                FROM dplanificacion 
                INNER JOIN indicador ON dplanificacion.id_indicador = indicador.id 
                INNER JOIN tipo ON tipo.id = indicador.id_tipo 
                WHERE id_cplanificacion = " . $idcPlanificacion . "  AND dplanificacion.id_indicador = 5
                GROUP BY  dplanificacion.id_pais
                
                UNION ALL
                
                SELECT 
                	dplanificacion.id_indicador, 
                	dplanificacion.id_pais AS 'Pais', 
                	indicador.indicador, 
                	tipo.tipo, 
                	REPLACE(COALESCE(SUM(dplanificacion.ultimo_plan_anual),0),'.',',') AS 'Planificado',
                	REPLACE(COALESCE(SUM(dplanificacion.ultimo_real_anual),0),'.',',') AS 'Realizado'
                FROM dplanificacion 
                INNER JOIN indicador ON dplanificacion.id_indicador = indicador.id 
                INNER JOIN tipo ON tipo.id = indicador.id_tipo 
                WHERE id_cplanificacion = " . $idcPlanificacion . "  AND dplanificacion.id_indicador = 6
                GROUP BY dplanificacion.id_pais
                
                UNION ALL
                
                SELECT 
                	dplanificacion.id_indicador, 
                	dplanificacion.id_pais AS 'Pais', 
                	indicador.indicador, 
                	tipo.tipo, 
                	REPLACE(COALESCE(SUM(dplanificacion.acumulado_plan_anual),0),'.',',') AS 'Planificado',
                	REPLACE(COALESCE(SUM(dplanificacion.acumulado_real_anual),0),'.',',') AS 'Realizado'
                FROM dplanificacion 
                INNER JOIN indicador ON dplanificacion.id_indicador = indicador.id 
                INNER JOIN tipo ON tipo.id = indicador.id_tipo 
                WHERE id_cplanificacion = " . $idcPlanificacion . "  AND dplanificacion.id_indicador = 7
                GROUP BY dplanificacion.id_pais
                
                UNION ALL
                
                SELECT 
                	dplanificacion.id_indicador, 
                	dplanificacion.id_pais AS 'Pais', 
                	indicador.indicador, 
                	tipo.tipo, 
                	REPLACE(COALESCE(SUM(dplanificacion.ultimo_plan_anual),0),'.',',') AS 'Planificado',
                	REPLACE(COALESCE(SUM(dplanificacion.ultimo_real_anual),0),'.',',') AS 'Realizado'
                FROM dplanificacion 
                INNER JOIN indicador ON dplanificacion.id_indicador = indicador.id 
                INNER JOIN tipo ON tipo.id = indicador.id_tipo 
                WHERE id_cplanificacion = " . $idcPlanificacion . "  AND dplanificacion.id_indicador = 8
                GROUP BY dplanificacion.id_pais
                
                UNION ALL
                
                SELECT 
                	dplanificacion.id_indicador, 
                	dplanificacion.id_pais AS 'Pais', 
                	indicador.indicador, 
                	tipo.tipo, 
                	REPLACE(COALESCE(SUM(dplanificacion.acumulado_plan_anual),0),'.',',') AS 'Planificado',
                	REPLACE(COALESCE(SUM(dplanificacion.acumulado_real_anual),0),'.',',') AS 'Realizado'
                FROM dplanificacion 
                INNER JOIN indicador ON dplanificacion.id_indicador = indicador.id 
                INNER JOIN tipo ON tipo.id = indicador.id_tipo 
                WHERE id_cplanificacion = " . $idcPlanificacion . "  AND dplanificacion.id_indicador = 9
                GROUP BY dplanificacion.id_pais
                
                UNION ALL
                
                SELECT 
                	dplanificacion.id_indicador, 
                	dplanificacion.id_pais AS 'Pais', 
                	indicador.indicador, 
                	tipo.tipo, 
                	REPLACE(COALESCE(SUM(dplanificacion.acumulado_plan_anual),0),'.',',') AS 'Planificado',
                	REPLACE(COALESCE(SUM(dplanificacion.acumulado_real_anual),0),'.',',') AS 'Realizado'
                FROM dplanificacion 
                INNER JOIN indicador ON dplanificacion.id_indicador = indicador.id 
                INNER JOIN tipo ON tipo.id = indicador.id_tipo 
                WHERE id_cplanificacion = " . $idcPlanificacion . "  AND dplanificacion.id_indicador = 10
                GROUP BY dplanificacion.id_pais
                
                UNION ALL
                
                SELECT 
                	dplanificacion.id_indicador, 
                	dplanificacion.id_pais AS 'Pais', 
                	indicador.indicador, 
                	tipo.tipo, 
                	REPLACE(COALESCE(SUM(dplanificacion.ultimo_plan_anual),0),'.',',') AS 'Planificado',
                	REPLACE(COALESCE(SUM(dplanificacion.ultimo_real_anual),0),'.',',') AS 'Realizado'
                FROM dplanificacion 
                INNER JOIN indicador ON dplanificacion.id_indicador = indicador.id 
                INNER JOIN tipo ON tipo.id = indicador.id_tipo 
                WHERE id_cplanificacion = " . $idcPlanificacion . "  AND dplanificacion.id_indicador = 11
                GROUP BY dplanificacion.id_pais
                
                UNION ALL
                
                SELECT 
                	dplanificacion.id_indicador, 
                	dplanificacion.id_pais AS 'Pais', 
                	indicador.indicador, 
                	tipo.tipo, 
                	REPLACE(COALESCE(SUM(dplanificacion.acumulado_plan_anual),0),'.',',') AS 'Planificado',
                	REPLACE(COALESCE(SUM(dplanificacion.acumulado_real_anual),0),'.',',') AS 'Realizado'
                FROM dplanificacion 
                INNER JOIN indicador ON dplanificacion.id_indicador = indicador.id 
                INNER JOIN tipo ON tipo.id = indicador.id_tipo 
                WHERE id_cplanificacion = " . $idcPlanificacion . "  AND dplanificacion.id_indicador = 12
                GROUP BY dplanificacion.id_pais
                
                UNION ALL
                
                SELECT 
                	dplanificacion.id_indicador, 
                	dplanificacion.id_pais AS 'Pais', 
                	indicador.indicador, 
                	tipo.tipo, 
                	REPLACE(COALESCE(SUM(dplanificacion.ultimo_plan_anual),0),'.',',') AS 'Planificado',
                	REPLACE(COALESCE(SUM(dplanificacion.ultimo_real_anual),0),'.',',') AS 'Realizado'
                FROM dplanificacion 
                INNER JOIN indicador ON dplanificacion.id_indicador = indicador.id 
                INNER JOIN tipo ON tipo.id = indicador.id_tipo 
                WHERE id_cplanificacion = " . $idcPlanificacion . "  AND dplanificacion.id_indicador = 13
                GROUP BY dplanificacion.id_pais
                
                UNION ALL
                
                SELECT 
                	dplanificacion.id_indicador, 
                	dplanificacion.id_pais AS 'Pais', 
                	indicador.indicador, 
                	tipo.tipo, 
                	REPLACE(COALESCE(SUM(dplanificacion.ultimo_plan_anual),0),'.',',') AS 'Planificado',
                	REPLACE(COALESCE(SUM(dplanificacion.ultimo_real_anual),0),'.',',') AS 'Realizado'
                FROM dplanificacion 
                INNER JOIN indicador ON dplanificacion.id_indicador = indicador.id 
                INNER JOIN tipo ON tipo.id = indicador.id_tipo 
                WHERE id_cplanificacion = " . $idcPlanificacion . "  AND dplanificacion.id_indicador = 14
                GROUP BY dplanificacion.id_pais
                
                UNION ALL
                
                SELECT 
                	dplanificacion.id_indicador, 
                	dplanificacion.id_pais AS 'Pais', 
                	indicador.indicador, 
                	tipo.tipo, 
                	REPLACE(COALESCE(SUM(dplanificacion.ultimo_plan_anual),0),'.',',') AS 'Planificado',
                	REPLACE(COALESCE(SUM(dplanificacion.ultimo_real_anual),0),'.',',') AS 'Realizado'
                FROM dplanificacion 
                INNER JOIN indicador ON dplanificacion.id_indicador = indicador.id 
                INNER JOIN tipo ON tipo.id = indicador.id_tipo 
                WHERE id_cplanificacion = " . $idcPlanificacion . "  AND dplanificacion.id_indicador = 15
                GROUP BY dplanificacion.id_pais
                
                UNION ALL
                
                SELECT 
                	dplanificacion.id_indicador, 
                	dplanificacion.id_pais AS 'Pais', 
                	indicador.indicador, 
                	tipo.tipo, 
                	REPLACE(COALESCE(SUM(dplanificacion.acumulado_plan_anual),0),'.',',') AS 'Planificado',
                	REPLACE(COALESCE(SUM(dplanificacion.acumulado_real_anual),0),'.',',') AS 'Realizado'
                FROM dplanificacion 
                INNER JOIN indicador ON dplanificacion.id_indicador = indicador.id 
                INNER JOIN tipo ON tipo.id = indicador.id_tipo 
                WHERE id_cplanificacion = " . $idcPlanificacion . "  AND dplanificacion.id_indicador = 16
                GROUP BY dplanificacion.id_pais
                
                UNION ALL
                
                SELECT 
                	dplanificacion.id_indicador, 
                	dplanificacion.id_pais AS 'Pais', 
                	indicador.indicador, 
                	tipo.tipo, 
                	REPLACE(COALESCE(SUM(dplanificacion.acumulado_plan_anual),0),'.',',') AS 'Planificado',
                	REPLACE(COALESCE(SUM(dplanificacion.acumulado_real_anual),0),'.',',') AS 'Realizado'
                FROM dplanificacion 
                INNER JOIN indicador ON dplanificacion.id_indicador = indicador.id 
                INNER JOIN tipo ON tipo.id = indicador.id_tipo 
                WHERE id_cplanificacion = " . $idcPlanificacion . "  AND dplanificacion.id_indicador = 17
                GROUP BY dplanificacion.id_pais
                
                UNION ALL
                
                SELECT 
                	dplanificacion.id_indicador, 
                	dplanificacion.id_pais AS 'Pais', 
                	indicador.indicador, 
                	tipo.tipo, 
                	REPLACE(COALESCE(SUM(dplanificacion.ultimo_plan_anual),0),'.',',') AS 'Planificado',
                	REPLACE(COALESCE(SUM(dplanificacion.ultimo_real_anual),0),'.',',') AS 'Realizado'
                FROM dplanificacion 
                INNER JOIN indicador ON dplanificacion.id_indicador = indicador.id 
                INNER JOIN tipo ON tipo.id = indicador.id_tipo 
                WHERE id_cplanificacion = " . $idcPlanificacion . "  AND dplanificacion.id_indicador = 18
                GROUP BY dplanificacion.id_pais";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
}