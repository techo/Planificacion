<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class ExtrasController extends BaseController
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
        $this->setPageTitle('Indicadores Extras');
        $model = Container::getModel("Extras");
        //Query para listar os indicadores do pais de acordo com a session
        $this->view->indicadores = $model->select();
        
        /* Render View Paises */
        $this->renderView('extras/index', 'layout');
    }
    
    public function add($aParam)
    {
        $aParam = (array) $aParam;
        
        $this->setPageTitle('Indicadores Extras');
        $model = Container::getModel("Extras");
        
        //Query para buscar os indicadores extras do pais e sede
        $aRet = $model->BuscaIndicadores($aParam);
        
        for($i=0; $i < count($aRet); $i++)
        {
            $aTemp = (array) $aRet[$i];
            
            $aParam['indicador'] = $aTemp['id'];
            
            //Query para inserir os Indicadores extras na planificacion
            $this->view->indicadores = $model->InsertIndicadores($aParam);
        }
        
        /* Render View Paises */
        $this->renderView('extras/index', 'layout');
    }
    
    //Busca Pais en login.techo.org
    public function GetPais($idPais)
    {
        $url = 'http://id.techo.org/pais?api=true&token='.$_SESSION['Planificacion']['token'].'&id='.$idPais;
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $output = curl_exec($curl);
        curl_close($curl);
        
        $data = json_decode($output, true);
        
        return $data;
    }
    
}