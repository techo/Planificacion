<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class AnosController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Anos');
        $model = Container::getModel("Ano");
        $this->view->ano = $model->select();
        
        /* Render View Paises */
        $this->renderView('anos/index', 'layout');
    }
    
}