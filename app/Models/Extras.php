<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class Extras extends BaseModel
{
    protected $table = "indicador";
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function select()
    {
        
        $sql  = "SELECT * FROM indicador WHERE id_pais = " . $_SESSION['Planificacion']['pais_id'] . " AND deleted = 0 AND situation = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function BuscaIndicadores($aParam)
    {
        $sql  = "SELECT * FROM indicador WHERE id_pais = " . $aParam['pais'] . " AND id_sede IN (0,".$aParam['sede'].") AND deleted = 0 AND situation = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
    
    public function InsertIndicadores($aParam)
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
        $sql .= "'". $aParam['cplanificacion']."', ";
        $sql .= "'". $aParam['indicador']."', ";
        $sql .= "'". $aParam['pais']."', ";
        $sql .= "'". $aParam['sede']."', ";
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
        $sql .= " NOW(), ";
        $sql .= " 1, ";
        $sql .= " 0)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $this->pdo->lastInsertId();
        $stmt->closeCursor();
        
        //Regasta info do campo para acrecentar valor
        $sql  = "SELECT addplanificacion FROM indicador WHERE id = " . $aParam['indicador'];
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $indicador = (array) $stmt->fetch();
        $stmt->closeCursor();
        
        // Depois de inserir na planificacao, inseri a sede no campo addplanificacion na tabela de indicadores para nao listar mais na tela de indicadores extras
        $sql  = "";
        $sql .= "UPDATE indicador SET ";
        $sql .= "addplanificacion = '".$indicador['addplanificacion']."[" . $aParam['sede']."],' ";
        $sql .= "WHERE id = '" . $aParam['indicador']."'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
        $stmt->closeCursor();
        
        return $result;
    }
   
}
