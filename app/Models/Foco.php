<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class Foco extends BaseModel
{
    protected $table = "foco";
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function select()
    {
        $sql  = "";
        $sql .= "SELECT  * ";
        $sql .= " FROM {$this->table} ";
        $sql .= "WHERE deleted = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function delete($id)
    {
        $query .= "UPDATE {$this->table} SET ";
        $query .= "deleted = 1 ";
        $query .= "WHERE id=:id ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id", $id);
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }
    
    public function selectAnos()
    {
        $sql  = "";
        $sql .= "SELECT  * FROM ano ";
        $sql .= "WHERE deleted = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function CarregaIndicadores()
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "indicador.id,";
        $sql .= "indicador.indicador, ";
        $sql .= "indicador.situation, ";
        $sql .= "indicador.id_temporalidad, ";
        $sql .= "temporalidad.temporalidad, ";
        $sql .= "indicador.id_tipo, ";
        $sql .= "tipo.tipo, ";
        $sql .= "indicador.id_pilar, ";
        $sql .= "pilar.pilar, ";
        $sql .= "indicador.date_update ";
        $sql .= "FROM indicador ";
        $sql .= "INNER JOIN temporalidad ON temporalidad.id = indicador.id_temporalidad ";
        $sql .= "INNER JOIN tipo ON tipo.id = indicador.id_tipo ";
        $sql .= "INNER JOIN pilar ON pilar.id = indicador.id_pilar ";
        $sql .= "WHERE indicador.deleted = 0 AND indicador.id_pais = 0 and indicador.situation = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
}
