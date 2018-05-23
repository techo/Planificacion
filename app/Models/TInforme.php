<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class TInforme extends BaseModel
{
    protected $table = "ano";
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function ListAnos()
    {
        $sql  = "";
        $sql .= "SELECT ";
        $sql .= "cplanificacion.id,";
        $sql .= "cplanificacion.id_ano, ";
        $sql .= "ano.ano, ";
        $sql .= "cplanificacion.situation, ";
        $sql .= "cplanificacion.id_creator, ";
        $sql .= "cplanificacion.id_updater, ";
        $sql .= "cplanificacion.date_insert, ";
        $sql .= "cplanificacion.date_update ";
        $sql .= " FROM cplanificacion";
        $sql .= " INNER JOIN ano ON ano.id = cplanificacion.id_ano ";
        $sql .= "WHERE cplanificacion.deleted = 0 and cplanificacion.situation = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaPaises($idplanificacion)
    {
        $sql  = "";
        $sql .= "SELECT * ";
        $sql .= " FROM dplanificacion ";
        $sql .= "WHERE dplanificacion.situation = 1 and id_cplanificacion = ". $idplanificacion;
        if($_SESSION['Planificacion']['pais_id'] != 5)
        {
            $sql  .= " and dplanificacion.id_pais = ". $_SESSION['Planificacion']['pais_id'];
        }
        $sql  .= " GROUP BY id_pais";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaSedes($idplanificacion, $idpais)
    {
        $sql  = "";
        $sql .= "SELECT * ";
        $sql .= " FROM dplanificacion ";
        $sql .= "WHERE dplanificacion.situation = 1 and id_cplanificacion = ". $idplanificacion . " and dplanificacion.id_pais = " . $idpais." GROUP BY id_sede";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaIndicadores($idplanificacion, $idpais, $idsede)
    {
        $sql  = "";
        $sql .= "SELECT  ";
        $sql .= "dplanificacion.id,  ";
        $sql .= "dplanificacion.id_indicador,  ";
        $sql .= "indicador.indicador  ";
        $sql .= " FROM dplanificacion ";
        $sql .= " INNER JOIN indicador on indicador.id = dplanificacion.id_indicador ";
        $sql .= "WHERE dplanificacion.situation = 1 and id_cplanificacion = ". $idplanificacion . " and dplanificacion.id_pais = " . $idpais."  and dplanificacion.id_sede = ". $idsede;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    // 3 Querys Iguais para caso necessite uma modificacao expecifica em cada relatorio
    public function BuscaTrimestre($idplanificacion, $idpais, $idsede, $idIndicador)
    {
        $sql  = "";
        $sql .= "SELECT  ";
        $sql .= "dplanificacion.*,  ";
        $sql .= "indicador.indicador  ";
        $sql .= " FROM dplanificacion ";
        $sql .= " INNER JOIN indicador on indicador.id = dplanificacion.id_indicador ";
        $sql .= "WHERE dplanificacion.situation = 1 and id_cplanificacion = ". $idplanificacion . " and dplanificacion.id_pais = " . $idpais."  and dplanificacion.id_sede = ". $idsede . " and id_indicador =" . $idIndicador;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaMensual($idplanificacion, $idpais, $idsede, $idIndicador)
    {
        $sql  = "";
        $sql .= "SELECT  ";
        $sql .= "dplanificacion.*,  ";
        $sql .= "indicador.indicador  ";
        $sql .= " FROM dplanificacion ";
        $sql .= " INNER JOIN indicador on indicador.id = dplanificacion.id_indicador ";
        $sql .= "WHERE dplanificacion.situation = 1 and id_cplanificacion = ". $idplanificacion . " and dplanificacion.id_pais = " . $idpais."  and dplanificacion.id_sede = ". $idsede . " and id_indicador =" . $idIndicador;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaAnual($idplanificacion, $idpais, $idsede, $idIndicador)
    {
        $sql  = "";
        $sql .= "SELECT  ";
        $sql .= "dplanificacion.*,  ";
        $sql .= "indicador.indicador  ";
        $sql .= " FROM dplanificacion ";
        $sql .= " INNER JOIN indicador on indicador.id = dplanificacion.id_indicador ";
        $sql .= "WHERE dplanificacion.situation = 1 and id_cplanificacion = ". $idplanificacion . " and dplanificacion.id_pais = " . $idpais."  and dplanificacion.id_sede = ". $idsede . " and id_indicador =" . $idIndicador;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaMonitoreo($idplanificacion, $idpais, $idsede)
    {
        $sql  = "";
        $sql .= "SELECT  ";
        $sql .= "dplanificacion.*,  ";
        $sql .= "indicador.indicador  ";
        $sql .= " FROM dplanificacion ";
        $sql .= " INNER JOIN indicador on indicador.id = dplanificacion.id_indicador ";
        $sql .= "WHERE dplanificacion.situation = 1 and id_cplanificacion = ". $idplanificacion . " and dplanificacion.id_pais = " . $idpais."  and dplanificacion.id_sede = ". $idsede;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
}
