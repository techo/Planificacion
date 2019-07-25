<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class PowerBiController extends BaseController
{
    public function __construct()
    {
        session_start();
        
        if($_SERVER['SERVER_NAME'] == 'admin.planificacion.techo.org' || $_SERVER['SERVER_NAME'] == 'localhost')
        {
            if(!isset($_SESSION['Planificacion']['token']))
            {
                header('Location: http://login.techo.org/?appid=98532jvfn145sas87aawrh154aeeth&redirect=https://admin.planificacion.techo.org/');
            }
        }
        else
        {
            if(!isset($_SESSION['Planificacion']['token']))
            {
                header('Location: http://login.techo.org/?appid=245sd4d5f4g8h1rt4584ht84t54tg8tg&redirect=https://planificacion.techo.org/');
            }
        }
    }
    
    public function index()
    {
        $this->setPageTitle('Power BI - TECHO');
         # precisa obrigatorio pra funcionar ter uma model
        $model = Container::getModel("Ano");
        
        /* Render View Paises */
        $this->renderView('powerbi/index', 'layout');
    }
    
    public function inforgrafia2019()
    {
        $this->setPageTitle('Power BI - TECHO');
        # precisa obrigatorio pra funcionar ter uma model
        $model = Container::getModel("Ano");
        
        /* Render View Paises */
        $this->renderView('powerbi/infografia2019', 'layout');
    }
}