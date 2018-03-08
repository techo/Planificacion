<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class IndicadoresController extends BaseController
{
    public function __construct()
    {
        session_start();
    }
    
    public function index()
    {
        $this->setPageTitle('Indicadores');
        $model = Container::getModel("Indicador");
        $this->view->indicador = $model->select();
        $aKPI = $this->view->indicador;
        
        for($i=0; $i < count($aKPI); $i++)
        {
            $aKPI[$i] = (array) $aKPI[$i];
            
            //Get Area
            $area = $this->GetArea($aKPI[$i]['id_area']);
            $aKPI[$i]['area'] = $area['nombre'];
            
            //Get Pais
            if($aKPI[$i]['id_pais'])
            {
                $pais = $this->GetPais($aKPI[$i]['id_pais']);
                $aKPI[$i]['pais'] = $pais['nombre'];
            }
            else 
            {
                $aKPI[$i]['pais'] = 'Todos';
            }
            
            //Get Sede
            if($aKPI[$i]['id_sede'])
            {
                $sede = $this->GetSede($aKPI[$i]['id_sede']);
                $aKPI[$i]['sede'] = $sede['nombre'];
            }
            else
            {
                $aKPI[$i]['sede'] = 'Todas';
            }
            
            $this->view->indicador[$i] = (object) $aKPI[$i];
            
        }
        
        /* Render View KPIs */
        $this->renderView('indicadores/index', 'layout');
    }
    
    //Busca Area en id.techo.org
    public function GetArea($idArea)
    {
        $url = 'http://id.techo.org/area?api=true&token='.$_SESSION['Planificacion']['token'].'&id='.$idArea;
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CAINFO, getcwd() . DIRECTORY_SEPARATOR . 'cacert.pem');
        
        $output = curl_exec($curl);
        curl_close($curl);
        
        $data = json_decode($output, true);
        
        return $data;
    }
    
    //Busca Pais en id.techo.org
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