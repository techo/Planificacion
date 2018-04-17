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
        
        // Se nao for Oficina Internacional lista apenas da sua SEDE
        $idSede = $_SESSION['Planificacion']['sede_id'];
        
        //Busca Planificacion
        $this->view->planificacion = $model->selectExpefica($idSede);
        
        for($i=0; $i < count($this->view->planificacion); $i++)
        {
            $idPlanificacion = $this->view->planificacion[$i]->id;
            
            $aDados = (array) $aDados[0];
            
            $pais  = $this->view->planificacion[$i]->id_pais;
            $sede = $this->view->planificacion[$i]->id_sede;
            
            $cPais = $this->GetPais($pais);
            $cSede = $this->GetSede($sede);
            
            $this->view->planificacion[$i]->pais = $cPais['nombre'];
            $this->view->planificacion[$i]->sede = $cSede[0]['nombre'];
        }
        
        /* Render View Planificacion */
        $this->renderView('planificacion/index', 'layout');
    }
    
    //Busca Pais en login.techo.org
    public function GetPais($idPais)
    {
        $url = 'http://id.techo.org/pais?api=true&token='.$_SESSION['Planificacion']['token'].'&id='.$idPais;
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $output = curl_exec($curl);
        curl_close($curl);
        
        $data = json_decode($output, true);
        
        return $data;
    }
    
    //Busca Sede en id.techo.org
    public function GetSede($idSede)
    {
        $url = 'http://id.techo.org/sede?api=true&token='.$_SESSION['Planificacion']['token'].'&id='.$idSede;
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $output = curl_exec($curl);
        curl_close($curl);
        
        $data = json_decode($output, true);
        
        return $data;
    }
    
    public function show($id)
    {
        $this->setPageTitle('Planificar a&ntilde;o');
        
        $model = Container::getModel("CPlanificacion");
        $this->view->planificacion = $model->search($id);
        
        $this->renderView('planificacion/planificar', 'layout');
    }
    
    public function carregardados($aParam)
    {
        $aParam = (array) $aParam;
        $idPlanificacion = $aParam['id'];
        $idSede = $_SESSION['Planificacion']['sede_id'];
        
        $model = Container::getModel("CPlanificacion");
        
        $aPlanificacion = $model->search($idPlanificacion);
        
        $aPlanificacion = (array) $aPlanificacion[0];
        
        //Indicador
        $aCabec[0]['name'] = 'indicador';
        $aCabec[0]['label'] = 'Indicador';
        $aCabec[0]['datatype'] = 'string';
        $aCabec[0]['editable'] = false;
        
        //Enero Plan
        $aCabec[1]['name'] = 'enero_plan';
        $aCabec[1]['label'] = '01 Plan';
        $aCabec[1]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_plan_enero'] == 1)
        {
            $aCabec[1]['editable'] = true;
        }
        else
        {
            $aCabec[1]['editable'] = false;
        }
        
        //Enero Real
        $aCabec[2]['name'] = 'enero_real';
        $aCabec[2]['label'] = '01 Real';
        $aCabec[2]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_real_enero'] == 1)
        {
            $aCabec[2]['editable'] = true;
        }
        else
        {
            $aCabec[2]['editable'] = false;
        }
        
        //Febrero Plan
        $aCabec[3]['name'] = 'febrero_plan';
        $aCabec[3]['label'] = '02 Plan';
        $aCabec[3]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_plan_febrero'] == 1)
        {
            $aCabec[3]['editable'] = true;
        }
        else
        {
            $aCabec[3]['editable'] = false;
        }
        
        //Febrero Real
        $aCabec[4]['name'] = 'febrero_real';
        $aCabec[4]['label'] = '02 Real';
        $aCabec[4]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_real_febrero'] == 1)
        {
            $aCabec[4]['editable'] = true;
        }
        else
        {
            $aCabec[4]['editable'] = false;
        }
        
        //Marzo Plan
        $aCabec[5]['name'] = 'marzo_plan';
        $aCabec[5]['label'] = '03 Plan';
        $aCabec[5]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_plan_marzo'] == 1)
        {
            $aCabec[5]['editable'] = true;
        }
        else
        {
            $aCabec[5]['editable'] = false;
        }
        
        //Marzo Real
        $aCabec[6]['name'] = 'marzo_real';
        $aCabec[6]['label'] = '03 Real';
        $aCabec[6]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_real_marzo'] == 1)
        {
            $aCabec[6]['editable'] = true;
        }
        else
        {
            $aCabec[6]['editable'] = false;
        }
        
        //Abril Plan
        $aCabec[7]['name'] = 'abril_plan';
        $aCabec[7]['label'] = '04 Plan';
        $aCabec[7]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_plan_abril'] == 1)
        {
            $aCabec[7]['editable'] = true;
        }
        else
        {
            $aCabec[7]['editable'] = false;
        }
        
        //Abril Real
        $aCabec[8]['name'] = 'abril_real';
        $aCabec[8]['label'] = '04 Real';
        $aCabec[8]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_real_abril'] == 1)
        {
            $aCabec[8]['editable'] = true;
        }
        else
        {
            $aCabec[8]['editable'] = false;
        }
        
        //Mayo Plan
        $aCabec[9]['name'] = 'mayo_plan';
        $aCabec[9]['label'] = '05 Plan';
        $aCabec[9]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_plan_mayo'] == 1)
        {
            $aCabec[9]['editable'] = true;
        }
        else
        {
            $aCabec[9]['editable'] = false;
        }
        
        //Mayo Real
        $aCabec[10]['name'] = 'mayo_real';
        $aCabec[10]['label'] = '05 Real';
        $aCabec[10]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_real_mayo'] == 1)
        {
            $aCabec[10]['editable'] = true;
        }
        else
        {
            $aCabec[10]['editable'] = false;
        }
        
        //Junio Plan
        $aCabec[11]['name'] = 'junio_plan';
        $aCabec[11]['label'] = '06 Plan';
        $aCabec[11]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_plan_junio'] == 1)
        {
            $aCabec[11]['editable'] = true;
        }
        else
        {
            $aCabec[11]['editable'] = false;
        }
        
        //Junio Real
        $aCabec[12]['name'] = 'junio_real';
        $aCabec[12]['label'] = '06 Real';
        $aCabec[12]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_real_junio'] == 1)
        {
            $aCabec[12]['editable'] = true;
        }
        else
        {
            $aCabec[12]['editable'] = false;
        }
        
        //Julio Plan
        $aCabec[13]['name'] = 'julio_plan';
        $aCabec[13]['label'] = '07 Plan';
        $aCabec[13]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_plan_julio'] == 1)
        {
            $aCabec[13]['editable'] = true;
        }
        else
        {
            $aCabec[13]['editable'] = false;
        }
        
        //Julio Real
        $aCabec[14]['name'] = 'julio_real';
        $aCabec[14]['label'] = '07 Real';
        $aCabec[14]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_real_julio'] == 1)
        {
            $aCabec[14]['editable'] = true;
        }
        else
        {
            $aCabec[14]['editable'] = false;
        }
        
        //Agosto Plan
        $aCabec[15]['name'] = 'agosto_plan';
        $aCabec[15]['label'] = '08 Plan';
        $aCabec[15]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_plan_agosto'] == 1)
        {
            $aCabec[15]['editable'] = true;
        }
        else
        {
            $aCabec[15]['editable'] = false;
        }
        
        //Agosto Real
        $aCabec[16]['name'] = 'agosto_real';
        $aCabec[16]['label'] = '08 Real';
        $aCabec[16]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_real_agosto'] == 1)
        {
            $aCabec[16]['editable'] = true;
        }
        else
        {
            $aCabec[16]['editable'] = false;
        }
        
        //Septiembre Plan
        $aCabec[17]['name'] = 'septiembre_plan';
        $aCabec[17]['label'] = '09 Plan';
        $aCabec[17]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_plan_septiembre'] == 1)
        {
            $aCabec[17]['editable'] = true;
        }
        else
        {
            $aCabec[17]['editable'] = false;
        }
        
        //Septiembre Real
        $aCabec[18]['name'] = 'septiembre_real';
        $aCabec[18]['label'] = '09 Real';
        $aCabec[18]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_real_septiembre'] == 1)
        {
            $aCabec[18]['editable'] = true;
        }
        else
        {
            $aCabec[18]['editable'] = false;
        }
        
        //Octubre Plan
        $aCabec[19]['name'] = 'octubre_plan';
        $aCabec[19]['label'] = '10 Plan';
        $aCabec[19]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_plan_octubre'] == 1)
        {
            $aCabec[19]['editable'] = true;
        }
        else
        {
            $aCabec[19]['editable'] = false;
        }
        
        //Octubre Real
        $aCabec[20]['name'] = 'octubre_real';
        $aCabec[20]['label'] = '10 Real';
        $aCabec[20]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_real_octubre'] == 1)
        {
            $aCabec[20]['editable'] = true;
        }
        else
        {
            $aCabec[20]['editable'] = false;
        }
        
        //Noviembre Plan
        $aCabec[21]['name'] = 'noviembre_plan';
        $aCabec[21]['label'] = '11 Plan';
        $aCabec[21]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_plan_noviembre'] == 1)
        {
            $aCabec[21]['editable'] = true;
        }
        else
        {
            $aCabec[21]['editable'] = false;
        }
        
        //Noviembre Real
        $aCabec[22]['name'] = 'noviembre_real';
        $aCabec[22]['label'] = '11 Real';
        $aCabec[22]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_real_noviembre'] == 1)
        {
            $aCabec[22]['editable'] = true;
        }
        else
        {
            $aCabec[22]['editable'] = false;
        }
        
        //Diciembre  Plan
        $aCabec[23]['name'] = 'diciembre_plan';
        $aCabec[23]['label'] = '12 Plan';
        $aCabec[23]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_plan_diciembre'] == 1)
        {
            $aCabec[23]['editable'] = true;
        }
        else
        {
            $aCabec[23]['editable'] = false;
        }
        
        //Diciembre Real
        $aCabec[24]['name'] = 'diciembre_real';
        $aCabec[24]['label'] = '12 Real';
        $aCabec[24]['datatype'] = 'integer';
        
        if($aPlanificacion['edit_real_diciembre'] == 1)
        {
            $aCabec[24]['editable'] = true;
        }
        else
        {
            $aCabec[24]['editable'] = false;
        }
        
        echo json_encode(array("metadata" => $aCabec));
        
    }
    
    public function listagem($aParam)
    {
        $aParam = (array) $aParam;
        $idPlanificacion = $aParam['id'];
        $idSede = $_SESSION['Planificacion']['sede_id'];
        
        $model = Container::getModel("CPlanificacion");
        
        $aListagem = $model->Listagem($idPlanificacion, $idSede);
        
        for($i=0; $i < count($aListagem); $i++)
        {
            $Dados = (array) $aListagem[$i];
            
            $aIndicador[$i]['id'] = $Dados['id'];
            $aIndicador[$i]['values']['indicador']       = $Dados['indicador'];
            $aIndicador[$i]['values']['enero_plan']      = $Dados['enero_plan'] == NULL ? 0 : $Dados['enero_plan'];
            $aIndicador[$i]['values']['enero_real']      = $Dados['enero_real'] == NULL ? 0 : $Dados['enero_real'];
            $aIndicador[$i]['values']['febrero_plan']    = $Dados['febrero_plan'] == NULL ? 0 : $Dados['febrero_plan'];
            $aIndicador[$i]['values']['febrero_real']    = $Dados['febrero_real'] == NULL ? 0 : $Dados['febrero_real'];
            $aIndicador[$i]['values']['marzo_plan']      = $Dados['marzo_plan'] == NULL ? 0 : $Dados['marzo_plan'];
            $aIndicador[$i]['values']['marzo_real']      = $Dados['marzo_real'] == NULL ? 0 : $Dados['marzo_real'];
            $aIndicador[$i]['values']['abril_plan']      = $Dados['abril_plan'] == NULL ? 0 : $Dados['abril_plan'];
            $aIndicador[$i]['values']['abril_real']      = $Dados['abril_real'] == NULL ? 0 : $Dados['abril_real'];
            $aIndicador[$i]['values']['mayo_plan']       = $Dados['mayo_plan'] == NULL ? 0 : $Dados['mayo_plan'];
            $aIndicador[$i]['values']['mayo_real']       = $Dados['mayo_real'] == NULL ? 0 : $Dados['mayo_real'];
            $aIndicador[$i]['values']['junio_plan']      = $Dados['junio_plan'] == NULL ? 0 : $Dados['junio_plan'];
            $aIndicador[$i]['values']['junio_real']      = $Dados['junio_real'] == NULL ? 0 : $Dados['junio_real'];
            $aIndicador[$i]['values']['julio_plan']      = $Dados['julio_plan'] == NULL ? 0 : $Dados['julio_plan'];
            $aIndicador[$i]['values']['julio_real']      = $Dados['julio_real'] == NULL ? 0 : $Dados['julio_real'];
            $aIndicador[$i]['values']['agosto_plan']     = $Dados['agosto_plan'] == NULL ? 0 : $Dados['agosto_plan'];
            $aIndicador[$i]['values']['agosto_real']     = $Dados['agosto_real'] == NULL ? 0 : $Dados['agosto_real'];
            $aIndicador[$i]['values']['septiembre_plan'] = $Dados['septiembre_plan'] == NULL ? 0 : $Dados['septiembre_plan'];
            $aIndicador[$i]['values']['septiembre_real'] = $Dados['septiembre_real'] == NULL ? 0 : $Dados['septiembre_real'];
            $aIndicador[$i]['values']['octubre_plan']    = $Dados['octubre_plan'] == NULL ? 0 : $Dados['octubre_plan'];
            $aIndicador[$i]['values']['octubre_real']    = $Dados['octubre_real'] == NULL ? 0 : $Dados['octubre_real'];
            $aIndicador[$i]['values']['noviembre_plan']  = $Dados['noviembre_plan'] == NULL ? 0 : $Dados['noviembre_plan'];
            $aIndicador[$i]['values']['noviembre_real']  = $Dados['noviembre_real'] == NULL ? 0 : $Dados['noviembre_real'];
            $aIndicador[$i]['values']['diciembre_plan']  = $Dados['diciembre_plan'] == NULL ? 0 : $Dados['diciembre_plan'];
            $aIndicador[$i]['values']['diciembre_real']  = $Dados['diciembre_real'] == NULL ? 0 : $Dados['diciembre_real'];
        }
        
        echo json_encode(array("data" => $aIndicador));
        
    }
}