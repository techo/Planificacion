<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class CPlanificacionController extends BaseController
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
        $this->setPageTitle('Create Planificacion');
        $model = Container::getModel("CPlanificacion");
        $this->view->cplanificacion = $model->select();
        
        for($i=0; $i < count($this->view->cplanificacion); $i++)
        {
            $aKPI[$i] = (array) $this->view->cplanificacion[$i];
            
            //Get Pais
            if($aKPI[$i]['id_pais'])
            {
                $pais = $this->GetPais($aKPI[$i]['id_pais']);
                $aKPI[$i]['pais'] = $pais['nombre'];
            }
            
            //Get Sede
            if($aKPI[$i]['id_sede'])
            {
                $sede = $this->GetSede($aKPI[$i]['id_sede']);
                $aKPI[$i]['sede'] = $sede[0]['nombre'];
            }
            
            $this->view->cplanificacion[$i] = (object) $aKPI[$i];
        }
        
        /* Render View Paises */
        $this->renderView('cplanificacion/index', 'layout');
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
    
    //Apos selecionar Pais no Cadastro de Indicadores, lista as sedes do Pais
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
    
    public function SearchSede($idPais)
    {
        $id = (array) $idPais;
        $id = $id['id'];
        
        //Busca Area
        $result = $this->Sedes($id);
        
        $html .= '<div class="col-lg-6">';
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
    
    public function add()
    {
        $this->setPageTitle('Crear Planificacion');
        $model = Container::getModel("cplanificacion");
        
        //Busca Anos
        $this->view->ano = $model->ListaAno();
        
        //Busca Pais
        $pais = $this->Paises();
        
        //Convert Array en Object
        for($i=0; $i < count($pais); $i++)
        {
            $pais[$i] = (object) $pais[$i];
        }
        //Lista Paises
        $this->view->pais = $pais;
        
        $this->view->indicador = $model->ListaIndicador();
        
        for($i=0; $i < count($this->view->indicador); $i++)
        {
            $aKPI[$i] = (array) $this->view->indicador[$i];
            
            //Get Area
            $area = $this->GetArea($aKPI[$i]['id_area']);
            $aKPI[$i]['area'] = $area['nombre'];
            
            $this->view->indicador[$i] = (object) $aKPI[$i];
            
        }
        
        $this->renderView('cplanificacion/add', 'layout');
    }
    
    public function save($aParam)
    {
        $aParam = (array) $aParam;
        
        //Quebra a String em Array para facilitar a gravacao e remove o elemento vazio
        $indicadores = explode(',',$aParam['indicadores']);
        $indicadores = array_filter($indicadores);
        
        $aParam['ano']    = filter_var($aParam['ano'], FILTER_SANITIZE_STRING);
        $aParam['pais']   = filter_var($aParam['pais'], FILTER_SANITIZE_STRING);
        $aParam['sede']   = filter_var($aParam['sede'], FILTER_SANITIZE_STRING);
        $aParam['status'] = filter_var($aParam['status'], FILTER_SANITIZE_STRING);
        
        $model  = Container::getModel("cplanificacion");
        //Grava Planificacion
        $result = $model->GuardarPlanificacion($aParam);
        
        //Se gravar com Sucesso grava os filhos (Indicadores)
        if($result)
        {
            //Id Cabecalho Planificacion
            $id = $result;
            
            for($i=0; $i < count($indicadores); $i++)
            {
                $indicador = $indicadores[$i];
                $result = $model->GuardarDetalheIndicadores($indicador, $id, $aParam['status']);
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
        else
        {
            echo json_encode(array("results" => false));
        }
    }
    
    public function show($id)
    {
        $this->setPageTitle('Editar Planificacion');
        $model = Container::getModel("cplanificacion");
        
        $this->view->cplanificacion = $model->search($id);
        $this->view->ano            = $model->ListaAno();
        
        //Busca Pais
        $pais = $this->Paises();
        
        //Convert Array en Object
        for($i=0; $i < count($pais); $i++)
        {
            $pais[$i] = (object) $pais[$i];
        }
        //Lista Paises
        $this->view->pais = $pais;
        
        //Busca Sede
        $sede = $this->Sedes($this->view->cplanificacion[0]->id_pais);
        
        //Convert Array en Object
        for($i=0; $i < count($sede); $i++)
        {
            $sede[$i] = (object) $sede[$i];
        }
        //Lista Paises
        $this->view->sede = $sede;
        
        //Todos Indicadores Cadastrados
        $this->view->indicador = $model->ListaIndicador();
        
        for($i=0; $i < count($this->view->indicador); $i++)
        {
            $aKPI[$i] = (array) $this->view->indicador[$i];
            
            //Get Area
            $area = $this->GetArea($aKPI[$i]['id_area']);
            $aKPI[$i]['area'] = $area['nombre'];
            
       //     $this->view->indicador[$i] = (object) $aKPI[$i];
            
        }
        
        //Lista de Indicadores do Registro em Edicao
        $aIndicadores = $model->KpisRegistro($this->view->cplanificacion[0]->id);
        $j = 0;
        
        //Verificar quais estao selecionados e quais nao para formar a lista
        for($i=0; $i < count($aKPI); $i++)
        {
            $aTeste = (array) $aIndicadores[$j];
            
            if($aKPI[$i]['id'] == $aTeste['id_indicador'])
            {
                $html .= '<tr class="odd selected">';
                $html .= '<td></td>';
                $html .= '<td hidden>'.$aKPI[$i]['id'].'</td>';
                $html .= '<td>'.$aKPI[$i]['indicador'].'</td>';
                $html .= '<td>'.$aKPI[$i]['temporalidad'].'</td>';
                $html .= '<td>'.$aKPI[$i]['tipo'].'</td>';
                $html .= '<td>'.$aKPI[$i]['pilar'].'</td>';
                $html .= '<td>'.$aKPI[$i]['area'].'</td>';
                $html .= '</tr>';
                $j++;
            }
            else 
            {
                $html .= '<tr>';
                $html .= '<td></td>';
                $html .= '<td hidden>'.$aKPI[$i]['id'].'</td>';
                $html .= '<td>'.$aKPI[$i]['indicador'].'</td>';
                $html .= '<td>'.$aKPI[$i]['temporalidad'].'</td>';
                $html .= '<td>'.$aKPI[$i]['tipo'].'</td>';
                $html .= '<td>'.$aKPI[$i]['pilar'].'</td>';
                $html .= '<td>'.$aKPI[$i]['area'].'</td>';
                $html .= '</tr>';
            }
        }
        
        //Devolvo o HTML
        $this->view->indicadores = $html;
        
        /* Render View Temporalidades */
        $this->renderView('cplanificacion/edit', 'layout');
    }
    
    public function edit($aParam)
    {
        $aParam = (array) $aParam;
        
        //Quebra a String em Array para facilitar a gravacao e remove o elemento vazio
        $indicadores = explode(',',$aParam['indicadores']);
        $indicadores = array_filter($indicadores);
        
        $aParam['ano']    = filter_var($aParam['ano'], FILTER_SANITIZE_STRING);
        $aParam['pais']   = filter_var($aParam['pais'], FILTER_SANITIZE_STRING);
        $aParam['sede']   = filter_var($aParam['sede'], FILTER_SANITIZE_STRING);
        $aParam['status'] = filter_var($aParam['status'], FILTER_SANITIZE_STRING);
        
        $model  = Container::getModel("cplanificacion");
        //Actualiza Planificacion
        $result = $model->ActualizarPlanificacion($aParam);
        
        //Se gravar com Sucesso grava os filhos (Indicadores)
        if($result)
        {
            //Verificar se os Indicadores ja comecaram a ser planificados, para decidir se pode alterar ou nao
            $ListaKPI = $model->BuscaIndicadores($aParam['id']);
            $verifica = true;
            
            for($i=0; $i < count($ListaKPI); $i++)
            {
                $indicador = (array) $ListaKPI[$i];
                
                if($indicador['date_update'] != '0000-00-00 00:00:00')
                {
                    $verifica = false;
                }
            }
            
            //Se esta variavel for false nao podemos alterar os KPIs pois ja comecou a planificar
            if($verifica)
            {
                //Apaga os Anteriores e Cria os Novos
                for($i=0; $i < count($ListaKPI); $i++)
                {
                    $indicador = (array) $ListaKPI[$i];
                    $model->ApagaIndicadores($aParam['id']);
                }
                
                //Comeca gravar os indicadores atualizados
                for($i=0; $i < count($indicadores); $i++)
                {
                    $indicador = $indicadores[$i];
                    $result = $model->GuardarDetalheIndicadores($indicador, $aParam['id'], $aParam['status']);
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
            else
            {
                //Retorna para view falando que deu ruim (comecou a planificar)
                echo json_encode(array("results" => false));
            }
        }
        else
        {
            //Erro na gravacao do Cabecalho
            echo json_encode(array("results" => false));
        }
    }
}