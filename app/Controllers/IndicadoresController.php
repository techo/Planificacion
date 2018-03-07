<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class IndicadoresController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Indicadores');
        $model = Container::getModel("Indicador");
        $this->view->indicador = $model->select();
               
        /* Render View Paises */
        $this->renderView('indicadores/index', 'layout');
    }
}