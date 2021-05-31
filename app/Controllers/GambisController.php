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
    
    public function DataStudio($request)
    {
        $aRequest = (array) $request;
        
        $this->setPageTitle('API');
        $model = Container::getModel("Gambis");
        
        //Agarra el ano corriente para buscar id de la planificacion actual
        $ano = date("Y");
        
        // Año corriente
        if($aRequest[0] == $ano)
        {
            $ano = date("Y");
        }
        else // Años Passados
        {
            $ano = $aRequest[0];
        }
        
        $aRet = $model->GetAno($ano);
        
        if(empty($aRet))
        {
            echo('Planificacion del ano ' . $ano . ' no fue localizada!');
        }
        
        $id = $aRet[0]->id;
        
        //Agarra id cPlanificacion
        $aPlan = $model->GetPlanificacion($id);
        
        $aDados = $model->DataStudio($aPlan[0]->id);
        
        for($i=0; $i < count($aDados); $i++)
        {
            $linha = (array) $aDados[$i];
            
            //All Information
            $aNew[$i]['Country']    = $linha['pais'];
            $aNew[$i]['Year']       = $ano;
            $aNew[$i]['Kpi']        = $linha['indicador'];
            $aNew[$i]['Type']       = $linha['tipo'];
            $aNew[$i]['T1P']        = $linha['T1P'];
            $aNew[$i]['T1R']        = $linha['T1R'];
            $aNew[$i]['T1C']        = $linha['T1C'];
            $aNew[$i]['T2P']        = $linha['T2P'];
            $aNew[$i]['T2R']        = $linha['T2R'];
            $aNew[$i]['T2C']        = $linha['T2C'];
            $aNew[$i]['T3P']        = $linha['T3P'];
            $aNew[$i]['T3R']        = $linha['T3R'];
            $aNew[$i]['T3C']        = $linha['T3C'];
            $aNew[$i]['T4P']        = $linha['T4P'];
            $aNew[$i]['T4R']        = $linha['T4R'];
            $aNew[$i]['T4C']        = $linha['T4C'];
            $aNew[$i]['AnualP']     = $linha['AnualP'];
            $aNew[$i]['AnualR']     = $linha['AnualR'];
            
            //Enero
            $aNew[$i]['Jan-Month']  = '01';
            $aNew[$i]['Jan-Plan']   = $linha['enero_plan'];
            $aNew[$i]['Jan-Real']   = $linha['enero_real'];
            
            //Febrero
            $aNew[$i]['Feb-Month']  = '02';
            $aNew[$i]['Feb-Plan']   = $linha['febrero_plan'];
            $aNew[$i]['Feb-Real']   = $linha['febrero_real'];
            
            //Marzo
            $aNew[$i]['Mar-Month']  = '03';
            $aNew[$i]['Mar-Plan']   = $linha['marzo_plan'];
            $aNew[$i]['Mar-Real']   = $linha['marzo_real'];
            
            //Abril
            $aNew[$i]['Apr-Month']  = '04';
            $aNew[$i]['Apr-Plan']   = $linha['abril_plan'];
            $aNew[$i]['Apr-Real']   = $linha['abril_real'];
            
            //Mayo
            $aNew[$i]['May-Month']  = '05';
            $aNew[$i]['May-Plan']   = $linha['mayo_plan'];
            $aNew[$i]['May-Real']   = $linha['mayo_real'];
            
            //Junio
            $aNew[$i]['Jun-Month']  = '06';
            $aNew[$i]['Jun-Plan']   = $linha['junio_plan'];
            $aNew[$i]['Jun-Real']   = $linha['junio_real'];
            
            //Julio
            $aNew[$i]['Jun-Month']  = '07';
            $aNew[$i]['Jun-Plan']   = $linha['julio_plan'];
            $aNew[$i]['Jun-Real']   = $linha['julio_real'];
            
            //Agosto
            $aNew[$i]['Aug-Month']  = '08';
            $aNew[$i]['Aug-Plan']   = $linha['agosto_plan'];
            $aNew[$i]['Aug-Real']   = $linha['agosto_real'];
            
            //Septiembre
            $aNew[$i]['Sep-Month']  = '09';
            $aNew[$i]['Sep-Plan']   = $linha['septiembre_plan'];
            $aNew[$i]['Sep-Real']   = $linha['septiembre_real'];
            
            //Octubre
            $aNew[$i]['Oct-Month']  = '10';
            $aNew[$i]['Oct-Plan']   = $linha['octubre_plan'];
            $aNew[$i]['Oct-Real']   = $linha['octubre_real'];
            
            //Noviembre
            $aNew[$i]['Nov-Month']  = '11';
            $aNew[$i]['Nov-Plan']   = $linha['noviembre_plan'];
            $aNew[$i]['Nov-Real']   = $linha['noviembre_real'];
            
            //Diciembre
            $aNew[$i]['Dec-Month']  = '12';
            $aNew[$i]['Dec-Plan']   = $linha['diciembre_plan'];
            $aNew[$i]['Dec-Real']   = $linha['diciembre_real']; 
        }
        
        echo(json_encode($aNew));
   }
   
   public function GraphicsData($request)
   {
       $aRequest = (array) $request;
       
       $this->setPageTitle('API');
       $model = Container::getModel("Gambis");
       
       //Agarra el ano corriente para buscar id de la planificacion actual
       $ano = date("Y");
       
       // Año corriente
       if($aRequest[0] == $ano)
       {
           $ano = date("Y");
       }
       else // Años Passados
       {
           $ano = $aRequest[0];
       }
       
       $aRet = $model->GetAno($ano);
       
       if(empty($aRet))
       {
           echo('Planificacion del ano ' . $ano . ' no fue localizada!');
       }
       
       $id = $aRet[0]->id;
       
       //Agarra id cPlanificacion
       $aPlan = $model->GetPlanificacion($id);
       
       $aDados = $model->DataStudio($aPlan[0]->id);
       
       for($i=0; $i < count($aDados); $i++)
       {
           $linha = (array) $aDados[$i];
           
           // Enero
           if(!empty($linha['enero_plan']) || !empty($linha['enero_real']))
           {
               $aNew[$i]['date']        = '01/'.$ano;
               $aNew[$i]['Country']     = $linha['pais'];
               $aNew[$i]['Kpi']         = $linha['indicador'];
               $aNew[$i]['Planificado'] = $linha['enero_plan'];
               $aNew[$i]['Real']        = $linha['enero_real'];
           }
           
           //Febrero
           if(!empty($linha['febrero_plan']) || !empty($linha['febrero_real']))
           {
               $aNew[$i]['date']        ='02/'.$ano;
               $aNew[$i]['Country']     = $linha['pais'];
               $aNew[$i]['Kpi']         = $linha['indicador'];
               $aNew[$i]['Planificado'] = $linha['febrero_plan'];
               $aNew[$i]['Real']        = $linha['febrero_real'];
           }
           
           //Marzo
           if(!empty($linha['marzo_plan']) || !empty($linha['marzo_real']))
           {
               $aNew[$i]['date']        = '03/'.$ano;
               $aNew[$i]['Country']     = $linha['pais'];
               $aNew[$i]['Kpi']         = $linha['indicador'];
               $aNew[$i]['Planificado'] = $linha['marzo_plan'];
               $aNew[$i]['Real']        = $linha['marzo_real'];
           }
           
           //Abril
           if(!empty($linha['abril_plan']) || !empty($linha['abril_real']))
           {
               $aNew[$i]['date']        = '04/'.$ano;
               $aNew[$i]['Country']     = $linha['pais'];
               $aNew[$i]['Kpi']         = $linha['indicador'];
               $aNew[$i]['Planificado'] = $linha['abril_plan'];
               $aNew[$i]['Real']        = $linha['abril_real'];
           }
           
           //Mayo
           if(!empty($linha['mayo_plan']) || !empty($linha['mayo_real']))
           {
               $aNew[$i]['date']        = '05/'.$ano;
               $aNew[$i]['Country']     = $linha['pais'];
               $aNew[$i]['Kpi']         = $linha['indicador'];
               $aNew[$i]['Planificado'] = $linha['mayo_plan'];
               $aNew[$i]['Real']        = $linha['mayo_real'];
           }
           
           //Junio
           if(!empty($linha['junio_plan']) || !empty($linha['junio_real']))
           {
               $aNew[$i]['date']        = '06/'.$ano;
               $aNew[$i]['Country']     = $linha['pais'];
               $aNew[$i]['Kpi']         = $linha['indicador'];
               $aNew[$i]['Planificado'] = $linha['junio_plan'];
               $aNew[$i]['Real']        = $linha['junio_real'];
           }
           
           //Julio
           if(!empty($linha['julio_plan']) || !empty($linha['julio_real']))
           {
               $aNew[$i]['date']        = '07/'.$ano;
               $aNew[$i]['Country']     = $linha['pais'];
               $aNew[$i]['Kpi']         = $linha['indicador'];
               $aNew[$i]['Planificado'] = $linha['julio_plan'];
               $aNew[$i]['Real']        = $linha['julio_real'];
           }
           
           //Agosto
           if(!empty($linha['agosto_plan']) || !empty($linha['agosto_real']))
           {
               $aNew[$i]['date']        = '08/'.$ano;
               $aNew[$i]['Country']     = $linha['pais'];
               $aNew[$i]['Kpi']         = $linha['indicador'];
               $aNew[$i]['Planificado'] = $linha['agosto_plan'];
               $aNew[$i]['Real']        = $linha['agosto_real'];
           }
           
           //Septiembre
           if(!empty($linha['septiembre_plan']) || !empty($linha['septiembre_real']))
           {
               $aNew[$i]['date']        = '09/'.$ano;
               $aNew[$i]['Country']     = $linha['pais'];
               $aNew[$i]['Kpi']         = $linha['indicador'];
               $aNew[$i]['Planificado'] = $linha['septiembre_plan'];
               $aNew[$i]['Real']        = $linha['septiembre_real'];
           }
           
           //Octubre
           if(!empty($linha['octubre_plan']) || !empty($linha['octubre_real']))
           {
               $aNew[$i]['date']        = '10/'.$ano;
               $aNew[$i]['Country']     = $linha['pais'];
               $aNew[$i]['Kpi']         = $linha['indicador'];
               $aNew[$i]['Planificado'] = $linha['octubre_plan'];
               $aNew[$i]['Real']        = $linha['octubre_real'];
           }
           
           //Noviembre
           if(!empty($linha['noviembre_plan']) || !empty($linha['noviembre_real']))
           {
               $aNew[$i]['date']        = '11/'.$ano;
               $aNew[$i]['Country']     = $linha['pais'];
               $aNew[$i]['Kpi']         = $linha['indicador'];
               $aNew[$i]['Planificado'] = $linha['noviembre_plan'];
               $aNew[$i]['Real']        = $linha['noviembre_real'];
           }
           
           //Diciembre
           if(!empty($linha['diciembre_plan']) || !empty($linha['diciembre_real']))
           {
               $aNew[$i]['date']        = '12/'.$ano;
               $aNew[$i]['Country']     = $linha['pais'];
               $aNew[$i]['Kpi']         = $linha['indicador'];
               $aNew[$i]['Planificado'] = $linha['diciembre_plan'];
               $aNew[$i]['Real']        = $linha['diciembre_real'];
           }
           
       }
       
       $out = array_values($aNew);
       echo(json_encode($out));
   }
   
   public function GetOficial($request)
   {
       $aRequest = (array) $request;
       
   /*    $aInfo[1]['Pais']  = 'Brasil';
       $aInfo[1]['Valor'] = '100.00';
       $aInfo[1]['Data']  = '2021-01-01';
       
       $aInfo[2]['Pais']  = 'EUA';
       $aInfo[2]['Valor'] = '500.40';
       $aInfo[2]['Data']  = '2021-02-01';
       
       $aInfo[3]['Pais']  = 'Guatemala';
       $aInfo[3]['Valor'] = '50.20';
       $aInfo[3]['Data']  = '2021-03-01';
       
       $aInfo[4]['Pais']  = 'Espanha';
       $aInfo[4]['Valor'] = '120.50';
       $aInfo[4]['Data']  = '2021-04-01';
       
       $out = array_values($aInfo);
       echo(json_encode($out));
       die();
     */  
      // $aPaises = [1,3,4,6,7,8,9,10,11,12,13,15,16,17,18,19,21];
      
       $aPaises = [1];
       
       $this->setPageTitle('API');
       $model = Container::getModel("Gambis");
       
       //Agarra el ano corriente para buscar id de la planificacion actual
       $ano = date("Y");
       
       // Año corriente
       if($aRequest[0] == $ano)
       {
           $ano = date("Y");
       }
       else // Años Passados
       {
           $ano = $aRequest[0];
       }
       
       $aRet = $model->GetAno($ano);
       
       if(empty($aRet))
       {
           echo('Planificacion del ano ' . $ano . ' no fue localizada!');
       }
       
       $id = $aRet[0]->id;
       
       //Agarra id cPlanificacion
       $aPlan = $model->GetPlanificacion($id);
       
       $aCompleto = array();
       
       foreach ($aPaises as $idpais)
       {
           $aDados = $model->OficialData($aPlan[0]->id, $idpais);
           
           for($i=0; $i < count($aDados); $i++)
           {
               $linha = (array) $aDados[$i];
               
               $res = preg_replace('/[^a-zA-Z0-9_ -]/s','',$linha['indicador']);
               $string = str_replace(' ', '_', $res);
               
               
                 $aNew[01]['country']              = $linha['pais'];
                 $aNew[01]['dt']                   = $ano.'-01-01';
                 $aNew[01][$string.'_Planificado'] = $linha['enero_plan'] ? $linha['enero_plan'] : '0.00';
                 $aNew[01][$string.'_Realizado']   = $linha['enero_real'] ? $linha['enero_real'] : '0.00';
                 
                 $aNew[02]['country']              = $linha['pais'];
                 $aNew[02]['dt']                   = $ano.'-02-01';
                 $aNew[02][$string.'_Planificado'] = $linha['febrero_plan'] ? $linha['febrero_plan'] : '0.00';
                 $aNew[02][$string.'_Realizado']   = $linha['febrero_real'] ? $linha['febrero_real'] : '0.00';
                 
                 $aNew[03]['country']              = $linha['pais'];
                 $aNew[03]['dt']                   = $ano.'-03-01';
                 $aNew[03][$string.'_Planificado'] = $linha['marzo_plan'] ? $linha['marzo_plan'] : '0.00';
                 $aNew[03][$string.'_Realizado']   = $linha['marzo_real'] ? $linha['marzo_real'] : '0.00';
                 
                 $aNew[04]['country']              = $linha['pais'];
                 $aNew[04]['dt']                   = $ano.'-04-01';
                 $aNew[04][$string.'_Planificado'] = $linha['abril_plan'] ? $linha['abril_plan'] : '0.00';
                 $aNew[04][$string.'_Realizado']   = $linha['abril_real'] ? $linha['abril_real'] : '0.00';
                 
                 $aNew[05]['country']              = $linha['pais'];
                 $aNew[05]['dt']                   = $ano.'-05-01';
                 $aNew[05][$string.'_Planificado'] = $linha['mayo_plan'] ? $linha['mayo_plan'] : '0.00';
                 $aNew[05][$string.'_Realizado']   = $linha['mayo_real'] ? $linha['mayo_real'] : '0.00';
                 
                 $aNew[06]['country']              = $linha['pais'];
                 $aNew[06]['dt']                   = $ano.'-06-01';
                 $aNew[06][$string.'_Planificado'] = $linha['junio_plan'] ? $linha['junio_plan'] : '0.00';
                 $aNew[06][$string.'_Realizado']   = $linha['junio_real'] ? $linha['junio_real'] : '0.00';
                 
                 $aNew[07]['country']              = $linha['pais'];
                 $aNew[07]['dt']                   = $ano.'-07-01';
                 $aNew[07][$string.'_Planificado'] = $linha['julio_plan'] ? $linha['julio_plan'] : '0.00';
                 $aNew[07][$string.'_Realizado']   = $linha['julio_real'] ? $linha['julio_real'] : '0.00';
                 
                 $aNew[8]['country']              = $linha['pais'];
                 $aNew[8]['dt']                   = $ano.'-08-01';
                 $aNew[8][$string.'_Planificado'] = $linha['agosto_plan'] ? $linha['agosto_plan'] : '0.00';
                 $aNew[8][$string.'_Realizado']   = $linha['agosto_real'] ? $linha['agosto_real'] : '0.00';
                 
                 $aNew[9]['country']              = $linha['pais'];
                 $aNew[9]['dt']                   = $ano.'-09-01';
                 $aNew[9][$string.'_Planificado'] = $linha['septiembre_plan'] ? $linha['septiembre_plan'] : '0.00';
                 $aNew[9][$string.'_Realizado']   = $linha['septiembre_real'] ? $linha['septiembre_real'] : '0.00';
                 
                 $aNew[10]['country']              = $linha['pais'];
                 $aNew[10]['dt']                   = $ano.'-10-01';
                 $aNew[10][$string.'_Planificado'] = $linha['octubre_plan'] ? $linha['octubre_plan'] : '0.00';
                 $aNew[10][$string.'_Realizado']   = $linha['octubre_real'] ? $linha['octubre_real'] : '0.00';
                 
                 $aNew[11]['country']              = $linha['pais'];
                 $aNew[11]['dt']                   = $ano.'-11-01';
                 $aNew[11][$string.'_Planificado'] = $linha['noviembre_plan'] ? $linha['noviembre_plan'] : '0.00';
                 $aNew[11][$string.'_Realizado']   = $linha['noviembre_real'] ? $linha['noviembre_real'] : '0.00';
                 
                 $aNew[12]['country']              = $linha['pais'];
                 $aNew[12]['dt']                   = $ano.'-12-01';
                 $aNew[12][$string.'_Planificado'] = $linha['diciembre_plan'] ? $linha['diciembre_plan'] : '0.00';
                 $aNew[12][$string.'_Realizado']   = $linha['diciembre_real'] ? $linha['diciembre_real'] : '0.00';
                 
                 
           }
           
           $aCompleto = array_merge($aCompleto, $aNew);
       }
       
       $out = array_values($aCompleto);
       echo(json_encode($aCompleto));
   }
   
   public function sanitizeString($str) {
       $str = preg_replace('/[áàãâä]/ui', 'a', $str);
       $str = preg_replace('/[éèêë]/ui', 'e', $str);
       $str = preg_replace('/[íìîï]/ui', 'i', $str);
       $str = preg_replace('/[óòõôö]/ui', 'o', $str);
       $str = preg_replace('/[úùûü]/ui', 'u', $str);
       $str = preg_replace('/[ç]/ui', 'c', $str);
       // $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
       $str = preg_replace('/[^a-z0-9]/i', '_', $str);
       $str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
       return $str;
   }
    
}