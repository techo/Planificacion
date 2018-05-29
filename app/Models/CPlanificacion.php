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
    
    public function selectExpefica($idSede)
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "{$this->table}.id,";
        $sql .= "{$this->table}.id_ano, ";
        $sql .= "ano.ano, ";
        $sql .= "dplanificacion.id_sede, ";
        $sql .= "dplanificacion.id_pais, ";
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
        $sql .= "INNER JOIN dplanificacion ON dplanificacion.id_cplanificacion = {$this->table}.id ";
        $sql .= "WHERE {$this->table}.deleted = 0 ";
        //Nao Oficina Internacional
        if($idSede != 1)
        {
            $sql .= " AND dplanificacion.id_sede = " . $idSede;
        }
        
        $sql .= " GROUP BY id_sede, id Order By ano.ano";
        
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
    
    public function GuardarDetalheIndicadores($indicador, $id, $status, $idSede, $idPais)
    {
        $sql  = "";
        $sql .= "INSERT INTO dplanificacion (";
        $sql .= "id, ";
        $sql .= "id_cplanificacion, ";
        $sql .= "id_indicador, ";
        $sql .= "id_pais, ";
        $sql .= "id_sede, ";
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
        $sql .= "'". $idPais."', ";
        $sql .= "'". $idSede."', ";
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
    
    public function KpisRegistro($idPlanificacion)
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "indicador.indicador,";
        $sql .= "temporalidad.temporalidad,";
        $sql .= "tipo.tipo,";
        $sql .= "pilar.pilar,";
        $sql .= "dplanificacion.id,";
        $sql .= "dplanificacion.id_cplanificacion, ";
        $sql .= "dplanificacion.id_pais,";
        $sql .= "dplanificacion.id_sede,";
        $sql .= "dplanificacion.id_indicador, ";
        $sql .= "dplanificacion.enero_plan, ";
        $sql .= "dplanificacion.enero_real, ";
        $sql .= "dplanificacion.febrero_plan, ";
        $sql .= "dplanificacion.febrero_real, ";
        $sql .= "dplanificacion.marzo_plan, ";
        $sql .= "dplanificacion.marzo_real, ";
        $sql .= "dplanificacion.abril_plan, ";
        $sql .= "dplanificacion.abril_real, ";
        $sql .= "dplanificacion.mayo_plan, ";
        $sql .= "dplanificacion.mayo_real, ";
        $sql .= "dplanificacion.junio_plan, ";
        $sql .= "dplanificacion.junio_real, ";
        $sql .= "dplanificacion.julio_plan, ";
        $sql .= "dplanificacion.julio_real, ";
        $sql .= "dplanificacion.agosto_plan, ";
        $sql .= "dplanificacion.agosto_real, ";
        $sql .= "dplanificacion.septiembre_plan, ";
        $sql .= "dplanificacion.septiembre_real, ";
        $sql .= "dplanificacion.octubre_plan, ";
        $sql .= "dplanificacion.octubre_real, ";
        $sql .= "dplanificacion.noviembre_plan, ";
        $sql .= "dplanificacion.noviembre_real, ";
        $sql .= "dplanificacion.diciembre_plan, ";
        $sql .= "dplanificacion.diciembre_real, ";
        $sql .= "dplanificacion.id_creator, ";
        $sql .= "dplanificacion.id_updater, ";
        $sql .= "dplanificacion.date_insert, ";
        $sql .= "dplanificacion.date_update ";
        $sql .= "FROM dplanificacion ";
        $sql .= "LEFT JOIN indicador ON indicador.id = dplanificacion.id_indicador ";
        $sql .= "LEFT JOIN temporalidad ON temporalidad.id = indicador.id_temporalidad ";
        $sql .= "LEFT JOIN tipo ON tipo.id = indicador.id_tipo ";
        $sql .= "LEFT JOIN pilar ON pilar.id = indicador.id_pilar ";
        $sql .= "WHERE dplanificacion.deleted = 0 AND dplanificacion.id_cplanificacion = " . $idPlanificacion;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function ActualizarPlanificacion($aParam)
    {
        $sql  = "";
        $sql .= "UPDATE {$this->table} SET ";
        $sql .= "id_ano               = '" . $aParam['ano']."', ";
        $sql .= "edit_plan_enero      = '" . $aParam['eneroplan']."', ";
        $sql .= "edit_real_enero      = '" . $aParam['eneroreal']."', ";
        $sql .= "edit_plan_febrero    = '" . $aParam['febreroplan']."', ";
        $sql .= "edit_real_febrero    = '" . $aParam['febreroreal']."', ";
        $sql .= "edit_plan_marzo      = '" . $aParam['marzoplan']."', ";
        $sql .= "edit_real_marzo      = '" . $aParam['marzoreal']."', ";
        $sql .= "edit_plan_abril      = '" . $aParam['abrilplan']."', ";
        $sql .= "edit_real_abril      = '" . $aParam['abrilreal']."', ";
        $sql .= "edit_plan_mayo       = '" . $aParam['mayoplan']."', ";
        $sql .= "edit_real_mayo       = '" . $aParam['mayoreal']."', ";
        $sql .= "edit_plan_junio      = '" . $aParam['junioplan']."', ";
        $sql .= "edit_real_junio      = '" . $aParam['junioreal']."', ";
        $sql .= "edit_plan_julio      = '" . $aParam['julioplan']."', ";
        $sql .= "edit_real_julio      = '" . $aParam['julioreal']."', ";
        $sql .= "edit_plan_agosto     = '" . $aParam['agostoplan']."', ";
        $sql .= "edit_real_agosto     = '" . $aParam['agostoreal']."', ";
        $sql .= "edit_plan_septiembre = '" . $aParam['septiembreplan']."', ";
        $sql .= "edit_real_septiembre = '" . $aParam['septiembrereal']."', ";
        $sql .= "edit_plan_octubre    = '" . $aParam['octubreplan']."', ";
        $sql .= "edit_real_octubre    = '" . $aParam['octubrereal']."', ";
        $sql .= "edit_plan_noviembre  = '" . $aParam['noviembreplan']."', ";
        $sql .= "edit_real_noviembre  = '" . $aParam['noviembrereal']."', ";
        $sql .= "edit_plan_diciembre  = '" . $aParam['deciembreplan']."', ";
        $sql .= "edit_real_diciembre  = '" . $aParam['deciembrereal']."', ";
        $sql .= "situation            = '" . $aParam['status']."', ";
        $sql .= "id_updater           = '" . $_SESSION['Planificacion']['user_id']."', ";
        $sql .= "date_update          = NOW() ";
        $sql .= "WHERE id             = '" . $aParam['id']."'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
        $stmt->closeCursor();
        
        return $result;
    }
    
    public function BuscaIndicadores($idPlanificacion)
    {
        $sql  = "";
        $sql .= "SELECT * ";
        $sql .= " FROM dplanificacion ";
        $sql .= "WHERE id_cplanificacion = " . $idPlanificacion . " AND deleted = 0 AND situation = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function ApagaIndicadores($id)
    {
        $sql  = "";
        $sql .= "DELETE FROM dplanificacion ";
        $sql .= "WHERE id_cplanificacion = " . $id;
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }
    
    public function LeituraSedes($idPlanificacion)
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "indicador.indicador,";
        $sql .= "temporalidad.temporalidad,";
        $sql .= "tipo.tipo,";
        $sql .= "pilar.pilar,";
        $sql .= "dplanificacion.id,";
        $sql .= "dplanificacion.id_cplanificacion, ";
        $sql .= "dplanificacion.id_pais,";
        $sql .= "dplanificacion.id_sede,";
        $sql .= "dplanificacion.id_indicador, ";
        $sql .= "dplanificacion.enero_plan, ";
        $sql .= "dplanificacion.enero_real, ";
        $sql .= "dplanificacion.febrero_plan, ";
        $sql .= "dplanificacion.febrero_real, ";
        $sql .= "dplanificacion.marzo_plan, ";
        $sql .= "dplanificacion.marzo_real, ";
        $sql .= "dplanificacion.abril_plan, ";
        $sql .= "dplanificacion.abril_real, ";
        $sql .= "dplanificacion.mayo_plan, ";
        $sql .= "dplanificacion.mayo_real, ";
        $sql .= "dplanificacion.junio_plan, ";
        $sql .= "dplanificacion.junio_real, ";
        $sql .= "dplanificacion.julio_plan, ";
        $sql .= "dplanificacion.julio_real, ";
        $sql .= "dplanificacion.agosto_plan, ";
        $sql .= "dplanificacion.agosto_real, ";
        $sql .= "dplanificacion.septiembre_plan, ";
        $sql .= "dplanificacion.septiembre_real, ";
        $sql .= "dplanificacion.octubre_plan, ";
        $sql .= "dplanificacion.octubre_real, ";
        $sql .= "dplanificacion.noviembre_plan, ";
        $sql .= "dplanificacion.noviembre_real, ";
        $sql .= "dplanificacion.diciembre_plan, ";
        $sql .= "dplanificacion.diciembre_real, ";
        $sql .= "dplanificacion.id_creator, ";
        $sql .= "dplanificacion.id_updater, ";
        $sql .= "dplanificacion.date_insert, ";
        $sql .= "dplanificacion.date_update ";
        $sql .= "FROM dplanificacion ";
        $sql .= "LEFT JOIN indicador ON indicador.id = dplanificacion.id_indicador ";
        $sql .= "LEFT JOIN temporalidad ON temporalidad.id = indicador.id_temporalidad ";
        $sql .= "LEFT JOIN tipo ON tipo.id = indicador.id_tipo ";
        $sql .= "LEFT JOIN pilar ON pilar.id = indicador.id_pilar ";
        $sql .= "WHERE dplanificacion.deleted = 0 AND dplanificacion.id_cplanificacion = " . $idPlanificacion . " GROUP BY id_sede";
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
    
    public function deleteIndicador($id)
    {
        $query .= "UPDATE dplanificacion SET ";
        $query .= "deleted = 1 ";
        $query .= "WHERE id=:id ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id", $id);
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }
    
    public function searchAnoPlanificacion($id)
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "{$this->table}.id,";
        $sql .= "{$this->table}.id_ano, ";
        $sql .= "ano.ano, ";
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
        $sql .= "WHERE {$this->table}.id_ano=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaSedePais($idPlanificacion, $idSede)
    {
        $sql  = "";
        $sql .= "SELECT * ";
        $sql .= " FROM dplanificacion ";
        $sql .= "WHERE id_cplanificacion = " . $idPlanificacion . " AND deleted = 0 AND situation = 1 AND id_sede = ". $idSede . " GROUP BY id_sede";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function GetPilar($idPilar)
    {
        $sql  = "";
        $sql .= "SELECT * ";
        $sql .= " FROM pilar ";
        $sql .= "WHERE id = " .$idPilar;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaIndicador($aParam)
    {
        $sql  = "";
        $sql .= "SELECT * ";
        $sql .= " FROM dplanificacion ";
        $sql .= "WHERE id = " .$aParam['id'];
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaTipo($idTipo)
    {
        $sql  = "";
        $sql .= "SELECT indicador.*, ";
        $sql .= "tipo.tipo ";
        $sql .= " FROM indicador ";
        $sql .= "INNER JOIN tipo tipo ON tipo.id = indicador.id_tipo ";
        $sql .= "WHERE indicador.id = " .$idTipo;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function Listagem($idPlanificacion, $idSede, $idPais = 0)
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "dplanificacion.*, ";
        $sql .= "indicador.indicador, ";
        $sql .= "indicador.id_pilar, ";
        $sql .= "indicador.id_temporalidad, ";
        $sql .= "temporalidad.temporalidad, ";
        $sql .= "indicador.formato, ";
        $sql .= "indicador.id_area ";
        $sql .= " FROM dplanificacion ";
        $sql .= "INNER JOIN indicador indicador ON indicador.id = dplanificacion.id_indicador ";
        $sql .= "INNER JOIN temporalidad temporalidad ON temporalidad.id = indicador.id_temporalidad ";
        $sql .= "WHERE dplanificacion.id_cplanificacion = " . $idPlanificacion . " AND dplanificacion.deleted = 0 AND dplanificacion.situation = 1 AND dplanificacion.id_sede = ". $idSede;
        if($idPais != 0)
        {
            $sql .= " AND dplanificacion.id_pais = " . $idPais;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function AtualizaDados($aParam)
    {
        $sql  = "";
        $sql .= "UPDATE {$this->table} SET ";
        $sql .= "situation              = '" . $aParam['status']."', ";
        $sql .= "edit_plan_enero        = '" . $aParam['eneroplan']."', ";
        $sql .= "edit_real_enero        = '" . $aParam['eneroreal']."', ";
        $sql .= "edit_plan_febrero      = '" . $aParam['febreroplan']."', ";
        $sql .= "edit_real_febrero      = '" . $aParam['febreroreal']."', ";
        $sql .= "edit_plan_marzo        = '" . $aParam['marzoplan']."', ";
        $sql .= "edit_real_marzo        = '" . $aParam['marzoreal']."', ";
        $sql .= "edit_plan_abril        = '" . $aParam['abrilplan']."', ";
        $sql .= "edit_real_abril        = '" . $aParam['abrilreal']."', ";
        $sql .= "edit_plan_mayo         = '" . $aParam['mayoplan']."', ";
        $sql .= "edit_real_mayo         = '" . $aParam['mayoreal']."', ";
        $sql .= "edit_plan_junio        = '" . $aParam['junioplan']."', ";
        $sql .= "edit_real_junio        = '" . $aParam['junioreal']."', ";
        $sql .= "edit_plan_julio        = '" . $aParam['julioplan']."', ";
        $sql .= "edit_real_julio        = '" . $aParam['julioreal']."', ";
        $sql .= "edit_plan_agosto       = '" . $aParam['agostoplan']."', ";
        $sql .= "edit_real_agosto       = '" . $aParam['agostoreal']."', ";
        $sql .= "edit_plan_septiembre   = '" . $aParam['septiembreplan']."', ";
        $sql .= "edit_real_septiembre   = '" . $aParam['septiembrereal']."', ";
        $sql .= "edit_plan_octubre      = '" . $aParam['octubreplan']."', ";
        $sql .= "edit_real_octubre      = '" . $aParam['octubrereal']."', ";
        $sql .= "edit_plan_noviembre    = '" . $aParam['noviembreplan']."', ";
        $sql .= "edit_real_noviembre    = '" . $aParam['noviembrereal']."', ";
        $sql .= "edit_plan_diciembre    = '" . $aParam['deciembreplan']."', ";
        $sql .= "edit_real_diciembre    = '" . $aParam['deciembrereal']."', ";
        $sql .= "id_updater             = '" . $_SESSION['Planificacion']['user_id']."', ";
        $sql .= "date_update            = NOW() ";
        $sql .= "WHERE id               = '" . $aParam['id']."'";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }
    
    public function AtualizaIndicador($aParam)
    {
        $sql  = "";
        $sql .= "UPDATE dplanificacion SET ";
        
        if($aParam['valor'] == 'NaN')
        {
            $sql .= "{$aParam['coluna']} = (NULL), ";
        }
        else
        {
            $sql .= "{$aParam['coluna']} = '".$aParam['valor']."', ";
        }
        
        $sql .= "id_updater = '" . $_SESSION['Planificacion']['user_id']."', ";
        $sql .= "date_update = NOW() ";
        $sql .= "WHERE id            = '" . $aParam['id']."'";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }
    
    public function GravaAcumulados($aValores)
    {
        $sql  = "";
        $sql .= "UPDATE dplanificacion SET ";
        $sql .= "acumulado_plan_anual = '".$aValores[0]['acumulado_plan_anual']."', ";
        $sql .= "acumulado_real_anual = '".$aValores[0]['acumulado_real_anual']."', ";
        $sql .= "acumulado_rp_anual   = '".$aValores[0]['acumulado_rp_anual']."', ";
        $sql .= "acumulado_plan_t1    = '".$aValores[0]['acumulado_plan_t1']."', ";
        $sql .= "acumulado_real_t1    = '".$aValores[0]['acumulado_real_t1']."', ";
        $sql .= "acumulado_rp_t1      = '".$aValores[0]['acumulado_rp_t1']."', ";
        $sql .= "acumulado_plan_t2    = '".$aValores[0]['acumulado_plan_t2']."', ";
        $sql .= "acumulado_real_t2    = '".$aValores[0]['acumulado_real_t2']."', ";
        $sql .= "acumulado_rp_t2      = '".$aValores[0]['acumulado_rp_t2']."', ";
        $sql .= "acumulado_plan_t3    = '".$aValores[0]['acumulado_plan_t3']."', ";
        $sql .= "acumulado_real_t3    = '".$aValores[0]['acumulado_real_t3']."', ";
        $sql .= "acumulado_rp_t3      = '".$aValores[0]['acumulado_rp_t3']."', ";
        $sql .= "acumulado_plan_t4    = '".$aValores[0]['acumulado_plan_t4']."', ";
        $sql .= "acumulado_real_t4    = '".$aValores[0]['acumulado_real_t4']."', ";
        $sql .= "acumulado_rp_t4      = '".$aValores[0]['acumulado_rp_t4']."', ";
        $sql .= "acumulado_plan_s1    = '".$aValores[0]['acumulado_plan_s1']."', ";
        $sql .= "acumulado_real_s1    = '".$aValores[0]['acumulado_real_s1']."', ";
        $sql .= "acumulado_rp_s1      = '".$aValores[0]['acumulado_rp_s1']."', ";
        $sql .= "acumulado_plan_s2    = '".$aValores[0]['acumulado_plan_s2']."', ";
        $sql .= "acumulado_real_s2    = '".$aValores[0]['acumulado_real_s2']."', ";
        $sql .= "acumulado_rp_s2      = '".$aValores[0]['acumulado_rp_s2']."', ";
        $sql .= "id_updater = '" . $_SESSION['Planificacion']['user_id']."', ";
        $sql .= "date_update = NOW() ";
        $sql .= "WHERE id            = '" . $aValores[0]['id']."'";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }
    
    public function GravaPromedio($aValores)
    {
        $sql  = "";
        $sql .= "UPDATE dplanificacion SET ";
        $sql .= "promedio_plan_anual = '".$aValores[0]['promedio_plan_anual']."', ";
        $sql .= "promedio_real_anual = '".$aValores[0]['promedio_real_anual']."', ";
        $sql .= "promedio_rp_anual   = '".$aValores[0]['promedio_rp_anual']."', ";
        $sql .= "promedio_plan_t1    = '".$aValores[0]['promedio_plan_t1']."', ";
        $sql .= "promedio_real_t1    = '".$aValores[0]['promedio_real_t1']."', ";
        $sql .= "promedio_rp_t1      = '".$aValores[0]['promedio_rp_t1']."', ";
        $sql .= "promedio_plan_t2    = '".$aValores[0]['promedio_plan_t2']."', ";
        $sql .= "promedio_real_t2    = '".$aValores[0]['promedio_real_t2']."', ";
        $sql .= "promedio_rp_t2      = '".$aValores[0]['promedio_rp_t2']."', ";
        $sql .= "promedio_plan_t3    = '".$aValores[0]['promedio_plan_t3']."', ";
        $sql .= "promedio_real_t3    = '".$aValores[0]['promedio_real_t3']."', ";
        $sql .= "promedio_rp_t3      = '".$aValores[0]['promedio_rp_t3']."', ";
        $sql .= "promedio_plan_t4    = '".$aValores[0]['promedio_plan_t4']."', ";
        $sql .= "promedio_real_t4    = '".$aValores[0]['promedio_real_t4']."', ";
        $sql .= "promedio_rp_t4      = '".$aValores[0]['promedio_rp_t4']."', ";
        $sql .= "promedio_plan_s1    = '".$aValores[0]['promedio_plan_s1']."', ";
        $sql .= "promedio_real_s1    = '".$aValores[0]['promedio_real_s1']."', ";
        $sql .= "promedio_rp_s1      = '".$aValores[0]['promedio_rp_s1']."', ";
        $sql .= "promedio_plan_s2    = '".$aValores[0]['promedio_plan_s2']."', ";
        $sql .= "promedio_real_s2    = '".$aValores[0]['promedio_real_s2']."', ";
        $sql .= "promedio_rp_s2      = '".$aValores[0]['promedio_rp_s2']."', ";
        $sql .= "id_updater = '" . $_SESSION['Planificacion']['user_id']."', ";
        $sql .= "date_update = NOW() ";
        $sql .= "WHERE id            = '" . $aValores[0]['id']."'";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaPlan($id)
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "dplanificacion.enero_plan, ";
        $sql .= "dplanificacion.febrero_plan, ";
        $sql .= "dplanificacion.marzo_plan, ";
        $sql .= "dplanificacion.abril_plan, ";
        $sql .= "dplanificacion.mayo_plan, ";
        $sql .= "dplanificacion.junio_plan, ";
        $sql .= "dplanificacion.julio_plan, ";
        $sql .= "dplanificacion.agosto_plan, ";
        $sql .= "dplanificacion.septiembre_plan, ";
        $sql .= "dplanificacion.octubre_plan, ";
        $sql .= "dplanificacion.noviembre_plan, ";
        $sql .= "dplanificacion.diciembre_plan ";
        $sql .= " FROM dplanificacion ";
        $sql .= "WHERE dplanificacion.id = " .$id;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaReal($id)
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "dplanificacion.enero_real, ";
        $sql .= "dplanificacion.febrero_real, ";
        $sql .= "dplanificacion.marzo_real, ";
        $sql .= "dplanificacion.abril_real, ";
        $sql .= "dplanificacion.mayo_real, ";
        $sql .= "dplanificacion.junio_real, ";
        $sql .= "dplanificacion.julio_real, ";
        $sql .= "dplanificacion.agosto_real, ";
        $sql .= "dplanificacion.septiembre_real, ";
        $sql .= "dplanificacion.octubre_real, ";
        $sql .= "dplanificacion.noviembre_real, ";
        $sql .= "dplanificacion.diciembre_real ";
        $sql .= " FROM dplanificacion ";
        $sql .= "WHERE dplanificacion.id = " .$id;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function GravaMinimo($aValores)
    {
        $sql  = "";
        $sql .= "UPDATE dplanificacion SET ";
        $sql .= "minimo_plan_anual = '".$aValores[0]['minimo_plan_anual']."', ";
        $sql .= "minimo_real_anual = '".$aValores[0]['minimo_real_anual']."', ";
        $sql .= "minimo_rp_anual   = '".$aValores[0]['minimo_rp_anual']."', ";
        $sql .= "minimo_plan_t1    = '".$aValores[0]['minimo_plan_t1']."', ";
        $sql .= "minimo_real_t1    = '".$aValores[0]['minimo_real_t1']."', ";
        $sql .= "minimo_rp_t1      = '".$aValores[0]['minimo_rp_t1']."', ";
        $sql .= "minimo_plan_t2    = '".$aValores[0]['minimo_plan_t2']."', ";
        $sql .= "minimo_real_t2    = '".$aValores[0]['minimo_real_t2']."', ";
        $sql .= "minimo_rp_t2      = '".$aValores[0]['minimo_rp_t2']."', ";
        $sql .= "minimo_plan_t3    = '".$aValores[0]['minimo_plan_t3']."', ";
        $sql .= "minimo_real_t3    = '".$aValores[0]['minimo_real_t3']."', ";
        $sql .= "minimo_rp_t3      = '".$aValores[0]['minimo_rp_t3']."', ";
        $sql .= "minimo_plan_t4    = '".$aValores[0]['minimo_plan_t4']."', ";
        $sql .= "minimo_real_t4    = '".$aValores[0]['minimo_real_t4']."', ";
        $sql .= "minimo_rp_t4      = '".$aValores[0]['minimo_rp_t4']."', ";
        $sql .= "minimo_plan_s1    = '".$aValores[0]['minimo_plan_s1']."', ";
        $sql .= "minimo_real_s1    = '".$aValores[0]['minimo_real_s1']."', ";
        $sql .= "minimo_rp_s1      = '".$aValores[0]['minimo_rp_s1']."', ";
        $sql .= "minimo_plan_s2    = '".$aValores[0]['minimo_plan_s2']."', ";
        $sql .= "minimo_real_s2    = '".$aValores[0]['minimo_real_s2']."', ";
        $sql .= "minimo_rp_s2      = '".$aValores[0]['minimo_rp_s2']."', ";
        $sql .= "id_updater = '" . $_SESSION['Planificacion']['user_id']."', ";
        $sql .= "date_update = NOW() ";
        $sql .= "WHERE id            = '" . $aValores[0]['id']."'";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }
    
    public function GravaMaximos($aValores)
    {
        $sql  = "";
        $sql .= "UPDATE dplanificacion SET ";
        $sql .= "maximo_plan_anual = '".$aValores[0]['maximo_plan_anual']."', ";
        $sql .= "maximo_real_anual = '".$aValores[0]['maximo_real_anual']."', ";
        $sql .= "maximo_rp_anual   = '".$aValores[0]['maximo_rp_anual']."', ";
        $sql .= "maximo_plan_t1    = '".$aValores[0]['maximo_plan_t1']."', ";
        $sql .= "maximo_real_t1    = '".$aValores[0]['maximo_real_t1']."', ";
        $sql .= "maximo_rp_t1      = '".$aValores[0]['maximo_rp_t1']."', ";
        $sql .= "maximo_plan_t2    = '".$aValores[0]['maximo_plan_t2']."', ";
        $sql .= "maximo_real_t2    = '".$aValores[0]['maximo_real_t2']."', ";
        $sql .= "maximo_rp_t2      = '".$aValores[0]['maximo_rp_t2']."', ";
        $sql .= "maximo_plan_t3    = '".$aValores[0]['maximo_plan_t3']."', ";
        $sql .= "maximo_real_t3    = '".$aValores[0]['maximo_real_t3']."', ";
        $sql .= "maximo_rp_t3      = '".$aValores[0]['maximo_rp_t3']."', ";
        $sql .= "maximo_plan_t4    = '".$aValores[0]['maximo_plan_t4']."', ";
        $sql .= "maximo_real_t4    = '".$aValores[0]['maximo_real_t4']."', ";
        $sql .= "maximo_rp_t4      = '".$aValores[0]['maximo_rp_t4']."', ";
        $sql .= "maximo_plan_s1    = '".$aValores[0]['maximo_plan_s1']."', ";
        $sql .= "maximo_real_s1    = '".$aValores[0]['maximo_real_s1']."', ";
        $sql .= "maximo_rp_s1      = '".$aValores[0]['maximo_rp_s1']."', ";
        $sql .= "maximo_plan_s2    = '".$aValores[0]['maximo_plan_s2']."', ";
        $sql .= "maximo_real_s2    = '".$aValores[0]['maximo_real_s2']."', ";
        $sql .= "maximo_rp_s2      = '".$aValores[0]['maximo_rp_s2']."', ";
        $sql .= "id_updater = '" . $_SESSION['Planificacion']['user_id']."', ";
        $sql .= "date_update = NOW() ";
        $sql .= "WHERE id            = '" . $aValores[0]['id']."'";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }
}
