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
    
    public function GuardarPlanificacion($aParam)
    {
        $sql  = "";
        $sql .= "INSERT INTO {$this->table} (";
        $sql .= "id, ";
        $sql .= "id_ano, ";
        $sql .= "id_pais, ";
        $sql .= "id_sede, ";
        $sql .= "edit_plan_enero, ";
        $sql .= "edit_real_enero, ";
        $sql .= "edit_plan_febrero, ";
        $sql .= "edit_real_febrero, ";
        $sql .= "edit_plan_marzo, ";
        $sql .= "edit_real_marzo, ";
        $sql .= "edit_plan_abril, ";
        $sql .= "edit_real_abril, ";
        $sql .= "edit_plan_mayo, ";
        $sql .= "edit_real_mayo, ";
        $sql .= "edit_plan_junio, ";
        $sql .= "edit_real_junio, ";
        $sql .= "edit_plan_julio, ";
        $sql .= "edit_real_julio, ";
        $sql .= "edit_plan_agosto, ";
        $sql .= "edit_real_agosto, ";
        $sql .= "edit_plan_septiembre, ";
        $sql .= "edit_real_septiembre, ";
        $sql .= "edit_plan_octubre, ";
        $sql .= "edit_real_octubre, ";
        $sql .= "edit_plan_noviembre, ";
        $sql .= "edit_real_noviembre, ";
        $sql .= "edit_plan_diciembre, ";
        $sql .= "edit_real_diciembre, ";
        $sql .= "id_creator, ";
        $sql .= "id_updater, ";
        $sql .= "date_insert, ";
        $sql .= "date_update, ";
        $sql .= "situation, ";
        $sql .= "deleted) VALUES (";
        $sql .= " NULL, ";
        $sql .= "'". $aParam['ano']."', ";
        $sql .= "'". $aParam['pais']."', ";
        $sql .= "'". $aParam['sede']."', ";
        $sql .= "'". $aParam['eneroplan']."', ";
        $sql .= "'". $aParam['eneroreal']."', ";
        $sql .= "'". $aParam['febreroplan']."', ";
        $sql .= "'". $aParam['febreroreal']."', ";
        $sql .= "'". $aParam['marzoplan']."', ";
        $sql .= "'". $aParam['marzoreal']."', ";
        $sql .= "'". $aParam['abrilplan']."', ";
        $sql .= "'". $aParam['abrilreal']."', ";
        $sql .= "'". $aParam['mayoplan']."', ";
        $sql .= "'". $aParam['mayoreal']."', ";
        $sql .= "'". $aParam['junioplan']."', ";
        $sql .= "'". $aParam['junioreal']."', ";
        $sql .= "'". $aParam['julioplan']."', ";
        $sql .= "'". $aParam['julioreal']."', ";
        $sql .= "'". $aParam['agostoplan']."', ";
        $sql .= "'". $aParam['agostoreal']."', ";
        $sql .= "'". $aParam['septiembreplan']."', ";
        $sql .= "'". $aParam['septiembrereal']."', ";
        $sql .= "'". $aParam['octubreplan']."', ";
        $sql .= "'". $aParam['octubrereal']."', ";
        $sql .= "'". $aParam['noviembreplan']."', ";
        $sql .= "'". $aParam['noviembrereal']."', ";
        $sql .= "'". $aParam['deciembreplan']."', ";
        $sql .= "'". $aParam['deciembrereal']."', ";
        $sql .= "'". $_SESSION['Planificacion']['user_id']."', ";
        $sql .= " 0, ";
        $sql .= " NOW(), ";
        $sql .= " '0000-00-00 00:00:00', ";
        $sql .= "'". $aParam['status']."', ";
        $sql .= " 0)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $this->pdo->lastInsertId();
        $stmt->closeCursor();
        
        return $result;
    }
    
    public function GuardarDetalheIndicadores($indicador, $id, $status)
    {
        $sql  = "";
        $sql .= "INSERT INTO dplanificacion (";
        $sql .= "id, ";
        $sql .= "id_cplanificacion, ";
        $sql .= "id_indicador, ";
        $sql .= "enero_plan, ";
        $sql .= "enero_real, ";
        $sql .= "febrero_plan, ";
        $sql .= "febrero_real, ";
        $sql .= "marzo_plan, ";
        $sql .= "marzo_real, ";
        $sql .= "abril_plan, ";
        $sql .= "abril_real, ";
        $sql .= "mayo_plan, ";
        $sql .= "mayo_real, ";
        $sql .= "junio_plan, ";
        $sql .= "junio_real, ";
        $sql .= "julio_plan, ";
        $sql .= "julio_real, ";
        $sql .= "agosto_plan, ";
        $sql .= "agosto_real, ";
        $sql .= "septiembre_plan, ";
        $sql .= "septiembre_real, ";
        $sql .= "octubre_plan, ";
        $sql .= "octubre_real, ";
        $sql .= "noviembre_plan, ";
        $sql .= "noviembre_real, ";
        $sql .= "diciembre_plan, ";
        $sql .= "diciembre_real, ";
        $sql .= "id_creator, ";
        $sql .= "id_updater, ";
        $sql .= "date_insert, ";
        $sql .= "date_update, ";
        $sql .= "situation, ";
        $sql .= "deleted) VALUES (";
        $sql .= " NULL, ";
        $sql .= "'". $id."', ";
        $sql .= "'". $indicador."', ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= " NULL, ";
        $sql .= "'". $_SESSION['Planificacion']['user_id']."', ";
        $sql .= " 0, ";
        $sql .= " NOW(), ";
        $sql .= " '0000-00-00 00:00:00', ";
        $sql .= "'". $status."', ";
        $sql .= " 0)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $this->pdo->lastInsertId();
        $stmt->closeCursor();
        
        return $result;
    }
    
    public function search($id)
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
        $sql .= "WHERE {$this->table}.id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
}
