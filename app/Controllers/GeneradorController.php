<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class GeneradorController extends BaseController
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
        $this->setPageTitle('Generador de Informes');
        $model = Container::getModel("Generador");
        
        $this->view->ano = $model->ListAnos();
               
        /* Render View Generador Informes */
        $this->renderView('generador/index', 'layout');
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
    
    //Busca Area en login.techo.org
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
    
    public function CarregaPais($idplanificacion)
    {
        //Buscar Paises Planificados neste ano
        $id = (array) $idplanificacion;
        $id = $id['id'];
        
        $model = Container::getModel("Generador");
        
        //Busca paises
        $result = $model->BuscaPaises($id);
        
        $html .= '<div class="col-lg-12">';
        $html .= '<hr>';
        $html .= '<h2>Elija los Pa&iacute;ses</h2>';
        $html .= '<table id="example" class="display" style="width:100%">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th></th>';
        $html .= '<th hidden></th>';
        $html .= '<th>Pa&iacute;s</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach ($result as $pais)
        {
            $aRet = $this->GetPais($pais->id_pais);
            $html .= '<tr>';
            $html .= '<td></td>';
            $html .= '<td hidden>'.$aRet['id'].'</td>';
            $html .= '<td>'.$aRet['nombre'].'</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '<tfoot>';
        $html .= '</tfoot>';
        $html .= '</table>';
        $html .= '</div>';
        
        echo ($html);
    }
    
    public function CarregaIndicadores()
    {
        //Buscar Indicadores comuns a todos paises
        $model = Container::getModel("Generador");
        
        //Busca paises
        $result = $model->BuscaIndicadores();
        
        $html .= '<div class="col-lg-12">';
        $html .= '<hr>';
        $html .= '<h2>Elija el Indicador</h2>';
        $html .= '<table id="example1" class="display" style="width:100%">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th></th>';
        $html .= '<th hidden></th>';
        $html .= '<th>Indicador</th>';
        $html .= '<th>Temporalidad</th>';
        $html .= '<th>Tipo</th>';
        $html .= '<th>Pilar Estrat&eacute;gico</th>';
        $html .= '<th>&Aacute;rea</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach ($result as $indicador)
        {
            $area  = $this->GetArea($indicador->id_area);
            $cArea = $area['nombre'];
            
            $html .= '<tr>';
            $html .= '<td></td>';
            $html .= '<td hidden>'.$indicador->id.'</td>';
            $html .= '<td>'.$indicador->indicador.'</td>';
            $html .= '<td>'.$indicador->temporalidad.'</td>';
            $html .= '<td>'.$indicador->tipo.'</td>';
            $html .= '<td>'.$indicador->pilar.'</td>';
            $html .= '<td>'.$cArea.'</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '<tfoot>';
        $html .= '</tfoot>';
        $html .= '</table>';
        $html .= '</div>';
        
        echo ($html);
    }
}