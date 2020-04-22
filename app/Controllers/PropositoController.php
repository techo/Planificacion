<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class PropositoController extends BaseController
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
        $this->setPageTitle('Propositos');
        $model = Container::getModel("proposito");
        
        $aPaises = $this->GetPais();
        
        $this->view->pais      = $aPaises;
        $this->view->ano       = $model->selectAnos();
        $this->view->proposito = $model->select();
        
        /* Render View Propositos */
        $this->renderView('propositos/index', 'layout');
    }
    
    //Busca Pais en login.techo.org
    public function GetPais()
    {
        $url = 'http://id.techo.org/pais?api=true&token='.$_SESSION['Planificacion']['token'];
        
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
    
    public function save($aParam)
    {
        $aParam = (array) $aParam;
        
        $aParam['proposito']     = filter_var($aParam['proposito'], FILTER_SANITIZE_STRING);
        $aParam['descripcion']   = filter_var($aParam['descripcion'], FILTER_SANITIZE_STRING);
        
        $model  = Container::getModel("proposito");
        $result = $model->insert($aParam);
        
        if($result)
        {
            echo json_encode(array("results" => true));
        }
        else
        {
            echo json_encode(array("results" => false));
        }
    }
    
    public function filter($aParam)
    {
        $aParam = (array) $aParam;
        
        $model  = Container::getModel("proposito");
        $result = $model->filter($aParam);
        $html ='';
        
        foreach ($result as $proposito)
        {
            $html .= '<div class="form-group ibox">';
            $html .= '<div class="ibox-title">';
            $html .= '<h5>'.$proposito->proposito.'</h5>';
            $html .= '</div>';
            $html .= '<div class="ibox-content">';
            $html .= '<h3>'.$proposito->descripcion.'</h3>';
            $html .= '<a href="#"><i class="fa fa-pencil"></i> Editar </a><a href="#"><i class="fa fa-eraser"></i> Eliminar </a><a href="#"><i class="fa fa-retweet"></i> Relacionar </a>';
            $html .= '</div>';
            $html .= '</div>';
        }
        
        echo json_encode(array("results" => $html));
    }
}