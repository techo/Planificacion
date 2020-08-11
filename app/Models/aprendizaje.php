<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class aprendizaje extends BaseModel
{
    protected $table = "aprendizaje";
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function select()
    {
        $sql  = "";
        $sql .= "SELECT  {$this->table}.*, ano.ano as ano, CASE
        WHEN {$this->table}.id_pais = 1 THEN 'Brasil'
        WHEN {$this->table}.id_pais = 2 THEN 'Chile'
        WHEN {$this->table}.id_pais = 3 THEN 'El Salvador'
        WHEN {$this->table}.id_pais = 4 THEN 'Argentina'
        WHEN {$this->table}.id_pais = 5 THEN 'Oficina Internacional'
        WHEN {$this->table}.id_pais = 6 THEN 'Bolivia'
        WHEN {$this->table}.id_pais = 7 THEN 'Colombia'
        WHEN {$this->table}.id_pais = 8 THEN 'Costa Rica'
        WHEN {$this->table}.id_pais = 9 THEN 'Ecuador'
        WHEN {$this->table}.id_pais = 10 THEN 'Guatemala'
        WHEN {$this->table}.id_pais = 11 THEN 'Haiti'
        WHEN {$this->table}.id_pais = 12 THEN 'Honduras'
        WHEN {$this->table}.id_pais = 13 THEN 'Mexico'
        WHEN {$this->table}.id_pais = 14 THEN 'Nicaragua'
        WHEN {$this->table}.id_pais = 15 THEN 'Panama'
        WHEN {$this->table}.id_pais = 16 THEN 'Paraguay'
        WHEN {$this->table}.id_pais = 17 THEN 'Peru'
        WHEN {$this->table}.id_pais = 18 THEN 'Republica Dominicana'
        WHEN {$this->table}.id_pais = 19 THEN 'Uruguay'
        WHEN {$this->table}.id_pais = 20 THEN 'EUA'
        WHEN {$this->table}.id_pais = 21 THEN 'Venezuela'
        WHEN {$this->table}.id_pais = 22 THEN 'Europa'
        ELSE 'Global'
        END AS 'Pais'";
        $sql .= " FROM {$this->table} ";
        $sql .= " INNER JOIN ano on ano.id = {$this->table}.id_ano ";
        $sql .= "WHERE {$this->table}.deleted = 0 ORDER BY {$this->table}.id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function selectAnos()
    {
        $sql  = "";
        $sql .= "SELECT  * FROM ano ";
        $sql .= "WHERE deleted = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function insert($aParam)
    {
        $sql  = "";
        $sql .= "INSERT INTO {$this->table} (";
        $sql .= "id, ";
        $sql .= "aprendizaje, ";
        $sql .= "descripcion, ";
        $sql .= "id_pais, ";
        $sql .= "id_ano, ";
        $sql .= "id_creator, ";
        $sql .= "id_updater, ";
        $sql .= "date_insert, ";
        $sql .= "date_update, ";
        $sql .= "deleted) VALUES (";
        $sql .= " NULL, ";
        $sql .= "'". $aParam['aprendizaje']."', ";
        $sql .= "'". $aParam['descripcion']."', ";
        $sql .= "'". $aParam['pais']."', ";
        $sql .= "'". $aParam['ano']."', ";
        $sql .= "'". $_SESSION['Planificacion']['user_id']."', ";
        $sql .= " 0, ";
        $sql .= " NOW(), ";
        $sql .= " NOW(), ";
        $sql .= " 0)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
        $stmt->closeCursor();
        
        return $result;
    }
    
    public function filter($aParam)
    {
        $sql  = "";
        $sql .= "SELECT  *";
        $sql .= " FROM {$this->table} ";
        $sql .= "WHERE deleted = 0";
        
        if($aParam['pais'] != 0)
        {
            $sql .= " AND id_pais = " . $aParam['pais'];
        }
        
        if($aParam['ano'] != 0)
        {
            $sql .= " AND id_ano = " . $aParam['ano'];
        }
        
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
    
    public function edit($aParam)
    {
        $sql  = "";
        $sql .= "SELECT  *";
        $sql .= " FROM {$this->table} ";
        $sql .= "WHERE ";
        $sql .= " id = " . $aParam['id'];
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function update($aParam)
    {
        $sql  = "";
        $sql .= "UPDATE {$this->table} SET ";
        $sql .= "aprendizaje             = '" . $aParam['aprendizaje']."', ";
        $sql .= "descripcion             = '" . $aParam['descripcion']."', ";
        $sql .= "id_pais                 = '" . $aParam['pais']."', ";
        $sql .= "id_ano                  = '" . $aParam['ano']."', ";
        $sql .= "id_updater              = '" . $_SESSION['Planificacion']['user_id']."', ";
        $sql .= "date_update             = NOW() ";
        $sql .= "WHERE id                = '" . $aParam['id']."'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
        $stmt->closeCursor();
        
        return $result;
    }
    
    public function getaprendizaje($id)
    {
        $sql  = "";
        $sql .= "SELECT  aprendizaje.*, ano.ano";
        $sql .= " FROM {$this->table} ";
        $sql .= " INNER JOIN ano on ano.id = aprendizaje.id_ano ";
        $sql .= "WHERE aprendizaje.deleted = 0 and aprendizaje.id = " . $id;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function indicesExcelencia()
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= " indicador.id, ";
        $sql .= " indicador.indicador, ";
        $sql .= " indicador.id_tipo, ";
        $sql .= " tipo.tipo ";
        $sql .= " FROM indicador ";
        $sql .= " INNER JOIN tipo on tipo.id = indicador.id_tipo ";
        $sql .= " WHERE indicador.formato IN ('#', '$') AND indicador.id_pais = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function InsertRelacion($aParam)
    {
        $sql  = "";
        $sql .= "INSERT INTO rlaprendizaje (";
        $sql .= "id, ";
        $sql .= "kpi1, ";
        $sql .= "ponderacion1, ";
        $sql .= "kpi2, ";
        $sql .= "ponderacion2, ";
        $sql .= "kpi3, ";
        $sql .= "ponderacion3, ";
        $sql .= "kpi4, ";
        $sql .= "ponderacion4, ";
        $sql .= "kpi5, ";
        $sql .= "ponderacion5, ";
        $sql .= "id_aprendizaje, ";
        $sql .= "ids_procesos, ";
        $sql .= "ids_aprendizajes, ";
        $sql .= "id_creator, ";
        $sql .= "id_updater, ";
        $sql .= "date_insert, ";
        $sql .= "date_update, ";
        $sql .= "deleted) VALUES (";
        $sql .= " NULL, ";
        $sql .= "'". $aParam['K1']."', ";
        $sql .= "'". $aParam['P1']."', ";
        $sql .= "'". $aParam['K2']."', ";
        $sql .= "'". $aParam['P2']."', ";
        $sql .= "'". $aParam['K3']."', ";
        $sql .= "'". $aParam['P3']."', ";
        $sql .= "'". $aParam['K4']."', ";
        $sql .= "'". $aParam['P4']."', ";
        $sql .= "'". $aParam['K5']."', ";
        $sql .= "'". $aParam['P5']."', ";
        $sql .= "'". $aParam['aprendizaje']."', ";
        $sql .= "'". $aParam['id_proceso']."', ";
        $sql .= "'". $aParam['id_aprendizaje']."', ";
        $sql .= "'". $_SESSION['Planificacion']['user_id']."', ";
        $sql .= " 0, ";
        $sql .= " NOW(), ";
        $sql .= " NOW(), ";
        $sql .= " 0)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
        $stmt->closeCursor();
        
        return $result;
    }
    
    public function getRelacion($id)
    {
        $sql  = "";
        $sql .= "SELECT  * ";
        $sql .= " FROM rlaprendizaje ";
        $sql .= "WHERE rlaprendizaje.id_aprendizaje = " . $id;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    } 
    
    public function UpdateRelacion($aParam)
    {
        $sql  = "";
        $sql .= "UPDATE rlaprendizaje SET ";
        $sql .= "kpi1                    = '" . $aParam['K1']."', ";
        $sql .= "ponderacion1            = '" . $aParam['P1']."', ";
        $sql .= "kpi2                    = '" . $aParam['K2']."', ";
        $sql .= "ponderacion2            = '" . $aParam['P2']."', ";
        $sql .= "kpi3                    = '" . $aParam['K3']."', ";
        $sql .= "ponderacion3            = '" . $aParam['P3']."', ";
        $sql .= "kpi4                    = '" . $aParam['K4']."', ";
        $sql .= "ponderacion4            = '" . $aParam['P4']."', ";
        $sql .= "kpi5                    = '" . $aParam['K5']."', ";
        $sql .= "ponderacion5            = '" . $aParam['P5']."', ";
        $sql .= "ids_procesos            = '" . $aParam['id_proceso']."', ";
        $sql .= "ids_aprendizajes        = '" . $aParam['id_aprendizaje']."', ";
        $sql .= "id_updater              = '" . $_SESSION['Planificacion']['user_id']."', ";
        $sql .= "date_update             = NOW() ";
        $sql .= "WHERE id                = '" . $aParam['idrelacion']."'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
        $stmt->closeCursor();
        
        return $result;
    }
    
    public function getAllProcesos($ano, $pais)
    {
        
        if($pais != 0)
        {
            $completa = " and proceso.id_pais IN ('" . $pais . "','0')";
        }
        else
        {
            $completa = "";
        }
        
        $sql  = "";
        $sql .= "SELECT  proceso.*";
        $sql .= " FROM proceso ";
        $sql .= " INNER JOIN ano on ano.id = proceso.id_ano ";
        $sql .= "WHERE proceso.deleted = 0 and proceso.id_ano = " . $ano . $completa;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function getAllAprendizajes($id, $pais, $ano)
    {
        
        if($pais != 0)
        {
            $completa = " and aprendizaje.id_pais IN ('" . $pais . "','0')";
        }
        else
        {
            $completa = "";
        }
        
        
        $sql  = "";
        $sql .= "SELECT  aprendizaje.*";
        $sql .= " FROM aprendizaje ";
        $sql .= " INNER JOIN ano on ano.id = aprendizaje.id_ano ";
        $sql .= "WHERE aprendizaje.deleted = 0 and aprendizaje.id_ano = " . $ano." and aprendizaje.id != " . $id . $completa;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function getUtilizados()
    {
        $sql  = "";
        $sql .= "SELECT  * FROM rlproposito ";
        $sql .= "WHERE deleted = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function getIndicador($id)
    {
        $sql  = "";
        $sql .= "SELECT  * FROM indicador ";
        $sql .= "WHERE id = " . $id;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function getProp()
    {
        $sql  = "";
        $sql .= "SELECT  * FROM rlpropuesta ";
        $sql .= "WHERE deleted = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function getProc()
    {
        $sql  = "";
        $sql .= "SELECT  * FROM rlproceso ";
        $sql .= "WHERE deleted = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function getApre()
    {
        $sql  = "";
        $sql .= "SELECT  * FROM rlaprendizaje ";
        $sql .= "WHERE deleted = 0 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
}
