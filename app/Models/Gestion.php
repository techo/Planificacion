<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class Gestion extends BaseModel
{
    protected $table = "dplanificacion";
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function DadosPais($aParam)
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "indicador.id as id_indicador, ";
        $sql .= "dplanificacion.id_sede, ";
        $sql .= "indicador.indicador AS 'KPI', ";
        $sql .= "tipo.tipo AS 'tipo', ";
        $sql .= "dplanificacion.enero_plan AS 'Enero_Plan', ";
        $sql .= "dplanificacion.febrero_plan AS 'Febrero_Plan', ";
        $sql .= "dplanificacion.febrero_real AS 'Febrero_Real', ";
        $sql .= "dplanificacion.marzo_plan AS 'Marzo_Plan', ";
        $sql .= "dplanificacion.marzo_real AS 'Marzo_Real', ";
        $sql .= "dplanificacion.abril_plan AS 'Abril_Plan', ";
        $sql .= "dplanificacion.abril_real AS 'Abril_Real', ";
        $sql .= "dplanificacion.mayo_plan AS 'Mayo_Plan', ";
        $sql .= "dplanificacion.mayo_real AS 'Mayo_Real', ";
        $sql .= "dplanificacion.junio_plan AS 'Junio_Plan', ";
        $sql .= "dplanificacion.junio_real AS 'Junio_Real', ";
        $sql .= "dplanificacion.julio_plan AS 'Julio_Plan', ";
        $sql .= "dplanificacion.julio_real AS 'Julio_Real', ";
        $sql .= "dplanificacion.agosto_plan AS 'Agosto_Plan', ";
        $sql .= "dplanificacion.agosto_real AS 'Agosto_Real', ";
        $sql .= "dplanificacion.septiembre_plan AS 'Septiembre_Plan', ";
        $sql .= "dplanificacion.septiembre_real AS 'Septiembre_Real', ";
        $sql .= "dplanificacion.octubre_plan AS 'Octubre_Plan', ";
        $sql .= "dplanificacion.octubre_real AS 'Octubre_Real', ";
        $sql .= "dplanificacion.noviembre_plan AS 'Noviembre_Plan', ";
        $sql .= "dplanificacion.noviembre_real AS 'Noviembre_Real', ";
        $sql .= "dplanificacion.diciembre_plan AS 'Diciembre_Plan', ";
        $sql .= "dplanificacion.diciembre_plan AS 'Diciembre_Real' ";
        $sql .= "FROM dplanificacion ";
        $sql .= "INNER JOIN indicador ON indicador.id = dplanificacion.id_indicador ";
        $sql .= "INNER JOIN tipo ON tipo.id = indicador.id_tipo ";
        $sql .= "WHERE dplanificacion.id_cplanificacion =  " . $aParam['idCPlanificacion'] . " ";
        $sql .= "AND dplanificacion.id_pais = " . $aParam['idPais'] . " ";
        $sql .= "AND indicador.id IN (5,6,9,85,271,83,7,74,268) ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
}
