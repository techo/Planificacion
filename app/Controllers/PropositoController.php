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
            $html .= '<a href="#"><i class="fa fa-pencil"></i> Editar &nbsp;&nbsp;&nbsp;</a><a href="#"><i class="fa fa-eraser"></i> Eliminar &nbsp;&nbsp;&nbsp;</a><a href="#"><i class="fa fa-retweet"></i> Relacionar </a>';
            $html .= '</div>';
            $html .= '</div>';
        }
        
        echo json_encode(array("results" => $html));
    }
    
    public function delete($id)
    {
        $model  = Container::getModel("proposito");
        $result = $model->delete($id);
        
        if($result)
        {
            header('Location: /proposito');
        }
    }
    
    public function edit($aParam)
    {
        $aParam    = (array) $aParam;
        $aPaises   = $this->GetPais();
        $model     = Container::getModel("proposito");
        $result    = $model->edit($aParam);
        $aAnos     = $model->selectAnos();
        $html      = '';
        
        $html   .= '<div class="col-lg-6">';
        $html   .= '<div class="ibox">';
        $html   .= '<div class="ibox-title">';
        $html   .= '<h5>Editar Prop&oacute;sito</h5>';
        $html   .= '</div>';
        $html   .= '<div class="ibox-content">';
        $html   .= '<div id="tab-1" class="">';
        $html   .= '<div class="panel-body">';
        $html   .= '<div class="col-lg-12">';
        $html   .= '<div class="form-group">';
        $html   .= '<label for="label">Prop&oacute;sito</label>';
        $html   .= '<input type="text" class="form-control" name="proposito" id="proposito" value="'.$result[0]->proposito.'">';
        $html   .= '</div>';
        $html   .= '</div>';
        $html   .= '<div class="col-lg-6">';
        $html   .= '<div class="form-group">';
        $html   .= '<label for="pais">Pa&iacute;s</label>';
        $html   .= '<select  id="pais" class="form-control" >';
        $html   .= '<option value="0">-- GLOBAL --</option>';
        
        foreach ($aPaises as $pais)
        {
            if($pais['ID_Pais'] == $result[0]->id_pais)
            {
                $html .= '<option value="'.$pais['ID_Pais'].'" selected>'.$pais['Nombre_Pais'].'</option>';
            }
            else
            {
                $html .= '<option value="'.$pais['ID_Pais'].'">'.$pais['Nombre_Pais'].'</option>';
            }
            
        }
        
        $html   .= '</select>';
        $html   .= '</div>';
        $html   .= '</div>';
        $html   .= '<div class="col-lg-6">';
        $html   .= '<div class="form-group">';
        $html   .= '<label for="ano">A&ntilde;o</label>';
        $html   .= '<select  id="ano" class="form-control" >';
        $html   .= '<option value="0">-- SELECCIONAR --</option>';
        
        foreach ($aAnos as $ano)
        {
            if($ano->id == $result[0]->id_ano)
            {
                $html .= '<option value="'.$ano->id.'" selected>'.$ano->ano.'</option>';
            }
            else
            {
                $html .= '<option value="'.$ano->id.'">'.$ano->ano.'</option>';
            }
            
        }
        
        $html   .= '</select>';
        $html   .= '</div>';
        $html   .= '</div>';
        $html   .= '<div class="col-lg-12">';
        $html   .= '<div class="form-group">';
        $html   .= '<label for="label">Descripci&oacute;n</label>';
        $html   .= '<textarea class="form-control" id="descripcion" rows="6" cols="45">';
        $html   .= $result[0]->descripcion.'</textarea>';
        $html   .= '</div>';
        $html   .= '</div>';
        $html   .= '<div class="col-lg-12">';
        $html   .= '<button type="button" id="editar" class="btn btn-w-m btn-warning">Editar</button>';
        $html   .= '</div>';
        $html   .= '</div>';
        $html   .= '</div>';
        $html   .= '</div>';
        $html   .= '</div>';
        $html   .= '</div> ';
        
        echo json_encode(array("results" => $html));
        
    }
}