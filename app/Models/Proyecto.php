<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class Proyecto extends BaseModel
{
    protected $table = "proyecto";
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function ListaAno()
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "id,";
        $sql .= "ano, ";
        $sql .= "situation, ";
        $sql .= "id_creator, ";
        $sql .= "id_updater, ";
        $sql .= "date_insert, ";
        $sql .= "date_update ";
        $sql .= " FROM ano ";
        $sql .= "WHERE deleted = 0 AND situation = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function Listagem($idPlanificacion, $idSede, $idPais = 0)
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "indicador.id, ";
        $sql .= "indicador.indicador, ";
        $sql .= "indicador.id_pilar, ";
        $sql .= "indicador.id_temporalidad, ";
        $sql .= "temporalidad.temporalidad, ";
        $sql .= "tipo.tipo, ";
        $sql .= "indicador.formato, ";
        $sql .= "indicador.id_area ";
        $sql .= " FROM dplanificacion ";
        $sql .= "INNER JOIN indicador indicador ON indicador.id = dplanificacion.id_indicador ";
        $sql .= "LEFT JOIN tipo ON tipo.id = indicador.id_tipo ";
        $sql .= "INNER JOIN temporalidad temporalidad ON temporalidad.id = indicador.id_temporalidad ";
        $sql .= "WHERE dplanificacion.id_cplanificacion = " . $idPlanificacion . " AND dplanificacion.deleted = 0 AND dplanificacion.situation = 1 AND dplanificacion.id_sede = ". $idSede;
        if($idPais != 0)
        {
            $sql .= " AND dplanificacion.id_pais = " . $idPais;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaAno($idPlanificacion)
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "cplanificacion.id,";
        $sql .= "cplanificacion.id_ano, ";
        $sql .= "ano.ano ";
        $sql .= " FROM cplanificacion ";
        $sql .= " INNER JOIN ano ON ano.id = cplanificacion.id_ano ";
        $sql .= "WHERE cplanificacion.deleted = 0 AND cplanificacion.situation = 1 AND cplanificacion.id = " . $idPlanificacion;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();
        return $result;
    }
    
}
