<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class TiposController extends BaseController
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
        $this->setPageTitle('Tipos');
        $model = Container::getModel("Tipo");
        $this->view->tipo = $model->select();
        
        /* Render View Paises */
        $this->renderView('tipos/index', 'layout');
    }
    
    public function add()
    {
        $this->setPageTitle('Tipos');
        $this->renderView('tipos/add', 'layout');
    }
    
    public function save($aParam)
    {
        $aParam = (array) $aParam;
        
        $aParam['tipo']   = filter_var($aParam['tipo'], FILTER_SANITIZE_STRING);
        $aParam['status'] = filter_var($aParam['status'], FILTER_SANITIZE_STRING);
        
        $model  = Container::getModel("Tipo");
        $result = $model->GuardarTipo($aParam);
        
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
        $model = Container::getModel("Tipo");
        $this->view->tipo = $model->search($id);
        
        /* Render View Tipos*/
        $this->renderView('tipos/edit', 'layout');
    }
    
    public function edit($aParam)
    {
        $aParam = (array) $aParam;
        
        $aParam['id']     = filter_var($aParam['id'], FILTER_SANITIZE_STRING);
        $aParam['tipo']   = filter_var($aParam['tipo'], FILTER_SANITIZE_STRING);
        $aParam['status'] = filter_var($aParam['status'], FILTER_SANITIZE_STRING);
        
        $model  = Container::getModel("Tipo");
        $result = $model->ActualizarTipo($aParam);
        
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
        $model  = Container::getModel("Tipo");
        $result = $model->delete($id);
        
        if($result)
        {
            header('Location: /tipos');
        }
    }
    
    public function GetTipo()
    {
        $model = Container::getModel("Tipo");
        $aTipos = $model->select();
        
        for($i=0; $i < count($aTipos); $i++)
        {
            $temporario = (array)$aTipos[$i];
            $aTemp[$i]  = $temporario['tipo'];
        }
        
        echo json_encode(array("values" => $aTemp));
    }
    
}