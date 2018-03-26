<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class TiposController extends BaseController
{
    public function __construct()
    {
        session_start();
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