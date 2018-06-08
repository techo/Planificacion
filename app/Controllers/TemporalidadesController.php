<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class TemporalidadesController extends BaseController
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
        $this->setPageTitle('Temporalidades');
        $model = Container::getModel("Temporalidad");
        $this->view->temporalidad = $model->select();
        
        /* Render View Paises */
        $this->renderView('temporalidades/index', 'layout');
    }
    
    public function add()
    {
        $this->setPageTitle('Temporalidades');
        $this->renderView('/temporalidades/add', 'layout');
    }
    
    public function save($aParam)
    {
        $aParam = (array) $aParam;
        
        $aParam['temporalidad']  = filter_var($aParam['temporalidad'], FILTER_SANITIZE_STRING);
        $aParam['status']        = filter_var($aParam['status'], FILTER_SANITIZE_STRING);
        
        $model  = Container::getModel("Temporalidad");
        $result = $model->GuardarTemporalidad($aParam);
        
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
        $model = Container::getModel("Temporalidad");
        $this->view->temporalidad = $model->search($id);
        
        /* Render View Temporalidades */
        $this->renderView('temporalidades/edit', 'layout');
    }
    
    public function edit($aParam)
    {
        $aParam = (array) $aParam;
        
        $aParam['id']           = filter_var($aParam['id'], FILTER_SANITIZE_STRING);
        $aParam['temporalidad'] = filter_var($aParam['temporalidad'], FILTER_SANITIZE_STRING);
        $aParam['status']       = filter_var($aParam['status'], FILTER_SANITIZE_STRING);
        
        $model  = Container::getModel("Temporalidad");
        $result = $model->ActualizarTemporalidad($aParam);
        
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
        $model  = Container::getModel("Temporalidad");
        $result = $model->delete($id);
        
        if($result)
        {
            header('Location: /temporalidades');
        }
    }
    
    public function GetTemporalidad()
    {
        $model = Container::getModel("Temporalidad");
        $aTemporalidades = $model->select();
        
        for($i=0; $i < count($aTemporalidades); $i++)
        {
            $temporario = (array)$aTemporalidades[$i];
            $aTemp[$i]  = $temporario['temporalidad'];
        }
        
        echo json_encode(array("values" => $aTemp));
    }
    
}