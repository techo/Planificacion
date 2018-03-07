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
    
}