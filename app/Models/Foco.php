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
    
    public function select()
    {
        $sql  = "";
        $sql .= "SELECT  foco.*,  CASE
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
        $sql .= "WHERE deleted = 0 ";
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
        $sql .= "WHERE deleted = 0 ";
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
}
