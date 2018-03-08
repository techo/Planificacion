<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class TemporalidadesController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Temporalidades');
        $model = Container::getModel("Temporalidad");
        $this->view->temporalidad = $model->select();
        
        /* Render View Paises */
        $this->renderView('temporalidades/index', 'layout');
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