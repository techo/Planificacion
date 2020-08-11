<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class propuesta extends BaseModel
{
    protected $table = "propuesta";
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
        $sql .= "propuesta, ";
        $sql .= "descripcion, ";
        $sql .= "id_pais, ";
        $sql .= "id_ano, ";
        $sql .= "id_creator, ";
        $sql .= "id_updater, ";
        $sql .= "date_insert, ";
        $sql .= "date_update, ";
        $sql .= "deleted) VALUES (";
        $sql .= " NULL, ";
        $sql .= "'". $aParam['propuesta']."', ";
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
        $sql .= "propuesta               = '" . $aParam['propuesta']."', ";
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
    
    public function getPropuesta($id)
    {
        $sql  = "";
        $sql .= "SELECT  propuesta.*, ano.ano";
        $sql .= " FROM {$this->table} ";
        $sql .= " INNER JOIN ano on ano.id = propuesta.id_ano ";
        $sql .= "WHERE propuesta.deleted = 0 and propuesta.id = " . $id;
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
        $sql .= "INSERT INTO rlpropuesta (";
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
        $sql .= "id_propuesta, ";
        $sql .= "ids_propuestas, ";
        $sql .= "ids_proposito, ";
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
        $sql .= "'". $aParam['propuesta']."', ";
        $sql .= "'". $aParam['id_propuesta']."', ";
        $sql .= "'". $aParam['id_proposito']."', ";
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
        $sql .= " FROM rlpropuesta ";
        $sql .= "WHERE rlpropuesta.id_propuesta = " . $id;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    } 
    
    public function UpdateRelacion($aParam)
    {
        $sql  = "";
        $sql .= "UPDATE rlpropuesta SET ";
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
        $sql .= "id_propuesta            = '" . $aParam['propuesta']."', ";
        $sql .= "ids_proposito           = '" . $aParam['id_proposito']."', ";
        $sql .= "ids_propuestas          = '" . $aParam['id_propuesta']."', ";
        $sql .= "id_updater              = '" . $_SESSION['Planificacion']['user_id']."', ";
        $sql .= "date_update             = NOW() ";
        $sql .= "WHERE id                = '" . $aParam['idrelacion']."'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
        $stmt->closeCursor();
        
        return $result;
    }
    
    public function getAllPropositos($ano, $pais)
    {
        
        if($pais != 0)
        {
            $completa = " and proposito.id_pais IN ('" . $pais . "','0')";
        }
        else
        {
            $completa = "";
        }
        
        $sql  = "";
        $sql .= "SELECT  proposito.*";
        $sql .= " FROM proposito ";
        $sql .= " INNER JOIN ano on ano.id = proposito.id_ano ";
        $sql .= "WHERE proposito.deleted = 0 and proposito.id_ano = " . $ano . $completa;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function getAllPropuestas($id, $pais, $ano)
    {
        
        if($pais != 0)
        {
            $completa = " and propuesta.id_pais IN ('" . $pais . "','0')";
        }
        else
        {
            $completa = "";
        }
        
        
        $sql  = "";
        $sql .= "SELECT  propuesta.*";
        $sql .= " FROM propuesta ";
        $sql .= " INNER JOIN ano on ano.id = propuesta.id_ano ";
        $sql .= "WHERE propuesta.deleted = 0 and propuesta.id_ano = " . $ano." and propuesta.id != " . $id . $completa;
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
    
}
