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
    
    public function ListaIndicador()
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
        $sql .= "indicador.id_pais, ";
        $sql .= "indicador.id_area, ";
        $sql .= "indicador.id_sede, ";
        $sql .= "indicador.id_creator, ";
        $sql .= "indicador.id_updater, ";
        $sql .= "indicador.date_insert, ";
        $sql .= "indicador.date_update ";
        $sql .= "FROM indicador ";
        $sql .= "INNER JOIN temporalidad ON temporalidad.id = indicador.id_temporalidad ";
        $sql .= "INNER JOIN tipo ON tipo.id = indicador.id_tipo ";
        $sql .= "INNER JOIN pilar ON pilar.id = indicador.id_pilar ";
        $sql .= "WHERE indicador.deleted = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
}
