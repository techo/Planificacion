<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class GeneradorController extends BaseController
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
        $this->setPageTitle('Generador de Informes');
        $model = Container::getModel("Generador");
        
        $this->view->ano = $model->ListAnos();
               
        /* Render View Generador Informes */
        $this->renderView('generador/index', 'layout');
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
    
    public function CarregaPais($idplanificacion)
    {
        //Buscar Paises Planificados neste ano
        $id = (array) $idplanificacion;
        $id = $id['id'];
        
        $model = Container::getModel("Generador");
        
        //Busca paises
        $result = $model->BuscaPaises($id);
        
        $html .= '';
        $html .= '<div class="col-lg-6">';
        $html .= '<div class="form-group">';
        $html .= '<label class="font-noraml">Elija los Paises</label>';
        $html .= '<div class="input-group">';
        $html .= '<select data-placeholder="Elija los Paises" class="chosen-select" multiple style="width:350px;" tabindex="4">';
        foreach ($result as $pais)
        {
            $aRet = $this->GetPais($pais->id_pais);
            $html .= '<option class="combo1"id="'.$aRet['id'].'" value="'.$aRet['id'].'">'.$aRet['nombre'].'</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        echo ($html);
        
    }
    
    public function GeraIndicador($aParam)
    {
        $aParam = (array) $aParam;
        
        
        //Buscar Indicadores comuns a todos paises no ano selecionado
        $model  = Container::getModel("Generador");
        $result = $model->BuscaIndicadores($aParam);
        
        $html .= '';
        $html .= '<div class="form-group">';
        $html .= '<label class="font-noraml">Indicador</label>';
        $html .= '<div class="input-group">';
        $html .= '<select data-placeholder="Elija el Indicador." class="chosen-select" style="width:350px;" tabindex="2">';
        $html .= '<option value="">Seleccione</option>';
        foreach ($result as $indicador)
        {
            $html .= '<option class="combo2"id="'.$indicador->id.'" value="'.$indicador->id.'">'.$indicador->indicador.'</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        echo ($html);
        
    }
    
    public function GeraPais($aDados)
    {
        $aDados= (array) $aDados;
        
        $i = 0;
        
        //Separa os Ids dos paises
        $paises = explode(',',$aDados['paises']);
        $pais = array_filter($paises);
        
        $model  = Container::getModel("Generador");
        
        foreach ($pais as $pais)
        {
            //Nome do Pais
            $cPais = $this->GetPais($pais);
            $cPais = $cPais['nombre'];
            
            //Buscar Dados do Indicador selecionado de todos paises tambem selecionados
            $result = $model->BuscaValores($aDados, $pais);
            
            $tipo    = $result[0]->tipo;
            $id_pais = $pais;
            //Verifica tipo de Indicador para efetuar os calculos
            if($tipo == 'Acumulado')
            {
                foreach ($result as $indicador)
                {
                    //Anual
                    $aValores[$i]['pais']        = $cPais;
                    $aValores[$i]['Plan_anual'] += $indicador->acumulado_plan_anual;
                    $aValores[$i]['Real_anual'] += $indicador->acumulado_real_anual;
                    $aValores[$i]['RP_anual']   += $indicador->acumulado_rp_anual;
                    
                    //T1
                    $aValores[$i]['Plan_t1'] += $indicador->acumulado_plan_t1;
                    $aValores[$i]['Real_t1'] += $indicador->acumulado_real_t1;
                    $aValores[$i]['RP_t1']   += $indicador->acumulado_rp_t1;
                    
                    //T2
                    $aValores[$i]['Plan_t2'] += $indicador->acumulado_plan_t2;
                    $aValores[$i]['Real_t2'] += $indicador->acumulado_real_t2;
                    $aValores[$i]['RP_t2']   += $indicador->acumulado_rp_t2;
                    
                    //T3
                    $aValores[$i]['Plan_t3'] += $indicador->acumulado_plan_t3;
                    $aValores[$i]['Real_t3'] += $indicador->acumulado_real_t3;
                    $aValores[$i]['RP_t3']   += $indicador->acumulado_rp_t3;
                    
                    //T4
                    $aValores[$i]['Plan_t4'] += $indicador->acumulado_plan_t4;
                    $aValores[$i]['Real_t4'] += $indicador->acumulado_real_t4;
                    $aValores[$i]['RP_t4']   += $indicador->acumulado_rp_t4;
                    
                    //S1
                    $aValores[$i]['Plan_s1'] += $indicador->acumulado_plan_s1;
                    $aValores[$i]['Real_s1'] += $indicador->acumulado_real_s1;
                    $aValores[$i]['RP_s1']   += $indicador->acumulado_rp_s1;
                    
                    //S2
                    $aValores[$i]['Plan_s2'] += $indicador->acumulado_plan_s2;
                    $aValores[$i]['Real_s2'] += $indicador->acumulado_real_s2;
                    $aValores[$i]['RP_s2']   += $indicador->acumulado_rp_s2;
                }
            }
            
            //Promedio
            if($tipo == 'Promedio')
            {
                foreach ($result as $indicador)
                {
                    //Anual
                    $aValores[$i]['pais']        = $cPais;
                    $aValores[$i]['Plan_anual'] += $indicador->promedio_plan_anual;
                    $aValores[$i]['Real_anual'] += $indicador->promedio_real_anual;
                    $aValores[$i]['RP_anual']   += $indicador->promedio_rp_anual;
                    
                    //T1
                    $aValores[$i]['Plan_t1'] += $indicador->promedio_plan_t1;
                    $aValores[$i]['Real_t1'] += $indicador->promedio_real_t1;
                    $aValores[$i]['RP_t1']   += $indicador->promedio_rp_t1;
                    
                    //T2
                    $aValores[$i]['Plan_t2'] += $indicador->promedio_plan_t2;
                    $aValores[$i]['Real_t2'] += $indicador->promedio_real_t2;
                    $aValores[$i]['RP_t2']   += $indicador->promedio_rp_t2;
                    
                    //T3
                    $aValores[$i]['Plan_t3'] += $indicador->promedio_plan_t3;
                    $aValores[$i]['Real_t3'] += $indicador->promedio_real_t3;
                    $aValores[$i]['RP_t3']   += $indicador->promedio_rp_t3;
                    
                    //T4
                    $aValores[$i]['Plan_t4'] += $indicador->promedio_plan_t4;
                    $aValores[$i]['Real_t4'] += $indicador->promedio_real_t4;
                    $aValores[$i]['RP_t4']   += $indicador->promedio_rp_t4;
                    
                    //S1
                    $aValores[$i]['Plan_s1'] += $indicador->promedio_plan_s1;
                    $aValores[$i]['Real_s1'] += $indicador->promedio_real_s1;
                    $aValores[$i]['RP_s1']   += $indicador->promedio_rp_s1;
                    
                    //S2
                    $aValores[$i]['Plan_s2'] += $indicador->promedio_plan_s2;
                    $aValores[$i]['Real_s2'] += $indicador->promedio_real_s2;
                    $aValores[$i]['RP_s2']   += $indicador->promedio_rp_s2;
                    
                }
            }
            
            //Minimo
            if($tipo == 'Minimo')
            {
                foreach ($result as $indicador)
                {
                    //Anual
                    $aValores[$i]['pais']        = $cPais;
                    $aValores[$i]['Plan_anual'] += $indicador->minimo_plan_anual;
                    $aValores[$i]['Real_anual'] += $indicador->minimo_real_anual;
                    $aValores[$i]['RP_anual']   += $indicador->minimo_rp_anual;
                    
                    //T1
                    $aValores[$i]['Plan_t1'] += $indicador->minimo_plan_t1;
                    $aValores[$i]['Real_t1'] += $indicador->minimo_real_t1;
                    $aValores[$i]['RP_t1']   += $indicador->minimo_rp_t1;
                    
                    //T2
                    $aValores[$i]['Plan_t2'] += $indicador->minimo_plan_t2;
                    $aValores[$i]['Real_t2'] += $indicador->minimo_real_t2;
                    $aValores[$i]['RP_t2']   += $indicador->minimo_rp_t2;
                    
                    //T3
                    $aValores[$i]['Plan_t3'] += $indicador->minimo_plan_t3;
                    $aValores[$i]['Real_t3'] += $indicador->minimo_real_t3;
                    $aValores[$i]['RP_t3']   += $indicador->minimo_rp_t3;
                    
                    //T4
                    $aValores[$i]['Plan_t4'] += $indicador->minimo_plan_t4;
                    $aValores[$i]['Real_t4'] += $indicador->minimo_real_t4;
                    $aValores[$i]['RP_t4']   += $indicador->minimo_rp_t4;
                    
                    //S1
                    $aValores[$i]['Plan_s1'] += $indicador->minimo_plan_s1;
                    $aValores[$i]['Real_s1'] += $indicador->minimo_real_s1;
                    $aValores[$i]['RP_s1']   += $indicador->minimo_rp_s1;
                    
                    //S2
                    $aValores[$i]['Plan_s2'] += $indicador->minimo_plan_s2;
                    $aValores[$i]['Real_s2'] += $indicador->minimo_real_s2;
                    $aValores[$i]['RP_s2']   += $indicador->minimo_rp_s2;
                    
                }
            }
            
            //Minimo
            if($tipo == 'Maximo')
            {
                foreach ($result as $indicador)
                {
                    //Anual
                    $aValores[$i]['pais']        = $cPais;
                    $aValores[$i]['Plan_anual'] += $indicador->maximo_plan_anual;
                    $aValores[$i]['Real_anual'] += $indicador->maximo_real_anual;
                    $aValores[$i]['RP_anual']   += $indicador->maximo_rp_anual;
                    
                    //T1
                    $aValores[$i]['Plan_t1'] += $indicador->maximo_plan_t1;
                    $aValores[$i]['Real_t1'] += $indicador->maximo_real_t1;
                    $aValores[$i]['RP_t1']   += $indicador->maximo_rp_t1;
                    
                    //T2
                    $aValores[$i]['Plan_t2'] += $indicador->maximo_plan_t2;
                    $aValores[$i]['Real_t2'] += $indicador->maximo_real_t2;
                    $aValores[$i]['RP_t2']   += $indicador->maximo_rp_t2;
                    
                    //T3
                    $aValores[$i]['Plan_t3'] += $indicador->maximo_plan_t3;
                    $aValores[$i]['Real_t3'] += $indicador->maximo_real_t3;
                    $aValores[$i]['RP_t3']   += $indicador->maximo_rp_t3;
                    
                    //T4
                    $aValores[$i]['Plan_t4'] += $indicador->maximo_plan_t4;
                    $aValores[$i]['Real_t4'] += $indicador->maximo_real_t4;
                    $aValores[$i]['RP_t4']   += $indicador->maximo_rp_t4;
                    
                    //S1
                    $aValores[$i]['Plan_s1'] += $indicador->maximo_plan_s1;
                    $aValores[$i]['Real_s1'] += $indicador->maximo_real_s1;
                    $aValores[$i]['RP_s1']   += $indicador->maximo_rp_s1;
                    
                    //S2
                    $aValores[$i]['Plan_s2'] += $indicador->maximo_plan_s2;
                    $aValores[$i]['Real_s2'] += $indicador->maximo_real_s2;
                    $aValores[$i]['RP_s2']   += $indicador->maximo_rp_s2;
                    
                }
            }
            
            //Ultimo
            if($tipo == 'Ultimo')
            {
                foreach ($result as $indicador)
                {
                    //Anual
                    $aValores[$i]['pais']        = $cPais;
                    $aValores[$i]['Plan_anual'] += $indicador->ultimo_plan_anual;
                    $aValores[$i]['Real_anual'] += $indicador->ultimo_real_anual;
                    $aValores[$i]['RP_anual']   += $indicador->ultimo_rp_anual;
                    
                    //T1
                    $aValores[$i]['Plan_t1'] += $indicador->ultimo_plan_t1;
                    $aValores[$i]['Real_t1'] += $indicador->ultimo_real_t1;
                    $aValores[$i]['RP_t1']   += $indicador->ultimo_rp_t1;
                    
                    //T2
                    $aValores[$i]['Plan_t2'] += $indicador->ultimo_plan_t2;
                    $aValores[$i]['Real_t2'] += $indicador->ultimo_real_t2;
                    $aValores[$i]['RP_t2']   += $indicador->ultimo_rp_t2;
                    
                    //T3
                    $aValores[$i]['Plan_t3'] += $indicador->ultimo_plan_t3;
                    $aValores[$i]['Real_t3'] += $indicador->ultimo_real_t3;
                    $aValores[$i]['RP_t3']   += $indicador->ultimo_rp_t3;
                    
                    //T4
                    $aValores[$i]['Plan_t4'] += $indicador->ultimo_plan_t4;
                    $aValores[$i]['Real_t4'] += $indicador->ultimo_real_t4;
                    $aValores[$i]['RP_t4']   += $indicador->ultimo_rp_t4;
                    
                    //S1
                    $aValores[$i]['Plan_s1'] += $indicador->ultimo_plan_s1;
                    $aValores[$i]['Real_s1'] += $indicador->ultimo_real_s1;
                    $aValores[$i]['RP_s1']   += $indicador->ultimo_rp_s1;
                    
                    //S2
                    $aValores[$i]['Plan_s2'] += $indicador->ultimo_plan_s2;
                    $aValores[$i]['Real_s2'] += $indicador->ultimo_real_s2;
                    $aValores[$i]['RP_s2']   += $indicador->ultimo_rp_s2;
                    
                }
            }
            
            
            $i++;
        }
        echo json_encode(array("data" => $aValores));
    }
}

