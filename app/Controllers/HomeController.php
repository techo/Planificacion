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
                $_SESSION['Planificacion']['pais_id']   = $data['id_pais'];
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
            $_SESSION['Planificacion']['pais_id']   = $data['id_pais'];
            $_SESSION['Planificacion']['Name']      = $data['nombre'];
        }
        
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
        
        $this->setPageTitle('Home');
        $this->renderView('home/index', 'layout');
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
    
    public function Paises()
    {
        $url = 'http://id.techo.org/pais?api=true&token='.$_SESSION['Planificacion']['token'];
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CAINFO, getcwd() . DIRECTORY_SEPARATOR . 'cacert.pem');
        
        $output = curl_exec($curl);
        curl_close($curl);
        
        $data = json_decode($output, true);
        
        for($i=0; $i < count($data); $i++)
        {
            $aTemp[$i]['id']   = $data[$i]['ID_Pais'];
            $aTemp[$i]['pais'] = $data[$i]['Nombre_Pais'];
        }
        
        //  echo json_encode(array("values" => $aTemp));
        return $aTemp;
    }
    
    public function Sedes($idPais)
    {
        $url = 'http://id.techo.org/sede?api=true&token='.$_SESSION['Planificacion']['token'].'&id_pais='.$idPais;
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CAINFO, getcwd() . DIRECTORY_SEPARATOR . 'cacert.pem');
        
        $output = curl_exec($curl);
        curl_close($curl);
        
        $data = json_decode($output, true);
        
        for($i=0; $i < count($data); $i++)
        {
            $aTemp[$i]['id']   = $data[$i]['id'];
            $aTemp[$i]['sede'] = $data[$i]['nombre'];
        }
        
        //  echo json_encode(array("values" => $aTemp));
        return $aTemp;
    }
    
    //Monta o DashBoard do Usuario
    public function UserLogado($aParam)
    {
        $aParam = (array) $aParam;
        
        $sede = $this->GetSede($aParam['sede']);
        $pais = $this->GetPais($aParam['pais']);
        
        //Oficina Internacional
        if($sede[0]['id'] == 1)
        {
            //Enviar Nome de todos Paises
            $aPaises = $this->Paises();
            $result  = $aPaises;
        }
        
        //Sede Nacional
        if($sede[0]['nombre'] == 'Sede Nacional')
        {
            //Enviar Nome do Pais e todas Sedes deste Pais
            $aSedes = $this->Sedes($aParam['pais']);
            $result = $aSedes;
            
        } 
        //Outras Sedes
        if($sede[0]['nombre'] != 'Sede Nacional' && $sede[0]['id'] != 1)
        {
            $aSedes[0]['id'] = $sede[0]['id'];
            $aSedes[0]['sede'] = $sede[0]['nombre'];
            
            //Envia Apenas Nome desta Sede
            $result = $aSedes;
        }
        
        echo json_encode(array("data" => $result));
    }
    
}