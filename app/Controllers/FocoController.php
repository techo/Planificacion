<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class FocoController extends BaseController
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
        $this->setPageTitle('Focos');
        $model  = Container::getModel("Foco");
        $idPais = $_SESSION['Planificacion']['pais_id'];
        $this->view->foco = $model->select($idPais);
        
        for($i=0; $i < count($this->view->foco); $i++)
        {
            //Get Sede
            if($this->view->foco[$i]->id_sede)
            {
                $sede = $this->GetSede($this->view->foco[$i]->id_sede);
                $this->view->foco[$i]->sede =  $sede[0]['nombre'];
            }
            else
            {
                $this->view->foco[$i]->sede = 'standard';
            }
        }
        
        /* Render View Paises */
        $this->renderView('foco/index', 'layout');
    }
    
    public function add()
    {
        $this->setPageTitle('Focos');
        $this->setPageTitle('Focos');
        $model = Container::getModel("Foco");
        
        $this->view->ano = $model->selectAnos();
        
        //Busca Pais
        $pais = $this->Paises();
        
        //Convert Array en Object
        for($i=0; $i < count($pais); $i++)
        {
            $pais[$i] = (object) $pais[$i];
        }
        //Lista Paises
        $this->view->pais = $pais;
        
        $this->view->indicador = $model->CarregaIndicadores();
        
        $this->renderView('foco/add', 'layout');
    }
    
    public function save($aParam)
    {
        $aParam = (array) $aParam;
        
        //Encabecado
        $aParam['nombre']       = filter_var($aParam['nombre'], FILTER_SANITIZE_STRING);
        $aParam['descripcion']  = filter_var($aParam['descripcion'], FILTER_SANITIZE_STRING);
        $aParam['obs']          = filter_var($aParam['obs'], FILTER_SANITIZE_STRING);
        $aParam['id_ano']       = filter_var($aParam['id_ano'], FILTER_SANITIZE_STRING);
        $aParam['id_pais']      = filter_var($aParam['id_pais'], FILTER_SANITIZE_STRING);
        $aParam['id_sede']      = filter_var($aParam['id_sede'], FILTER_SANITIZE_STRING);
        
        // detalle del Foco - indicadores
        $indicadores = explode(',',$aParam['indicadores']);
        $indicadores = array_filter($indicadores);
        
        // detalle del Foco - Podneracion
        $ponderacion = explode(',',$aParam['ponderacion']);
        $ponderacion = array_filter($ponderacion);
        
        $model  = Container::getModel("Foco");
        $result = $model->GuardarFoco($aParam);
        
        //Id Encabezado Foco
        $id = $result;
        
        foreach ($indicadores as $key => $value)
        {
            $indicador   = $value;
            $nponderacion = $ponderacion[$key] ? $ponderacion[$key] : '0.00';
            
            $result = $model->GuardarDetalleFoco($indicador, $id, $nponderacion);
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
    
    public function show($id)
    {
        $this->setPageTitle('Focos');
        $model = Container::getModel("Foco");
        $this->view->foco = $model->search($id);
        
        //Ano
        $this->view->ano = $model->ListaAno();
        
        //Pais
        $pais = $this->Paises();
        
        //Convert Array en Object
        for($i=0; $i < count($pais); $i++)
        {
            $pais[$i] = (object) $pais[$i];
        }
        //Lista Paises
        $this->view->pais = $pais;
        
        //Busca Sedes
        $sede = $this->Sedes($this->view->foco->id_pais);
        
        //Convert Array en Object
        for($i=0; $i < count($sede); $i++)
        {
            $sede[$i] = (object) $sede[$i];
        }
        //Lista Paises
        $this->view->sede = $sede;
        
        //Todos Indicadores
        $this->view->todos_indicadores = $model->CarregaIndicadores();
        
        //Indicadores que ya fueron elejidos anteriormente
        $this->view->indicador_elejidos = $model->IndicadoresFoco($id);
        
        /* Render View Paises */
        $this->renderView('foco/edit', 'layout');
    }
    
    public function edit($aParam)
    {
        $aDados = array();
        $aParam = (array) $aParam;
        $i = 0;
        
        //Encabecado
        $aParam['nombre']       = filter_var($aParam['nombre'], FILTER_SANITIZE_STRING);
        $aParam['descripcion']  = filter_var($aParam['descripcion'], FILTER_SANITIZE_STRING);
        $aParam['obs']          = filter_var($aParam['obs'], FILTER_SANITIZE_STRING);
        $aParam['id_ano']       = filter_var($aParam['id_ano'], FILTER_SANITIZE_STRING);
        $aParam['id_pais']      = filter_var($aParam['id_pais'], FILTER_SANITIZE_STRING);
        $aParam['id_sede']      = filter_var($aParam['id_sede'], FILTER_SANITIZE_STRING);
        
        // detalle del Foco - indicadores
        $indicadores = explode(',',$aParam['indicadores']);
        $indicadores = array_filter($indicadores);
        
        // detalle del Foco - Podneracion
        $ponderacion = explode(',',$aParam['ponderacion']);
        $ponderacion = array_filter($ponderacion);
        
        //Atualizar el encabezado focos
        $model  = Container::getModel("Foco");
        $result = $model->ActualizaFoco($aParam);
        $idFoco = $aParam['id'];
        //hace una comparacion entre el array nuevo de indicadores y el viejo para añadir o borrar el registro de indicador
        $aIndicadores = $model->IndicadoresFoco($idFoco);
        
        foreach ($aIndicadores as $value) 
        {
            $aDados[$i] = $value->id_indicador;
            $i++;
        }
        
        /*Arrays de Indicadores a serem removidos e adicionados no Foco*/
        $remover   = array_diff($aDados, $indicadores);
        $adicionar = array_diff($indicadores, $aDados);
        
        if(!empty($remover))
        {
            foreach ($remover as $value)
            {
                $result = $model->RemoveIndicador($value, $idFoco);
            }
        }
        
        if(!empty($adicionar))
        {
            foreach ($adicionar as $key => $value)
            {
                $result = $model->AddIndicador($value, $idFoco, $ponderacion[$key]);
            }
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
    
    public function delete($id)
    {
        $model  = Container::getModel("Foco");
        $result = $model->delete($id);
        
        if($result)
        {
            header('Location: /foco');
        }
    }
    
    public function SearchSede($idPais)
    {
        $id = (array) $idPais;
        $id = $id['id'];
        
        //Busca Area
        $result = $this->Sedes($id);
        
        $html .= '<div class="col-lg-3">';
        $html .= '<div class="form-group">';
        $html .= '<label for="sede">Sede</label>';
        $html .= '<select  id="sede" class="form-control" >';
        $html .= '<option value="0">-- SELECCIONE --</option>';
        foreach ($result as $sede)
        {
            $html.= '<option value="'.$sede['id'].'">'.$sede['sede'].'</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        
        echo ($html);
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
    
    //Apos selecionar Pais no Cadastro de Focos, lista as sedes do Pais selecionado
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