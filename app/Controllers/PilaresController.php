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
    
    public function GetPilar()
    {
        $model = Container::getModel("Pilar");
        $aPilares = $model->select();
        
        for($i=0; $i < count($aPilares); $i++)
        {
            $temporario = (array)$aPilares[$i];
            $aTemp[$i]  = $temporario['pilar'];
        }
        
        echo json_encode(array("values" => $aTemp));
    }
    
}