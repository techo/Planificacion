<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class Foco extends BaseModel
{
    protected $table = "foco";
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function select($idPais)
    {
        $sql  = "";
        $sql .= "SELECT  foco.*, ano.ano, CASE
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
        END AS 'pais' ";
        $sql .= " FROM {$this->table} ";
        $sql .= " INNER JOIN ano ON ano.id = {$this->table}.id_ano ";
        $sql .= "WHERE {$this->table}.deleted = 0 ";
        /*Se for diferente de OI mostra apenas nivel pais*/
        if($idPais != 5)
        {
            $sql .= " AND {$this->table}.id_pais = " . $idPais;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function GuardarFoco($aParam)
    {
        $sql  = "";
        $sql .= "INSERT INTO foco (";
        $sql .= "id, ";
        $sql .= "nombre, ";
        $sql .= "descripcion, ";
        $sql .= "obs, ";
        $sql .= "pasos, ";
        $sql .= "id_ano, ";
        $sql .= "id_pais, ";
        $sql .= "id_sede, ";
        $sql .= "id_creator, ";
        $sql .= "id_updater, ";
        $sql .= "date_insert, ";
        $sql .= "deleted) VALUES (";
        $sql .= " NULL, ";
        $sql .= "'". $aParam['nombre']."', ";
        $sql .= "'". $aParam['descripcion']."', ";
        $sql .= "'". $aParam['obs']."', ";
        $sql .= "'". $aParam['pasos']."', ";
        $sql .= "'". $aParam['id_ano']."', ";
        $sql .= "'". $aParam['id_pais']."', ";
        $sql .= "'". $aParam['id_sede']."', ";
        $sql .= "'". $_SESSION['Planificacion']['user_id']."', ";
        $sql .= " 0, ";
        $sql .= " NOW(), ";
        $sql .= " 0)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $this->pdo->lastInsertId();
        $stmt->closeCursor();
        
        return $result;
    }
    
    public function GuardarDetalleFoco($indicador, $id, $ponderacion)
    {
        $sql  = "";
        $sql .= "INSERT INTO dfoco (";
        $sql .= "id, ";
        $sql .= "id_foco, ";
        $sql .= "id_indicador, ";
        $sql .= "ponderacion, ";
        $sql .= "id_creator, ";
        $sql .= "id_updater, ";
        $sql .= "date_insert, ";
        $sql .= "deleted) VALUES (";
        $sql .= " NULL, ";
        $sql .= "'". $id."', ";
        $sql .= "'". $indicador."', ";
        $sql .= "". $ponderacion.", ";
        $sql .= "'". $_SESSION['Planificacion']['user_id']."', ";
        $sql .= " 0, ";
        $sql .= " NOW(), ";
        $sql .= " 0)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $this->pdo->lastInsertId();
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
    
    public function IndicadoresFoco($id)
    {
        $sql  = "";
        $sql .= "SELECT  * FROM dfoco ";
        $sql .= "WHERE dfoco.id_foco = $id and deleted = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function ActualizaFoco($aParam)
    {
        $sql  = "";
        $sql .= "UPDATE {$this->table} SET ";
        $sql .= "nombre            = '" . $aParam['nombre']."', ";
        $sql .= "descripcion       = '" . $aParam['descripcion']."', ";
        $sql .= "id_ano            = '" . $aParam['id_ano']."', ";
        $sql .= "id_pais           = '" . $aParam['id_pais']."', ";
        $sql .= "id_sede           = '" . $aParam['id_sede']."', ";
        $sql .= "obs               = '" . $aParam['obs']."', ";
        $sql .= "pasos             = '" . $aParam['pasos']."', ";
        $sql .= "id_updater        = '" . $_SESSION['Planificacion']['user_id']."', ";
        $sql .= "date_update       = NOW() ";
        $sql .= "WHERE id          = '" . $aParam['id']."'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
        $stmt->closeCursor();
        return $result;
    }
    
    public function RemoveIndicador($idIndicador, $idFoco)
    {
        $query .= "UPDATE dfoco SET ";
        $query .= "deleted = 1 ";
        $query .= "WHERE id_foco = $idFoco AND ";
        $query .= "id_indicador = $idIndicador ";
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }
    
    public function AddIndicador($indicador, $id, $ponderacion)
    {
        $sql  = "";
        $sql .= "INSERT INTO dfoco (";
        $sql .= "id, ";
        $sql .= "id_foco, ";
        $sql .= "id_indicador, ";
        $sql .= "ponderacion, ";
        $sql .= "id_creator, ";
        $sql .= "id_updater, ";
        $sql .= "date_insert, ";
        $sql .= "deleted) VALUES (";
        $sql .= " NULL, ";
        $sql .= "'". $id."', ";
        $sql .= "'". $indicador."', ";
        $sql .= "". $ponderacion.", ";
        $sql .= "'". $_SESSION['Planificacion']['user_id']."', ";
        $sql .= " 0, ";
        $sql .= " NOW(), ";
        $sql .= " 0)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $this->pdo->lastInsertId();
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
    
    public function selectAnos()
    {
        $sql  = "";
        $sql .= "SELECT  * FROM ano ";
        $sql .= "WHERE deleted = 0 and situation = 1 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function CarregaIndicadores()
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
        $sql .= "indicador.date_update ";
        $sql .= "FROM indicador ";
        $sql .= "INNER JOIN temporalidad ON temporalidad.id = indicador.id_temporalidad ";
        $sql .= "INNER JOIN tipo ON tipo.id = indicador.id_tipo ";
        $sql .= "INNER JOIN pilar ON pilar.id = indicador.id_pilar ";
        $sql .= "WHERE indicador.deleted = 0 AND indicador.id_pais = 0 and indicador.situation = 1";
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
}
