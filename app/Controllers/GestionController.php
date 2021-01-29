<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class GestionController extends BaseController
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
        $this->setPageTitle('Gestion  y Tendencias');
        $model = Container::getModel("Gestion");
        $this->renderView('gestion/index', 'layout');
    }
    
    public function pilares()
    {
        $this->setPageTitle('Visual por Pilares');
        
        //Busca Anos
        $model = Container::getModel("TInforme");
        $this->view->ano = $model->ListAnos();
        $this->renderView('gestion/pilares', 'layout');
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
        
        return $aTemp;
    }
    
    public function SelectBoxPais()
    {
        $aRet = $this->Paises();
        
        $html .= '<select class="form-control" name="pais" id="pais">';
        $html .= '<option value="0">-- SELECCIONE --</option>';
        foreach ($aRet as $pais)
        {
            if($pais['pais'] == 'Oficina Internacional' || $pais['pais'] == 'Europa' || $pais['pais'] == 'Nicaragua')
            {
                continue;
            }
            else
            {
                $html.= '<option value="'.$pais['id'].'">'.$pais['pais'].'</option>';
            }
            
        }
        $html .= '</select>';
        
        echo ($html);
    }
    
    public function SelectBoxSede($idPais)
    {
        $aRet = $this->Sedes($idPais);
        
        $html .= '<p><label for="sedes"><strong>Elija la Sede:</label></strong><p>';
        $html .= '<select class="form-control" id="sedes">';
        $html .= '<option value="0">-- SELECCIONE --</option>';
        foreach ($aRet as $sede)
        {
            $html.= '<option value="'.$sede['id'].'">'.$sede['sede'].'</option>';
        }
        $html .= '</select>';
        
        echo ($html);
    }
    
    public function DadosPais($idPais,$idCPlanificacion)
    {
        $aParam['idCPlanificacion']  = $idCPlanificacion;
        $aParam['idPais'] = $idPais;
        $aParam['visual'] = 'Pais';
        
        $model   = Container::getModel("Gestion");
        $result = $model->Dados($aParam);
        
        echo json_encode(array("resultado" => $result));
    }
    
    public function DadosSede($idPais,$idCPlanificacion, $idSede)
    {
        $aParam['idCPlanificacion']  = $idCPlanificacion;
        $aParam['idPais'] = $idPais;
        $aParam['idSede'] = $idSede;
        $aParam['visual'] = 'Sede';
        
        $model   = Container::getModel("Gestion");
        $result  = $model->Dados($aParam);
        
        echo json_encode(array("resultado" => $result));
    }
    
    public function DadosRegion($aDatos)
    {
        $idRegion = $aDatos->idRegion;
        
        $aParam['idCPlanificacion']  = $aDatos->idAno;
        $aParam['idPaises'] = '';
        $aParam['visual'] = 'Region';
        
        if($idRegion == 1)
        {
            // Andina
            $aParam['idPaises'] = '7, 6, 21, 17, 9';
        }
        elseif($idRegion == 2)
        {
            // Cono Sur y Brasil
            $aParam['idPaises'] = '4, 19, 16, 1';
        }
        elseif($idRegion == 3)
        {
            // Mexico, Centroamérica y el Caribe
            $aParam['idPaises'] = '13, 3, 10, 11, 12, 18';
        }
        elseif($idRegion == 4)
        {
            // Chile
            $aParam['idPaises'] =  '2';
        }
        
        $model   = Container::getModel("Gestion");
        $result  = $model->Dados($aParam);
        
        echo json_encode(array("resultado" => $result));
    }
    
    public function DadosLatam($aDatos)
    {
        $aParam['idCPlanificacion']  = $aDatos->idAno;
        $aParam['idPaises'] = '1, 2, 3, 4, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16,17, 18, 19, 21';
        $aParam['visual'] = 'Latam';
        
        $model   = Container::getModel("Gestion");
        $result  = $model->Dados($aParam);
        
        echo json_encode(array("resultado" => $result));
    }
}