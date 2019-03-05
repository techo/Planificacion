<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class Indicador extends BaseModel
{
    protected $table = "indicador";
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function select($idPais)
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "{$this->table}.id,";
        $sql .= "{$this->table}.indicador, ";
        $sql .= "{$this->table}.situation, ";
        $sql .= "{$this->table}.id_temporalidad, ";
        $sql .= "{$this->table}.descripcion, ";
        $sql .= "temporalidad.temporalidad, ";
        $sql .= "{$this->table}.id_tipo, ";
        $sql .= "tipo.tipo, ";
        $sql .= "{$this->table}.id_pilar, ";
        $sql .= "pilar.pilar, ";
        $sql .= "{$this->table}.id_pais, ";
        $sql .= "{$this->table}.id_area, ";
        $sql .= "{$this->table}.id_sede, ";
        $sql .= "{$this->table}.id_creator, ";
        $sql .= "{$this->table}.id_updater, ";
        $sql .= "{$this->table}.date_insert, ";
        $sql .= "{$this->table}.date_update ";
        $sql .= "FROM {$this->table} ";
        $sql .= "INNER JOIN temporalidad ON temporalidad.id = {$this->table}.id_temporalidad ";
        $sql .= "INNER JOIN tipo ON tipo.id = {$this->table}.id_tipo ";
        $sql .= "INNER JOIN pilar ON pilar.id = {$this->table}.id_pilar ";
        $sql .= "WHERE {$this->table}.deleted = 0 ";
        if($idPais != 5)
        {
            $sql .= " and id_pais IN (0, " .$idPais. ")";
        }
        $sql .= " Order By id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function ListaTemporalidad()
    {
        $sql  = "";
        $sql .= "SELECT * FROM temporalidad ";
        $sql .= "WHERE deleted = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function ListaTipo()
    {
        $sql  = "";
        $sql .= "SELECT * FROM tipo ";
        $sql .= "WHERE deleted = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function ListaPilar()
    {
        $sql  = "";
        $sql .= "SELECT * FROM pilar ";
        $sql .= "WHERE deleted = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function GuardarIndicador($aParam)
    {
        $sql  = "";
        $sql .= "INSERT INTO {$this->table} (";
        $sql .= "id, ";
        $sql .= "indicador, ";
        $sql .= "id_temporalidad, ";
        $sql .= "id_tipo, ";
        $sql .= "id_pilar, ";
        $sql .= "id_pais, ";
        $sql .= "id_area, ";
        $sql .= "id_sede, ";
        $sql .= "formato, ";
        $sql .= "descripcion, ";
        $sql .= "id_creator, ";
        $sql .= "id_updater, ";
        $sql .= "date_insert, ";
        $sql .= "date_update, ";
        $sql .= "situation, ";
        $sql .= "deleted) VALUES (";
        $sql .= " NULL, ";
        $sql .= "'". $aParam['indicador']."', ";
        $sql .= "'". $aParam['temporalidad']."', ";
        $sql .= "'". $aParam['tipo']."', ";
        $sql .= "'". $aParam['pilar']."', ";
        $sql .= "'". $aParam['pais']."', ";
        $sql .= "'". $aParam['area']."', ";
        $sql .= "'". $aParam['sede']."', ";
        $sql .= "'". $aParam['formato']."', ";
        $sql .= "'". $aParam['descripcion']."', ";
        $sql .= "'". $_SESSION['Planificacion']['user_id']."', ";
        $sql .= " 0, ";
        $sql .= " NOW(), ";
        $sql .= " NOW(), ";
        $sql .= "'". $aParam['status']."', ";
        $sql .= " 0)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
        $stmt->closeCursor();
        return $result;
    }
    
    public function search($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE id=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();
        return $result;
    }
    
    public function ActualizarIndicador($aParam)
    {
        $sql  = "";
        $sql .= "UPDATE {$this->table} SET ";
        $sql .= "indicador       = '" . $aParam['indicador']."', ";
        $sql .= "id_temporalidad = '" . $aParam['temporalidad']."', ";
        $sql .= "id_tipo         = '" . $aParam['tipo']."', ";
        $sql .= "id_pilar        = '" . $aParam['pilar']."', ";
        $sql .= "id_pais         = '" . $aParam['pais']."', ";
        $sql .= "id_area         = '" . $aParam['area']."', ";
        $sql .= "id_sede         = '" . $aParam['sede']."', ";
        $sql .= "formato         = '" . $aParam['formato']."', ";
        $sql .= "descripcion     = '" . $aParam['descripcion']."', ";
        $sql .= "situation       = '" . $aParam['status']."', ";
        $sql .= "id_updater        = '" . $_SESSION['Planificacion']['user_id']."', ";
        $sql .= "date_update       = NOW() ";
        $sql .= "WHERE id          = '" . $aParam['id']."'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
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
    
}
