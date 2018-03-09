<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class TiposController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Tipos');
        $model = Container::getModel("Tipo");
        $this->view->tipo = $model->select();
        
        /* Render View Paises */
        $this->renderView('tipos/index', 'layout');
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