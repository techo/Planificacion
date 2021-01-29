<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class Gestion extends BaseModel
{
    protected $table = "dplanificacion";
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function Dados($aParam)
    {
        $sql   = "SELECT ";
        $sql  .= "id_indicador, ";
        $sql  .= "indicador, ";
        $sql  .= "pilar, ";
        $sql  .= "formato, ";
        $sql  .= "id_pais, ";
        $sql  .= "tipo, ";
        $sql  .= "@T1P := COALESCE(IF(tipo = 'Acumulado', (COALESCE(enero_plan,0) + COALESCE(febrero_plan,0) + COALESCE(marzo_plan,0)), COALESCE(IF(tipo = 'Ultimo', IF(marzo_plan > 0, marzo_plan,IF(febrero_plan > 0, febrero_plan, IF(enero_plan > 0, enero_plan, 0))),IF(tipo = 'Promedio', (COALESCE(enero_plan,0) + COALESCE(febrero_plan,0) + COALESCE(marzo_plan,0)) / 3,'-')))), 0) AS 'T1P', ";
        $sql  .= "@T1R := COALESCE(IF(tipo = 'Acumulado', (COALESCE(enero_real,0) + COALESCE(febrero_real,0) + COALESCE(marzo_real,0)), COALESCE(IF(tipo = 'Ultimo', IF(marzo_real > 0, marzo_real,IF(febrero_real > 0, febrero_real, IF(enero_real > 0, enero_real, 0))),IF(tipo = 'Promedio', (COALESCE(enero_real,0) + COALESCE(febrero_real,0) + COALESCE(marzo_real,0)) / 3,'-')))), 0) AS 'T1R', ";
        $sql  .= "@T1C := CONCAT(ROUND(COALESCE(IF(tipo = 'Acumulado', (COALESCE(enero_real,0) + COALESCE(febrero_real,0) + COALESCE(marzo_real,0)) / (COALESCE(enero_plan,0) + COALESCE(febrero_plan,0) + COALESCE(marzo_plan,0)) * 100, (@T1R / @T1P) * 100), 0),0),'%') AS 'T1C', ";
        $sql  .= "@T2P := COALESCE(IF(tipo = 'Acumulado', (COALESCE(abril_plan,0) + COALESCE(mayo_plan,0) + COALESCE(junio_plan,0)), COALESCE(IF(tipo = 'Ultimo', IF(junio_plan > 0, junio_plan,IF(mayo_plan > 0, mayo_plan, IF(abril_plan > 0, abril_plan, 0))),IF(tipo = 'Promedio', (COALESCE(abril_plan,0) + COALESCE(mayo_plan,0) + COALESCE(junio_plan,0)) / 3,'-')))), 0) AS 'T2P', ";
        $sql  .= "@T2R := COALESCE(IF(tipo = 'Acumulado', (COALESCE(abril_real,0) + COALESCE(mayo_real,0) + COALESCE(junio_real,0)), COALESCE(IF(tipo = 'Ultimo', IF(junio_real > 0, junio_real,IF(mayo_real > 0, mayo_real, IF(abril_real > 0, abril_real, 0))),IF(tipo = 'Promedio', (COALESCE(abril_real,0) + COALESCE(mayo_real,0) + COALESCE(junio_real,0)) / 3,'-')))), 0) AS 'T2R', ";
        $sql  .= "@T2C := CONCAT(ROUND(COALESCE(IF(tipo = 'Acumulado', (COALESCE(abril_real,0) + COALESCE(mayo_real,0) + COALESCE(junio_real,0)) / (COALESCE(abril_plan,0) + COALESCE(mayo_plan,0) + COALESCE(junio_plan,0)) * 100, (@T2R / @T2P) * 100), 0),0),'%') AS 'T2C', ";
        $sql  .= "@T3P := COALESCE(IF(tipo = 'Acumulado', (COALESCE(julio_plan,0) + COALESCE(agosto_plan,0) + COALESCE(septiembre_plan,0)), COALESCE(IF(tipo = 'Ultimo', IF(septiembre_plan > 0, septiembre_plan,IF(agosto_plan > 0, agosto_plan, IF(julio_plan > 0, julio_plan, 0))),IF(tipo = 'Promedio', (COALESCE(julio_plan,0) + COALESCE(agosto_plan,0) + COALESCE(septiembre_plan,0)) / 3,'-')))), 0) AS 'T3P', ";
        $sql  .= "@T3R := COALESCE(IF(tipo = 'Acumulado', (COALESCE(julio_real,0) + COALESCE(agosto_real,0) + COALESCE(septiembre_real,0)), COALESCE(IF(tipo = 'Ultimo', IF(septiembre_real > 0, septiembre_real,IF(agosto_real > 0, agosto_real, IF(julio_real > 0, julio_real, 0))),IF(tipo = 'Promedio', (COALESCE(julio_real,0) + COALESCE(agosto_real,0) + COALESCE(septiembre_real,0)) / 3,'-')))), 0) AS 'T3R', ";
        $sql  .= "@T3C := CONCAT(ROUND(COALESCE(IF(tipo = 'Acumulado', (COALESCE(julio_real,0) + COALESCE(agosto_real,0) + COALESCE(septiembre_real,0)) / (COALESCE(julio_plan,0) + COALESCE(agosto_plan,0) + COALESCE(septiembre_plan,0)) * 100, (@T3R / @T3P) * 100), 0),0),'%') AS 'T3C', ";
        $sql  .= "@T4P := COALESCE(IF(tipo = 'Acumulado', (COALESCE(octubre_plan,0) + COALESCE(noviembre_plan,0) + COALESCE(diciembre_plan,0)), COALESCE(IF(tipo = 'Ultimo', IF(diciembre_plan > 0, diciembre_plan,IF(noviembre_plan > 0, noviembre_plan, IF(octubre_plan > 0, octubre_plan, 0))),IF(tipo = 'Promedio', (COALESCE(octubre_plan,0) + COALESCE(noviembre_plan,0) + COALESCE(diciembre_plan,0)) / 3,'-')))), 0) AS 'T4P', ";
        $sql  .= "@T4R := COALESCE(IF(tipo = 'Acumulado', (COALESCE(octubre_real,0) + COALESCE(noviembre_real,0) + COALESCE(diciembre_real,0)), COALESCE(IF(tipo = 'Ultimo', IF(diciembre_real > 0, diciembre_real,IF(noviembre_real > 0, noviembre_real, IF(octubre_real > 0, octubre_real, 0))),IF(tipo = 'Promedio', (COALESCE(octubre_real,0) + COALESCE(noviembre_real,0) + COALESCE(diciembre_real,0)) / 3,'-')))), 0) AS 'T4R', ";
        $sql  .= "@T4C := CONCAT(ROUND(COALESCE(IF(tipo = 'Acumulado', (COALESCE(octubre_real,0) + COALESCE(noviembre_real,0) + COALESCE(diciembre_real,0)) / (COALESCE(octubre_plan,0) + COALESCE(noviembre_plan,0) + COALESCE(diciembre_plan,0)) * 100, (@T4R / @T4P) * 100), 0),0),'%') AS 'T4C', ";
        $sql  .= "@AnualP := COALESCE(IF(tipo = 'Acumulado', (COALESCE(enero_plan,0) + COALESCE(febrero_plan,0) + COALESCE(marzo_plan,0) + COALESCE(abril_plan,0) + COALESCE(mayo_plan,0) + COALESCE(junio_plan,0) + COALESCE(julio_plan,0) + COALESCE(agosto_plan,0) + COALESCE(septiembre_plan,0) + COALESCE(octubre_plan,0) + COALESCE(noviembre_plan,0) + COALESCE(diciembre_plan,0)), COALESCE(IF(tipo = 'Ultimo', IF(diciembre_plan > 0, diciembre_plan,IF(noviembre_plan > 0, noviembre_plan, IF(octubre_plan > 0, octubre_plan, IF(septiembre_plan > 0, septiembre_plan, IF(agosto_plan > 0, agosto_plan, IF(julio_plan > 0, julio_plan, IF(junio_plan > 0, junio_plan, IF(mayo_plan > 0, mayo_plan, IF(abril_plan > 0, abril_plan, IF(marzo_plan > 0, marzo_plan, IF(febrero_plan > 0, febrero_plan, IF(enero_plan > 0, enero_plan, 0)))))))))))),IF(tipo = 'Promedio', (COALESCE(enero_plan,0) + COALESCE(febrero_plan,0) + COALESCE(marzo_plan,0) + COALESCE(abril_plan,0) + COALESCE(mayo_plan,0) + COALESCE(junio_plan,0) + COALESCE(julio_plan,0) + COALESCE(agosto_plan,0) + COALESCE(septiembre_plan,0) + COALESCE(octubre_plan,0) + COALESCE(noviembre_plan,0) + COALESCE(diciembre_plan,0)) / 12,'-')))), 0) AS 'AnualP', ";
        $sql  .= "@AnualR := COALESCE(IF(tipo = 'Acumulado', (COALESCE(enero_real,0) + COALESCE(febrero_real,0) + COALESCE(marzo_real,0) + COALESCE(abril_real,0) + COALESCE(mayo_real,0) + COALESCE(junio_real,0) + COALESCE(julio_real,0) + COALESCE(agosto_real,0) + COALESCE(septiembre_real,0) + COALESCE(octubre_real,0) + COALESCE(noviembre_real,0) + COALESCE(diciembre_real,0)), COALESCE(IF(tipo = 'Ultimo', IF(diciembre_real > 0, diciembre_real,IF(noviembre_real > 0, noviembre_real, IF(octubre_real > 0, octubre_real, IF(septiembre_real > 0, septiembre_real, IF(agosto_real > 0, agosto_real, IF(julio_real > 0, julio_real, IF(junio_real > 0, junio_real, IF(mayo_real > 0, mayo_real, IF(abril_real > 0, abril_real, IF(marzo_real > 0, marzo_real, IF(febrero_real > 0, febrero_real, IF(enero_real > 0, enero_real, 0)))))))))))),IF(tipo = 'Promedio', (COALESCE(enero_real,0) + COALESCE(febrero_real,0) + COALESCE(marzo_real,0) + COALESCE(abril_real,0) + COALESCE(mayo_real,0) + COALESCE(junio_real,0) + COALESCE(julio_real,0) + COALESCE(agosto_real,0) + COALESCE(septiembre_real,0) + COALESCE(octubre_real,0) + COALESCE(noviembre_real,0) + COALESCE(diciembre_real,0)) / 12,'-')))), 0) AS 'AnualR', ";
        $sql  .= "@AnualC := CONCAT(ROUND(COALESCE(IF(tipo = 'Acumulado', ((@AnualR / @AnualP) * 100), (@AnualR / @AnualP) * 100), 0),0),'%') AS 'AnualC', ";
        $sql  .= "enero_plan, ";
        $sql  .= "enero_real, ";
        $sql  .= "febrero_plan, ";
        $sql  .= "febrero_real, ";
        $sql  .= "marzo_plan, ";
        $sql  .= "marzo_real, ";
        $sql  .= "abril_plan, ";
        $sql  .= "abril_real, ";
        $sql  .= "mayo_plan, ";
        $sql  .= "mayo_real, ";
        $sql  .= "junio_plan, ";
        $sql  .= "junio_real, ";
        $sql  .= "julio_plan, ";
        $sql  .= "julio_real, ";
        $sql  .= "agosto_plan, ";
        $sql  .= "agosto_real, ";
        $sql  .= "septiembre_plan, ";
        $sql  .= "septiembre_real, ";
        $sql  .= "octubre_plan, ";
        $sql  .= "octubre_real, ";
        $sql  .= "noviembre_plan, ";
        $sql  .= "noviembre_real, ";
        $sql  .= "diciembre_plan, ";
        $sql  .= "diciembre_real ";
        $sql  .= "FROM ";
        $sql  .= "(SELECT ";
        $sql  .= "dplanificacion.id, ";
        $sql  .= "dplanificacion.id_pais, ";
        $sql  .= "dplanificacion.id_sede, ";
        $sql  .= "dplanificacion.id_indicador, ";
        $sql  .= "pilar.pilar, ";
        $sql  .= "SUM(dplanificacion.enero_plan) AS enero_plan, ";
        $sql  .= "SUM(dplanificacion.enero_real) AS enero_real, ";
        $sql  .= "SUM(dplanificacion.febrero_plan) AS febrero_plan, ";
        $sql  .= "SUM(dplanificacion.febrero_real) AS febrero_real, ";
        $sql  .= "SUM(dplanificacion.marzo_plan) AS marzo_plan, ";
        $sql  .= "SUM(dplanificacion.marzo_real) AS marzo_real, ";
        $sql  .= "SUM(dplanificacion.abril_plan) AS abril_plan, ";
        $sql  .= "SUM(dplanificacion.abril_real) AS abril_real, ";
        $sql  .= "SUM(dplanificacion.mayo_plan) AS mayo_plan, ";
        $sql  .= "SUM(dplanificacion.mayo_real) AS mayo_real, ";
        $sql  .= "SUM(dplanificacion.junio_plan) AS junio_plan, ";
        $sql  .= "SUM(dplanificacion.junio_real) AS junio_real, ";
        $sql  .= "SUM(dplanificacion.julio_plan) AS julio_plan, ";
        $sql  .= "SUM(dplanificacion.julio_real) AS julio_real, ";
        $sql  .= "SUM(dplanificacion.agosto_plan) AS agosto_plan, ";
        $sql  .= "SUM(dplanificacion.agosto_real) AS agosto_real, ";
        $sql  .= "SUM(dplanificacion.septiembre_plan) AS septiembre_plan, ";
        $sql  .= "SUM(dplanificacion.septiembre_real) AS septiembre_real, ";
        $sql  .= "SUM(dplanificacion.octubre_plan) AS octubre_plan, ";
        $sql  .= "SUM(dplanificacion.octubre_real) AS octubre_real, ";
        $sql  .= "SUM(dplanificacion.noviembre_plan) AS noviembre_plan, ";
        $sql  .= "SUM(dplanificacion.noviembre_real) AS noviembre_real, ";
        $sql  .= "SUM(dplanificacion.diciembre_plan) AS diciembre_plan, ";
        $sql  .= "SUM(dplanificacion.diciembre_real) AS diciembre_real, ";
        $sql  .= "indicador.indicador, ";
        $sql  .= "indicador.formato, ";
        $sql  .= "tipo.tipo ";
        $sql  .= "FROM dplanificacion ";
        $sql  .= "INNER JOIN indicador ON indicador.id = dplanificacion.id_indicador ";
        $sql  .= "INNER JOIN tipo ON indicador.id_tipo = tipo.id ";
        $sql  .= "INNER JOIN pilar ON pilar.id = indicador.id_pilar ";
        $sql  .= "WHERE dplanificacion.id_cplanificacion = {$aParam['idCPlanificacion']} ";
        
        if($aParam['visual'] == 'Pais' || $aParam['visual'] == 'Sede')
        {
            $sql  .= " AND dplanificacion.id_pais = {$aParam['idPais']} ";
        }
        
        if($aParam['visual'] == 'Sede')
        {
            $sql  .= " AND dplanificacion.id_sede = {$aParam['idSede']} ";
        }
        
        if($aParam['visual'] == 'Region')
        {
            $sql  .= " AND dplanificacion.id_pais IN ({$aParam['idPaises']}) ";
        }
        
        if($aParam['visual'] == 'Latam')
        {
            $sql  .= " AND dplanificacion.id_pais IN ({$aParam['idPaises']}) ";
        }
        
        $sql  .= " AND dplanificacion.id_indicador IN (5, 6, 9, 85, 271, 83, 7, 74, 268, 11, 59, 60, 12, 16, 17, 23, 15, 20, 22, 42) ";
        $sql  .= "GROUP BY dplanificacion.id_indicador) soma ";
        $sql  .= "GROUP BY id_indicador COLLATE utf8_unicode_ci";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }
}
