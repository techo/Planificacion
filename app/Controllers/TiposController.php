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
    
}