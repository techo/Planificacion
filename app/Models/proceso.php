<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class proceso extends BaseModel
{
    protected $table = "proceso";
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
        $sql .= "WHERE deleted = 0 ORDER BY id DESC";
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
        $sql .= "proceso, ";
        $sql .= "descripcion, ";
        $sql .= "id_pais, ";
        $sql .= "id_ano, ";
        $sql .= "id_creator, ";
        $sql .= "id_updater, ";
        $sql .= "date_insert, ";
        $sql .= "date_update, ";
        $sql .= "deleted) VALUES (";
        $sql .= " NULL, ";
        $sql .= "'". $aParam['proceso']."', ";
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
        $sql .= "proceso                 = '" . $aParam['proceso']."', ";
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
    
    public function getproceso($id)
    {
        $sql  = "";
        $sql .= "SELECT  proceso.*, ano.ano";
        $sql .= " FROM {$this->table} ";
        $sql .= " INNER JOIN ano on ano.id = proceso.id_ano ";
        $sql .= "WHERE proceso.deleted = 0 and proceso.id = " . $id;
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
        $sql .= "INSERT INTO rlproceso (";
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
        $sql .= "id_proceso, ";
        $sql .= "ids_procesos, ";
        $sql .= "ids_propuestas, ";
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
        $sql .= "'". $aParam['proceso']."', ";
        $sql .= "'". $aParam['id_procesos']."', ";
        $sql .= "'". $aParam['id_propuesta']."', ";
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
        $sql .= " FROM rlproceso ";
        $sql .= "WHERE rlproceso.id_proceso = " . $id;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    } 
    
    public function UpdateRelacion($aParam)
    {
        $sql  = "";
        $sql .= "UPDATE rlproceso SET ";
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
        $sql .= "id_proceso              = '" . $aParam['proceso']."', ";
        $sql .= "ids_procesos            = '" . $aParam['id_procesos']."', ";
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
    
    public function getAllPropuestas($ano, $pais)
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
        $sql .= "SELECT propuesta.*";
        $sql .= " FROM propuesta ";
        $sql .= " INNER JOIN ano on ano.id = propuesta.id_ano ";
        $sql .= "WHERE propuesta.deleted = 0 and propuesta.id_ano = " . $ano . $completa;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function getAllProcesos($id, $pais)
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
        $sql .= "WHERE proceso.deleted = 0 and proceso.id != " . $id . $completa;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
}
