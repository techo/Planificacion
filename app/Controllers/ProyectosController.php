<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class ProyectosController extends BaseController
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
    
    public function add($aParam)
    {
        $aParam = (array) $aParam;

        $this->setPageTitle('Proyectos');
        $model = Container::getModel("Proyecto");
        
        //Busca Anos
        $this->view->ano = $model->ListaAno();
        
        //Busca Indicadores selecionados para o ano selecionado
        $this->view->indicador = $model->Listagem($aParam['id'], $aParam['sede'], $aParam['pais']);
        
        $this->renderView('proyecto/add', 'layout');
    }
    
    public function save($aParam)
    {
        $aParam = (array) $aParam;
        
        foreach($aParam as $k=>$v)
        {
            $aDados[$k]['planificacion'] = $v['planificacion'];
            $aDados[$k]['indicador']     = $v['indicador'];
            $aDados[$k]['ponderacion']   = $v['ponderacion'];
            $aDados[$k]['proyecto']      = $v['proyecto'];
            $aDados[$k]['responsable']   = $v['responsable'];
            $aDados[$k]['pais']          = $v['pais'];
            $aDados[$k]['sede']          = $v['sede'];
        }
        
        unset($aDados['method']);
        
        $model  = Container::getModel("Proyecto");
        
        $aAno =  $model->BuscaAno($aDados[0]['planificacion']);
        
        //Ano vinculado ao Projeto
        $aDados['ano'] = $aAno->id_ano;
        
        //Gravar Projeto
        $aRet = $model->GrabarProyecto($aDados);
        
        if($aRet)
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
        $model  = Container::getModel("Proyecto");
        $result = $model->delete($id);
        
        if($result)
        {
            header('Location: /planificacion');
        }
    }
    
    public function show($id)
    {
        $model = Container::getModel("Proyecto");
        $this->view->proyecto = $model->search($id);
        
        //Todos Indicadores Cadastrados
        $this->view->indicador = $model->ListaIndicador();
        
        //Verificar quais estao selecionados e quais nao para formar a lista
        for($i=0; $i < count($this->view->indicador); $i++)
        {
            $j = 0;
            $aTeste = (array) $this->view->indicador[$i];
            
            if($this->view->proyecto->id_indicador_1 == $aTeste['id'])
            {
                $html .= '<tr class="odd selected">';
                $html .= '<td></td>';
                $html .= '<td hidden>'.$this->view->proyecto->id_indicador_1 .'</td>';
                $html .= '<td>'.$aTeste['indicador'].'</td>';
                $html .= '<td>'.$aTeste['temporalidad'].'</td>';
                $html .= '<td>'.$aTeste['tipo'].'</td>';
                $html .= '<td>'.$this->view->proyecto->ponderacion_1.'</td>';
                $html .= '</tr>';
                $j++;
            }
            
            if($this->view->proyecto->id_indicador_2 == $aTeste['id'])
            {
                $html .= '<tr class="odd selected">';
                $html .= '<td></td>';
                $html .= '<td hidden>'.$this->view->proyecto->id_indicador_2 .'</td>';
                $html .= '<td>'.$aTeste['indicador'].'</td>';
                $html .= '<td>'.$aTeste['temporalidad'].'</td>';
                $html .= '<td>'.$aTeste['tipo'].'</td>';
                $html .= '<td>'.$this->view->proyecto->ponderacion_2.'</td>';
                $html .= '</tr>';
                $j++;
            }
            
            if($this->view->proyecto->id_indicador_3 == $aTeste['id'])
            {
                $html .= '<tr class="odd selected">';
                $html .= '<td></td>';
                $html .= '<td hidden>'.$this->view->proyecto->id_indicador_3 .'</td>';
                $html .= '<td>'.$aTeste['indicador'].'</td>';
                $html .= '<td>'.$aTeste['temporalidad'].'</td>';
                $html .= '<td>'.$aTeste['tipo'].'</td>';
                $html .= '<td>'.$this->view->proyecto->ponderacion_3.'</td>';
                $html .= '</tr>';
                $j++;
            }
            
            if($this->view->proyecto->id_indicador_4 == $aTeste['id'])
            {
                $html .= '<tr class="odd selected">';
                $html .= '<td></td>';
                $html .= '<td hidden>'.$this->view->proyecto->id_indicador_4 .'</td>';
                $html .= '<td>'.$aTeste['indicador'].'</td>';
                $html .= '<td>'.$aTeste['temporalidad'].'</td>';
                $html .= '<td>'.$aTeste['tipo'].'</td>';
                $html .= '<td>'.$this->view->proyecto->ponderacion_4.'</td>';
                $html .= '</tr>';
                $j++;
            }
            
            if($this->view->proyecto->id_indicador_5 == $aTeste['id'])
            {
                $html .= '<tr class="odd selected">';
                $html .= '<td></td>';
                $html .= '<td hidden>'.$this->view->proyecto->id_indicador_5 .'</td>';
                $html .= '<td>'.$aTeste['indicador'].'</td>';
                $html .= '<td>'.$aTeste['temporalidad'].'</td>';
                $html .= '<td>'.$aTeste['tipo'].'</td>';
                $html .= '<td>'.$this->view->proyecto->ponderacion_5.'</td>';
                $html .= '</tr>';
                $j++;
            }
            
            if($this->view->proyecto->id_indicador_6 == $aTeste['id'])
            {
                $html .= '<tr class="odd selected">';
                $html .= '<td></td>';
                $html .= '<td hidden>'.$this->view->proyecto->id_indicador_6 .'</td>';
                $html .= '<td>'.$aTeste['indicador'].'</td>';
                $html .= '<td>'.$aTeste['temporalidad'].'</td>';
                $html .= '<td>'.$aTeste['tipo'].'</td>';
                $html .= '<td>'.$this->view->proyecto->ponderacion_6.'</td>';
                $html .= '</tr>';
                $j++;
            }
            
            if($this->view->proyecto->id_indicador_7 == $aTeste['id'])
            {
                $html .= '<tr class="odd selected">';
                $html .= '<td></td>';
                $html .= '<td hidden>'.$this->view->proyecto->id_indicador_7 .'</td>';
                $html .= '<td>'.$aTeste['indicador'].'</td>';
                $html .= '<td>'.$aTeste['temporalidad'].'</td>';
                $html .= '<td>'.$aTeste['tipo'].'</td>';
                $html .= '<td>'.$this->view->proyecto->ponderacion_7.'</td>';
                $html .= '</tr>';
                $j++;
            }
            
            if($this->view->proyecto->id_indicador_8 == $aTeste['id'])
            {
                $html .= '<tr class="odd selected">';
                $html .= '<td></td>';
                $html .= '<td hidden>'.$this->view->proyecto->id_indicador_8 .'</td>';
                $html .= '<td>'.$aTeste['indicador'].'</td>';
                $html .= '<td>'.$aTeste['temporalidad'].'</td>';
                $html .= '<td>'.$aTeste['tipo'].'</td>';
                $html .= '<td>'.$this->view->proyecto->ponderacion_8.'</td>';
                $html .= '</tr>';
                $j++;
            }
            
            if($this->view->proyecto->id_indicador_9 == $aTeste['id'])
            {
                $html .= '<tr class="odd selected">';
                $html .= '<td></td>';
                $html .= '<td hidden>'.$this->view->proyecto->id_indicador_9 .'</td>';
                $html .= '<td>'.$aTeste['indicador'].'</td>';
                $html .= '<td>'.$aTeste['temporalidad'].'</td>';
                $html .= '<td>'.$aTeste['tipo'].'</td>';
                $html .= '<td>'.$this->view->proyecto->ponderacion_9.'</td>';
                $html .= '</tr>';
                $j++;
            }
            
            if($this->view->proyecto->id_indicador_10 == $aTeste['id'])
            {
                $html .= '<tr class="odd selected">';
                $html .= '<td></td>';
                $html .= '<td hidden>'.$this->view->proyecto->id_indicador_10 .'</td>';
                $html .= '<td>'.$aTeste['indicador'].'</td>';
                $html .= '<td>'.$aTeste['temporalidad'].'</td>';
                $html .= '<td>'.$aTeste['tipo'].'</td>';
                $html .= '<td>'.$this->view->proyecto->ponderacion_10.'</td>';
                $html .= '</tr>';
                $j++;
            }
            
            if($j == 0)
            {
                $html .= '<tr>';
                $html .= '<td></td>';
                $html .= '<td hidden>'.$aTeste['id'].'</td>';
                $html .= '<td>'.$aTeste['indicador'].'</td>';
                $html .= '<td>'.$aTeste['temporalidad'].'</td>';
                $html .= '<td>'.$aTeste['tipo'].'</td>';
                $html .= '<td> 0</td>';
                $html .= '</tr>';
            }
        }
        
        //Devolvo o HTML
        $this->view->indicadores = $html;
        
        /* Render View Paises */
        $this->renderView('Proyecto/edit', 'layout');
    }
}