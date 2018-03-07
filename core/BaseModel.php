<?php
namespace Core;

use PDO;

abstract class BaseModel
{
    private $pdo;
    protected $table;
    
    public function select()
    {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
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
    
    public function execute($query)
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->rowCount();
        $stmt->closeCursor();
        
        return $result;
    }
}