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
}
