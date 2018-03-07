<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class AnosController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('A&ntilde;os');
        $model = Container::getModel("Ano");
        $this->view->ano = $model->select();
        
        /* Render View Paises */
        $this->renderView('anos/index', 'layout');
    }
    
}