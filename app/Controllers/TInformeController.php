<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class TInformeController extends BaseController
{
    public function __construct()
    {
        session_start();
        
        if(!isset($_SESSION['Planificacion']['token']))
        {
            header('Location: http://login.techo.org/');
        }
    }
    
    public function index()
    {
        $this->setPageTitle('Informe Trimestre');
        $model = Container::getModel("CPlanificacion");
        
        /* Render View Paises */
        $this->renderView('tinforme/index', 'layout');
    }
    
}