<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class TInformeController extends BaseController
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
        $this->setPageTitle('Informe Trimestre');
        $model = Container::getModel("TInforme");
        
        //Busca Anos
        $this->view->ano = $model->ListAnos();
        
        //Todos Paises
   //     $paises = $this->Paises();
        
     //   unset($paises[15]);
        
  //      $this->view->paises = $paises;
        
        /* Render View Paises */
        $this->renderView('tinforme/index', 'layout');
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
    
    public function CarregaPais($idplanificacion)
    {
        //Buscar Paises Planificados neste ano
        $id = (array) $idplanificacion;
        $id = $id['id'];
        
        $model = Container::getModel("TInforme");
        
        //Busca paises
        $result = $model->BuscaPaises($id);
        
        $html .= '<div class="col-lg-3">';
        $html .= '<div class="form-group">';
        $html .= '<label for="paises">Pais</label>';
        $html .= '<select  id="pais" class="form-control" >';
        $html .= '<option value="0">-- SELECCIONE --</option>';
        foreach ($result as $pais)
        {
            $aRet = $this->GetPais($pais->id_pais);
            $html.= '<option value="'.$aRet['id'].'">'.$aRet['nombre'].'</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        
        echo ($html);
    }
    
    public function CarregaSede($aDados)
    {
        //Buscar Paises Planificados neste ano
        $aDados         = (array) $aDados;
        
        $idplanificacion = $aDados['cplanificacion'];
        $id              = $aDados['idPais'];
        
        $model = Container::getModel("TInforme");
        
        //Busca paises
        $result = $model->BuscaSedes($idplanificacion, $id);
        
        $html .= '<div class="col-lg-3">';
        $html .= '<div class="form-group">';
        $html .= '<label for="sedes">Sede</label>';
        $html .= '<select  id="sedes" class="form-control" >';
        $html .= '<option value="0">-- SELECCIONE --</option>';
        foreach ($result as $sede)
        {
            $aRet = $this->GetSede($sede->id_sede);
            $html.= '<option value="'.$aRet[0]['id'].'">'.$aRet[0]['nombre'].'</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        
        echo ($html);
    }
    
    public function CarregaIndicadores($aDados)
    {
        //Buscar Paises Planificados neste ano
        $aDados         = (array) $aDados;
        
        $idplanificacion = $aDados['cplanificacion'];
        $pais            = $aDados['idPais'];
        $sede            = $aDados['idSede'];
        
        $model = Container::getModel("TInforme");
        
        //Busca paises
        $result = $model->BuscaIndicadores($idplanificacion, $pais, $sede);
        
        $html .= '<div class="col-lg-6">';
        $html .= '<div class="form-group">';
        $html .= '<label for="indicadores">Indicadores</label>';
        $html .= '<select  id="indicador" class="form-control" >';
        $html .= '<option value="0">-- SELECCIONE --</option>';
        foreach ($result as $indicadores)
        {
            $html.= '<option value="'.$indicadores->id.'">'.$indicadores->indicador.'</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        
        echo ($html);
    }
    
}