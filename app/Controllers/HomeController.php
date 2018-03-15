<?php 
namespace App\Controllers;

use Core\BaseController;

class HomeController extends BaseController
{
    public function __construct()
    {
        session_start();
    }
    
    public function index()
    {
        //Assume o Token Gerado no Login, em desenvolvimento local usa um token fixo
        if($_SERVER['SERVER_NAME'] != 'localhost')
        {
            if($_GET['token'])
            {
                $_SESSION['Planificacion']['token']   = $_GET['token'];
            }
            
            //Session Producao e Local
            if($_SESSION['Planificacion']['token'])
            {
                $url = 'http://login.techo.org/api?token='. $_SESSION['Planificacion']['token'];
                
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                
                $output = curl_exec($curl);
                curl_close($curl);
                
                $data = json_decode($output, TRUE);
                
                $_SESSION['Planificacion']['Mail']      = $data['email'];
                $_SESSION['Planificacion']['user_id']   = $data['id'];
                $_SESSION['Planificacion']['sede_id']   = $data['id_sede'];
                $_SESSION['Planificacion']['area_id']   = $data['id_area'];
                $_SESSION['Planificacion']['cargo_id']  = $data['id_cargo'];
                $_SESSION['Planificacion']['Name']      = $data['nombre'];
            }
        }
        else
        {
            $_SESSION['Planificacion']['token']   = '7c9b5c9b9baae1227deb96f1c51a7b61';
            
            $url = 'http://login.techo.org/api?token='. $_SESSION['Planificacion']['token'];
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            $output = curl_exec($curl);
            curl_close($curl);
            
            $data = json_decode($output, TRUE);
            
            $_SESSION['Planificacion']['Mail']      = $data['email'];
            $_SESSION['Planificacion']['user_id']   = $data['id'];
            $_SESSION['Planificacion']['sede_id']   = $data['id_sede'];
            $_SESSION['Planificacion']['area_id']   = $data['id_area'];
            $_SESSION['Planificacion']['cargo_id']  = $data['id_cargo'];
            $_SESSION['Planificacion']['Name']      = $data['nombre'];
        }
        
        $this->setPageTitle('Home');
        $this->renderView('home/index', 'layout');
    }
    
    
}