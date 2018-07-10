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
        }
        
        unset($aDados['method']);
        
        $model  = Container::getModel("Proyecto");
        
        $aAno =  $model->BuscaAno($aDados[0]['planificacion']);
        
        //Ano vinculado ao Projeto
        $aDados['ano'] = $aAno->id_ano;
        
        $aDados['pais'] = $_SESSION['Planificacion']['pais_id'];
        $aDados['sede'] = $_SESSION['Planificacion']['sede_id'];
        
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
}