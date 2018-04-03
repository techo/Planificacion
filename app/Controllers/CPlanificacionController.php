<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class CPlanificacionController extends BaseController
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
        $this->setPageTitle('Create Planificacion');
        $model = Container::getModel("CPlanificacion");
        $this->view->cplanificacion = $model->select();
        
        for($i=0; $i < count($this->view->cplanificacion); $i++)
        {
            $aKPI[$i] = (array) $this->view->cplanificacion[$i];
            
            //Get Pais
            if($aKPI[$i]['id_pais'])
            {
                $pais = $this->GetPais($aKPI[$i]['id_pais']);
                $aKPI[$i]['pais'] = $pais['nombre'];
            }
            
            //Get Sede
            if($aKPI[$i]['id_sede'])
            {
                $sede = $this->GetSede($aKPI[$i]['id_sede']);
                $aKPI[$i]['sede'] = $sede[0]['nombre'];
            }
            
            $this->view->cplanificacion[$i] = (object) $aKPI[$i];
        }
        
        /* Render View Paises */
        $this->renderView('cplanificacion/index', 'layout');
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
    
    //Busca Sede en id.techo.org
    public function GetSede($idSede)
    {
        $url = 'http://id.techo.org/sede?api=true&token='.$_SESSION['Planificacion']['token'].'&id='.$idSede;
        
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