<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class Proyecto extends BaseModel
{
    protected $table = "proyecto";
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
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
    
    public function Listagem($idPlanificacion, $idSede, $idPais = 0)
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "indicador.id, ";
        $sql .= "indicador.indicador, ";
        $sql .= "indicador.id_pilar, ";
        $sql .= "indicador.id_temporalidad, ";
        $sql .= "temporalidad.temporalidad, ";
        $sql .= "tipo.tipo, ";
        $sql .= "indicador.formato, ";
        $sql .= "indicador.id_area ";
        $sql .= " FROM dplanificacion ";
        $sql .= "INNER JOIN indicador indicador ON indicador.id = dplanificacion.id_indicador ";
        $sql .= "LEFT JOIN tipo ON tipo.id = indicador.id_tipo ";
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
    
    public function BuscaAno($idPlanificacion)
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "cplanificacion.id,";
        $sql .= "cplanificacion.id_ano, ";
        $sql .= "ano.ano ";
        $sql .= " FROM cplanificacion ";
        $sql .= " INNER JOIN ano ON ano.id = cplanificacion.id_ano ";
        $sql .= "WHERE cplanificacion.deleted = 0 AND cplanificacion.situation = 1 AND cplanificacion.id = " . $idPlanificacion;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();
        return $result;
    }
    
    public function GrabarProyecto($aParam)
    {
        $sql  = "";
        $sql .= "INSERT INTO {$this->table} (";
        $sql .= "id, ";
        $sql .= "proyecto, ";
        $sql .= "responsable, ";
        $sql .= "id_ano, ";
        $sql .= "id_pais, ";
        $sql .= "id_sede, ";
        $sql .= "id_cplanificacion, ";
        $sql .= "id_indicador_1, ";
        $sql .= "ponderacion_1, ";
        $sql .= "id_indicador_2, ";
        $sql .= "ponderacion_2, ";
        $sql .= "id_indicador_3, ";
        $sql .= "ponderacion_3, ";
        $sql .= "id_indicador_4, ";
        $sql .= "ponderacion_4, ";
        $sql .= "id_indicador_5, ";
        $sql .= "ponderacion_5, ";
        $sql .= "id_indicador_6, ";
        $sql .= "ponderacion_6, ";
        $sql .= "id_indicador_7, ";
        $sql .= "ponderacion_7, ";
        $sql .= "id_indicador_8, ";
        $sql .= "ponderacion_8, ";
        $sql .= "id_indicador_9, ";
        $sql .= "ponderacion_9, ";
        $sql .= "id_indicador_10, ";
        $sql .= "ponderacion_10, ";
        $sql .= "id_creator, ";
        $sql .= "id_updater, ";
        $sql .= "date_insert, ";
        $sql .= "date_update, ";
        $sql .= "deleted) VALUES (";
        $sql .= " NULL, ";
        $sql .= "'". $aParam[0]['proyecto']."', ";
        $sql .= "'". $aParam[0]['responsable']."', ";
        $sql .= "'". $aParam['ano']."', ";
        $sql .= "'". $aParam[0]['pais']."', ";
        $sql .= "'". $aParam[0]['sede']."', ";
        $sql .= "'". $aParam[0]['planificacion']."', ";
        $sql .= "'". $aParam[0]['indicador']."', ";
        $sql .= "'". $aParam[0]['ponderacion']."', ";
        $sql .= "". ($aParam[1]['indicador']    ? $aParam[1]['indicador']   : 'NULL') .", ";
        $sql .= "". ($aParam[1]['ponderacion']  ? $aParam[1]['ponderacion'] : 'NULL') .", ";
        $sql .= "". ($aParam[2]['indicador']    ? $aParam[2]['indicador']   : 'NULL') .", ";
        $sql .= "". ($aParam[2]['ponderacion']  ? $aParam[2]['ponderacion'] : 'NULL') .", ";
        $sql .= "". ($aParam[3]['indicador']    ? $aParam[3]['indicador']   : 'NULL') .", ";
        $sql .= "". ($aParam[3]['ponderacion']  ? $aParam[3]['ponderacion'] : 'NULL') .", ";
        $sql .= "". ($aParam[4]['indicador']    ? $aParam[4]['indicador']   : 'NULL') .", ";
        $sql .= "". ($aParam[4]['ponderacion']  ? $aParam[4]['ponderacion'] : 'NULL') .", ";
        $sql .= "". ($aParam[5]['indicador']    ? $aParam[5]['indicador']   : 'NULL') .", ";
        $sql .= "". ($aParam[5]['ponderacion']  ? $aParam[5]['ponderacion'] : 'NULL') .", ";
        $sql .= "". ($aParam[6]['indicador']    ? $aParam[6]['indicador']   : 'NULL') .", ";
        $sql .= "". ($aParam[6]['ponderacion']  ? $aParam[6]['ponderacion'] : 'NULL') .", ";
        $sql .= "". ($aParam[7]['indicador']    ? $aParam[7]['indicador']   : 'NULL') .", ";
        $sql .= "". ($aParam[7]['ponderacion']  ? $aParam[7]['ponderacion'] : 'NULL') .", ";
        $sql .= "". ($aParam[8]['indicador']    ? $aParam[8]['indicador']   : 'NULL') .", ";
        $sql .= "". ($aParam[8]['ponderacion']  ? $aParam[8]['ponderacion'] : 'NULL') .", ";
        $sql .= "". ($aParam[9]['indicador']    ? $aParam[9]['indicador']   : 'NULL') .", ";
        $sql .= "". ($aParam[9]['ponderacion']  ? $aParam[9]['ponderacion'] : 'NULL') .", ";
        $sql .= "'". $_SESSION['Planificacion']['user_id']."', ";
        $sql .= " 0, ";
        $sql .= " NOW(), ";
        $sql .= " '0000-00-00 00:00:00', ";
        $sql .= " 0)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
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
