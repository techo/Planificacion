<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class PaisesController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Paises');
        $model = Container::getModel("Pais");
        $this->view->pais = $model->select();
        $this->renderView('pais/index', 'layout');
    }
    
    public function show($id, $request)
    {
        $model = Container::getModel("Pais");
        $aPais = $model->search($id);
        
        echo('<pre>');
        die(print_r($aPais, true));
    }
    
    public function teste($id, $sexo, $idade, $request)
    {  
        $aRequest = (array) $request;
        
        if($aRequest['api'] === 'true')
        {
            $data = json_decode(file_get_contents('php://input'), true);
            die(print_r($data, true));
        }
        else {
            die(print_r($id, true));
        }
        
    }
    
}