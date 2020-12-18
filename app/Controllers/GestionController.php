<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class GestionController extends BaseController
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
        $this->setPageTitle('Gestion  y Tendencias');
        $model = Container::getModel("Gestion");
        $this->renderView('gestion/index', 'layout');
    }
    
    public function pilares()
    {
        $this->setPageTitle('Visual por Pilares');
        
        //Busca Anos
        $model = Container::getModel("TInforme");
        $this->view->ano = $model->ListAnos();
        $this->renderView('gestion/pilares', 'layout');
    }
    
    public function Paises()
    {
        $url = 'http://id.techo.org/pais?api=true&token='.$_SESSION['Planificacion']['token'];
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CAINFO, getcwd() . DIRECTORY_SEPARATOR . 'cacert.pem');
        
        $output = curl_exec($curl);
        curl_close($curl);
        
        $data = json_decode($output, true);
        
        for($i=0; $i < count($data); $i++)
        {
            $aTemp[$i]['id']   = $data[$i]['ID_Pais'];
            $aTemp[$i]['pais'] = $data[$i]['Nombre_Pais'];
        }
        return $aTemp;
    }
    
    public function Sedes($idPais)
    {
        $url = 'http://id.techo.org/sede?api=true&token='.$_SESSION['Planificacion']['token'].'&id_pais='.$idPais;
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CAINFO, getcwd() . DIRECTORY_SEPARATOR . 'cacert.pem');
        
        $output = curl_exec($curl);
        curl_close($curl);
        
        $data = json_decode($output, true);
        
        for($i=0; $i < count($data); $i++)
        {
            $aTemp[$i]['id']   = $data[$i]['id'];
            $aTemp[$i]['sede'] = $data[$i]['nombre'];
        }
        
        return $aTemp;
    }
    
    public function SelectBoxPais()
    {
        $aRet = $this->Paises();
        
        $html .= '<select class="form-control" name="pais" id="pais">';
        $html .= '<option value="0">-- SELECCIONE --</option>';
        foreach ($aRet as $pais)
        {
            if($pais['pais'] == 'Oficina Internacional' || $pais['pais'] == 'Europa' || $pais['pais'] == 'Nicaragua')
            {
                continue;
            }
            else
            {
                $html.= '<option value="'.$pais['id'].'">'.$pais['pais'].'</option>';
            }
            
        }
        $html .= '</select>';
        
        echo ($html);
    }
    
    public function SelectBoxSede($idPais)
    {
        $aRet = $this->Sedes($idPais);
        
        $html .= '<p><label for="sedes"><strong>Elija la Sede:</label></strong><p>';
        $html .= '<select class="form-control" id="sedes">';
        $html .= '<option value="0">-- SELECCIONE --</option>';
        foreach ($aRet as $sede)
        {
            $html.= '<option value="'.$sede['id'].'">'.$sede['sede'].'</option>';
        }
        $html .= '</select>';
        
        echo ($html);
    }
    
    public function DadosPais($idPais,$idCPlanificacion)
    {
        $aParam['idCPlanificacion']  = $idCPlanificacion;
        $aParam['idPais'] = $idPais;
        
        $model   = Container::getModel("Gestion");
        $result = $model->DadosPais($aParam);
        
        $i = 0;
        foreach($result as $k=>$v)
        {
            if($v->tipo == 'Acumulado')
            {
                $aRegistro[$i]['Indicador'] = $v->KPI;
                $aRegistro[$i]['Tipo']      = $v->tipo;

                $aRegistro[$i]['T1P']       = $v->Enero_Plan + $v->Febrero_Plan + $v->Marzo_Plan;
                $aRegistro[$i]['T2P']       = $v->Abril_Plan + $v->Mayo_Plan    + $v->Junio_Plan;
                $aRegistro[$i]['T3P']       = $v->Julio_Plan + $v->Agosto_Plan  + $v->Septiembre_Plan;
                $aRegistro[$i]['T4P']       = $v->Octubre_Plan + $v->Noviembre_Plan + $v->Diciembre_Plan;
                
                $teste['Abril'] = $v->Abril_Plan;
                $teste['Mayo']  = $v->Mayo_Plan;
                $teste['Junio'] = $v->Junio_Plan;
                
            }
            elseif($v->tipo == 'Ultimo')
            {
                $aRegistro[$i]['Indicador'] = $v->KPI;
                $aRegistro[$i]['Tipo']      = $v->tipo;
                /* Planejado Trimestre 1 Tipo Ultimo */
                if($v->Enero_Plan)
                {
                    $aRegistro[$i]['T1P'] = $v->Enero_Marzo;
                }
                elseif($v->Febrero_Plan)
                {
                    $aRegistro[$i]['T1P'] = $v->Febrero_Plan;
                }
                elseif($v->Marzo_Plan)
                {
                    $aRegistro[$i]['T1P'] = $v->Marzo_Plan;
                }
                
                /* Planejado Trimestre 2 Tipo Ultimo */
                if($v->Abril_Plan)
                {
                    $aRegistro[$i]['T2P'] = $v->Abril_Plan;
                }
                elseif($v->Mayo_Plan)
                {
                    $aRegistro[$i]['T2P'] = $v->Mayo_Plan;
                }
                elseif($v->Junio_Plan)
                {
                    $aRegistro[$i]['T2P'] = $v->Junio_Plan;
                }
                
                /* Planejado Trimestre 3 Tipo Ultimo */
                if($v->Julio_Plan)
                {
                    $aRegistro[$i]['T3P'] = $v->Julio_Plan;
                }
                elseif($v->Agosto_Plan)
                {
                    $aRegistro[$i]['T3P'] = $v->Agosto_Plan;
                }
                elseif($v->Septiembre_Plan)
                {
                    $aRegistro[$i]['T3P'] = $v->Septiembre_Plan;
                }
                
                /* Planejado Trimestre 3 Tipo Ultimo */
                if($v->Octubre_Plan)
                {
                    $aRegistro[$i]['T4P'] = $v->Octubre_Plan;
                }
                elseif($v->Noviembre_Plan)
                {
                    $aRegistro[$i]['T4P'] = $v->Noviembre_Plan;
                }
                elseif($v->Diciembre_Plan)
                {
                    $aRegistro[$i]['T4P'] = $v->Diciembre_Plan;
                }
            }
            
            $i++;
        }
        
        echo('<pre>');
        die(print_r($aRegistro, true));
        
        
        if($result)
        {
            echo json_encode(array("results" => true));
        }
        else
        {
            echo json_encode(array("results" => false));
        }
    }
    
}