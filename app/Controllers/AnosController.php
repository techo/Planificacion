<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class AnosController extends BaseController
{
    public function __construct()
    {
        session_start();
    }
    
    public function index()
    {
        $this->setPageTitle('A&ntilde;os');
        $model = Container::getModel("Ano");
        $this->view->ano = $model->select();
        
        /* Render View Paises */
        $this->renderView('anos/index', 'layout');
    }
    
    public function add()
    {
        $this->setPageTitle('A&ntilde;os');
        $this->renderView('anos/add', 'layout');
    }
    
    public function save($aParam)
    {
        $aParam = (array) $aParam;
        
        $aParam['ano']  = filter_var($aParam['ano'], FILTER_SANITIZE_STRING);

        $model  = Container::getModel("Ano");
        $result = $model->GuardarAno($aParam);
        
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
        $model = Container::getModel("Ano");
        $this->view->ano = $model->search($id);
        
        /* Render View Paises */
        $this->renderView('anos/edit', 'layout');
    }
    
    public function edit($aParam)
    {
        $aParam = (array) $aParam;
        
        $aParam['id']  = filter_var($aParam['id'], FILTER_SANITIZE_STRING);
        $aParam['ano'] = filter_var($aParam['ano'], FILTER_SANITIZE_STRING);
        
        $model  = Container::getModel("Ano");
        $result = $model->ActualizarAno($aParam);
        
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