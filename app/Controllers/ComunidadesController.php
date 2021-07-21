<?php 
namespace App\Controllers;

use Core\Container;

class ComunidadesController
{
//     public function __construct()
//     {
//         echo('<pre>');
//         die(print_r('Hello World', true));
//     }
    
    public function UpdateComunidades()
    {
        $aReturn = array();
        
        $model = Container::getModel("Gambis");
        
        $aRet = $model->GetAno($_GET['ano']);
        
        $ano = $aRet[0]->id;
        
        $idCplanificacion = $model->GetPlanificacion($ano);
        
        $aParam['indicador'] = $_GET['indicador'];
        $aParam['pais']      = $_GET['pais'];
        $aParam['sede']      = $_GET['sede'];
        $aParam['valor']     = $_GET['valor'];
        $aParam['columna']   = $_GET['columna'];
        $aParam['ano']       = $idCplanificacion[0]->id;
        
        $aDados = $model->DataUpdate($aParam);
        
        try 
        {
            $aReturn['success']  = true;
            $aReturn['message'] = 'Registro Actualizado con Exito';
            $aReturn['false'] = false;
        }
        catch (Exception $e) 
        {
            $aReturn['success']  = false;
            $aReturn['message'] = $e->getMessage();
            $aReturn['false'] = true;
        }
        
        echo('<pre>');
        die(print_r($aReturn, true));
    }
}