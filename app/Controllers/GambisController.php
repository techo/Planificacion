<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class GambisController extends BaseController
{
    public function __construct()
    {
        header('Content-Type: application/json; charset=utf-8');
        session_start();
    }
    
    public function index()
    {
        $this->setPageTitle('Gambis');
        $model = Container::getModel("Gambis");
        $aIndicador = $model->select();

        for($i=0; $i < count($aIndicador); $i++)
        {
            $aDados['id_sede'] = 82;
            $aDados['id_pais'] = 17;
            $aDados['id_cplanificacion'] = 11; // Modificar em produção
            $aDados['indicador']  = $aIndicador[$i]->id;
            $aDados['id_creador'] = 1;
            $aDados['id_updater'] = 0;
            $aDados['situation']  = 1;
            $aDados['deleted']    = 0;
            
            $aRet = $model->Inserir($aDados);
            
        }
        
        /* Render View Paises */
        $this->renderView('gambis/index', 'layout');
    }
    
    public function api($request)
    {
        $aRequest = (array) $request;
        
        $_SESSION['Planificacion']['token']   = '7c9b5c9b9baae1227deb96f1c51a7b61';
        
        if($aRequest['api'] === 'true'&& $aRequest['method'] == 'GET')
        {
            $this->setPageTitle('API');
            $model = Container::getModel("Gambis");
            
            //Agarra el ano corriente para buscar id de la planificacion actual
            $ano = date("Y");
            
            $aRet = $model->GetAno($ano);
            $id = $aRet[0]->id;
            
            //Agarra id cPlanificacion
            $aPlan = $model->GetPlanificacion($id);
            
            $aDados = $model->api($aPlan[0]->id);
            
            for($i=0; $i < count($aDados); $i++)
            {
                $linha = (array) $aDados[$i];
                
                //Enero
                $aNew[$i.'01']['id']         = $linha['id_indicador'];
                $aNew[$i.'01']['name']       = $linha['indicador'];
				$aNew[$i.'01']['tipo']       = $linha['tipo'];
                $aNew[$i.'01']['month']      = '1';
                $aNew[$i.'01']['value_plan'] = $linha['enero_plan'];
                $aNew[$i.'01']['value_real'] = $linha['enero_real'];
                $aNew[$i.'01']['pais']       = $linha['id_pais'];
                $aNew[$i.'01']['sede']       = $linha['id_sede'];
                //Febrero
                $aNew[$i.'02']['id']           = $linha['id_indicador'];
                $aNew[$i.'02']['name']         = $linha['indicador'];
				$aNew[$i.'02']['tipo']         = $linha['tipo'];
                $aNew[$i.'02']['month']        = '2';
                $aNew[$i.'02']['value_plan']   = $linha['febrero_plan'];
                $aNew[$i.'02']['value_real']   = $linha['febrero_real'];
                $aNew[$i.'02']['pais']         = $linha['id_pais'];
                $aNew[$i.'02']['sede']         = $linha['id_sede'];
                //Marzo
                $aNew[$i.'03']['id']           = $linha['id_indicador'];
                $aNew[$i.'03']['name']         = $linha['indicador'];
				$aNew[$i.'03']['tipo']         = $linha['tipo'];
                $aNew[$i.'03']['month']        = '3';
                $aNew[$i.'03']['value_plan']   = $linha['marzo_plan'];
                $aNew[$i.'03']['value_real']   = $linha['marzo_real'];
                $aNew[$i.'03']['pais']         = $linha['id_pais'];
                $aNew[$i.'03']['sede']         = $linha['id_sede'];
                //Abril
                $aNew[$i.'04']['id']           = $linha['id_indicador'];
                $aNew[$i.'04']['name']         = $linha['indicador'];
				$aNew[$i.'04']['tipo']         = $linha['tipo'];
                $aNew[$i.'04']['month']        = '4';
                $aNew[$i.'04']['value_plan']   = $linha['abril_plan'];
                $aNew[$i.'04']['value_real']   = $linha['abril_real'];
                $aNew[$i.'04']['pais']         = $linha['id_pais'];
                $aNew[$i.'04']['sede']         = $linha['id_sede'];
                //Mayo
                $aNew[$i.'05']['id']           = $linha['id_indicador'];
                $aNew[$i.'05']['name']         = $linha['indicador'];
				$aNew[$i.'05']['tipo']         = $linha['tipo'];
                $aNew[$i.'05']['month']        = '5';
                $aNew[$i.'05']['value_plan']   = $linha['mayo_plan'];
                $aNew[$i.'05']['value_real']   = $linha['mayo_real'];
                $aNew[$i.'05']['pais']         = $linha['id_pais'];
                $aNew[$i.'05']['sede']         = $linha['id_sede'];
                //Junio
                $aNew[$i.'06']['id']           = $linha['id_indicador'];
                $aNew[$i.'06']['name']         = $linha['indicador'];
				$aNew[$i.'06']['tipo']         = $linha['tipo'];
                $aNew[$i.'06']['month']        = '6';
                $aNew[$i.'06']['value_plan']   = $linha['junio_plan'];
                $aNew[$i.'06']['value_real']   = $linha['junio_real'];
                $aNew[$i.'06']['pais']         = $linha['id_pais'];
                $aNew[$i.'06']['sede']         = $linha['id_sede'];
                //Julio
                $aNew[$i.'07']['id']           = $linha['id_indicador'];
                $aNew[$i.'07']['name']         = $linha['indicador'];
				$aNew[$i.'07']['tipo']         = $linha['tipo'];
                $aNew[$i.'07']['month']        = '7';
                $aNew[$i.'07']['value_plan']   = $linha['julio_plan'];
                $aNew[$i.'07']['value_real']   = $linha['julio_real'];
                $aNew[$i.'07']['pais']         = $linha['id_pais'];
                $aNew[$i.'07']['sede']         = $linha['id_sede'];
                //Agosto
                $aNew[$i.'08']['id']           = $linha['id_indicador'];
                $aNew[$i.'08']['name']         = $linha['indicador'];
				$aNew[$i.'08']['tipo']         = $linha['tipo'];
                $aNew[$i.'08']['month']        = '8';
                $aNew[$i.'08']['value_plan']   = $linha['agosto_plan'];
                $aNew[$i.'08']['value_real']   = $linha['agosto_real'];
                $aNew[$i.'08']['pais']         = $linha['id_pais'];
                $aNew[$i.'08']['sede']         = $linha['id_sede'];
                //Septiembre
                $aNew[$i.'09']['id']           = $linha['id_indicador'];
                $aNew[$i.'09']['name']         = $linha['indicador'];
				$aNew[$i.'09']['tipo']         = $linha['tipo'];
                $aNew[$i.'09']['month']        = '9';
                $aNew[$i.'09']['value_plan']   = $linha['septiembre_plan'];
                $aNew[$i.'09']['value_real']   = $linha['septiembre_real'];
                $aNew[$i.'09']['pais']         = $linha['id_pais'];
                $aNew[$i.'09']['sede']         = $linha['id_sede'];
                //Octubre
                $aNew[$i.'10']['id']           = $linha['id_indicador'];
                $aNew[$i.'10']['name']         = $linha['indicador'];
				$aNew[$i.'10']['tipo']         = $linha['tipo'];
                $aNew[$i.'10']['month']        = '10';
                $aNew[$i.'10']['value_plan']   = $linha['octubre_plan'];
                $aNew[$i.'10']['value_real']   = $linha['octubre_real'];
                $aNew[$i.'10']['pais']         = $linha['id_pais'];
                $aNew[$i.'10']['sede']         = $linha['id_sede'];
                //Noviembre
                $aNew[$i.'11']['id']           = $linha['id_indicador'];
                $aNew[$i.'11']['name']         = $linha['indicador'];
				$aNew[$i.'11']['tipo']         = $linha['tipo'];
                $aNew[$i.'11']['month']        = '11';
                $aNew[$i.'11']['value_plan']   = $linha['noviembre_plan'];
                $aNew[$i.'11']['value_real']   = $linha['noviembre_real'];
                $aNew[$i.'11']['pais']         = $linha['id_pais'];
                $aNew[$i.'11']['sede']         = $linha['id_sede'];
                //Diciembre
                $aNew[$i.'12']['id']           = $linha['id_indicador'];
                $aNew[$i.'12']['name']         = $linha['indicador'];
				$aNew[$i.'12']['tipo']         = $linha['tipo'];
                $aNew[$i.'12']['month']        = '12';
                $aNew[$i.'12']['value_plan']   = $linha['diciembre_plan'];
                $aNew[$i.'12']['value_real']   = $linha['diciembre_real'];
                $aNew[$i.'12']['pais']         = $linha['id_pais'];
                $aNew[$i.'12']['sede']         = $linha['id_sede'];
                
            }
            
            echo(json_encode($aNew));
        }
    }
    
    # http://planificacion.techo.org/api/valores
    public function valores($request)
    {
        
        $aRequest = (array) $request;
        
        $_SESSION['Planificacion']['token']   = '7c9b5c9b9baae1227deb96f1c51a7b61';
        
        $this->setPageTitle('API');
        $model = Container::getModel("Gambis");
        
        //Agarra el ano corriente para buscar id de la planificacion actual
        $ano = date("Y");
        
        $aRet = $model->GetAno($ano);
        $id = $aRet[0]->id;
        
        //Agarra id cPlanificacion
        $aPlan = $model->GetPlanificacion($id);
        
        $aDados = $model->valores($aPlan[0]->id);
        
        echo(json_encode($aDados));
    }
    
    public function IndicesExcelencia($request)
    {
        
        $aRequest = (array) $request;
        
        $_SESSION['Planificacion']['token']   = '7c9b5c9b9baae1227deb96f1c51a7b61';
        
        $this->setPageTitle('API');
        $model = Container::getModel("Gambis");
        
        $aDados = $model->indicesExcelencia();
        
        echo(json_encode($aDados));
    }
    
}