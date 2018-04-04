<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class CPlanificacionController extends BaseController
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
        $this->setPageTitle('Create Planificacion');
        $model = Container::getModel("CPlanificacion");
        $this->view->cplanificacion = $model->select();
        
        for($i=0; $i < count($this->view->cplanificacion); $i++)
        {
            $aKPI[$i] = (array) $this->view->cplanificacion[$i];
            
            //Get Pais
            if($aKPI[$i]['id_pais'])
            {
                $pais = $this->GetPais($aKPI[$i]['id_pais']);
                $aKPI[$i]['pais'] = $pais['nombre'];
            }
            
            //Get Sede
            if($aKPI[$i]['id_sede'])
            {
                $sede = $this->GetSede($aKPI[$i]['id_sede']);
                $aKPI[$i]['sede'] = $sede[0]['nombre'];
            }
            
            $this->view->cplanificacion[$i] = (object) $aKPI[$i];
        }
        
        /* Render View Paises */
        $this->renderView('cplanificacion/index', 'layout');
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
        
        //  echo json_encode(array("values" => $aTemp));
        return $aTemp;
    }
    
    //Apos selecionar Pais no Cadastro de Indicadores, lista as sedes do Pais
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
        
        //  echo json_encode(array("values" => $aTemp));
        return $aTemp;
    }
    
    public function SearchSede($idPais)
    {
        $id = (array) $idPais;
        $id = $id['id'];
        
        //Busca Area
        $result = $this->Sedes($id);
        
        $html .= '<div class="col-lg-6">';
        $html .= '<div class="form-group">';
        $html .= '<label for="sede">Sede</label>';
        $html .= '<select  id="sede" class="form-control" >';
        $html .= '<option value="0">-- SELECCIONE --</option>';
        foreach ($result as $sede)
        {
            $html.= '<option value="'.$sede['id'].'">'.$sede['sede'].'</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        
        echo ($html);
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
    
    public function add()
    {
        $this->setPageTitle('Crear Planificacion');
        $model = Container::getModel("cplanificacion");
        
        //Busca Anos
        $this->view->ano = $model->ListaAno();
        
        //Busca Pais
        $pais = $this->Paises();
        
        //Convert Array en Object
        for($i=0; $i < count($pais); $i++)
        {
            $pais[$i] = (object) $pais[$i];
        }
        //Lista Paises
        $this->view->pais = $pais;
        
        $this->view->indicador = $model->ListaIndicador();
        
        for($i=0; $i < count($this->view->indicador); $i++)
        {
            $aKPI[$i] = (array) $this->view->indicador[$i];
            
            //Get Area
            $area = $this->GetArea($aKPI[$i]['id_area']);
            $aKPI[$i]['area'] = $area['nombre'];
            
            $this->view->indicador[$i] = (object) $aKPI[$i];
            
        }
        
        $this->renderView('cplanificacion/add', 'layout');
    }
    
    public function save($aParam)
    {
        $aParam = (array) $aParam;
        
        $indicadores = explode(',',$aParam['indicadores']);
        $indicadores = array_filter($indicadores);
        
        $aParam['ano']  = filter_var($aParam['ano'], FILTER_SANITIZE_STRING);
        $aParam['pais'] = filter_var($aParam['pais'], FILTER_SANITIZE_STRING);
        $aParam['sede'] = filter_var($aParam['sede'], FILTER_SANITIZE_STRING);
        
        $model  = Container::getModel("Indicador");
        //Grava Planificacion
        $result = $model->GuardarPlanificacion($aParam);
        
        //Se gravar com Sucesso grava os filhos (Indicadores)
        if($result)
        {
            //Implementar um for para gravar 1 a 1...
            $result = $model->GuardarDetalheIndicadores($indicadores);
        }
        else
        {
            echo json_encode(array("results" => false));
        }
    }
}