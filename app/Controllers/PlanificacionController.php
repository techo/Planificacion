<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class PlanificacionController extends BaseController
{
    public function __construct()
    {
        session_start();
        
        if(!isset($_SESSION['Planificacion']['token']))
        {
            header('Location: http://login.techo.org/');
        }
    }
    
    public function index()
    {
        $this->setPageTitle('Planificaci&oacute;n');
        $model = Container::getModel("CPlanificacion");
        //Busca Anos
        $this->view->ano = $model->ListaAno();

        $cPlanificacion = $model->searchAnoPlanificacion(3); // Aletrar ID da planificacao correta
        
        $aPlanificacion = (array) $cPlanificacion[0];
        $id = $aPlanificacion['id'];
        
        $Planificacion = $model->KpisRegistro($id);
        
        
        for($i=0; $i < count($Planificacion); $i++)
        {
            $aDado = (array) $Planificacion[$i];
            
            $aXML[$i]['id']        = $aDado['id'];
            $aXML[$i]['indicador']  = $aDado['indicador'];
            $aXML[$i]['enero_plan'] = $aDado['enero_plan'];
            $aXML[$i]['enero_real'] = $aDado['enero_real'];
            $aXML[$i]['febrero_plan'] = $aDado['febrero_plan'];
            $aXML[$i]['febrero_real'] = $aDado['febrero_real'];
            $aXML[$i]['marzo_plan'] = $aDado['marzo_plan'];
            $aXML[$i]['marzo_real'] = $aDado['marzo_real'];
            $aXML[$i]['abril_plan'] = $aDado['abril_plan'];
            $aXML[$i]['abril_real'] = $aDado['abril_real'];
            $aXML[$i]['mayo_plan'] = $aDado['mayo_plan'];
            $aXML[$i]['mayo_real'] = $aDado['mayo_real'];
            $aXML[$i]['junio_plan'] = $aDado['junio_plan'];
            $aXML[$i]['junio_real'] = $aDado['junio_real'];
            $aXML[$i]['julio_plan'] = $aDado['julio_plan'];
            $aXML[$i]['julio_real'] = $aDado['julio_real'];
            $aXML[$i]['agosto_plan'] = $aDado['agosto_plan'];
            $aXML[$i]['agosto_real'] = $aDado['agosto_real'];
            $aXML[$i]['septiembre_plan'] = $aDado['septiembre_plan'];
            $aXML[$i]['septiembre_real'] = $aDado['septiembre_real'];
            $aXML[$i]['octubre_plan'] = $aDado['octubre_plan'];
            $aXML[$i]['octubre_real'] = $aDado['octubre_real'];
            $aXML[$i]['noviembre_plan'] = $aDado['noviembre_plan'];
            $aXML[$i]['noviembre_real'] = $aDado['noviembre_real'];
            $aXML[$i]['diciembre_plan'] = $aDado['diciembre_plan'];
            $aXML[$i]['diciembre_real'] = $aDado['diciembre_real'];
            
        }
        
        echo('<pre>');
        die(print_r($aXML, true));
        
        
        /* Render View Planificacion */
        $this->renderView('planificacion/index', 'layout');
    }
}