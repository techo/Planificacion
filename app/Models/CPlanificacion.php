<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class CPlanificacion extends BaseModel
{
    protected $table = "cplanificacion";
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function select()
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "{$this->table}.id,";
        $sql .= "{$this->table}.id_ano, ";
        $sql .= "ano.ano, ";
        $sql .= "{$this->table}.id_pais, ";
        $sql .= "{$this->table}.id_sede, ";
        $sql .= "{$this->table}.edit_plan_enero, ";
        $sql .= "{$this->table}.edit_real_enero, ";
        $sql .= "{$this->table}.edit_plan_febrero, ";
        $sql .= "{$this->table}.edit_real_febrero, ";
        $sql .= "{$this->table}.edit_plan_marzo, ";
        $sql .= "{$this->table}.edit_real_marzo, ";
        $sql .= "{$this->table}.edit_plan_abril, ";
        $sql .= "{$this->table}.edit_real_abril, ";
        $sql .= "{$this->table}.edit_plan_mayo, ";
        $sql .= "{$this->table}.edit_real_mayo, ";
        $sql .= "{$this->table}.edit_plan_junio, ";
        $sql .= "{$this->table}.edit_real_junio, ";
        $sql .= "{$this->table}.edit_plan_julio, ";
        $sql .= "{$this->table}.edit_real_julio, ";
        $sql .= "{$this->table}.edit_plan_agosto, ";
        $sql .= "{$this->table}.edit_real_agosto, ";
        $sql .= "{$this->table}.edit_plan_septiembre, ";
        $sql .= "{$this->table}.edit_real_septiembre, ";
        $sql .= "{$this->table}.edit_plan_octubre, ";
        $sql .= "{$this->table}.edit_real_octubre, ";
        $sql .= "{$this->table}.edit_plan_noviembre, ";
        $sql .= "{$this->table}.edit_real_noviembre, ";
        $sql .= "{$this->table}.edit_plan_diciembre, ";
        $sql .= "{$this->table}.edit_real_diciembre, ";
        $sql .= "{$this->table}.situation, ";
        $sql .= "{$this->table}.id_creator, ";
        $sql .= "{$this->table}.id_updater, ";
        $sql .= "{$this->table}.date_insert, ";
        $sql .= "{$this->table}.date_update ";
        $sql .= " FROM {$this->table} ";
        $sql .= "INNER JOIN ano ano ON ano.id = {$this->table}.id_ano ";
        $sql .= "WHERE {$this->table}.deleted = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
}
