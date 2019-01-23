<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class PlanificacionController extends BaseController
{
    public function __construct()
    {
        session_start();
        
        if($_SERVER['SERVER_NAME'] == 'admin.planificacion.techo.org' || $_SERVER['SERVER_NAME'] == 'localhost')
        {
            if(!isset($_SESSION['Planificacion']['token']))
            {
                header('Location: http://login.techo.org/?appid=98532jvfn145sas87aawrh154aeeth&redirect=https://admin.planificacion.techo.org/');
            }
        }
        else
        {
            if(!isset($_SESSION['Planificacion']['token']))
            {
                header('Location: http://login.techo.org/?appid=245sd4d5f4g8h1rt4584ht84t54tg8tg&redirect=https://planificacion.techo.org/');
            }
        }
    }
    
    public function index()
    {
        $this->setPageTitle('Planificaci&oacute;n');
        $model = Container::getModel("CPlanificacion");
        
        // Se nao for Oficina Internacional lista apenas da sua SEDE
        $idSede = $_SESSION['Planificacion']['sede_id'];
        $idPais = $_SESSION['Planificacion']['pais_id'];
        
        $tp = $this->GetSede($idSede);
        $n = $tp[0]['nombre'];
        
        //Busca Planificacion
        $this->view->planificacion = $model->selectExpefica($idSede, $idPais, $n);
        
        for($i=0; $i < count($this->view->planificacion); $i++)
        {
            $idPlanificacion = $this->view->planificacion[$i]->id;
            
            $aDados = (array) $aDados[0];
            
            $pais  = $this->view->planificacion[$i]->id_pais;
            $sede = $this->view->planificacion[$i]->id_sede;
            
          //  $cPais = $this->GetPais($pais);
          // $cSede = $this->GetSede($sede);
          
            //Removido linha acima porque estava demorando muito para carregar a pagina
            if (array_key_exists($pais, $_SESSION['Planificacion']['countries']))
            {
                $cPais = $_SESSION['Planificacion']['countries'][$pais];
            }
            
            if (array_key_exists($sede, $_SESSION['Planificacion']['sedes']))
            {
                $cSede = $_SESSION['Planificacion']['sedes'][$sede];
            }
            
            $this->view->planificacion[$i]->pais = utf8_encode($cPais);
            $this->view->planificacion[$i]->sede = utf8_encode($cSede);
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
    
    //Busca Area en login.techo.org
    public function GetArea($idArea)
    {
        $url = 'http://id.techo.org/area?api=true&token='.$_SESSION['Planificacion']['token'].'&id='.$idArea;
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CAINFO, getcwd() . DIRECTORY_SEPARATOR . 'cacert.pem');
        
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
        
        $this->view->proyecto = $model->ListProyectos($_GET['sede'], $id);
        
        for($i=0; $i < count($this->view->proyecto); $i++)
        {
            $pais  = $this->view->proyecto[$i]->id_pais;
            $sede = $this->view->proyecto[$i]->id_sede;
            
            $cPais = $this->GetPais($pais);
            $cSede = $this->GetSede($sede);
            
            $this->view->proyecto[$i]->pais = $cPais['nombre'];
            $this->view->proyecto[$i]->sede = $cSede[0]['nombre'];
        }
        
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
        
        //Tipo
        $aCabec[1]['name'] = 'tipo';
        $aCabec[1]['label'] = 'Tipo';
        $aCabec[1]['datatype'] = 'string';
        $aCabec[1]['editable'] = false;
        
        //Pilar
        $aCabec[2]['name'] = 'pilar';
        $aCabec[2]['label'] = 'Pilar';
        $aCabec[2]['datatype'] = 'string';
        $aCabec[2]['editable'] = false;
        
        //Area
        $aCabec[3]['name'] = 'area';
        $aCabec[3]['label'] = 'Area';
        $aCabec[3]['datatype'] = 'string';
        $aCabec[3]['editable'] = false;
        
        //Enero Plan
        $aCabec[4]['name'] = 'enero_plan';
        $aCabec[4]['label'] = '01 Plan';
        $aCabec[4]['datatype'] = 'double';
        
        if($aPlanificacion['edit_plan_enero'] == 1)
        {
            $aCabec[4]['editable'] = true;
        }
        else
        {
            $aCabec[4]['editable'] = false;
        }
        
        //Enero Real
        $aCabec[5]['name'] = 'enero_real';
        $aCabec[5]['label'] = '01 Real';
        $aCabec[5]['datatype'] = 'double';
        
        if($aPlanificacion['edit_real_enero'] == 1)
        {
            $aCabec[5]['editable'] = true;
        }
        else
        {
            $aCabec[5]['editable'] = false;
        }
        
        //Febrero Plan
        $aCabec[6]['name'] = 'febrero_plan';
        $aCabec[6]['label'] = '02 Plan';
        $aCabec[6]['datatype'] = 'double';
        
        if($aPlanificacion['edit_plan_febrero'] == 1)
        {
            $aCabec[6]['editable'] = true;
        }
        else
        {
            $aCabec[6]['editable'] = false;
        }
        
        //Febrero Real
        $aCabec[7]['name'] = 'febrero_real';
        $aCabec[7]['label'] = '02 Real';
        $aCabec[7]['datatype'] = 'double';
        
        if($aPlanificacion['edit_real_febrero'] == 1)
        {
            $aCabec[7]['editable'] = true;
        }
        else
        {
            $aCabec[7]['editable'] = false;
        }
        
        //Marzo Plan
        $aCabec[8]['name'] = 'marzo_plan';
        $aCabec[8]['label'] = '03 Plan';
        $aCabec[8]['datatype'] = 'double';
        
        if($aPlanificacion['edit_plan_marzo'] == 1)
        {
            $aCabec[8]['editable'] = true;
        }
        else
        {
            $aCabec[8]['editable'] = false;
        }
        
        //Marzo Real
        $aCabec[9]['name'] = 'marzo_real';
        $aCabec[9]['label'] = '03 Real';
        $aCabec[9]['datatype'] = 'double';
        
        if($aPlanificacion['edit_real_marzo'] == 1)
        {
            $aCabec[9]['editable'] = true;
        }
        else
        {
            $aCabec[9]['editable'] = false;
        }
        
        //Abril Plan
        $aCabec[10]['name'] = 'abril_plan';
        $aCabec[10]['label'] = '04 Plan';
        $aCabec[10]['datatype'] = 'double';
        
        if($aPlanificacion['edit_plan_abril'] == 1)
        {
            $aCabec[10]['editable'] = true;
        }
        else
        {
            $aCabec[10]['editable'] = false;
        }
        
        //Abril Real
        $aCabec[11]['name'] = 'abril_real';
        $aCabec[11]['label'] = '04 Real';
        $aCabec[11]['datatype'] = 'double';
        
        if($aPlanificacion['edit_real_abril'] == 1)
        {
            $aCabec[11]['editable'] = true;
        }
        else
        {
            $aCabec[11]['editable'] = false;
        }
        
        //Mayo Plan
        $aCabec[12]['name'] = 'mayo_plan';
        $aCabec[12]['label'] = '05 Plan';
        $aCabec[12]['datatype'] = 'double';
        
        if($aPlanificacion['edit_plan_mayo'] == 1)
        {
            $aCabec[12]['editable'] = true;
        }
        else
        {
            $aCabec[12]['editable'] = false;
        }
        
        //Mayo Real
        $aCabec[13]['name'] = 'mayo_real';
        $aCabec[13]['label'] = '05 Real';
        $aCabec[13]['datatype'] = 'double';
        
        if($aPlanificacion['edit_real_mayo'] == 1)
        {
            $aCabec[13]['editable'] = true;
        }
        else
        {
            $aCabec[13]['editable'] = false;
        }
        
        //Junio Plan
        $aCabec[14]['name'] = 'junio_plan';
        $aCabec[14]['label'] = '06 Plan';
        $aCabec[14]['datatype'] = 'double';
        
        if($aPlanificacion['edit_plan_junio'] == 1)
        {
            $aCabec[14]['editable'] = true;
        }
        else
        {
            $aCabec[14]['editable'] = false;
        }
        
        //Junio Real
        $aCabec[15]['name'] = 'junio_real';
        $aCabec[15]['label'] = '06 Real';
        $aCabec[15]['datatype'] = 'double';
        
        if($aPlanificacion['edit_real_junio'] == 1)
        {
            $aCabec[15]['editable'] = true;
        }
        else
        {
            $aCabec[15]['editable'] = false;
        }
        
        //Julio Plan
        $aCabec[16]['name'] = 'julio_plan';
        $aCabec[16]['label'] = '07 Plan';
        $aCabec[16]['datatype'] = 'double';
        
        if($aPlanificacion['edit_plan_julio'] == 1)
        {
            $aCabec[16]['editable'] = true;
        }
        else
        {
            $aCabec[16]['editable'] = false;
        }
        
        //Julio Real
        $aCabec[17]['name'] = 'julio_real';
        $aCabec[17]['label'] = '07 Real';
        $aCabec[17]['datatype'] = 'double';
        
        if($aPlanificacion['edit_real_julio'] == 1)
        {
            $aCabec[17]['editable'] = true;
        }
        else
        {
            $aCabec[17]['editable'] = false;
        }
        
        //Agosto Plan
        $aCabec[18]['name'] = 'agosto_plan';
        $aCabec[18]['label'] = '08 Plan';
        $aCabec[18]['datatype'] = 'double';
        
        if($aPlanificacion['edit_plan_agosto'] == 1)
        {
            $aCabec[18]['editable'] = true;
        }
        else
        {
            $aCabec[18]['editable'] = false;
        }
        
        //Agosto Real
        $aCabec[19]['name'] = 'agosto_real';
        $aCabec[19]['label'] = '08 Real';
        $aCabec[19]['datatype'] = 'double';
        
        if($aPlanificacion['edit_real_agosto'] == 1)
        {
            $aCabec[19]['editable'] = true;
        }
        else
        {
            $aCabec[19]['editable'] = false;
        }
        
        //Septiembre Plan
        $aCabec[20]['name'] = 'septiembre_plan';
        $aCabec[20]['label'] = '09 Plan';
        $aCabec[20]['datatype'] = 'double';
        
        if($aPlanificacion['edit_plan_septiembre'] == 1)
        {
            $aCabec[20]['editable'] = true;
        }
        else
        {
            $aCabec[20]['editable'] = false;
        }
        
        //Septiembre Real
        $aCabec[21]['name'] = 'septiembre_real';
        $aCabec[21]['label'] = '09 Real';
        $aCabec[21]['datatype'] = 'double';
        
        if($aPlanificacion['edit_real_septiembre'] == 1)
        {
            $aCabec[21]['editable'] = true;
        }
        else
        {
            $aCabec[21]['editable'] = false;
        }
        
        //Octubre Plan
        $aCabec[22]['name'] = 'octubre_plan';
        $aCabec[22]['label'] = '10 Plan';
        $aCabec[22]['datatype'] = 'double';
        
        if($aPlanificacion['edit_plan_octubre'] == 1)
        {
            $aCabec[22]['editable'] = true;
        }
        else
        {
            $aCabec[22]['editable'] = false;
        }
        
        //Octubre Real
        $aCabec[23]['name'] = 'octubre_real';
        $aCabec[23]['label'] = '10 Real';
        $aCabec[23]['datatype'] = 'double';
        
        if($aPlanificacion['edit_real_octubre'] == 1)
        {
            $aCabec[23]['editable'] = true;
        }
        else
        {
            $aCabec[23]['editable'] = false;
        }
        
        //Noviembre Plan
        $aCabec[24]['name'] = 'noviembre_plan';
        $aCabec[24]['label'] = '11 Plan';
        $aCabec[24]['datatype'] = 'double';
        
        if($aPlanificacion['edit_plan_noviembre'] == 1)
        {
            $aCabec[24]['editable'] = true;
        }
        else
        {
            $aCabec[24]['editable'] = false;
        }
        
        //Noviembre Real
        $aCabec[25]['name'] = 'noviembre_real';
        $aCabec[25]['label'] = '11 Real';
        $aCabec[25]['datatype'] = 'double';
        
        if($aPlanificacion['edit_real_noviembre'] == 1)
        {
            $aCabec[25]['editable'] = true;
        }
        else
        {
            $aCabec[25]['editable'] = false;
        }
        
        //Diciembre  Plan
        $aCabec[26]['name'] = 'diciembre_plan';
        $aCabec[26]['label'] = '12 Plan';
        $aCabec[26]['datatype'] = 'double';
        
        if($aPlanificacion['edit_plan_diciembre'] == 1)
        {
            $aCabec[26]['editable'] = true;
        }
        else
        {
            $aCabec[26]['editable'] = false;
        }
        
        //Diciembre Real
        $aCabec[27]['name'] = 'diciembre_real';
        $aCabec[27]['label'] = '12 Real';
        $aCabec[27]['datatype'] = 'double';
        
        if($aPlanificacion['edit_real_diciembre'] == 1)
        {
            $aCabec[27]['editable'] = true;
        }
        else
        {
            $aCabec[27]['editable'] = false;
        }
        
        echo json_encode(array("metadata" => $aCabec));
        
    }
    
    public function listagem($aParam)
    {
        $aParam = (array) $aParam;
        
        $idPlanificacion = $aParam['id'];
        $idSede = $aParam['sede'];
        $idPais = $aParam['pais'] ? $aParam['pais'] : 0;
        
        $model = Container::getModel("CPlanificacion");
        
        //Se for sede Oficina Internacional, buscar o id do registro
     /*   if($idSede == '1')
        {
            $aIndicadores = $model->BuscaIndicadores($idPlanificacion, $aParam['sede'], $aParam['pais']);
            
            $idSede = $aParam['sede'];
            $idPais = $aParam['pais'];
            
        } */
        
        $aListagem = $model->Listagem($idPlanificacion, $idSede, $idPais);
        
        for($i=0; $i < count($aListagem); $i++)
        {
            $Dados = (array) $aListagem[$i];
            
            //Buscar Pilar
            $aPilar = $model->GetPilar($Dados['id_pilar']);
            
            $cPilar = $aPilar[0]->pilar;
            
            //Busca Area
            $aArea = $this->GetArea($Dados['id_area']);
            $cArea = $aArea['codigo'];
            
            if(strlen($Dados['indicador']) > 60)
            {
                $punto = ' ... ';
            }
            else
            {
                $punto = ' ';
            }
            
            if(strlen($cPilar) > 43)
            {
                $punt = ' ... ';
            }
            else
            {
                $punt = ' ';
            }
            
            
            $aIndicador[$i]['id'] = $Dados['id'];
            $aIndicador[$i]['formato']                   = $Dados['formato'];
            $aIndicador[$i]['values']['indicador']       = substr($Dados['indicador'], 0, 60) . $punto;
            $aIndicador[$i]['values']['tipo']            = $Dados['tipo'];
            $aIndicador[$i]['values']['pilar']           = substr($cPilar, 0, 31). $punt;
            $aIndicador[$i]['values']['area']            = $cArea;
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
    
    public function atualiza($aParam)
    {
        $aParam = (array) $aParam;
        
        $model = Container::getModel("CPlanificacion");
        
        $aRet = $model->AtualizaIndicador($aParam);
        
        if($aRet)
        {
            //Verificar Tipo do Indicador
            $aDados = $model->BuscaIndicador($aParam);
            
            $idIndicador   = $aDados[0]->id_indicador;
            $aTipo         = $model->BuscaTipo($idIndicador);
            $tipo          = $aTipo[0]->tipo;
            
            //troca NULL por Zero
            //Plan 
            $aDados[0]->enero_plan      = $aDados[0]->enero_plan ? $aDados[0]->enero_plan : 0;
            $aDados[0]->febrero_plan    = $aDados[0]->febrero_plan ? $aDados[0]->febrero_plan : 0;
            $aDados[0]->marzo_plan      = $aDados[0]->marzo_plan? $aDados[0]->marzo_plan : 0;
            $aDados[0]->abril_plan      = $aDados[0]->abril_plan ? $aDados[0]->abril_plan : 0;
            $aDados[0]->mayo_plan       = $aDados[0]->mayo_plan ? $aDados[0]->mayo_plan : 0;
            $aDados[0]->junio_plan      = $aDados[0]->junio_plan ? $aDados[0]->junio_plan : 0;
            $aDados[0]->julio_plan      = $aDados[0]->julio_plan ? $aDados[0]->julio_plan : 0;
            $aDados[0]->agosto_plan     = $aDados[0]->agosto_plan ? $aDados[0]->agosto_plan : 0;
            $aDados[0]->septiembre_plan = $aDados[0]->septiembre_plan ? $aDados[0]->septiembre_plan: 0;
            $aDados[0]->octubre_plan    = $aDados[0]->octubre_plan ? $aDados[0]->octubre_plan : 0;
            $aDados[0]->noviembre_plan  = $aDados[0]->noviembre_plan ? $aDados[0]->noviembre_plan : 0;
            $aDados[0]->diciembre_plan  = $aDados[0]->diciembre_plan ? $aDados[0]->diciembre_plan: 0;
            
            //Real
            $aDados[0]->enero_real      = $aDados[0]->enero_real ? $aDados[0]->enero_real : 0;
            $aDados[0]->febrero_real    = $aDados[0]->febrero_real ? $aDados[0]->febrero_real : 0;
            $aDados[0]->marzo_real      = $aDados[0]->marzo_real ? $aDados[0]->marzo_real : 0;
            $aDados[0]->abril_real      = $aDados[0]->abril_real ? $aDados[0]->abril_real : 0;
            $aDados[0]->mayo_real       = $aDados[0]->mayo_real  ? $aDados[0]->mayo_real : 0;
            $aDados[0]->junio_real      = $aDados[0]->junio_real ? $aDados[0]->junio_real : 0;
            $aDados[0]->julio_real      = $aDados[0]->julio_real ? $aDados[0]->julio_real : 0;
            $aDados[0]->agosto_real     = $aDados[0]->agosto_real ? $aDados[0]->agosto_real : 0;
            $aDados[0]->septiembre_real = $aDados[0]->septiembre_real ? $aDados[0]->septiembre_real: 0;
            $aDados[0]->octubre_real    = $aDados[0]->octubre_real ? $aDados[0]->octubre_real : 0;
            $aDados[0]->noviembre_real  = $aDados[0]->noviembre_real ? $aDados[0]->noviembre_real : 0;
            $aDados[0]->diciembre_real  = $aDados[0]->diciembre_real ? $aDados[0]->diciembre_real : 0;
            
            //Recalcular e gravar os Acumulados deste Indicador
            if($tipo == 'Acumulado')
            {
                
                //Zera Valores para refazer o calculo de todos
                $aValores[0]['acumulado_plan_anual'] = 0;
                $aValores[0]['acumulado_real_anual'] = 0;
                $aValores[0]['acumulado_rp_anual']   = 0;
                $aValores[0]['acumulado_plan_t1']    = 0;
                $aValores[0]['acumulado_real_t1']    = 0;
                $aValores[0]['acumulado_rp_t1']      = 0;
                $aValores[0]['acumulado_plan_t2']    = 0;
                $aValores[0]['acumulado_real_t2']    = 0;
                $aValores[0]['acumulado_rp_t2']      = 0;
                $aValores[0]['acumulado_plan_t3']    = 0;
                $aValores[0]['acumulado_real_t3']    = 0;
                $aValores[0]['acumulado_rp_t3']      = 0;
                $aValores[0]['acumulado_plan_t4']    = 0;
                $aValores[0]['acumulado_real_t4']    = 0;
                $aValores[0]['acumulado_rp_t4']      = 0;
                $aValores[0]['acumulado_plan_s1']    = 0;
                $aValores[0]['acumulado_real_s1']    = 0;
                $aValores[0]['acumulado_rp_s1']      = 0;
                $aValores[0]['acumulado_plan_s2']    = 0;
                $aValores[0]['acumulado_real_s2']    = 0;
                $aValores[0]['acumulado_rp_s2']      = 0;
                
                //Inicio calculos
                
                //Acumulado Plan Anual
                $aValores[0]['acumulado_plan_anual'] = $aDados[0]->enero_plan + $aDados[0]->febrero_plan + $aDados[0]->marzo_plan + $aDados[0]->abril_plan + $aDados[0]->mayo_plan + $aDados[0]->junio_plan + $aDados[0]->julio_plan + $aDados[0]->agosto_plan + 
                $aDados[0]->septiembre_plan + $aDados[0]->octubre_plan + $aDados[0]->noviembre_plan + $aDados[0]->diciembre_plan;
                
                //Acumulado Real Anual
                $aValores[0]['acumulado_real_anual'] = $aDados[0]->enero_real + $aDados[0]->febrero_real + $aDados[0]->marzo_real + $aDados[0]->abril_real + $aDados[0]->mayo_real + $aDados[0]->junio_real + $aDados[0]->julio_real + $aDados[0]->agosto_real+
                $aDados[0]->septiembre_real + $aDados[0]->octubre_real + $aDados[0]->noviembre_real + $aDados[0]->diciembre_real;
                
                //Acumulado % (R/P) Anual
                $aValores[0]['acumulado_rp_anual'] = $aValores[0]['acumulado_real_anual'] / $aValores[0]['acumulado_plan_anual'];
                
                //Caso seja 0.00 / 0.00
                if(!$aValores[0]['acumulado_rp_anual'])
                {
                    $aValores[0]['acumulado_rp_anual'] = 0;
                }
                
                //Acumulado Plan T1
                $aValores[0]['acumulado_plan_t1'] = $aDados[0]->enero_plan + $aDados[0]->febrero_plan + $aDados[0]->marzo_plan;
                
                //Acumulado Real T1
                $aValores[0]['acumulado_real_t1'] = $aDados[0]->enero_real + $aDados[0]->febrero_real + $aDados[0]->marzo_real;
                
                //Acumulado % (R/P) T1
                $aValores[0]['acumulado_rp_t1'] = $aValores[0]['acumulado_real_t1'] / $aValores[0]['acumulado_plan_t1'];
                
                //Caso seja 0.00 / 0.00
                if(!$aValores[0]['acumulado_rp_t1'])
                {
                    $aValores[0]['acumulado_rp_t1'] = 0;
                }
                
                //Acumulado Plan T2
                $aValores[0]['acumulado_plan_t2'] = $aDados[0]->abril_plan + $aDados[0]->mayo_plan + $aDados[0]->junio_plan;
                
                //Acumulado Real T2
                $aValores[0]['acumulado_real_t2'] = $aDados[0]->abril_real + $aDados[0]->mayo_real + $aDados[0]->junio_real;
                
                //Acumulado % (R/P) T2
                $aValores[0]['acumulado_rp_t2'] = $aValores[0]['acumulado_real_t2'] / $aValores[0]['acumulado_plan_t2'];
                
                //Caso seja 0.00 / 0.00
                if(!$aValores[0]['acumulado_rp_t2'])
                {
                    $aValores[0]['acumulado_rp_t2'] = 0;
                }
                
                //Acumulado Plan T3
                $aValores[0]['acumulado_plan_t3'] = $aDados[0]->julio_plan + $aDados[0]->agosto_plan + $aDados[0]->septiembre_plan;
                
                //Acumulado Real T3
                $aValores[0]['acumulado_real_t3'] = $aDados[0]->julio_real + $aDados[0]->agosto_real + $aDados[0]->septiembre_real;
                
                //Acumulado % (R/P) T3
                $aValores[0]['acumulado_rp_t3'] = $aValores[0]['acumulado_real_t3'] / $aValores[0]['acumulado_plan_t3'];
                
                //Caso seja 0.00 / 0.00
                if(!$aValores[0]['acumulado_rp_t3'])
                {
                    $aValores[0]['acumulado_rp_t3'] = 0;
                }
                
                //Acumulado Plan T4
                $aValores[0]['acumulado_plan_t4'] = $aDados[0]->octubre_plan + $aDados[0]->noviembre_plan + $aDados[0]->diciembre_plan;
                
                //Acumulado Real T4
                $aValores[0]['acumulado_real_t4'] = $aDados[0]->octubre_real + $aDados[0]->noviembre_real + $aDados[0]->diciembre_real;
                
                //Acumulado % (R/P) T4
                $aValores[0]['acumulado_rp_t4'] = $aValores[0]['acumulado_real_t4'] / $aValores[0]['acumulado_plan_t4'];
                
                //Caso seja 0.00 / 0.00
                if(!$aValores[0]['acumulado_rp_t4'])
                {
                    $aValores[0]['acumulado_rp_t4'] = 0;
                }
                
                //Acumulado Plan S1
                $aValores[0]['acumulado_plan_s1'] = $aDados[0]->enero_plan + $aDados[0]->febrero_plan + $aDados[0]->marzo_plan + $aDados[0]->abril_plan + $aDados[0]->mayo_plan + $aDados[0]->junio_plan;
                
                //Acumulado Real S1
                $aValores[0]['acumulado_real_s1'] = $aDados[0]->enero_real + $aDados[0]->febrero_real + $aDados[0]->marzo_real + $aDados[0]->abril_real + $aDados[0]->mayo_real + $aDados[0]->junio_real;
                
                //Acumulado % (R/P) S1
                $aValores[0]['acumulado_rp_s1'] = $aValores[0]['acumulado_real_s1'] / $aValores[0]['acumulado_plan_s1'];
                
                //Caso seja 0.00 / 0.00
                if(!$aValores[0]['acumulado_rp_s1'])
                {
                    $aValores[0]['acumulado_rp_s1'] = 0;
                }
                
                //Acumulado Plan S2
                $aValores[0]['acumulado_plan_s2'] = $aDados[0]->julio_plan + $aDados[0]->agosto_plan + $aDados[0]->septiembre_plan + $aDados[0]->octubre_plan + $aDados[0]->noviembre_plan + $aDados[0]->diciembre_plan;
                
                //Acumulado Real S2
                $aValores[0]['acumulado_real_s2'] = $aDados[0]->julio_real + $aDados[0]->agosto_real +$aDados[0]->septiembre_real + $aDados[0]->octubre_real + $aDados[0]->noviembre_real + $aDados[0]->diciembre_real;
                
                //Acumulado % (R/P) S2
                $aValores[0]['acumulado_rp_s2'] = $aValores[0]['acumulado_real_s2'] / $aValores[0]['acumulado_plan_s2'];
                
                //Caso seja 0.00 / 0.00
                if(!$aValores[0]['acumulado_rp_s2'])
                {
                    $aValores[0]['acumulado_rp_s2'] = 0;
                }
                
                $aValores[0]['id'] = $aParam['id'];
                
                //Metodo que grava os Acumulados
                $aRetVal = $model->GravaAcumulados($aValores);
                
            }
            
            //Recalcular e gravar o Promedio deste Indicador
            if($tipo == 'Promedio')
            {
                //Zera Valores para refazer o calculo de todos
                $aValores[0]['promedio_plan_anual'] = 0;
                $aValores[0]['promedio_real_anual'] = 0;
                $aValores[0]['promedio_rp_anual']   = 0;
                $aValores[0]['promedio_plan_t1']    = 0;
                $aValores[0]['promedio_real_t1']    = 0;
                $aValores[0]['promedio_rp_t1']      = 0;
                $aValores[0]['promedio_plan_t2']    = 0;
                $aValores[0]['promedio_real_t2']    = 0;
                $aValores[0]['promedio_rp_t2']      = 0;
                $aValores[0]['promedio_plan_t3']    = 0;
                $aValores[0]['promedio_real_t3']    = 0;
                $aValores[0]['promedio_rp_t3']      = 0;
                $aValores[0]['promedio_plan_t4']    = 0;
                $aValores[0]['promedio_real_t4']    = 0;
                $aValores[0]['promedio_rp_t4']      = 0;
                $aValores[0]['promedio_plan_s1']    = 0;
                $aValores[0]['promedio_real_s1']    = 0;
                $aValores[0]['promedio_rp_s1']      = 0;
                $aValores[0]['promedio_plan_s2']    = 0;
                $aValores[0]['promedio_real_s2']    = 0;
                $aValores[0]['promedio_rp_s2']      = 0;
                
                //Inicio calculos
                
                //Promedio Plan Anual
                $aValores[0]['promedio_plan_anual'] = ($aDados[0]->enero_plan + $aDados[0]->febrero_plan + $aDados[0]->marzo_plan + $aDados[0]->abril_plan + $aDados[0]->mayo_plan + $aDados[0]->junio_plan + $aDados[0]->julio_plan + $aDados[0]->agosto_plan +
                $aDados[0]->septiembre_plan + $aDados[0]->octubre_plan + $aDados[0]->noviembre_plan + $aDados[0]->diciembre_plan) / 12 ;
                
                $aValores[0]['promedio_real_anual'] = ($aDados[0]->enero_real + $aDados[0]->febrero_real + $aDados[0]->marzo_real + $aDados[0]->abril_real + $aDados[0]->mayo_real + $aDados[0]->junio_real + $aDados[0]->julio_real + $aDados[0]->agosto_real+
                $aDados[0]->septiembre_real + $aDados[0]->octubre_real + $aDados[0]->noviembre_real + $aDados[0]->diciembre_real) / 12;
                
                $aValores[0]['promedio_rp_anual'] = $aValores[0]['promedio_real_anual'] / $aValores[0]['promedio_plan_anual'];
                
                $aValores[0]['promedio_plan_t1'] = ($aDados[0]->enero_plan + $aDados[0]->febrero_plan + $aDados[0]->marzo_plan) / 3;
                
                $aValores[0]['promedio_real_t1'] = ($aDados[0]->enero_real + $aDados[0]->febrero_real + $aDados[0]->marzo_real) / 3;
                
                $aValores[0]['promedio_rp_t1'] = $aValores[0]['promedio_real_t1'] / $aValores[0]['promedio_plan_t1'];
                
                //Caso seja 0.00 / 0.00
                if(!$aValores[0]['promedio_rp_t1'])
                {
                    $aValores[0]['promedio_rp_t1'] = 0;
                }
                
                $aValores[0]['promedio_plan_t2'] = ($aDados[0]->abril_plan + $aDados[0]->mayo_plan + $aDados[0]->junio_plan) / 3;
                
                $aValores[0]['promedio_real_t2'] = ($aDados[0]->abril_real + $aDados[0]->mayo_real + $aDados[0]->junio_real) / 3;
                
                $aValores[0]['promedio_rp_t2'] = $aValores[0]['promedio_real_t2'] / $aValores[0]['promedio_plan_t2'];
                
                //Caso seja 0.00 / 0.00
                if(!$aValores[0]['promedio_rp_t2'])
                {
                    $aValores[0]['promedio_rp_t2'] = 0;
                }
                
                $aValores[0]['promedio_plan_t3'] = ($aDados[0]->julio_plan + $aDados[0]->agosto_plan + $aDados[0]->septiembre_plan) / 3;
                
                $aValores[0]['promedio_real_t3'] = ($aDados[0]->julio_real + $aDados[0]->agosto_real + $aDados[0]->septiembre_real) / 3;
                
                $aValores[0]['promedio_rp_t3'] = $aValores[0]['promedio_real_t3'] / $aValores[0]['promedio_plan_t3'];
                
                //Caso seja 0.00 / 0.00
                if(!$aValores[0]['promedio_rp_t3'])
                {
                    $aValores[0]['promedio_rp_t3'] = 0;
                }
                
                $aValores[0]['promedio_plan_t4'] = ($aDados[0]->octubre_plan + $aDados[0]->noviembre_plan + $aDados[0]->diciembre_plan) / 3;
                
                $aValores[0]['promedio_real_t4'] = ($aDados[0]->octubre_real + $aDados[0]->noviembre_real + $aDados[0]->diciembre_real) / 3;
                
                $aValores[0]['promedio_rp_t4'] = $aValores[0]['promedio_real_t4'] / $aValores[0]['promedio_plan_t4'];
                
                //Caso seja 0.00 / 0.00
                if(!$aValores[0]['promedio_rp_t4'])
                {
                    $aValores[0]['promedio_rp_t4'] = 0;
                }
                
                
                $aValores[0]['promedio_plan_s1'] = ($aDados[0]->enero_plan + $aDados[0]->febrero_plan + $aDados[0]->marzo_plan + $aDados[0]->abril_plan + $aDados[0]->mayo_plan + $aDados[0]->junio_plan) / 6;
                
                $aValores[0]['promedio_real_s1'] = ($aDados[0]->enero_real + $aDados[0]->febrero_real + $aDados[0]->marzo_real + $aDados[0]->abril_real + $aDados[0]->mayo_real + $aDados[0]->junio_real) / 6;
                
                $aValores[0]['promedio_rp_s1'] = $aValores[0]['promedio_real_s1'] / $aValores[0]['promedio_plan_s1'];
                
                //Caso seja 0.00 / 0.00
                if(!$aValores[0]['promedio_rp_s1'])
                {
                    $aValores[0]['promedio_rp_s1'] = 0;
                }
                
                $aValores[0]['promedio_plan_s2'] = ($aDados[0]->julio_plan + $aDados[0]->agosto_plan + $aDados[0]->septiembre_plan + $aDados[0]->octubre_plan + $aDados[0]->noviembre_plan + $aDados[0]->diciembre_plan) / 6;
                
                $aValores[0]['promedio_real_s2'] = ($aDados[0]->julio_real + $aDados[0]->agosto_real +$aDados[0]->septiembre_real + $aDados[0]->octubre_real + $aDados[0]->noviembre_real + $aDados[0]->diciembre_real) / 6;
                
                $aValores[0]['promedio_rp_s2'] = $aValores[0]['promedio_real_s2'] / $aValores[0]['promedio_plan_s2'];
                
                //Caso seja 0.00 / 0.00
                if(!$aValores[0]['promedio_rp_s2'])
                {
                    $aValores[0]['promedio_rp_s2'] = 0;
                }
                
                $aValores[0]['id'] = $aParam['id'];
                
                //Metodo que grava os Acumulados
                $aRetVal = $model->GravaPromedio($aValores);
            }
            
            //Recalcular e gravar o Minimo deste Indicador
            if($tipo == 'Minimo')
            {
                //Zera Valores para refazer o calculo de todos
                $aValores[0]['minimo_plan_anual'] = 0;
                $aValores[0]['minimo_real_anual'] = 0;
                $aValores[0]['minimo_rp_anual']   = 0;
                $aValores[0]['minimo_plan_t1']    = 0;
                $aValores[0]['minimo_real_t1']    = 0;
                $aValores[0]['minimo_rp_t1']      = 0;
                $aValores[0]['minimo_plan_t2']    = 0;
                $aValores[0]['minimo_real_t2']    = 0;
                $aValores[0]['minimo_rp_t2']      = 0;
                $aValores[0]['minimo_plan_t3']    = 0;
                $aValores[0]['minimo_real_t3']    = 0;
                $aValores[0]['minimo_rp_t3']      = 0;
                $aValores[0]['minimo_plan_t4']    = 0;
                $aValores[0]['minimo_real_t4']    = 0;
                $aValores[0]['minimo_rp_t4']      = 0;
                $aValores[0]['minimo_plan_s1']    = 0;
                $aValores[0]['minimo_real_s1']    = 0;
                $aValores[0]['minimo_rp_s1']      = 0;
                $aValores[0]['minimo_plan_s2']    = 0;
                $aValores[0]['minimo_real_s2']    = 0;
                $aValores[0]['minimo_rp_s2']      = 0;
                
                //Inicio calculos
                
                //Metodo que busca os Planejados
                $Plan = $model->BuscaPlan($aParam['id']);
                $Plan =  (array) $Plan[0];
                
                //Remover os NULL
                foreach($Plan as $k=>$v)
                {
                    if($v == '')
                    {
                        unset($Plan[$k]);
                    }
                }
                
                //Metodo que busca os Reais
                $Real = $model->BuscaReal($aParam['id']);
                $Real =  (array) $Real[0];
                
                //Remover os NULL
                foreach($Real as $k=>$v)
                {
                    if($v == '')
                    {
                        unset($Real[$k]);
                    }
                }
                
                //Menor valor de todos Planejados
                $nMin = min($Plan) ? min($Plan) : 'NULL';
                
                //Menor Valor de todos Reais
                $nMax = min($Real) ? min($Real) : 'NULL';
                
                //Minimo Plan Anual
                $aValores[0]['minimo_plan_anual'] = $nMin;
                $aValores[0]['minimo_real_anual'] = $nMax;
                
                
                if($aValores[0]['minimo_plan_anual'] == 'NULL' || $aValores[0]['minimo_real_anual'] == 'NULL')
                {
                    $aValores[0]['minimo_rp_anual'] = 'NULL';
                }
                else 
                {
                    $aValores[0]['minimo_rp_anual'] = $aValores[0]['minimo_real_anual'] / $aValores[0]['minimo_plan_anual'];
                    
                    //Caso seja 0.00 / 0.00
                    if(!$aValores[0]['minimo_rp_anual'])
                    {
                        $aValores[0]['minimo_rp_anual'] = 0;
                    }
                }
                
                //Encontrar menor Plan do T1
                foreach($Plan as $k=>$v)
                {
                    if($k == 'enero_plan' || $k == 'febrero_plan' || $k == 'marzo_plan')
                    {
                        $aPlanT1[$k] = $v;
                    }
                    else
                    {
                       continue;
                    }
                }
                
                //Encontrar menor Real do T1
                foreach($Real as $k=>$v)
                {
                    if($k == 'enero_real' || $k == 'febrero_real' || $k == 'marzo_real')
                    {
                        $aRealT1[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                
                //Trimestre 1
                $aValores[0]['minimo_plan_t1']    = min($aPlanT1) ? min($aPlanT1) : 'NULL';
                $aValores[0]['minimo_real_t1']    = min($aRealT1) ? min($aRealT1) : 'NULL';
                
                
                if($aValores[0]['minimo_plan_t1'] == 'NULL' || $aValores[0]['minimo_real_t1'] == 'NULL')
                {
                    $aValores[0]['minimo_rp_t1'] = 'NULL';
                }
                else 
                {
                    $aValores[0]['minimo_rp_t1'] = $aValores[0]['minimo_real_t1'] / $aValores[0]['minimo_plan_t1'];
                    
                    //Caso seja 0.00 / 0.00
                    if(!$aValores[0]['minimo_rp_t1'])
                    {
                        $aValores[0]['minimo_rp_t1'] = 0;
                    }
                }
                
                //Encontrar menor Plan do T2
                foreach($Plan as $k=>$v)
                {
                    if($k == 'abril_plan' || $k == 'mayo_plan' || $k == 'junio_plan')
                    {
                        $aPlanT2[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Encontrar menor Real do T2
                foreach($Real as $k=>$v)
                {
                    if($k == 'abril_real' || $k == 'mayo_real' || $k == 'junio_real')
                    {
                        $aRealT2[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Trimestre 2
                $aValores[0]['minimo_plan_t2']    = min($aPlanT2) ? min($aPlanT2) : 'NULL';
                $aValores[0]['minimo_real_t2']    = min($aRealT2) ? min($aRealT2) : 'NULL';
                
                if($aValores[0]['minimo_plan_t2'] == 'NULL' || $aValores[0]['minimo_real_t2'] == 'NULL')
                {
                    $aValores[0]['minimo_rp_t2'] = 'NULL';
                }
                else 
                {
                    $aValores[0]['minimo_rp_t2'] = $aValores[0]['minimo_real_t2'] / $aValores[0]['minimo_plan_t2'];
                    
                    //Caso seja 0.00 / 0.00
                    if(!$aValores[0]['minimo_rp_t2'])
                    {
                        $aValores[0]['minimo_rp_t2'] = 0;
                    }
                }
                
                //Encontrar menor Plan do T3
                foreach($Plan as $k=>$v)
                {
                    if($k == 'julio_plan' || $k == 'agosto_plan' || $k == 'septiembre_plan')
                    {
                        $aPlanT3[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Encontrar menor Real do T3
                foreach($Real as $k=>$v)
                {
                    if($k == 'julio_real' || $k == 'agosto_real' || $k == 'septiembre_real')
                    {
                        $aRealT3[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Trimestre 3
                $aValores[0]['minimo_plan_t3']    = min($aPlanT3) ? min($aPlanT3) : 'NULL';
                $aValores[0]['minimo_real_t3']    = min($aRealT3) ? min($aRealT3) : 'NULL';
                
                if($aValores[0]['minimo_plan_t3'] == 'NULL' || $aValores[0]['minimo_real_t3'] == 'NULL')
                {
                    $aValores[0]['minimo_rp_t3'] = 'NULL';
                }
                else
                {
                    $aValores[0]['minimo_rp_t3'] = $aValores[0]['minimo_real_t3'] / $aValores[0]['minimo_plan_t3'];
                    
                    //Caso seja 0.00 / 0.00
                    if(!$aValores[0]['minimo_rp_t3'])
                    {
                        $aValores[0]['minimo_rp_t3'] = 0;
                    }
                }
                
                //Encontrar menor Plan do T4
                foreach($Plan as $k=>$v)
                {
                    if($k == 'octubre_plan' || $k == 'noviembre_plan' || $k == 'diciembre_plan')
                    {
                        $aPlanT4[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Encontrar menor Real do T4
                foreach($Real as $k=>$v)
                {
                    if($k == 'octubre_real' || $k == 'noviembre_real' || $k == 'diciembre_real')
                    {
                        $aRealT4[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Trimestre 4
                $aValores[0]['minimo_plan_t4']    = min($aPlanT4) ? min($aPlanT4) : 'NULL';
                $aValores[0]['minimo_real_t4']    = min($aRealT4) ? min($aRealT4) : 'NULL';
                
                if($aValores[0]['minimo_plan_t4'] == 'NULL' || $aValores[0]['minimo_real_t4'] == 'NULL')
                {
                    $aValores[0]['minimo_rp_t4'] = 'NULL';
                }
                else 
                {
                    $aValores[0]['minimo_rp_t4'] = $aValores[0]['minimo_real_t4'] / $aValores[0]['minimo_plan_t4'];
                    
                    //Caso seja 0.00 / 0.00
                    if(!$aValores[0]['minimo_rp_t4'])
                    {
                        $aValores[0]['minimo_rp_t4'] = 0;
                    }
                }
                
                //Encontrar menor Plan do S1
                foreach($Plan as $k=>$v)
                {
                    if($k == 'enero_plan' || $k == 'febrero_plan' || $k == 'marzo_plan' || $k == 'abril_plan' || $k == 'mayo_plan' || $k == 'junio_plan')
                    {
                        $aPlanS1[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Encontrar menor Real do S1
                foreach($Real as $k=>$v)
                {
                    if($k == 'enero_real' || $k == 'febrero_real' || $k == 'marzo_real' || $k == 'abril_real' || $k == 'mayo_real' || $k == 'junio_real')
                    {
                        $aRealS1[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Semestre 1
                $aValores[0]['minimo_plan_s1']    = min($aPlanS1) ? min($aPlanS1) : 'NULL';
                $aValores[0]['minimo_real_s1']    = min($aRealS1) ? min($aRealS1) : 'NULL';
                
                if($aValores[0]['minimo_plan_s1'] == 'NULL' || $aValores[0]['minimo_real_s1'] == 'NULL')
                {
                    $aValores[0]['minimo_rp_s1'] = 'NULL';
                }
                else 
                {
                    $aValores[0]['minimo_rp_s1'] = $aValores[0]['minimo_real_s1'] / $aValores[0]['minimo_plan_s1'];
                    
                    //Caso seja 0.00 / 0.00
                    if(!$aValores[0]['minimo_rp_s1'])
                    {
                        $aValores[0]['minimo_rp_s1'] = 0;
                    }
                }
                
                //Encontrar menor Plan do S2
                foreach($Plan as $k=>$v)
                {
                    if($k == 'julio_plan' || $k == 'agosto_plan' || $k == 'septiembre_plan' || $k == 'octubre_plan' || $k == 'noviembre_plan' || $k == 'diciembre_plan')
                    {
                        $aPlanS2[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Encontrar menor Real do S2
                foreach($Real as $k=>$v)
                {
                    if($k == 'julio_real' || $k == 'agosto_real' || $k == 'septiembre_real' || $k == 'octubre_real' || $k == 'noviembre_real' || $k == 'diciembre_real')
                    {
                        $aRealS2[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Semestre 2
                $aValores[0]['minimo_plan_s2']    = min($aPlanS2) ? min($aPlanS2) : 'NULL';
                $aValores[0]['minimo_real_s2']    = min($aRealS2) ? min($aRealS2) : 'NULL';
                
                if($aValores[0]['minimo_plan_s2'] == 'NULL' || $aValores[0]['minimo_real_s2'] == 'NULL')
                {
                    $aValores[0]['minimo_rp_s2'] = 'NULL';
                }
                else
                {
                    $aValores[0]['minimo_rp_s2'] = $aValores[0]['minimo_real_s2'] / $aValores[0]['minimo_plan_s2'];
                    
                    //Caso seja 0.00 / 0.00
                    if(!$aValores[0]['minimo_rp_s2'])
                    {
                        $aValores[0]['minimo_rp_s2'] = 0;
                    }
                }
                
                $aValores[0]['id'] = $aParam['id'];
                
                //Metodo que grava os Minimos
                $aRetVal = $model->GravaMinimo($aValores);
                
            }
            
            //Recalcular e gravar o Maximo deste Indicador
            if($tipo == 'Maximo')
            {
                //Zera Valores para refazer o calculo de todos
                $aValores[0]['maximo_plan_anual'] = 0;
                $aValores[0]['maximo_real_anual'] = 0;
                $aValores[0]['maximo_rp_anual']   = 0;
                $aValores[0]['maximo_plan_t1']    = 0;
                $aValores[0]['maximo_real_t1']    = 0;
                $aValores[0]['maximo_rp_t1']      = 0;
                $aValores[0]['maximo_plan_t2']    = 0;
                $aValores[0]['maximo_real_t2']    = 0;
                $aValores[0]['maximo_rp_t2']      = 0;
                $aValores[0]['maximo_plan_t3']    = 0;
                $aValores[0]['maximo_real_t3']    = 0;
                $aValores[0]['maximo_rp_t3']      = 0;
                $aValores[0]['maximo_plan_t4']    = 0;
                $aValores[0]['maximo_real_t4']    = 0;
                $aValores[0]['maximo_rp_t4']      = 0;
                $aValores[0]['maximo_plan_s1']    = 0;
                $aValores[0]['maximo_real_s1']    = 0;
                $aValores[0]['maximo_rp_s1']      = 0;
                $aValores[0]['maximo_plan_s2']    = 0;
                $aValores[0]['maximo_real_s2']    = 0;
                $aValores[0]['maximo_rp_s2']      = 0;
                
                //Inicio calculos
                //Metodo que busca os Planejados
                $Plan = $model->BuscaPlan($aParam['id']);
                $Plan =  (array) $Plan[0];
                
                //Remover os NULL
                foreach($Plan as $k=>$v)
                {
                    if($v == '')
                    {
                        unset($Plan[$k]);
                    }
                }
                
                //Metodo que busca os Reais
                $Real = $model->BuscaReal($aParam['id']);
                $Real =  (array) $Real[0];
                
                //Remover os NULL
                foreach($Real as $k=>$v)
                {
                    if($v == '')
                    {
                        unset($Real[$k]);
                    }
                }
                
                //Menor valor de todos Planejados
                $nMaxPlan = max($Plan);
                
                //Menor Valor de todos Reais
                $nMinPlan = max($Real);
                
                //Minimo Plan Anual
                $aValores[0]['maximo_plan_anual'] = $nMaxPlan ? $nMaxPlan : 'NULL';
                $aValores[0]['maximo_real_anual'] = $nMinPlan ? $nMinPlan : 'NULL';
                
                if($aValores[0]['maximo_real_anual'] == 'NULL' || $aValores[0]['maximo_real_anual'] == 'NULL')
                {
                    $aValores[0]['maximo_rp_anual']  = 'NULL';
                }
                else
                {
                    $aValores[0]['maximo_rp_anual']   = $aValores[0]['maximo_real_anual'] / $aValores[0]['maximo_plan_anual'];
                }
                
                
                //Encontrar menor Plan do T1
                foreach($Plan as $k=>$v)
                {
                    if($k == 'enero_plan' || $k == 'febrero_plan' || $k == 'marzo_plan')
                    {
                        $aPlanT1[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Encontrar menor Real do T1
                foreach($Real as $k=>$v)
                {
                    if($k == 'enero_real' || $k == 'febrero_real' || $k == 'marzo_real')
                    {
                        $aRealT1[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Trimestre 1
                $aValores[0]['maximo_plan_t1']    = max($aPlanT1) ? max($aPlanT1) : 'NULL';
                $aValores[0]['maximo_real_t1']    = max($aRealT1) ? max($aRealT1) : 'NULL';
                
                if($aValores[0]['maximo_plan_t1'] == 'NULL' || $aValores[0]['maximo_real_t1'] == 'NULL')
                {
                    $aValores[0]['maximo_rp_t1'] = 'NULL';
                }
                else
                {
                    $aValores[0]['maximo_rp_t1']      = $aValores[0]['maximo_real_t1'] / $aValores[0]['maximo_plan_t1'];
                }
                
                //Encontrar menor Plan do T2
                foreach($Plan as $k=>$v)
                {
                    if($k == 'abril_plan' || $k == 'mayo_plan' || $k == 'junio_plan')
                    {
                        $aPlanT2[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Encontrar menor Real do T2
                foreach($Real as $k=>$v)
                {
                    if($k == 'abril_real' || $k == 'mayo_real' || $k == 'junio_real')
                    {
                        $aRealT2[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Trimestre 2
                $aValores[0]['maximo_plan_t2']    = max($aPlanT2) ? max($aPlanT2) : 'NULL';
                $aValores[0]['maximo_real_t2']    = max($aRealT2) ? max($aRealT2) : 'NULL';
                
                if($aValores[0]['maximo_plan_t2'] == 'NULL' || $aValores[0]['maximo_real_t2'] == 'NULL')
                {
                    $aValores[0]['maximo_rp_t2'] = 'NULL';
                }
                else
                {
                    $aValores[0]['maximo_rp_t2'] = $aValores[0]['maximo_real_t2'] / $aValores[0]['maximo_plan_t2'];
                }
                
                //Encontrar menor Plan do T3
                foreach($Plan as $k=>$v)
                {
                    if($k == 'julio_plan' || $k == 'agosto_plan' || $k == 'septiembre_plan')
                    {
                        $aPlanT3[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Encontrar menor Real do T3
                foreach($Real as $k=>$v)
                {
                    if($k == 'julio_real' || $k == 'agosto_real' || $k == 'septiembre_real')
                    {
                        $aRealT3[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Trimestre 3
                $aValores[0]['maximo_plan_t3']    = max($aPlanT3) ? max($aPlanT3) : 'NULL';
                $aValores[0]['maximo_real_t3']    = max($aRealT3) ? max($aRealT3) : 'NULL';
                
                if($aValores[0]['maximo_plan_t3'] == 'NULL' || $aValores[0]['maximo_real_t3'] == 'NULL')
                {
                    $aValores[0]['maximo_rp_t3'] = 'NULL';
                }
                else 
                {
                    $aValores[0]['maximo_rp_t3'] = $aValores[0]['maximo_real_t3'] / $aValores[0]['maximo_plan_t3'];
                }
                
                //Encontrar menor Plan do T4
                foreach($Plan as $k=>$v)
                {
                    if($k == 'octubre_plan' || $k == 'noviembre_plan' || $k == 'diciembre_plan')
                    {
                        $aPlanT4[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Encontrar menor Real do T4
                foreach($Real as $k=>$v)
                {
                    if($k == 'octubre_real' || $k == 'noviembre_real' || $k == 'diciembre_real')
                    {
                        $aRealT4[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Trimestre 4
                $aValores[0]['maximo_plan_t4']    = max($aPlanT4) ? max($aPlanT4) : 'NULL';
                $aValores[0]['maximo_real_t4']    = max($aRealT4) ? max($aRealT4) : 'NULL';
                
                if($aValores[0]['maximo_plan_t4'] == 'NULL' || $aValores[0]['maximo_real_t4'] == 'NULL')
                {
                    $aValores[0]['maximo_rp_t4'] = 'NULL';
                }
                else 
                {
                    $aValores[0]['maximo_rp_t4'] = $aValores[0]['maximo_real_t4'] / $aValores[0]['maximo_plan_t4'];
                }
                
                //Encontrar menor Plan do S1
                foreach($Plan as $k=>$v)
                {
                    if($k == 'enero_plan' || $k == 'febrero_plan' || $k == 'marzo_plan' || $k == 'abril_plan' || $k == 'mayo_plan' || $k == 'junio_plan')
                    {
                        $aPlanS1[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Encontrar menor Real do S1
                foreach($Real as $k=>$v)
                {
                    if($k == 'enero_real' || $k == 'febrero_real' || $k == 'marzo_real' || $k == 'abril_real' || $k == 'mayo_real' || $k == 'junio_real')
                    {
                        $aRealS1[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Semestre 1
                $aValores[0]['maximo_plan_s1']    = max($aPlanS1) ? max($aPlanS1) : 'NULL';
                $aValores[0]['maximo_real_s1']    = max($aRealS1) ? max($aRealS1) : 'NULL';
                
                if($aValores[0]['maximo_plan_s1'] == 'NULL' || $aValores[0]['maximo_real_s1'] == 'NULL')
                {
                    $aValores[0]['maximo_rp_s1'] = 'NULL';
                }
                else 
                {
                    $aValores[0]['maximo_rp_s1'] = $aValores[0]['maximo_real_s1'] / $aValores[0]['maximo_plan_s1'];
                }
                
                //Encontrar menor Plan do S2
                foreach($Plan as $k=>$v)
                {
                    if($k == 'julio_plan' || $k == 'agosto_plan' || $k == 'septiembre_plan' || $k == 'octubre_plan' || $k == 'noviembre_plan' || $k == 'diciembre_plan')
                    {
                        $aPlanS2[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Encontrar menor Real do S2
                foreach($Real as $k=>$v)
                {
                    if($k == 'julio_real' || $k == 'agosto_real' || $k == 'septiembre_real' || $k == 'octubre_real' || $k == 'noviembre_real' || $k == 'diciembre_real')
                    {
                        $aRealS2[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Semestre 2
                $aValores[0]['maximo_plan_s2']    = max($aPlanS2) ? max($aPlanS2) : 'NULL';
                $aValores[0]['maximo_real_s2']    = max($aRealS2) ? max($aRealS2) : 'NULL';
                
                if($aValores[0]['maximo_plan_s2'] == 'NULL' || $aValores[0]['maximo_real_s2'] == 'NULL')
                {
                    $aValores[0]['maximo_rp_s2'] = 'NULL';
                }
                else
                {
                    $aValores[0]['maximo_rp_s2'] = $aValores[0]['maximo_real_s2'] / $aValores[0]['maximo_plan_s2'];
                }
                
               
                $aValores[0]['id'] = $aParam['id'];
                
                //Metodo que grava os Maximos
                $aRetVal = $model->GravaMaximos($aValores);
            }
            
            //Recalcular e gravar o Ultimo deste Indicador
            if($tipo == 'Ultimo')
            {
                //Zera Valores para refazer o calculo de todos
                $aValores[0]['ultimo_plan_anual'] = 0;
                $aValores[0]['ultimo_real_anual'] = 0;
                $aValores[0]['ultimo_rp_anual']   = 0;
                $aValores[0]['ultimo_plan_t1']    = 0;
                $aValores[0]['ultimo_real_t1']    = 0;
                $aValores[0]['ultimo_rp_t1']      = 0;
                $aValores[0]['ultimo_plan_t2']    = 0;
                $aValores[0]['ultimo_real_t2']    = 0;
                $aValores[0]['ultimo_rp_t2']      = 0;
                $aValores[0]['ultimo_plan_t3']    = 0;
                $aValores[0]['ultimo_real_t3']    = 0;
                $aValores[0]['ultimo_rp_t3']      = 0;
                $aValores[0]['ultimo_plan_t4']    = 0;
                $aValores[0]['ultimo_real_t4']    = 0;
                $aValores[0]['ultimo_rp_t4']      = 0;
                $aValores[0]['ultimo_plan_s1']    = 0;
                $aValores[0]['ultimo_real_s1']    = 0;
                $aValores[0]['ultimo_rp_s1']      = 0;
                $aValores[0]['ultimo_plan_s2']    = 0;
                $aValores[0]['ultimo_real_s2']    = 0;
                $aValores[0]['ultimo_rp_s2']      = 0;
                
                //Inicio calculos
                //Metodo que busca os Planejados
                $Plan = $model->BuscaPlan($aParam['id']);
                $Plan =  (array) $Plan[0];
                
                //Remover os NULL
                foreach($Plan as $k=>$v)
                {
                    if($v == '')
                    {
                        unset($Plan[$k]);
                    }
                }
                //Troca index para pegar o ultimo mes preenchido
                $j = 0;
                foreach($Plan as $k=>$v)
                {
                    $aPlanejado[$j]['value'] = $v;
                    $aPlanejado[$j]['month'] = $k;
                    $j++;
                }
                
                //Metodo que busca os Reais
                $Real = $model->BuscaReal($aParam['id']);
                $Real =  (array) $Real[0];
                
                //Remover os NULL
                foreach($Real as $k=>$v)
                {
                    if($v == '')
                    {
                        unset($Real[$k]);
                    }
                }
                
                //Troca index para pegar o ultimo mes preenchido
                $i = 0;
                foreach($Real as $k=>$v)
                {
                    $aRealizado[$i]['value'] = $v;
                    $aRealizado[$i]['month'] = $k;
                    $i++;
                }
                
                //Captura o ultimo planejado e real
                $plan = end($aPlanejado);
                $real = end($aRealizado);
                
                //Ultimo Plan Anual
                $aValores[0]['ultimo_plan_anual'] = $plan['value'] ? $plan['value'] : 'NULL';
                $aValores[0]['ultimo_real_anual'] = $real['value'] ? $real['value'] : 'NULL';
                
                if($aValores[0]['ultimo_plan_anual'] == 'NULL' || $aValores[0]['ultimo_real_anual'] == 'NULL')
                {
                    $aValores[0]['ultimo_rp_anual']  = 'NULL';
                }
                else
                {
                    $aValores[0]['ultimo_rp_anual']   = $aValores[0]['ultimo_real_anual'] / $aValores[0]['ultimo_plan_anual'];
                }
                
                //Encontrar Ultimo Plan do T1
                foreach($Plan as $k=>$v)
                {
                    if($k == 'enero_plan' || $k == 'febrero_plan' || $k == 'marzo_plan')
                    {
                        $aPlanT1[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Troca index para pegar o ultimo mes preenchido
                $x = 0;
                foreach($aPlanT1 as $k=>$v)
                {
                    $aPlanejadoT1[$x]['value'] = $v;
                    $aPlanejadoT1[$x]['month'] = $k;
                    $x++;
                }
                
                //Captura o ultimo planejado T1
                $ultimoPlan = end($aPlanejadoT1);
                
                //Encontrar Ultimo Real do T1
                foreach($Real as $k=>$v)
                {
                    if($k == 'enero_real' || $k == 'febrero_real' || $k == 'marzo_real')
                    {
                        $aRealT1[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Troca index para pegar o ultimo mes preenchido
                $y = 0;
                foreach($aRealT1 as $k=>$v)
                {
                    $aRealizadoT1[$y]['value'] = $v;
                    $aRealizadoT1[$y]['month'] = $k;
                    $y++;
                }
                
                //Captura o ultimo Realizado T1
                $ultimoReal = end($aRealizadoT1);
                
                //Trimestre 1
                $aValores[0]['ultimo_plan_t1']    = $ultimoPlan['value'] ? $ultimoPlan['value'] : 'NULL';
                $aValores[0]['ultimo_real_t1']    = $ultimoReal['value'] ? $ultimoReal['value'] : 'NULL';
                
                if($aValores[0]['ultimo_plan_t1'] == 'NULL' || $aValores[0]['ultimo_real_t1'] == 'NULL')
                {
                    $aValores[0]['ultimo_rp_t1'] = 'NULL';
                }
                else
                {
                    $aValores[0]['ultimo_rp_t1'] = $aValores[0]['ultimo_real_t1'] / $aValores[0]['ultimo_plan_t1'];
                }
                
                //Encontrar Ultimo  Plan do T2
                foreach($Plan as $k=>$v)
                {
                    if($k == 'abril_plan' || $k == 'mayo_plan' || $k == 'junio_plan')
                    {
                        $aPlanT2[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Troca index para pegar o ultimo mes preenchido
                $x = 0;
                foreach($aPlanT2 as $k=>$v)
                {
                    $aPlanejadoT2[$x]['value'] = $v;
                    $aPlanejadoT2[$x]['month'] = $k;
                    $x++;
                }
                
                //Captura o ultimo planejado T2
                $ultimoPlanT2 = end($aPlanejadoT2);
                
                //Encontrar Ultimo Real do T2
                foreach($Real as $k=>$v)
                {
                    if($k == 'abril_real' || $k == 'mayo_real' || $k == 'junio_real')
                    {
                        $aRealT2[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Troca index para pegar o ultimo mes preenchido
                $y = 0;
                foreach($aRealT2 as $k=>$v)
                {
                    $aRealizadoT2[$y]['value'] = $v;
                    $aRealizadoT2[$y]['month'] = $k;
                    $y++;
                }
                
                //Captura o ultimo Realizado T2
                $ultimoRealT2 = end($aRealizadoT2);
                
                //Trimestre 2
                $aValores[0]['ultimo_plan_t2']    = $ultimoPlanT2['value'] ? $ultimoPlanT2['value'] : 'NULL';
                $aValores[0]['ultimo_real_t2']    = $ultimoRealT2['value'] ? $ultimoRealT2['value'] : 'NULL';
                
                if($aValores[0]['ultimo_plan_t2'] == 'NULL' || $aValores[0]['ultimo_real_t2'] == 'NULL')
                {
                    $aValores[0]['ultimo_rp_t2'] = 'NULL';
                }
                else
                {
                    $aValores[0]['ultimo_rp_t2'] = $aValores[0]['ultimo_real_t2'] / $aValores[0]['ultimo_plan_t2'];
                }
                
                //Encontrar Ultimo Plan do T3
                foreach($Plan as $k=>$v)
                {
                    if($k == 'julio_plan' || $k == 'agosto_plan' || $k == 'septiembre_plan')
                    {
                        $aPlanT3[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Troca index para pegar o ultimo mes preenchido
                $x = 0;
                foreach($aPlanT3 as $k=>$v)
                {
                    $aPlanejadoT3[$x]['value'] = $v;
                    $aPlanejadoT3[$x]['month'] = $k;
                    $x++;
                }
                
                //Captura o ultimo planejado T3
                $ultimoPlanT3 = end($aPlanejadoT3);
                
                //Encontrar menor Real do T3
                foreach($Real as $k=>$v)
                {
                    if($k == 'julio_real' || $k == 'agosto_real' || $k == 'septiembre_real')
                    {
                        $aRealT3[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Troca index para pegar o ultimo mes preenchido
                $y = 0;
                foreach($aRealT3 as $k=>$v)
                {
                    $aRealizadoT3[$y]['value'] = $v;
                    $aRealizadoT3[$y]['month'] = $k;
                    $y++;
                }
                
                //Captura o ultimo Realizado T3
                $ultimoRealT3 = end($aRealizadoT3);
                
                //Trimestre 3
                $aValores[0]['ultimo_plan_t3']    = $ultimoPlanT3['value'] ? $ultimoPlanT3['value'] : 'NULL';
                $aValores[0]['ultimo_real_t3']    = $ultimoRealT3['value'] ? $ultimoRealT3['value'] : 'NULL';
                
                if($aValores[0]['ultimo_plan_t3'] == 'NULL' || $aValores[0]['ultimo_real_t3'] == 'NULL')
                {
                    $aValores[0]['ultimo_rp_t3'] = 'NULL';
                }
                else
                {
                    $aValores[0]['ultimo_rp_t3'] = $aValores[0]['ultimo_real_t3'] / $aValores[0]['ultimo_plan_t3'];
                }
                
                //Encontrar menor Plan do T4
                foreach($Plan as $k=>$v)
                {
                    if($k == 'octubre_plan' || $k == 'noviembre_plan' || $k == 'diciembre_plan')
                    {
                        $aPlanT4[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Troca index para pegar o ultimo mes preenchido
                $x = 0;
                foreach($aPlanT4 as $k=>$v)
                {
                    $aPlanejadoT4[$x]['value'] = $v;
                    $aPlanejadoT4[$x]['month'] = $k;
                    $x++;
                }
                
                //Captura o ultimo planejado T4
                $ultimoPlanT4 = end($aPlanejadoT4);
                
                //Encontrar menor Real do T4
                foreach($Real as $k=>$v)
                {
                    if($k == 'octubre_real' || $k == 'noviembre_real' || $k == 'diciembre_real')
                    {
                        $aRealT4[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Troca index para pegar o ultimo mes preenchido
                $y = 0;
                foreach($aRealT4 as $k=>$v)
                {
                    $aRealizadoT4[$y]['value'] = $v;
                    $aRealizadoT4[$y]['month'] = $k;
                    $y++;
                }
                
                //Captura o ultimo Realizado T4
                $ultimoRealT4 = end($aRealizadoT4);
                
                //Trimestre 4
                $aValores[0]['ultimo_plan_t4']    = $ultimoPlanT4['value'] ? $ultimoPlanT4['value'] : 'NULL';
                $aValores[0]['ultimo_real_t4']    = $ultimoRealT4['value'] ? $ultimoRealT4['value'] : 'NULL';
                
                if($aValores[0]['ultimo_plan_t4'] == 'NULL' || $aValores[0]['ultimo_real_t4'] == 'NULL')
                {
                    $aValores[0]['ultimo_rp_t4'] = 'NULL';
                }
                else
                {
                    $aValores[0]['ultimo_rp_t4'] = $aValores[0]['ultimo_real_t4'] / $aValores[0]['ultimo_plan_t4'];
                }
                
                //Encontrar Ultimo Plan do S1
                foreach($Plan as $k=>$v)
                {
                    if($k == 'enero_plan' || $k == 'febrero_plan' || $k == 'marzo_plan' || $k == 'abril_plan' || $k == 'mayo_plan' || $k == 'junio_plan')
                    {
                        $aPlanS1[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Troca index para pegar o ultimo mes preenchido
                $x = 0;
                foreach($aPlanS1 as $k=>$v)
                {
                    $aPlanejadoS1[$x]['value'] = $v;
                    $aPlanejadoS1[$x]['month'] = $k;
                    $x++;
                }
                
                //Captura o ultimo planejado S1
                $ultimoPlanS1 = end($aPlanejadoS1);
                
                //Encontrar Ultimo Real do S1
                foreach($Real as $k=>$v)
                {
                    if($k == 'enero_real' || $k == 'febrero_real' || $k == 'marzo_real' || $k == 'abril_real' || $k == 'mayo_real' || $k == 'junio_real')
                    {
                        $aRealS1[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Troca index para pegar o ultimo mes preenchido
                $y = 0;
                foreach($aRealS1 as $k=>$v)
                {
                    $aRealizadoS1[$y]['value'] = $v;
                    $aRealizadoS1[$y]['month'] = $k;
                    $y++;
                }
                
                //Captura o ultimo Realizado S1
                $ultimoRealS1 = end($aRealizadoS1);
                
                //Semestre 1
                $aValores[0]['ultimo_plan_s1']    = $ultimoPlanS1['value'] ? $ultimoPlanS1['value'] : 'NULL';
                $aValores[0]['ultimo_real_s1']    = $ultimoRealS1['value'] ? $ultimoRealS1['value'] : 'NULL';
                
                if($aValores[0]['ultimo_plan_s1'] == 'NULL' || $aValores[0]['ultimo_real_s1'] == 'NULL')
                {
                    $aValores[0]['ultimo_rp_s1'] = 'NULL';
                }
                else
                {
                    $aValores[0]['ultimo_rp_s1'] = $aValores[0]['ultimo_real_s1'] / $aValores[0]['ultimo_plan_s1'];
                }
                
                //Encontrar menor Plan do S2
                foreach($Plan as $k=>$v)
                {
                    if($k == 'julio_plan' || $k == 'agosto_plan' || $k == 'septiembre_plan' || $k == 'octubre_plan' || $k == 'noviembre_plan' || $k == 'diciembre_plan')
                    {
                        $aPlanS2[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Troca index para pegar o ultimo mes preenchido
                $x = 0;
                foreach($aPlanS2 as $k=>$v)
                {
                    $aPlanejadoS2[$x]['value'] = $v;
                    $aPlanejadoS2[$x]['month'] = $k;
                    $x++;
                }
                
                //Captura o ultimo planejado S1
                $ultimoPlanS2 = end($aPlanejadoS2);
                
                //Encontrar menor Real do S2
                foreach($Real as $k=>$v)
                {
                    if($k == 'julio_real' || $k == 'agosto_real' || $k == 'septiembre_real' || $k == 'octubre_real' || $k == 'noviembre_real' || $k == 'diciembre_real')
                    {
                        $aRealS2[$k] = $v;
                    }
                    else
                    {
                        continue;
                    }
                }
                
                //Troca index para pegar o ultimo mes preenchido
                $y = 0;
                foreach($aRealS2 as $k=>$v)
                {
                    $aRealizadoS2[$y]['value'] = $v;
                    $aRealizadoS2[$y]['month'] = $k;
                    $y++;
                }
                
                //Captura o ultimo Realizado S1
                $ultimoRealS2 = end($aRealizadoS2);
                
                //Semestre 2
                $aValores[0]['ultimo_plan_s2']    = $ultimoPlanS2['value'] ? $ultimoPlanS2['value'] : 'NULL';
                $aValores[0]['ultimo_real_s2']    = $ultimoRealS2['value'] ? $ultimoRealS2['value'] : 'NULL';
                
                if($aValores[0]['ultimo_plan_s2'] == 'NULL' || $aValores[0]['ultimo_real_s2'] == 'NULL')
                {
                    $aValores[0]['ultimo_rp_s2'] = 'NULL';
                }
                else
                {
                    $aValores[0]['ultimo_rp_s2'] = $aValores[0]['ultimo_real_s2'] / $aValores[0]['ultimo_plan_s2'];
                }
                
                $aValores[0]['id'] = $aParam['id'];
                
                //Metodo que grava os Maximos
                $aRetVal = $model->GravaUltimo($aValores);
            }
        }
        
        if($aRetVal)
        {
            echo json_encode(array("results" => true));
        }
        else
        {
            echo json_encode(array("results" => false));
        }
    }
        
}