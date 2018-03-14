<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class PilaresController extends BaseController
{
    public function __construct()
    {
        session_start();
    }
    
    public function index()
    {
        $this->setPageTitle('Pilares');
        $model = Container::getModel("Pilar");
        $this->view->pilar = $model->select();
        
        /* Render View Paises */
        $this->renderView('pilares/index', 'layout');
    }
    
    public function add()
    {
        $this->setPageTitle('Pilares');
        $this->renderView('pilares/add', 'layout');
    }
    
    public function save($aParam)
    {
        $aParam = (array) $aParam;
        
        $aParam['pilar']  = filter_var($aParam['pilar'], FILTER_SANITIZE_STRING);
        
        $model  = Container::getModel("Pilar");
        $result = $model->GuardarPilar($aParam);
        
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
        $model = Container::getModel("Pilar");
        $this->view->pilar = $model->search($id);
        
        /* Render View Paises */
        $this->renderView('pilares/edit', 'layout');
    }
    
    public function edit($aParam)
    {
        $aParam = (array) $aParam;
        
        $aParam['id']    = filter_var($aParam['id'], FILTER_SANITIZE_STRING);
        $aParam['pilar'] = filter_var($aParam['pilar'], FILTER_SANITIZE_STRING);
        
        $model  = Container::getModel("Pilar");
        $result = $model->ActualizarPilar($aParam);
        
        if($result)
        {
            echo json_encode(array("results" => true));
        }
        else
        {
            echo json_encode(array("results" => false));
        }
    }
    
    public function GetPilar()
    {
        $model = Container::getModel("Pilar");
        $aPilares = $model->select();
        
        for($i=0; $i < count($aPilares); $i++)
        {
            $temporario = (array)$aPilares[$i];
            $aTemp[$i]  = $temporario['pilar'];
        }
        
        echo json_encode(array("values" => $aTemp));
    }
    
}