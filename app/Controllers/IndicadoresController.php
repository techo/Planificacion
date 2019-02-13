<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class IndicadoresController extends BaseController
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
        $this->setPageTitle('Indicadores');
        $model = Container::getModel("Indicador");
        $this->view->indicador = $model->select($_SESSION['Planificacion']['pais_id']);
        $aKPI = $this->view->indicador;
        
        for($i=0; $i < count($aKPI); $i++)
        {
            $aKPI[$i] = (array) $aKPI[$i];
            
            //Get Area
           // $area = $this->GetArea($aKPI[$i]['id_area']);
           // $aKPI[$i]['area'] = $area['nombre'];
           
            if (array_key_exists($aKPI[$i]['id_area'], $_SESSION['Planificacion']['areas']))
            {
                $aKPI[$i]['area'] = utf8_encode($_SESSION['Planificacion']['areas'][$aKPI[$i]['id_area']]);
            }
            
            //Get Pais
            if($aKPI[$i]['id_pais'])
            {
                $pais = $this->GetPais($aKPI[$i]['id_pais']);
                $aKPI[$i]['pais'] = $pais['nombre'];
            }
            else 
            {
                $aKPI[$i]['pais'] = 'Todos';
            }
            
            //Get Sede
            if($aKPI[$i]['id_sede'])
            {
                $sede = $this->GetSede($aKPI[$i]['id_sede']);
                $aKPI[$i]['sede'] = $sede['nombre'];
            }
            else
            {
                $aKPI[$i]['sede'] = 'Todas';
            }
            
            $this->view->indicador[$i] = (object) $aKPI[$i];
            
        }
        
        /* Render View KPIs */
        $this->renderView('indicadores/index', 'layout');
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
    
    public function Areas()
    {
        $url = 'http://id.techo.org/area?api=true&token='.$_SESSION['Planificacion']['token'];
        
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
            $aTemp[$i]['id']   = $data[$i]['ID_Area'];
            $aTemp[$i]['area'] = $data[$i]['Nombre_Area'];
        }
        
      //  echo json_encode(array("values" => $aTemp));
        return $aTemp;
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
    
    public function Indicadores()
    {
        $model = Container::getModel("Indicador");
        $aIndicadores = $model->select();
        
        for($i=0; $i < count($aIndicadores); $i++)
        {
            $temporario = (array)$aIndicadores[$i];
            
            //Get Area
            $area = $this->GetArea($temporario['id_area']);
            
            //Montagem Array
            $aTemp[$i]['Indicador']    = $temporario['indicador'];
            $aTemp[$i]['Temporalidad'] = $temporario['temporalidad'];
            $aTemp[$i]['Tipo']         = $temporario['tipo'];
            $aTemp[$i]['Pilar']        = $temporario['pilar'];
            $aTemp[$i]['Area']         = $area['nombre'];
            
        }
        
        echo json_encode(array("result" => $aTemp));
        
    }
    
    public function add()
    {
        $this->setPageTitle('Indicador');
        $model = Container::getModel("Indicador");
        //Busca Temporalidad
        $this->view->temporalidad = $model->ListaTemporalidad();
        
        //Busca Tipo
        $this->view->tipo  = $model->ListaTipo();
        
        //Busca Pilar
        $this->view->pilar = $model->ListaPilar();
        
        //Busca Area
        $area = $this->Areas();
        
        //Convert Array en Object
        for($i=0; $i < count($area); $i++)
        {
            $area[$i] = (object) $area[$i];
        }
        //Lista Areas
        $this->view->area  = $area;
        
        //Busca Pais
        $pais = $this->Paises();
        
        //Convert Array en Object
        for($i=0; $i < count($pais); $i++)
        {
            $pais[$i] = (object) $pais[$i];
        }
        //Lista Paises
        $this->view->pais = $pais;
        
        //Render View
        $this->renderView('indicadores/add', 'layout');
    }
    
    public function save($aParam)
    {
        $aParam = (array) $aParam;
        
        $aParam['indicador']    = filter_var($aParam['indicador'], FILTER_SANITIZE_STRING);
        $aParam['temporalidad'] = filter_var($aParam['temporalidad'], FILTER_SANITIZE_STRING);
        $aParam['tipo']         = filter_var($aParam['tipo'], FILTER_SANITIZE_STRING);
        $aParam['pilar']        = filter_var($aParam['pilar'], FILTER_SANITIZE_STRING);
        $aParam['pais']         = filter_var($aParam['pais'], FILTER_SANITIZE_STRING);
        $aParam['area']         = filter_var($aParam['area'], FILTER_SANITIZE_STRING);
        $aParam['sede']         = filter_var($aParam['sede'], FILTER_SANITIZE_STRING);
        $aParam['status']       = filter_var($aParam['status'], FILTER_SANITIZE_STRING);
        $aParam['formato']      = filter_var($aParam['formato'], FILTER_SANITIZE_STRING);
        
        $model  = Container::getModel("Indicador");
        $result = $model->GuardarIndicador($aParam);
        
        if($result)
        {
            echo json_encode(array("results" => true));
        }
        else
        {
            echo json_encode(array("results" => false));
        }
    }
    
    public function show($id)
    {
        $model = Container::getModel("Indicador");
        $this->view->indicador    = $model->search($id);
        $this->view->temporalidad = $model->ListaTemporalidad();
        $this->view->tipo         = $model->ListaTipo();
        $this->view->pilar        = $model->ListaPilar();
        
        //Busca Area
        $area = $this->Areas();
        
        //Convert Array en Object
        for($i=0; $i < count($area); $i++)
        {
            $area[$i] = (object) $area[$i];
        }
        //Lista Areas
        $this->view->area  = $area;
        
        //Busca Pais
        $pais = $this->Paises();
        
        //Convert Array en Object
        for($i=0; $i < count($pais); $i++)
        {
            $pais[$i] = (object) $pais[$i];
        }
        //Lista Paises
        $this->view->pais = $pais;
        
        //Busca Sedes
        $sede = $this->Sedes($this->view->indicador->id_pais);
        
        //Convert Array en Object
        for($i=0; $i < count($sede); $i++)
        {
            $sede[$i] = (object) $sede[$i];
        }
        //Lista Paises
        $this->view->sede = $sede;
        
        /* Render View Paises */
        $this->renderView('indicadores/edit', 'layout');
    }
    
    public function edit($aParam)
    {
        $aParam = (array) $aParam;
        
        $aParam['id']           = filter_var($aParam['id'], FILTER_SANITIZE_STRING);
        $aParam['indicador']    = filter_var($aParam['indicador'], FILTER_SANITIZE_STRING);
        $aParam['temporalidad'] = filter_var($aParam['temporalidad'], FILTER_SANITIZE_STRING);
        $aParam['tipo']         = filter_var($aParam['tipo'], FILTER_SANITIZE_STRING);
        $aParam['pilar']        = filter_var($aParam['pilar'], FILTER_SANITIZE_STRING);
        $aParam['pais']         = filter_var($aParam['pais'], FILTER_SANITIZE_STRING);
        $aParam['area']         = filter_var($aParam['area'], FILTER_SANITIZE_STRING);
        $aParam['sede']         = filter_var($aParam['sede'], FILTER_SANITIZE_STRING);
        $aParam['status']       = filter_var($aParam['status'], FILTER_SANITIZE_STRING);
        $aParam['formato']      = filter_var($aParam['formato'], FILTER_SANITIZE_STRING);
        
        $model  = Container::getModel("Indicador");
        $result = $model->ActualizarIndicador($aParam);
        
        if($result)
        {
            echo json_encode(array("results" => true));
        }
        else
        {
            echo json_encode(array("results" => false));
        }
    }
    
    public function delete($id)
    {
        $model  = Container::getModel("Indicador");
        $result = $model->delete($id);
        
        if($result)
        {
            header('Location: /indicadores');
        }
    }
}