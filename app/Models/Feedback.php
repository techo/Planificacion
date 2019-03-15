<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class Feedback extends BaseModel
{
    protected $table = "feedback";
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function select()
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "id, ";
        $sql .= "nombre_usuario, ";
        $sql .= "id_usuario, ";
        $sql .= "DATE_FORMAT(fecha_hora,'%d/%M') as fecha_hora, ";
        $sql .= "feedback, ";
        $sql .= "foto_usuario, ";
        $sql .= "DATE_FORMAT(date_insert,'%d/%m/%Y') as date_insert ";
        $sql .= " FROM {$this->table} ";
        $sql .= "WHERE deleted = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function Guardar($aParam)
    {
        $sql  = "";
        $sql .= "INSERT INTO {$this->table} (";
        $sql .= "id, ";
        $sql .= "id_usuario, ";
        $sql .= "nombre_usuario, ";
        $sql .= "fecha_hora, ";
        $sql .= "feedback, ";
        $sql .= "foto_usuario, ";
        $sql .= "date_insert, ";
        $sql .= "date_update, ";
        $sql .= "deleted) VALUES (";
        $sql .= " NULL, ";
        $sql .= "'". $_SESSION['Planificacion']['user_id']."', ";
        $sql .= "'". $aParam['usuario']."', ";
        $sql .= " NOW(), ";
        $sql .= "'". $aParam['mensaje']."', ";
        $sql .= "'". $aParam['foto']."', ";
        $sql .= " NOW(), ";
        $sql .= " NOW(), ";
        $sql .= " 0)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
        $stmt->closeCursor();
        
        return $result;
    }
    
}