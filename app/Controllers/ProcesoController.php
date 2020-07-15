<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class ProcesoController extends BaseController
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
        $this->setPageTitle('Proceso');
        $model = Container::getModel("proceso");
        
        $aPaises = $this->GetPais();
        
        $this->view->pais      = $aPaises;
        $this->view->ano       = $model->selectAnos();
        $this->view->proceso   = $model->select();
        
        /* Render View Proceso */
        $this->renderView('procesos/index', 'layout');
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
        
        $aParam['proceso']     = filter_var($aParam['proceso'], FILTER_SANITIZE_STRING);
        $aParam['descripcion']   = filter_var($aParam['descripcion'], FILTER_SANITIZE_STRING);
        
        $model  = Container::getModel("proceso");
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
        
        $model  = Container::getModel("proceso");
        $result = $model->filter($aParam);
        $html ='';
        
        foreach ($result as $proceso)
        {
            $html .= '<div class="form-group ibox">';
            $html .= '<div class="ibox-title">';
            $html .= '<h5>'.$proceso->proceso.'</h5>';
            $html .= '</div>';
            $html .= '<div class="ibox-content">';
            $html .= '<h3>'.$proceso->descripcion.'</h3>';
            $html .= '<a href="#" onclick="EditarProceso('.$proceso->id.');"><i class="fa fa-pencil"></i> Editar &nbsp;&nbsp;&nbsp;</a><a href="#" onclick="EliminarProceso('.$proceso->id.');"><i class="fa fa-eraser"></i> Eliminar &nbsp;&nbsp;&nbsp;</a><a href="/proceso/relacionar/'.$proceso->id.'"><i class="fa fa-retweet"></i> Relacionar </a>';
            $html .= '</div>';
            $html .= '</div>';
        }
        
        echo json_encode(array("results" => $html));
    }
    
    public function delete($id)
    {
        $model  = Container::getModel("proceso");
        $result = $model->delete($id);
        
        if($result)
        {
            header('Location: /proceso');
        }
    }
    
    public function edit($aParam)
    {
        $aParam    = (array) $aParam;
        $aPaises   = $this->GetPais();
        $model     = Container::getModel("proceso");
        $result    = $model->edit($aParam);
        $aAnos     = $model->selectAnos();
        $html      = '';
        
        $html   .= '<div class="col-lg-6">';
        $html   .= '<div class="ibox">';
        $html   .= '<div class="ibox-title">';
        $html   .= '<h5>Editar Proceso</h5>';
        $html   .= '</div>';
        $html   .= '<div class="ibox-content">';
        $html   .= '<div id="tab-1" class="">';
        $html   .= '<div class="panel-body">';
        $html   .= '<div class="col-lg-12">';
        $html   .= '<div class="form-group">';
        $html   .= '<label for="label">Proceso</label>';
        $html   .= '<input type="text" class="form-control" name="proceso" id="proceso" value="'.$result[0]->proceso.'">';
        $html   .= '<input type="hidden" class="form-control" name="id" id="id" value="'.$result[0]->id.'">';
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
        $html   .= '<button type="button" onclick="AtualizarProceso();" class="btn btn-w-m btn-warning">Actualizar</button>';
        $html   .= '</div>';
        $html   .= '</div>';
        $html   .= '</div>';
        $html   .= '</div>';
        $html   .= '</div>';
        $html   .= '</div> ';
        
        echo json_encode(array("results" => $html));
        
    }
    
    public function update($aParam)
    {
        $aParam = (array) $aParam;
        
        $aParam['proceso']     = filter_var($aParam['proceso'], FILTER_SANITIZE_STRING);
        $aParam['descripcion']   = filter_var($aParam['descripcion'], FILTER_SANITIZE_STRING);
        
        $model  = Container::getModel("proceso");
        $result = $model->update($aParam);
        
        if($result)
        {
            echo json_encode(array("results" => true));
        }
        else
        {
            echo json_encode(array("results" => false));
        }
    }
    
    public function relacionar($aParam)
    {
        $aParam = (array) $aParam;
        $id = $aParam[0];
        
        $this->setPageTitle('Relacionar');
        $model = Container::getModel("proceso");
        
        //Verifica se já existe relacao para editar
        $relacion = $model->getRelacion($id);
        
        if(!empty($relacion))
        {
            $aDados['propuestas'] = (explode(",",$relacion[0]->ids_propuestas));
            $aDados['procesos'] = (explode(",",$relacion[0]->ids_procesos));
            
            $this->view->existe = $relacion;
            $this->view->dados = $aDados;
        }
        
        //info do Proceso
        $result = $model->getproceso($id);
        $ano   = $result[0]->id_ano;
        
        //Get Pais
        $pais = $this->GetPaisUnico($result[0]->id_pais);
        
        if($result[0]->id_pais == 0)
        {
            $pais['nombre'] = 'GLOBAL';
            $pais['id']     = 0;
        }
        
        $result[0]->pais = $pais['nombre'];
        
        //Busca todos propuestas
        $aPropuestas = $model->getAllPropuestas($ano, $pais['id']);
        $this->view->propuestas = $aPropuestas;
        
        //Busca todos processos exceto ela mesma
        $aProcesos = $model->getAllProcesos($id, $pais['id']);
        $this->view->procesos = $aProcesos;
        
        //Get Idnices de Excelencia
        $kpis = $model->indicesExcelencia();
        
        $this->view->info = $result[0];
        
        $this->view->kpis = $kpis;
        
        /* Render View Relacionar Indicadores */
        $this->renderView('/procesos/relacionar', 'layout');
    }
    
    //Busca Pais en login.techo.org
    public function GetPaisUnico($idPais)
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
    
    public function relacion($aParam)
    {
        $aParam = (array) $aParam;
        
        $idpropuestas = '';
        $idprocesos = '';
        $contador = 1;
        $count    = 1;
        
        foreach($aParam['ids_propuesta'] as $k=>$v)
        {
            if($contador == 1)
            {
                $idpropuestas = $v;
            }
            else
            {
                $idpropuestas = $idpropuestas . ',' . $v;
            }
            $contador++;
        }
        
        foreach($aParam['ids_proceso'] as $k=>$v)
        {
            if($count == 1)
            {
                $idprocesos = $v;
            }
            else
            {
                $idprocesos = $idprocesos . ',' . $v;
            }
            $count++;
        }
        
        $aParam['id_propuesta'] = $idpropuestas;
        $aParam['id_procesos'] = $idprocesos;
        
        // Indicadores - kPIS
        $aParam['K1'] = $aParam['K1'] ? $aParam['K1'] : 0;
        $aParam['K2'] = $aParam['K2'] ? $aParam['K2'] : 0;
        $aParam['K3'] = $aParam['K3'] ? $aParam['K3'] : 0;
        $aParam['K4'] = $aParam['K4'] ? $aParam['K4'] : 0;
        $aParam['K5'] = $aParam['K5'] ? $aParam['K5'] : 0;
        
        // Ponderacion
        $aParam['P1'] = $aParam['P1'] ? $aParam['P1'] : 0;
        $aParam['P2'] = $aParam['P2'] ? $aParam['P2'] : 0;
        $aParam['P3'] = $aParam['P3'] ? $aParam['P3'] : 0;
        $aParam['P4'] = $aParam['P4'] ? $aParam['P4'] : 0;
        $aParam['P5'] = $aParam['P5'] ? $aParam['P5'] : 0;
        
        $aParam['P1'] = str_replace(",",".",$aParam['P1']);
        $aParam['P2'] = str_replace(",",".",$aParam['P2']);
        $aParam['P3'] = str_replace(",",".",$aParam['P3']);
        $aParam['P4'] = str_replace(",",".",$aParam['P4']);
        $aParam['P5'] = str_replace(",",".",$aParam['P5']);
        
        $model = Container::getModel("proceso");
        
        if($aParam['idrelacion'] == '')
        {
            $result = $model->InsertRelacion($aParam);
        }
        else
        {
            $result = $model->UpdateRelacion($aParam);
        }
        
        if($result)
        {
            echo json_encode(array("results" => true));
        }
        else
        {
            echo json_encode(array("results" => false));
        }
    }
}