<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class PilaresController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Pilares');
        $model = Container::getModel("Pilar");
        $this->view->pilar = $model->select();
        
        /* Render View Paises */
        $this->renderView('pilares/index', 'layout');
    }
    
}