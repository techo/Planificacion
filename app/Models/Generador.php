<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class Generador extends BaseModel
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
    
    //Indicadores Comuns a todos
    public function BuscaIndicadores($aParam)
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "indicador.id,";
        $sql .= "indicador.indicador";
        $sql .= " FROM dplanificacion";
        $sql .= " INNER JOIN indicador ON indicador.id = dplanificacion.id_indicador ";
        $sql .= " WHERE dplanificacion.deleted = 0 and dplanificacion.id_cplanificacion = " . $aParam['id'];
        $sql .= " GROUP BY dplanificacion.id_indicador";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    //Retorno Final para calculos 
    public function BuscaValores($aParam, $idPais)
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "indicador.indicador, ";
        $sql .= "tipo.tipo, ";
        $sql .= "dplanificacion.* ";
        $sql .= " FROM dplanificacion";
        $sql .= " INNER JOIN indicador ON indicador.id = dplanificacion.id_indicador ";
        $sql .= " INNER JOIN tipo ON tipo.id = indicador.id_tipo ";
        $sql .= " WHERE dplanificacion.situation = 1 AND dplanificacion.id_cplanificacion = " . $aParam['ano'] . " AND dplanificacion.id_indicador = " .  $aParam['indicador'] . " AND dplanificacion.id_pais IN (" . $idPais . ")";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
}
