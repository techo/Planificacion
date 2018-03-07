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
    
    public function select()
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "{$this->table}.id,";
        $sql .= "{$this->table}.indicador, ";
        $sql .= "{$this->table}.id_ano, ";
        $sql .= "ano.ano, ";
        $sql .= "{$this->table}.id_temporalidad, ";
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
        $sql .= "INNER JOIN ano ON ano.id = {$this->table}.id_ano ";
        $sql .= "INNER JOIN temporalidad ON temporalidad.id = {$this->table}.id_temporalidad ";
        $sql .= "INNER JOIN tipo ON tipo.id = {$this->table}.id_tipo ";
        $sql .= "INNER JOIN pilar ON pilar.id = {$this->table}.id_pilar ";
        $sql .= "WHERE {$this->table}.deleted = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
}
