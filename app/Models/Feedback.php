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
        $sql .= "SELECT  *";
        $sql .= " FROM {$this->table} ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
}