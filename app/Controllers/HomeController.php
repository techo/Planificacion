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
            $_SESSION['Planificacion']['token'] = $_GET['token'];
        }
        else
        {
            $_SESSION['Planificacion']['token'] = '7c9b5c9b9baae1227deb96f1c51a7b61';
        }
        
        $this->setPageTitle('Home');
        $this->renderView('home/index', 'layout');
    }
    
    
}