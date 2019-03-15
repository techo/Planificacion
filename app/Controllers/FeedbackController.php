<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class FeedbackController extends BaseController
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
        $this->setPageTitle('FeedBack');
        $model = Container::getModel("feedback");
        $this->view->feedback = $model->select();
        
        /* Render View feedback */
        $this->renderView('feedback/index', 'layout');
    }
    
    public function save($aParam)
    {
        $aParam = (array) $aParam;
        
        $aParam['mensaje'] = $aParam['mensaje'];
        $aParam['usuario'] = $_SESSION['Planificacion']['Name'];
        $aParam['foto']    = $_SESSION['Planificacion']['picture'];
        
        $model  = Container::getModel("Feedback");
        $result = $model->Guardar($aParam);
        
        if($result)
        {
            echo json_encode(array("results" => true));
        }
        else
        {
            echo json_encode(array("results" => false));
        }
    }
    
}