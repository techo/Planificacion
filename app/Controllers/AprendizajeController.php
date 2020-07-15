<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class AprendizajeController extends BaseController
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
        $this->setPageTitle('Aprendizaje');
        $model = Container::getModel("aprendizaje");
        
        $aPaises = $this->GetPais();
        
        $this->view->pais      = $aPaises;
        $this->view->ano       = $model->selectAnos();
        $this->view->aprendizaje   = $model->select();
        
        /* Render View Aprendizaje */
        $this->renderView('aprendizajes/index', 'layout');
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
        
        $aParam['aprendizaje']     = filter_var($aParam['aprendizaje'], FILTER_SANITIZE_STRING);
        $aParam['descripcion']   = filter_var($aParam['descripcion'], FILTER_SANITIZE_STRING);
        
        $model  = Container::getModel("aprendizaje");
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
        
        $model  = Container::getModel("aprendizaje");
        $result = $model->filter($aParam);
        $html ='';
        
        foreach ($result as $aprendizaje)
        {
            $html .= '<div class="form-group ibox">';
            $html .= '<div class="ibox-title">';
            $html .= '<h5>'.$aprendizaje->aprendizaje.'</h5>';
            $html .= '</div>';
            $html .= '<div class="ibox-content">';
            $html .= '<h3>'.$aprendizaje->descripcion.'</h3>';
            $html .= '<a href="#" onclick="EditarAprendizaje('.$aprendizaje->id.');"><i class="fa fa-pencil"></i> Editar &nbsp;&nbsp;&nbsp;</a><a href="#" onclick="EliminarAprendizaje('.$aprendizaje->id.');"><i class="fa fa-eraser"></i> Eliminar &nbsp;&nbsp;&nbsp;</a><a href="/aprendizaje/relacionar/'.$aprendizaje->id.'"><i class="fa fa-retweet"></i> Relacionar </a>';
            $html .= '</div>';
            $html .= '</div>';
        }
        
        echo json_encode(array("results" => $html));
    }
    
    public function delete($id)
    {
        $model  = Container::getModel("aprendizaje");
        $result = $model->delete($id);
        
        if($result)
        {
            header('Location: /aprendizaje');
        }
    }
    
    public function edit($aParam)
    {
        $aParam    = (array) $aParam;
        $aPaises   = $this->GetPais();
        $model     = Container::getModel("aprendizaje");
        $result    = $model->edit($aParam);
        $aAnos     = $model->selectAnos();
        $html      = '';
        
        $html   .= '<div class="col-lg-6">';
        $html   .= '<div class="ibox">';
        $html   .= '<div class="ibox-title">';
        $html   .= '<h5>Editar Aprendizaje</h5>';
        $html   .= '</div>';
        $html   .= '<div class="ibox-content">';
        $html   .= '<div id="tab-1" class="">';
        $html   .= '<div class="panel-body">';
        $html   .= '<div class="col-lg-12">';
        $html   .= '<div class="form-group">';
        $html   .= '<label for="label">Aprendizaje</label>';
        $html   .= '<input type="text" class="form-control" name="aprendizaje" id="aprendizaje" value="'.$result[0]->aprendizaje.'">';
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
        $html   .= '<button type="button" onclick="AtualizarAprendizaje();" class="btn btn-w-m btn-warning">Actualizar</button>';
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
        
        $aParam['aprendizaje']     = filter_var($aParam['aprendizaje'], FILTER_SANITIZE_STRING);
        $aParam['descripcion']   = filter_var($aParam['descripcion'], FILTER_SANITIZE_STRING);
        
        $model  = Container::getModel("aprendizaje");
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
        $model = Container::getModel("aprendizaje");
        
        //Verifica se já existe relacao para editar
        $relacion = $model->getRelacion($id);
        
        if(!empty($relacion))
        {
            $aDados['procesos'] = (explode(",",$relacion[0]->ids_procesos));
            $aDados['aprendizajes'] = (explode(",",$relacion[0]->ids_aprendizajes));
            
            $this->view->existe = $relacion;
            $this->view->dados = $aDados;
        }
        
        //info do Aprendizaje
        $result = $model->getaprendizaje($id);
        $ano   = $result[0]->id_ano;
        //Get Pais
        $pais = $this->GetPaisUnico($result[0]->id_pais);
        
        if($result[0]->id_pais == 0)
        {
            $pais['nombre'] = 'GLOBAL';
            $pais['id']     = 0;
        }
        
        $result[0]->pais = $pais['nombre'];
        
        //Busca todos procesos
        $aProcesos = $model->getAllProcesos($ano, $pais['id']);
        $this->view->procesos = $aProcesos;
        
        //Busca todas asprendizajes exceto ela mesma
        $aAprendizajes = $model->getAllAprendizajes($id, $pais['id']);
        $this->view->aprendizajes = $aAprendizajes;
        
        //Get Idnices de Excelencia
        $kpis = $model->indicesExcelencia();
        
        $this->view->info = $result[0];
        
        $this->view->kpis = $kpis;
        
        /* Render View Relacionar Indicadores */
        $this->renderView('/aprendizajes/relacionar', 'layout');
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
        $idprcesos = '';
        $idaprendizajes = '';
        $contador = 1;
        $count    = 1;
        
        foreach($aParam['ids_proceso'] as $k=>$v)
        {
            if($contador == 1)
            {
                $idprocesos = $v;
            }
            else
            {
                $idprocesos = $idprocesos . ',' . $v;
            }
            $contador++;
        }
        
        foreach($aParam['ids_aprendizaje'] as $k=>$v)
        {
            if($count == 1)
            {
                $idaprendizajes = $v;
            }
            else
            {
                $idaprendizajes = $idaprendizajes . ',' . $v;
            }
            $count++;
        }
        
        $aParam['id_proceso'] = $idprocesos;
        $aParam['id_aprendizaje'] = $idaprendizajes;
        
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
        
        $model = Container::getModel("aprendizaje");
        
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