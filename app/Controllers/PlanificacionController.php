<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class PlanificacionController extends BaseController
{
    public function __construct()
    {
        session_start();
    }
    
    public function index()
    {
        $this->setPageTitle('Planificacion');
        $model = Container::getModel("Planificacion");
        $this->view->planificacion = $model->select();
        
        /* Render View Paises */
        $this->renderView('planificacion/index', 'layout');
    }
}