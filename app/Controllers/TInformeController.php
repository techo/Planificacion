<?php 
namespace App\Controllers;

use Core\BaseController;
use Core\Container;

class TInformeController extends BaseController
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
        
        //Busca Sedes
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
        
        //Busca Indicadores
        $result = $model->BuscaIndicadores($idplanificacion, $pais, $sede);
        
        $html .= '<div class="col-lg-6">';
        $html .= '<div class="form-group">';
        $html .= '<label for="indicadores">Indicadores</label>';
        $html .= '<select  id="indicador" class="form-control" >';
        $html .= '<option value="0">-- SELECCIONE --</option>';
        foreach ($result as $indicadores)
        {
            $html.= '<option value="'.$indicadores->id_indicador.'">'.$indicadores->indicador.'</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        
        echo ($html);
    }
    
    public function CarregaTrimestre($aDados)
    {
        //Buscar Paises Planificados neste ano
        $aDados         = (array) $aDados;
        
        $idplanificacion = $aDados['cplanificacion'];
        $pais            = $aDados['idPais'];
        $sede            = $aDados['idSede'];
        $indicador       = $aDados['idIndicador'];
        
        $model = Container::getModel("TInforme");
        
        //Busca Trismestre
        $result = $model->BuscaTrimestre($idplanificacion, $pais, $sede, $indicador);
        
        //Dados para o Chart Plan
        $T1Plan = $result[0]->enero_plan + $result[0]->febrero_plan + $result[0]->marzo_plan;
        $T2Plan = $result[0]->abril_plan + $result[0]->mayo_plan    + $result[0]->junio_plan;
        $T3Plan = $result[0]->julio_plan + $result[0]->agosto_plan  + $result[0]->septiembre_plan;
        $T4Plan = $result[0]->octubre_plan + $result[0]->noviembre_plan + $result[0]->diciembre_plan;
        
        //Dados para o Chart Real
        $T1Real = $result[0]->enero_real + $result[0]->febrero_real + $result[0]->marzo_real;
        $T2Real = $result[0]->abril_real + $result[0]->mayo_real + $result[0]->junio_real;
        $T3Real = $result[0]->julio_real + $result[0]->agosto_real + $result[0]->septiembre_real;
        $T4Real = $result[0]->octubre_real + $result[0]->noviembre_real + $result[0]->diciembre_real;
        
        //tudo junto pq deu merda separado
        echo json_encode(array("plan" => $T1Plan . ',' . $T2Plan . ',' . $T3Plan. ',' . $T4Plan . ',' . $T1Real. ',' . $T2Real. ',' . $T3Real. ',' . $T4Real));
      //  echo json_encode(array("real" => $T1Real. ',' . $T2Real. ',' . $T3Real. ',' . $T4Real));
    }
    
    public function mensual()
    {
        $this->setPageTitle('Informe Mensual');
        $model = Container::getModel("TInforme");
        
        //Busca Anos
        $this->view->ano = $model->ListAnos();
        
        /* Render View Paises */
        $this->renderView('tinforme/mensual', 'layout');
    }
    
    public function CarregaMensal($aDados)
    {
        //Buscar Paises Planificados neste ano
        $aDados         = (array) $aDados;
        
        $idplanificacion = $aDados['cplanificacion'];
        $pais            = $aDados['idPais'];
        $sede            = $aDados['idSede'];
        $indicador       = $aDados['idIndicador'];
        
        $model = Container::getModel("TInforme");
        
        //Busca Trismestre
        $result = $model->BuscaMensual($idplanificacion, $pais, $sede, $indicador);
        
        //Dados para o Chart Plan
        $EneroPlan      = $result[0]->enero_plan;
        $FebreroPlan    = $result[0]->febrero_plan;
        $MarzoPlan      = $result[0]->marzo_plan;
        $AbrilPlan      = $result[0]->abril_plan;
        $MayoPlan       = $result[0]->mayo_plan;
        $JunioPlan      = $result[0]->junio_plan;
        $JulioPlan      = $result[0]->julio_plan;
        $AgostoPlan     = $result[0]->agosto_plan;
        $SeptiembrePlan = $result[0]->septiembre_plan;
        $OctubrePlan    = $result[0]->octubre_plan;
        $NoviembrePlan  = $result[0]->noviembre_plan;
        $DiciembrePlan  = $result[0]->diciembre_plan;
        
        //Dados para o Chart Real
        $EneroReal      = $result[0]->enero_real;
        $FebreroReal    = $result[0]->febrero_real;
        $MarzoReal      = $result[0]->marzo_real;
        $AbrilReal      = $result[0]->abril_real;
        $MayoReal       = $result[0]->mayo_real;
        $JunioReal      = $result[0]->junio_real;
        $JulioReal      = $result[0]->julio_real;
        $AgostoReal     = $result[0]->agosto_real;
        $SeptiembreReal = $result[0]->septiembre_real;
        $OctubreReal    = $result[0]->octubre_real;
        $NoviembreReal  = $result[0]->noviembre_real;
        $DiciembreReal  = $result[0]->diciembre_real;
        
        //tudo junto pq deu merda separado
        echo json_encode(array("plan" => $EneroPlan. ',' . $FebreroPlan. ',' . $MarzoPlan. ',' . $AbrilPlan. ',' . $MayoPlan. ',' . $JunioPlan. ',' . $JulioPlan. ',' . $AgostoPlan. ',' .$SeptiembrePlan. ',' .$OctubrePlan. ',' .$NoviembrePlan. ',' .$DiciembrePlan. ',' .
            $EneroReal. ',' .$FebreroReal. ',' .$MarzoReal. ',' .$AbrilReal. ',' .$MayoReal. ',' .$JunioReal. ',' .$JulioReal. ',' .$AgostoReal. ',' .$SeptiembreReal. ',' .$OctubreReal. ',' .$NoviembreReal. ',' .$DiciembreReal));
    }
    
    public function anual()
    {
        $this->setPageTitle('Informe Anual');
        $model = Container::getModel("TInforme");
        
        //Busca Anos
        $this->view->ano = $model->ListAnos();
        
        /* Render View Paises */
        $this->renderView('tinforme/anual', 'layout');
    }
    
    public function CarregaAnual($aDados)
    {
        //Buscar Paises Planificados neste ano
        $aDados         = (array) $aDados;
        
        $idplanificacion = $aDados['cplanificacion'];
        $pais            = $aDados['idPais'];
        $sede            = $aDados['idSede'];
        $indicador       = $aDados['idIndicador'];
        
        $model = Container::getModel("TInforme");
        
        //Busca Anual
        $result = $model->BuscaAnual($idplanificacion, $pais, $sede, $indicador);
        
        //Dados para o Chart Plan
        $aPlanificado = $result[0]->enero_plan + $result[0]->febrero_plan + $result[0]->marzo_plan + $result[0]->abril_plan + $result[0]->mayo_plan + 
                        $result[0]->junio_plan + $result[0]->julio_plan + $result[0]->agosto_plan  + $result[0]->septiembre_plan + $result[0]->octubre_plan +
                        $result[0]->noviembre_plan + $result[0]->diciembre_plan;
                
        //Dados para o Chart Real
        $aRealizado  = $result[0]->enero_real + $result[0]->febrero_real + $result[0]->marzo_real + $result[0]->abril_real + $result[0]->mayo_real + 
                       $result[0]->junio_real + $result[0]->julio_real + $result[0]->agosto_real + $result[0]->septiembre_real + $result[0]->octubre_real + 
                       $result[0]->noviembre_real + $result[0]->diciembre_real;
               
        //tudo junto pq deu merda separado
        echo json_encode(array("plan" => $aPlanificado. ',' . $aRealizado));
    }
    
    public function Monitoreo()
    {
        $this->setPageTitle('Monitoreo KPIs');
        $model = Container::getModel("TInforme");
        
        //Busca Anos
        $this->view->ano = $model->ListAnos();
        
        /* Render View Paises */
        $this->renderView('tinforme/monitoreo', 'layout');
    }
    
    public function BuscaValoresMonitoreo($aDados)
    {
        $aDados = (array) $aDados;
        
        $idplanificacion = $aDados['cplanificacion']; // sei qual planificacao pelo ano
        $pais            = $aDados['idPais'];
        $sede            = $aDados['idSede'];
        
        $model = Container::getModel("TInforme");
        
        //Busca Anual
        $result = $model->BuscaMonitoreo($idplanificacion, $pais, $sede);
        
        for($i=0; $i < count($result); $i++)
        {
            $result[$i] = (array) $result[$i];
            
            $this->view->indicadores[$i] = (object) $result[$i];
        }
        
        //Montar Grid Monitoreo KPIs
        $html  = '';
        $html .= '<div  class="wrapper wrapper-content animated fadeInRight">';
        $html .= '<div class="row">';
        $html .= '<div class="col-lg-12">';
        $html .= '<div class="ibox float-e-margins">';
        $html .= '<div class="ibox-title">';
        $html .= '<h5>Monitoreo de KPIs</h5>';
        $html .= '</div>';
        $html .= '<div class="ibox-content">';
        $html .= '<div id="tablecontent"><table class="display responsive nowrap table table-striped table-bordered table-hover dataTables-example" style="width:100%">';
        //$html .= '<table class="table table-striped table-bordered table-hover dataTables-example" >';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>KPI</th>';
        $html .= '<th>Tipo</th>';
        $html .= '<th>P. Anual</th>';
        $html .= '<th>R. Anual </th>';
        $html .= '<th>% (R/P) Anual</th>';
        $html .= '<th>P. T1</th>';
        $html .= '<th>R. T1</th>';
        $html .= '<th>% (R/P) T1</th>';
        $html .= '<th>P. T2</th>';
        $html .= '<th>R. T2</th>';
        $html .= '<th>% (R/P) T2</th>';
        $html .= '<th>P. T3</th>';
        $html .= '<th>R. T3</th>';
        $html .= '<th>% (R/P) T3</th>';
        $html .= '<th>P. T4</th>';
        $html .= '<th>R. T4</th>';
        $html .= '<th>% (R/P) T4</th>';
        $html .= '<th>P. S1</th>';
        $html .= '<th>R. S1</th>';
        $html .= '<th>% (R/P) S1</th>';
        $html .= '<th>P. S2</th>';
        $html .= '<th>R. S2</th>';
        $html .= '<th>% (R/P) S2</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        
        foreach ($this->view->indicadores as $indicadores)
        {
            $formato = $indicadores->formato;
            $porcento = ' % ';
            
            if($formato == '#')
            {
                $formato = '&#160;';
            }
            
            $html .= '<tr class="gradeX">';
            $html .= '<td>' . $indicadores->indicador . '</td>';
            $html .= '<td>' . $indicadores->tipo. '</td>';
            
            if($indicadores->tipo == 'Acumulado')
            {
                $html .= '<td>' . $indicadores->acumulado_plan_anual . ' ' . $formato .'</td>';
                $html .= '<td>' . $indicadores->acumulado_real_anual. ' ' .$formato .'</td>';
                
                //Cor Acumulado RP Anual
                if((number_format($indicadores->acumulado_rp_anual, 2, '.', '') <= '0.00') || (number_format($indicadores->acumulado_rp_anual, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->acumulado_rp_anual, 2, '.', '') >= '60.00') && (number_format($indicadores->acumulado_rp_anual, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->acumulado_rp_anual, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->acumulado_rp_anual. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->acumulado_plan_t1. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->acumulado_real_t1. ' ' .$formato .'</td>';
                
                //Cor Acumulado RP T1
                if((number_format($indicadores->acumulado_rp_t1, 2, '.', '') <= '0.00') || (number_format($indicadores->acumulado_rp_t1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->acumulado_rp_t1, 2, '.', '') >= '60.00') && (number_format($indicadores->acumulado_rp_t1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->acumulado_rp_t1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->acumulado_rp_t1. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->acumulado_plan_t2. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->acumulado_real_t2. ' ' .$formato .'</td>';
                
                //Cor Acumulado RP T2
                if((number_format($indicadores->acumulado_rp_t2, 2, '.', '') <= '0.00') || (number_format($indicadores->acumulado_rp_t2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->acumulado_rp_t2, 2, '.', '') >= '60.00') && (number_format($indicadores->acumulado_rp_t2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->acumulado_rp_t2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->acumulado_rp_t2. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->acumulado_plan_t3. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->acumulado_real_t3. ' ' .$formato .'</td>';
                
                //Cor Acumulado RP T3
                if((number_format($indicadores->acumulado_rp_t3, 2, '.', '') <= '0.00') || (number_format($indicadores->acumulado_rp_t3, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->acumulado_rp_t3, 2, '.', '') >= '60.00') && (number_format($indicadores->acumulado_rp_t3, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->acumulado_rp_t3, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->acumulado_rp_t3. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->acumulado_plan_t4. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->acumulado_real_t4. ' ' .$formato .'</td>';
                
                //Cor Acumulado RP T4
                if((number_format($indicadores->acumulado_rp_t4, 2, '.', '') <= '0.00') || (number_format($indicadores->acumulado_rp_t4, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->acumulado_rp_t4, 2, '.', '') >= '60.00') && (number_format($indicadores->acumulado_rp_t4, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->acumulado_rp_t4, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->acumulado_rp_t4. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->acumulado_plan_s1. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->acumulado_real_s1. ' ' .$formato .'</td>';
                
                //Cor Acumulado RP S1
                if((number_format($indicadores->acumulado_rp_s1, 2, '.', '') <= '0.00') || (number_format($indicadores->acumulado_rp_s1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->acumulado_rp_s1, 2, '.', '') >= '60.00') && (number_format($indicadores->acumulado_rp_s1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->acumulado_rp_s1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->acumulado_rp_s1. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->acumulado_plan_s2. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->acumulado_real_s2. ' ' .$formato .'</td>';
                
                //Cor Acumulado RP S2
                if((number_format($indicadores->acumulado_rp_s2, 2, '.', '') <= '0.00') || (number_format($indicadores->acumulado_rp_s2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->acumulado_rp_s2, 2, '.', '') >= '60.00') && (number_format($indicadores->acumulado_rp_s2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->acumulado_rp_s2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                $html .= '<td class="'.$cCor.'">' . $indicadores->acumulado_rp_s2. ' ' .$porcento.'</td>';
                
            }
            
            if($indicadores->tipo == 'Promedio')
            {
                $html .= '<td>' . $indicadores->promedio_plan_anual. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->promedio_real_anual. ' ' .$formato .'</td>';
                
                //Cor Promedio RP Anual
                if((number_format($indicadores->promedio_rp_anual, 2, '.', '') <= '0.00') || (number_format($indicadores->promedio_rp_anual, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->promedio_rp_anual, 2, '.', '') >= '60.00') && (number_format($indicadores->promedio_rp_anual, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->promedio_rp_anual, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->promedio_rp_anual. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->promedio_plan_t1. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->promedio_real_t1. ' ' .$formato .'</td>';
                
                //Cor Promedio RP T1
                if((number_format($indicadores->promedio_rp_t1, 2, '.', '') <= '0.00') || (number_format($indicadores->promedio_rp_t1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->promedio_rp_t1, 2, '.', '') >= '60.00') && (number_format($indicadores->promedio_rp_t1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->promedio_rp_t1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->promedio_rp_t1. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->promedio_plan_t2. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->promedio_real_t2. ' ' .$formato .'</td>';
                
                //Cor promedio RP T2
                if((number_format($indicadores->promedio_rp_t2, 2, '.', '') <= '0.00') || (number_format($indicadores->promedio_rp_t2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->promedio_rp_t2, 2, '.', '') >= '60.00') && (number_format($indicadores->promedio_rp_t2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->promedio_rp_t2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->promedio_rp_t2. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->promedio_plan_t3. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->promedio_real_t3. ' ' .$formato .'</td>';
                
                //Cor promedio RP T3
                if((number_format($indicadores->promedio_rp_t3, 2, '.', '') <= '0.00') || (number_format($indicadores->promedio_rp_t3, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->promedio_rp_t3, 2, '.', '') >= '60.00') && (number_format($indicadores->promedio_rp_t3, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->promedio_rp_t3, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->promedio_rp_t3. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->promedio_plan_t4. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->promedio_real_t4. ' ' .$formato .'</td>';
                
                //Cor promedio RP T4
                if((number_format($indicadores->promedio_rp_t4, 2, '.', '') <= '0.00') || (number_format($indicadores->promedio_rp_t4, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->promedio_rp_t4, 2, '.', '') >= '60.00') && (number_format($indicadores->promedio_rp_t4, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->promedio_rp_t4, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->promedio_rp_t4. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->promedio_plan_s1. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->promedio_real_s1. ' ' .$formato .'</td>';
                
                //Cor Promedio RP S1
                if((number_format($indicadores->promedio_rp_s1, 2, '.', '') <= '0.00') || (number_format($indicadores->promedio_rp_s1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->promedio_rp_s1, 2, '.', '') >= '60.00') && (number_format($indicadores->promedio_rp_s1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->promedio_rp_s1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->promedio_rp_s1. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->promedio_plan_s2. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->promedio_real_s2. ' ' .$formato .'</td>';
                
                //Cor Promedio RP S2
                if((number_format($indicadores->promedio_rp_s2, 2, '.', '') <= '0.00') || (number_format($indicadores->promedio_rp_s2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->promedio_rp_s2, 2, '.', '') >= '60.00') && (number_format($indicadores->promedio_rp_s2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->promedio_rp_s2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->promedio_rp_s2. ' ' .$porcento.'</td>';
            }
            
            if($indicadores->tipo == 'Minimo')
            {
                $html .= '<td>' . $indicadores->minimo_plan_anual. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->minimo_real_anual. ' ' .$formato .'</td>';
                
                //Cor Minimo RP Anual
                if((number_format($indicadores->minimo_rp_anual, 2, '.', '') <= '0.00') || (number_format($indicadores->minimo_rp_anual, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->minimo_rp_anual, 2, '.', '') >= '60.00') && (number_format($indicadores->minimo_rp_anual, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->minimo_rp_anual, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->minimo_rp_anual. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->minimo_plan_t1. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->minimo_real_t1. ' ' .$formato .'</td>';
                
                //Cor minimo RP T1
                if((number_format($indicadores->minimo_rp_t1, 2, '.', '') <= '0.00') || (number_format($indicadores->minimo_rp_t1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->minimo_rp_t1, 2, '.', '') >= '60.00') && (number_format($indicadores->minimo_rp_t1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->minimo_rp_t1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->minimo_rp_t1. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->minimo_plan_t2. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->minimo_real_t2. ' ' .$formato .'</td>';
                
                //Cor minimo RP T2
                if((number_format($indicadores->minimo_rp_t2, 2, '.', '') <= '0.00') || (number_format($indicadores->minimo_rp_t2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->minimo_rp_t2, 2, '.', '') >= '60.00') && (number_format($indicadores->minimo_rp_t2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->minimo_rp_t2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->minimo_rp_t2. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->minimo_plan_t3. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->minimo_real_t3. ' ' .$formato .'</td>';
                
                //Cor minimo RP T3
                if((number_format($indicadores->minimo_rp_t3, 2, '.', '') <= '0.00') || (number_format($indicadores->minimo_rp_t3, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->minimo_rp_t3, 2, '.', '') >= '60.00') && (number_format($indicadores->minimo_rp_t3, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->minimo_rp_t3, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->minimo_rp_t3. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->minimo_plan_t4. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->minimo_real_t4. ' ' .$formato .'</td>';
                
                //Cor minimo RP T4
                if((number_format($indicadores->minimo_rp_t4, 2, '.', '') <= '0.00') || (number_format($indicadores->minimo_rp_t4, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->minimo_rp_t4, 2, '.', '') >= '60.00') && (number_format($indicadores->minimo_rp_t4, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->minimo_rp_t4, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->minimo_rp_t4. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->minimo_plan_s1. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->minimo_real_s1. ' ' .$formato .'</td>';
                
                //Cor Minimo RP S1
                if((number_format($indicadores->minimo_rp_s1, 2, '.', '') <= '0.00') || (number_format($indicadores->minimo_rp_s1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->minimo_rp_s1, 2, '.', '') >= '60.00') && (number_format($indicadores->minimo_rp_s1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->minimo_rp_s1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->minimo_rp_s1. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->minimo_plan_s2. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->minimo_real_s2. ' ' .$formato .'</td>';
                
                //Cor Minimo RP S2
                if((number_format($indicadores->minimo_rp_s2, 2, '.', '') <= '0.00') || (number_format($indicadores->minimo_rp_s2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->minimo_rp_s2, 2, '.', '') >= '60.00') && (number_format($indicadores->minimo_rp_s2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->minimo_rp_s2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->minimo_rp_s2. ' ' .$porcento.'</td>';
            }
            
            if($indicadores->tipo == 'Maximo')
            {
                $html .= '<td>' . $indicadores->maximo_plan_anual. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->maximo_real_anual. ' ' .$formato .'</td>';
                
                //Cor Maximo RP Anual
                if((number_format($indicadores->maximo_rp_anual, 2, '.', '') <= '0.00') || (number_format($indicadores->maximo_rp_anual, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->maximo_rp_anual, 2, '.', '') >= '60.00') && (number_format($indicadores->maximo_rp_anual, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->maximo_rp_anual, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->maximo_rp_anual. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->maximo_plan_t1. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->maximo_real_t1. ' ' .$formato .'</td>';
                
                //Cor maximo RP T1
                if((number_format($indicadores->maximo_rp_t1, 2, '.', '') <= '0.00') || (number_format($indicadores->maximo_rp_t1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->maximo_rp_t1, 2, '.', '') >= '60.00') && (number_format($indicadores->maximo_rp_t1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->maximo_rp_t1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->maximo_rp_t1. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->maximo_plan_t2. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->maximo_real_t2. ' ' .$formato .'</td>';
                
                //Cor maximo RP T2
                if((number_format($indicadores->maximo_rp_t2, 2, '.', '') <= '0.00') || (number_format($indicadores->maximo_rp_t2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->maximo_rp_t2, 2, '.', '') >= '60.00') && (number_format($indicadores->maximo_rp_t2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->maximo_rp_t2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->maximo_rp_t2. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->maximo_plan_t3. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->maximo_real_t3. ' ' .$formato .'</td>';
                
                //Cor maximo RP T3
                if((number_format($indicadores->maximo_rp_t3, 2, '.', '') <= '0.00') || (number_format($indicadores->maximo_rp_t3, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->maximo_rp_t3, 2, '.', '') >= '60.00') && (number_format($indicadores->maximo_rp_t3, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->maximo_rp_t3, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->maximo_rp_t3. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->maximo_plan_t4. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->maximo_real_t4. ' ' .$formato .'</td>';
                
                //Cor maximo RP T4
                if((number_format($indicadores->maximo_rp_t4, 2, '.', '') <= '0.00') || (number_format($indicadores->maximo_rp_t4, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->maximo_rp_t4, 2, '.', '') >= '60.00') && (number_format($indicadores->maximo_rp_t4, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->maximo_rp_t4, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->maximo_rp_t4. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->maximo_plan_s1. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->maximo_real_s1. ' ' .$formato .'</td>';
                
                //Cor Maximo RP S1
                if((number_format($indicadores->maximo_rp_s1, 2, '.', '') <= '0.00') || (number_format($indicadores->maximo_rp_s1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->maximo_rp_s1, 2, '.', '') >= '60.00') && (number_format($indicadores->maximo_rp_s1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->maximo_rp_s1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->maximo_rp_s1. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->maximo_plan_s2. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->maximo_real_s2. ' ' .$formato .'</td>';
                
                //Cor Maximo RP S2
                if((number_format($indicadores->maximo_rp_s2, 2, '.', '') <= '0.00') || (number_format($indicadores->maximo_rp_s2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->maximo_rp_s2, 2, '.', '') >= '60.00') && (number_format($indicadores->maximo_rp_s2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->maximo_rp_s2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->maximo_rp_s2. ' ' .$porcento.'</td>';
            }
            
            if($indicadores->tipo == 'Ultimo')
            {
                $html .= '<td>' . $indicadores->ultimo_plan_anual. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->ultimo_real_anual. ' ' .$formato .'</td>';
                
                //Cor Ultimo RP Anual
                if((number_format($indicadores->ultimo_rp_anual, 2, '.', '') <= '0.00') || (number_format($indicadores->ultimo_rp_anual, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->ultimo_rp_anual, 2, '.', '') >= '60.00') && (number_format($indicadores->ultimo_rp_anual, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->ultimo_rp_anual, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->ultimo_rp_anual. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->ultimo_plan_t1. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->ultimo_real_t1. ' ' .$formato .'</td>';
                
                //Cor ultimo RP T1
                if((number_format($indicadores->ultimo_rp_t1, 2, '.', '') <= '0.00') || (number_format($indicadores->ultimo_rp_t1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->ultimo_rp_t1, 2, '.', '') >= '60.00') && (number_format($indicadores->ultimo_rp_t1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->ultimo_rp_t1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->ultimo_rp_t1. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->ultimo_plan_t2. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->ultimo_real_t2. ' ' .$formato .'</td>';
                
                //Cor ultimo RP T2
                if((number_format($indicadores->ultimo_rp_t2, 2, '.', '') <= '0.00') || (number_format($indicadores->ultimo_rp_t2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->ultimo_rp_t2, 2, '.', '') >= '60.00') && (number_format($indicadores->ultimo_rp_t2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->ultimo_rp_t2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->ultimo_rp_t2. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->ultimo_plan_t3. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->ultimo_real_t3. ' ' .$formato .'</td>';
                
                //Cor ultimo RP T3
                if((number_format($indicadores->ultimo_rp_t3, 2, '.', '') <= '0.00') || (number_format($indicadores->ultimo_rp_t3, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->ultimo_rp_t3, 2, '.', '') >= '60.00') && (number_format($indicadores->ultimo_rp_t3, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->ultimo_rp_t3, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->ultimo_rp_t3. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->ultimo_plan_t4. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->ultimo_real_t4. ' ' .$formato .'</td>';
                
                //Cor ultimo RP T4
                if((number_format($indicadores->ultimo_rp_t4, 2, '.', '') <= '0.00') || (number_format($indicadores->ultimo_rp_t4, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->ultimo_rp_t4, 2, '.', '') >= '60.00') && (number_format($indicadores->ultimo_rp_t4, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->ultimo_rp_t4, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->ultimo_rp_t4. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->ultimo_plan_s1. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->ultimo_real_s1. ' ' .$formato .'</td>';
                
                //Cor Ultimo RP S1
                if((number_format($indicadores->ultimo_rp_s1, 2, '.', '') <= '0.00') || (number_format($indicadores->ultimo_rp_s1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->ultimo_rp_s1, 2, '.', '') >= '60.00') && (number_format($indicadores->ultimo_rp_s1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->ultimo_rp_s1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->ultimo_rp_s1. ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->ultimo_plan_s2. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->ultimo_real_s2. ' ' .$formato .'</td>';
                
                //Cor Ultimo RP S2
                if((number_format($indicadores->ultimo_rp_s2, 2, '.', '') <= '0.00') || (number_format($indicadores->ultimo_rp_s2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->ultimo_rp_s2, 2, '.', '') >= '60.00') && (number_format($indicadores->ultimo_rp_s2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->ultimo_rp_s2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . $indicadores->ultimo_rp_s2. ' ' .$porcento.'</td>';
            }
        }
        
        $html .= '</tbody>';
        $html .= '</table></div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
               
        echo ($html);
    }
    
    public function Monitoreo2()
    {
        $this->setPageTitle('Monitoreo KPIs por Pa&iacute;s');
        $model = Container::getModel("TInforme");
        
        //Busca Anos
        $this->view->ano = $model->ListAnos();
        
        /* Render View Paises */
        $this->renderView('tinforme/monitoreo2', 'layout');
    }
    
    public function BuscaValoresMonitoreo2($aDados)
    {
        $aDados = (array) $aDados;
        
        $idplanificacion = $aDados['cplanificacion']; // sei qual planificacao pelo ano
        $pais            = $aDados['idPais'];
        
        $model = Container::getModel("TInforme");
        
        $aRet = $model->BuscaDadosGerais($pais, $idplanificacion);
        
//         echo('<pre>');
//         die(print_r($aRet, true));
        
        //Montar Grid Monitoreo KPIs
        $html  = '';
        $html .= '<div  class="wrapper wrapper-content animated fadeInRight">';
        $html .= '<div class="row">';
        $html .= '<div class="col-lg-12">';
        $html .= '<div class="ibox float-e-margins">';
        $html .= '<div class="ibox-title">';
        $html .= '<h5>Monitoreo de KPIs</h5>';
        $html .= '</div>';
        $html .= '<div class="ibox-content">';
        $html .= '<div id="tablecontent"> <table class="display responsive nowrap table table-striped table-bordered table-hover dataTables-example" style="width:100%">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>KPI</th>';
        $html .= '<th>Tipo</th>';
        $html .= '<th>P. Anual</th>';
        $html .= '<th>R. Anual </th>';
        $html .= '<th>% (R/P)</th>';
        $html .= '<th>P. T1</th>';
        $html .= '<th>R. T1</th>';
        $html .= '<th>% (R/P) T1</th>';
        $html .= '<th>P. T2</th>';
        $html .= '<th>R. T2</th>';
        $html .= '<th>% (R/P) T2</th>';
        $html .= '<th>P. T3</th>';
        $html .= '<th>R. T3</th>';
        $html .= '<th>% (R/P) T3</th>';
        $html .= '<th>P. T4</th>';
        $html .= '<th>R. T4</th>';
        $html .= '<th>% (R/P) T4</th>';
        $html .= '<th>P. S1</th>';
        $html .= '<th>R. S1</th>';
        $html .= '<th>% (R/P) S1</th>';
        $html .= '<th>P. S2</th>';
        $html .= '<th>R. S2</th>';
        $html .= '<th>% (R/P) S2</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        
        foreach ($aRet as $indicadores)
        {
            $cCor = '';
            $formato = $indicadores->formato;
            $porcento = ' % ';
            
            if($formato == '#')
            {
                $formato = '&#160;';
            }
            
            $html .= '<tr class="gradeX">';
            $html .= '<td title="'. $indicadores->indicador .'">' . $indicadores->indicador . '</td>';
            $html .= '<td>' . $indicadores->tipo. '</td>';
            
            if($indicadores->tipo == 'Acumulado')
            {
               
                $html .= '<td>' . number_format($indicadores->acumulado_plan_anual, 2, ',', '.') . ' ' . $formato .'</td>';
                $html .= '<td>' . number_format($indicadores->acumulado_real_anual, 2, ',', '.'). ' ' .$formato .'</td>';
                
                //Cor Acumulado RP Anual
                if((number_format($indicadores->acumulado_rp_t1, 2, '.', '') <= '0.00') || (number_format($indicadores->acumulado_rp_t1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->acumulado_rp_t1, 2, '.', '') >= '60.00') && (number_format($indicadores->acumulado_rp_t1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->acumulado_rp_t1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->acumulado_rp_anual, 2, ',', ''). ' ' .$porcento.'</td>';
                $html .= '<td>' . number_format($indicadores->acumulado_plan_t1, 2, ',', '.') . ' ' .$formato .'</td>';
                $html .= '<td>' . number_format($indicadores->acumulado_real_t1, 2, ',', '.') . ' ' .$formato .'</td>';
                
                //Cor Acumulado RP T1
                if((number_format($indicadores->acumulado_rp_t1, 2, '.', '') <= '0.00') || (number_format($indicadores->acumulado_rp_t1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->acumulado_rp_t1, 2, '.', '') >= '60.00') && (number_format($indicadores->acumulado_rp_t1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->acumulado_rp_t1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->acumulado_rp_t1, 2, ',', ''). ' ' .$porcento.'</td>';
                $html .= '<td>' . number_format($indicadores->acumulado_plan_t2, 2, ',', '.') . ' ' .$formato .'</td>';
                $html .= '<td>' . number_format($indicadores->acumulado_real_t2, 2, ',', '.') . ' ' .$formato .'</td>';
                
                //Cor Acumulado RP T2
                if((number_format($indicadores->acumulado_rp_t2, 2, '.', '') <= '0.00') || (number_format($indicadores->acumulado_rp_t2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->acumulado_rp_t2, 2, '.', '') >= '60.00') && (number_format($indicadores->acumulado_rp_t2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->acumulado_rp_t2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->acumulado_rp_t2, 2, ',', ''). ' ' .$porcento.'</td>';
                $html .= '<td>' . number_format($indicadores->acumulado_plan_t3, 2, ',', '.') . ' ' .$formato .'</td>';
                $html .= '<td>' . number_format($indicadores->acumulado_real_t3, 2, ',', '.') . ' ' .$formato .'</td>';
                
                //Cor Acumulado RP T3
                if((number_format($indicadores->acumulado_rp_t3, 2, '.', '') <= '0.00') || (number_format($indicadores->acumulado_rp_t3, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->acumulado_rp_t3, 2, '.', '') >= '60.00') && (number_format($indicadores->acumulado_rp_t3, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->acumulado_rp_t3, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->acumulado_rp_t3, 2, ',', ''). ' ' .$porcento.'</td>';
                $html .= '<td>' . number_format($indicadores->acumulado_plan_t4, 2, ',', '.') . ' ' .$formato .'</td>';
                $html .= '<td>' . number_format($indicadores->acumulado_real_t4, 2, ',', '.') . ' ' .$formato .'</td>';
                
                //Cor Acumulado RP T4
                if((number_format($indicadores->acumulado_rp_t4, 2, '.', '') <= '0.00') || (number_format($indicadores->acumulado_rp_t4, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->acumulado_rp_t4, 2, '.', '') >= '60.00') && (number_format($indicadores->acumulado_rp_t4, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->acumulado_rp_t4, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->acumulado_rp_t4, 2, ',', ''). ' ' .$porcento.'</td>';
                $html .= '<td>' . number_format($indicadores->acumulado_plan_s1, 2, ',', '.') . ' ' .$formato .'</td>';
                $html .= '<td>' . number_format($indicadores->acumulado_real_s1, 2, ',', '.') . ' ' .$formato .'</td>';
                
                //Cor Acumulado RP S1
                if((number_format($indicadores->acumulado_rp_s1, 2, '.', '') <= '0.00') || (number_format($indicadores->acumulado_rp_s1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->acumulado_rp_s1, 2, '.', '') >= '60.00') && (number_format($indicadores->acumulado_rp_s1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->acumulado_rp_s1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->acumulado_rp_s1, 2, ',', ''). ' ' .$porcento.'</td>';
                $html .= '<td>' . number_format($indicadores->acumulado_plan_s2, 2, ',', '.') . ' ' .$formato .'</td>';
                $html .= '<td>' . number_format($indicadores->acumulado_real_s2, 2, ',', '.') . ' ' .$formato .'</td>';
                
                //Cor Acumulado RP S2
                if((number_format($indicadores->acumulado_rp_s2, 2, '.', '') <= '0.00') || (number_format($indicadores->acumulado_rp_s2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->acumulado_rp_s2, 2, '.', '') >= '60.00') && (number_format($indicadores->acumulado_rp_s2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->acumulado_rp_s2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->acumulado_rp_s2, 2, ',', '.'). ' ' .$porcento.'</td>';
                
            }
            
            if($indicadores->tipo == 'Promedio')
            {
                $html .= '<td>' . $indicadores->promedio_plan_anual. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->promedio_real_anual. ' ' .$formato .'</td>';
                
                //Cor Promedio RP Anual
                if((number_format($indicadores->promedio_rp_anual, 2, '.', '') <= '0.00') || (number_format($indicadores->promedio_rp_anual, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->promedio_rp_anual, 2, '.', '') >= '60.00') && (number_format($indicadores->promedio_rp_anual, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->promedio_rp_anual, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->promedio_rp_anual, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->promedio_plan_t1. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->promedio_real_t1. ' ' .$formato .'</td>';
                
                //Cor Promedio RP T1
                if((number_format($indicadores->promedio_rp_t1, 2, '.', '') <= '0.00') || (number_format($indicadores->promedio_rp_t1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->promedio_rp_t1, 2, '.', '') >= '60.00') && (number_format($indicadores->promedio_rp_t1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->promedio_rp_t1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->promedio_rp_t1, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->promedio_plan_t2. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->promedio_real_t2. ' ' .$formato .'</td>';
                
                //Cor promedio RP T2
                if((number_format($indicadores->promedio_rp_t2, 2, '.', '') <= '0.00') || (number_format($indicadores->promedio_rp_t2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->promedio_rp_t2, 2, '.', '') >= '60.00') && (number_format($indicadores->promedio_rp_t2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->promedio_rp_t2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->promedio_rp_t2, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->promedio_plan_t3. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->promedio_real_t3. ' ' .$formato .'</td>';
                
                //Cor promedio RP T3
                if((number_format($indicadores->promedio_rp_t3, 2, '.', '') <= '0.00') || (number_format($indicadores->promedio_rp_t3, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->promedio_rp_t3, 2, '.', '') >= '60.00') && (number_format($indicadores->promedio_rp_t3, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->promedio_rp_t3, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->promedio_rp_t3, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->promedio_plan_t4. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->promedio_real_t4. ' ' .$formato .'</td>';
                
                //Cor promedio RP T4
                if((number_format($indicadores->promedio_rp_t4, 2, '.', '') <= '0.00') || (number_format($indicadores->promedio_rp_t4, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->promedio_rp_t4, 2, '.', '') >= '60.00') && (number_format($indicadores->promedio_rp_t4, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->promedio_rp_t4, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->promedio_rp_t4, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->promedio_plan_s1. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->promedio_real_s1. ' ' .$formato .'</td>';
                
                //Cor Promedio RP S1
                if((number_format($indicadores->promedio_rp_s1, 2, '.', '') <= '0.00') || (number_format($indicadores->promedio_rp_s1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->promedio_rp_s1, 2, '.', '') >= '60.00') && (number_format($indicadores->promedio_rp_s1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->promedio_rp_s1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->promedio_rp_s1, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->promedio_plan_s2. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->promedio_real_s2. ' ' .$formato .'</td>';
                
                //Cor Promedio RP S2
                if((number_format($indicadores->promedio_rp_s2, 2, '.', '') <= '0.00') || (number_format($indicadores->promedio_rp_s2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->promedio_rp_s2, 2, '.', '') >= '60.00') && (number_format($indicadores->promedio_rp_s2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->promedio_rp_s2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->promedio_rp_s2, 2, ',', ' '). ' ' .$porcento.'</td>';
            }
            
            if($indicadores->tipo == 'Minimo')
            {
                $html .= '<td>' . $indicadores->minimo_plan_anual. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->minimo_real_anual. ' ' .$formato .'</td>';
                
                //Cor Minimo RP Anual
                if((number_format($indicadores->minimo_rp_anual, 2, '.', '') <= '0.00') || (number_format($indicadores->minimo_rp_anual, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->minimo_rp_anual, 2, '.', '') >= '60.00') && (number_format($indicadores->minimo_rp_anual, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->minimo_rp_anual, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->minimo_rp_anual, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->minimo_plan_t1. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->minimo_real_t1. ' ' .$formato .'</td>';
                
                //Cor minimo RP T1
                if((number_format($indicadores->minimo_rp_t1, 2, '.', '') <= '0.00') || (number_format($indicadores->minimo_rp_t1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->minimo_rp_t1, 2, '.', '') >= '60.00') && (number_format($indicadores->minimo_rp_t1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->minimo_rp_t1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->minimo_rp_t1, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->minimo_plan_t2. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->minimo_real_t2. ' ' .$formato .'</td>';
                
                //Cor minimo RP T2
                if((number_format($indicadores->minimo_rp_t2, 2, '.', '') <= '0.00') || (number_format($indicadores->minimo_rp_t2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->minimo_rp_t2, 2, '.', '') >= '60.00') && (number_format($indicadores->minimo_rp_t2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->minimo_rp_t2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->minimo_rp_t2, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->minimo_plan_t3. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->minimo_real_t3. ' ' .$formato .'</td>';
                
                //Cor minimo RP T3
                if((number_format($indicadores->minimo_rp_t3, 2, '.', '') <= '0.00') || (number_format($indicadores->minimo_rp_t3, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->minimo_rp_t3, 2, '.', '') >= '60.00') && (number_format($indicadores->minimo_rp_t3, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->minimo_rp_t3, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->minimo_rp_t3, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->minimo_plan_t4. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->minimo_real_t4. ' ' .$formato .'</td>';
                
                //Cor minimo RP T4
                if((number_format($indicadores->minimo_rp_t4, 2, '.', '') <= '0.00') || (number_format($indicadores->minimo_rp_t4, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->minimo_rp_t4, 2, '.', '') >= '60.00') && (number_format($indicadores->minimo_rp_t4, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->minimo_rp_t4, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->minimo_rp_t4, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->minimo_plan_s1. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->minimo_real_s1. ' ' .$formato .'</td>';
                
                //Cor Minimo RP S1
                if((number_format($indicadores->minimo_rp_s1, 2, '.', '') <= '0.00') || (number_format($indicadores->minimo_rp_s1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->minimo_rp_s1, 2, '.', '') >= '60.00') && (number_format($indicadores->minimo_rp_s1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->minimo_rp_s1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->minimo_rp_s1, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->minimo_plan_s2. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->minimo_real_s2. ' ' .$formato .'</td>';
                
                //Cor Minimo RP S2
                if((number_format($indicadores->minimo_rp_s2, 2, '.', '') <= '0.00') || (number_format($indicadores->minimo_rp_s2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->minimo_rp_s2, 2, '.', '') >= '60.00') && (number_format($indicadores->minimo_rp_s2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->minimo_rp_s2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->minimo_rp_s2, 2, ',', ' '). ' ' .$porcento.'</td>';
            }
            
            if($indicadores->tipo == 'Maximo')
            {
                $html .= '<td>' . $indicadores->maximo_plan_anual. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->maximo_real_anual. ' ' .$formato .'</td>';
                
                //Cor Maximo RP Anual
                if((number_format($indicadores->maximo_rp_anual, 2, '.', '') <= '0.00') || (number_format($indicadores->maximo_rp_anual, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->maximo_rp_anual, 2, '.', '') >= '60.00') && (number_format($indicadores->maximo_rp_anual, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->maximo_rp_anual, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->maximo_rp_anual, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->maximo_plan_t1. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->maximo_real_t1. ' ' .$formato .'</td>';
                
                //Cor maximo RP T1
                if((number_format($indicadores->maximo_rp_t1, 2, '.', '') <= '0.00') || (number_format($indicadores->maximo_rp_t1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->maximo_rp_t1, 2, '.', '') >= '60.00') && (number_format($indicadores->maximo_rp_t1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->maximo_rp_t1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->maximo_rp_t1, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->maximo_plan_t2. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->maximo_real_t2. ' ' .$formato .'</td>';
                
                //Cor maximo RP T2
                if((number_format($indicadores->maximo_rp_t2, 2, '.', '') <= '0.00') || (number_format($indicadores->maximo_rp_t2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->maximo_rp_t2, 2, '.', '') >= '60.00') && (number_format($indicadores->maximo_rp_t2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->maximo_rp_t2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->maximo_rp_t2, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->maximo_plan_t3. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->maximo_real_t3. ' ' .$formato .'</td>';
                
                //Cor maximo RP T3
                if((number_format($indicadores->maximo_rp_t3, 2, '.', '') <= '0.00') || (number_format($indicadores->maximo_rp_t3, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->maximo_rp_t3, 2, '.', '') >= '60.00') && (number_format($indicadores->maximo_rp_t3, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->maximo_rp_t3, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->maximo_rp_t3, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->maximo_plan_t4. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->maximo_real_t4. ' ' .$formato .'</td>';
                
                //Cor maximo RP T4
                if((number_format($indicadores->maximo_rp_t4, 2, '.', '') <= '0.00') || (number_format($indicadores->maximo_rp_t4, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->maximo_rp_t4, 2, '.', '') >= '60.00') && (number_format($indicadores->maximo_rp_t4, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->maximo_rp_t4, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->maximo_rp_t4, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->maximo_plan_s1. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->maximo_real_s1. ' ' .$formato .'</td>';
                
                //Cor Maximo RP S1
                if((number_format($indicadores->maximo_rp_s1, 2, '.', '') <= '0.00') || (number_format($indicadores->maximo_rp_s1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->maximo_rp_s1, 2, '.', '') >= '60.00') && (number_format($indicadores->maximo_rp_s1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->maximo_rp_s1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->maximo_rp_s1, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->maximo_plan_s2. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->maximo_real_s2. ' ' .$formato .'</td>';
                
                //Cor Maximo RP S2
                if((number_format($indicadores->maximo_rp_s2, 2, '.', '') <= '0.00') || (number_format($indicadores->maximo_rp_s2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->maximo_rp_s2, 2, '.', '') >= '60.00') && (number_format($indicadores->maximo_rp_s2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->maximo_rp_s2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->maximo_rp_s2, 2, ',', ' '). ' ' .$porcento.'</td>';
            }
            
            if($indicadores->tipo == 'Ultimo')
            {
                $html .= '<td>' . $indicadores->ultimo_plan_anual. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->ultimo_real_anual. ' ' .$formato .'</td>';
                
                //Cor Ultimo RP Anual
                if((number_format($indicadores->ultimo_rp_anual, 2, '.', '') <= '0.00') || (number_format($indicadores->ultimo_rp_anual, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->ultimo_rp_anual, 2, '.', '') >= '60.00') && (number_format($indicadores->ultimo_rp_anual, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->ultimo_rp_anual, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->ultimo_rp_anual, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->ultimo_plan_t1. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->ultimo_real_t1. ' ' .$formato .'</td>';
                
                //Cor ultimo RP T1
                if((number_format($indicadores->ultimo_rp_t1, 2, '.', '') <= '0.00') || (number_format($indicadores->ultimo_rp_t1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->ultimo_rp_t1, 2, '.', '') >= '60.00') && (number_format($indicadores->ultimo_rp_t1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->ultimo_rp_t1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->ultimo_rp_t1, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->ultimo_plan_t2. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->ultimo_real_t2. ' ' .$formato .'</td>';
                
                //Cor ultimo RP T2
                if((number_format($indicadores->ultimo_rp_t2, 2, '.', '') <= '0.00') || (number_format($indicadores->ultimo_rp_t2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->ultimo_rp_t2, 2, '.', '') >= '60.00') && (number_format($indicadores->ultimo_rp_t2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->ultimo_rp_t2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->ultimo_rp_t2, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->ultimo_plan_t3. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->ultimo_real_t3. ' ' .$formato .'</td>';
                
                //Cor ultimo RP T3
                if((number_format($indicadores->ultimo_rp_t3, 2, '.', '') <= '0.00') || (number_format($indicadores->ultimo_rp_t3, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->ultimo_rp_t3, 2, '.', '') >= '60.00') && (number_format($indicadores->ultimo_rp_t3, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->ultimo_rp_t3, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->ultimo_rp_t3, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->ultimo_plan_t4. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->ultimo_real_t4. ' ' .$formato .'</td>';
                
                //Cor ultimo RP T4
                if((number_format($indicadores->ultimo_rp_t4, 2, '.', '') <= '0.00') || (number_format($indicadores->ultimo_rp_t4, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->ultimo_rp_t4, 2, '.', '') >= '60.00') && (number_format($indicadores->ultimo_rp_t4, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->ultimo_rp_t4, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->ultimo_rp_t4, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->ultimo_plan_s1. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->ultimo_real_s1. ' ' .$formato .'</td>';
                
                //Cor Ultimo RP S1
                if((number_format($indicadores->ultimo_rp_s1, 2, '.', '') <= '0.00') || (number_format($indicadores->ultimo_rp_s1, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->ultimo_rp_s1, 2, '.', '') >= '60.00') && (number_format($indicadores->ultimo_rp_s1, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->ultimo_rp_s1, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->ultimo_rp_s1, 2, ',', ' '). ' ' .$porcento.'</td>';
                $html .= '<td>' . $indicadores->ultimo_plan_s2. ' ' .$formato .'</td>';
                $html .= '<td>' . $indicadores->ultimo_real_s2. ' ' .$formato .'</td>';
                
                //Cor Ultimo RP S2
                if((number_format($indicadores->ultimo_rp_s2, 2, '.', '') <= '0.00') || (number_format($indicadores->ultimo_rp_s2, 2, '.', '') <= '59.99'))
                {
                    $cCor = 'Vermelho';
                }
                
                if((number_format($indicadores->ultimo_rp_s2, 2, '.', '') >= '60.00') && (number_format($indicadores->ultimo_rp_s2, 2, '.', '') <= '79.99'))
                {
                    $cCor = 'Amarelo';
                }
                
                if((number_format($indicadores->ultimo_rp_s2, 2, '.', '') >= '80.00'))
                {
                    $cCor = 'Verde';
                }
                
                $html .= '<td class="'.$cCor.'">' . number_format($indicadores->ultimo_rp_s2, 2, ',', ' '). ' ' .$porcento.'</td>';
            }
        }
        
        $html .= '</tbody>';
        $html .= '</table></div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        echo ($html);
        
    }
    
    public function MonitoreoProyecto()
    {
        $this->setPageTitle('Monitoreo Proyecto');
        $model = Container::getModel("TInforme");
        
        //Busca Anos
        $this->view->ano = $model->ListAnos();
        
        /* Render View Paises */
        $this->renderView('tinforme/mproyecto', 'layout');
        
    }
    
    public function BuscaValoresProyecto($aDados)
    {
        $aDados = (array) $aDados;
        
        $cplanificacion  = $aDados['cplanificacion'];
        $pais            = $aDados['idPais'];
        $sede            = $aDados['idSede'];
        
        $model = Container::getModel("TInforme");
        
        //Busca Dados
        $result = $model->BuscaProyectos($cplanificacion, $pais, $sede);
        $i = 0;
        
        if(empty($result))
        {
            $html = '<!DOCTYPE html>
                    <html>
                    <head>
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <style>
                    .alert {
                        padding: 20px;
                        background-color: #f44336;
                        color: white;
                    }
                    
                    .closebtn {
                        margin-left: 15px;
                        color: white;
                        font-weight: bold;
                        float: right;
                        font-size: 22px;
                        line-height: 20px;
                        cursor: pointer;
                        transition: 0.3s;
                    }
                    
                    .closebtn:hover {
                        color: black;
                    }
                    </style>
                    </head>
                    <body>
                    
                    <div class="alert">
                      <strong>Alerta!</strong> No Hay Proyectos Creados!.
                    </div>
                    
                    </body>
                    </html>';
            echo ($html);
            die();
        }
        
        foreach ($result as $dados)
        {
            //Montar Grid Monitoreo Proyectos
            $html .= '<div  class="wrapper wrapper-content animated fadeInRight">';
            $html .= '<div class="row">';
            $html .= '<div class="col-lg-12">';
            $html .= '<div class="ibox float-e-margins">';
            $html .= '<div class="ibox-title">';
            $html .= '<h5><b>'. $dados->proyecto. '</b></h5>';
            $html .= '</div>';
            $html .= '<div class="ibox-content" style="visibility: show;">';
         //   $html .= '<a id="mostrar'.$i.'" href="javascript:mostrar('.$i.');">Ocultar</a>';
            $html .= '<div id="tablecontent-'.$i.'"> <table class="display responsive nowrap table table-striped table-bordered table-hover dataTables-example" style="width:100%">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th>Proyecto</th>';
            $html .= '<th>KPI</th>';
            $html .= '<th class="azul">Peso/Ponderaci&oacute;n</th>';
            $html .= '<th class="azul">Plan '. $dados->ano .'</th>';
            $html .= '<th class="azul">Real '. $dados->ano .'</th>';
            $html .= '<th class="azul">% (R/P) '. $dados->ano .'</th>';
            $html .= '<th class="azul">Plan S1</th>';
            $html .= '<th class="azul">Real S1</th>';
            $html .= '<th class="azul">% (R/P)</th>';
            $html .= '<th class="azul">Plan S2</th>';
            $html .= '<th class="azul">Real S2</th>';
            $html .= '<th class="azul">% (R/P)</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            
            $html .= '<tr class="gradeX">';
            $html .= '<td title="'. $dados->proyecto.'">' . $dados->proyecto. '</td>';
            
            if($dados->Indicador1)
            {
                $html .= '<td title="'. $dados->Indicador1.'">' . $dados->Indicador1. '</td>';
                $html .= '<td title="'. $dados->Ponderacion1.'">' . $dados->Ponderacion1. '</td>';
                
                //Busca Tipo do Indicador
               // $tipo = $model->BuscaTipo($dados->Id_1);
                
                //Busca Dados do KPI 1
                $aRet = $model->BuscaDadosGerais($dados->id_pais, $dados->cplanificacion, $dados->Id_1);
                
                if(!empty($aRet))
                {
                    //Anual
                    $tipo_plan = strtolower($aRet[0]->tipo) . '_plan_anual';
                    $tipo_real = strtolower($aRet[0]->tipo) . '_real_anual';
                    $tipo_rp   = strtolower($aRet[0]->tipo) . '_rp_anual';
                    
                    //S1
                    $tipo_plans1 = strtolower($aRet[0]->tipo) . '_plan_s1';
                    $tipo_reals1 = strtolower($aRet[0]->tipo) . '_real_s1';
                    $tipo_rps1   = strtolower($aRet[0]->tipo) . '_rp_s1';
                    
                    //S2
                    $tipo_plans2 = strtolower($aRet[0]->tipo) . '_plan_s2';
                    $tipo_reals2 = strtolower($aRet[0]->tipo) . '_real_s2';
                    $tipo_rps2   = strtolower($aRet[0]->tipo) . '_rp_s2';
                    
                    //Cor RP Anual
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '0.00') || (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '59.99'))
                    {
                        $cCor = 'Vermelho';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '60.00') && (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '79.99'))
                    {
                        $cCor = 'Amarelo';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '80.00'))
                    {
                        $cCor = 'Verde';
                    }
                    //Anual
                    $html .= '<td title="'. $aRet[0]->$tipo_plan .'">' . $aRet[0]->$tipo_plan . '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_real .'">' . $aRet[0]->$tipo_real . '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rp, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rp, 2, '.', '') . '</td>';
                    
                    //S1
                    $html .= '<td title="'. $aRet[0]->$tipo_plans1.'">' . $aRet[0]->$tipo_plans1. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals1.'">' . $aRet[0]->$tipo_reals1. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps1, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps1, 2, '.', '') . '</td>';
                    
                    //S2
                    $html .= '<td title="'. $aRet[0]->$tipo_plans2.'">' . $aRet[0]->$tipo_plans2. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals2.'">' . $aRet[0]->$tipo_reals2. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps2, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps2, 2, '.', '') . '</td>';
                }
                
            }
            
            if($dados->Indicador2)
            {
                $html .= '<tr>';
                $html .= '<th></th>';
                $html .= '<td title="'. $dados->Indicador2.'">' . $dados->Indicador2. '</td>';
                $html .= '<td title="'. $dados->Ponderacion2.'">' . $dados->Ponderacion2. '</td>';
                
                //Busca Dados do KPI 2
                $aRet = $model->BuscaDadosGerais($dados->id_pais, $dados->cplanificacion, $dados->Id_2);
                
                if(!empty($aRet))
                {
                    //Anual
                    $tipo_plan = strtolower($aRet[0]->tipo) . '_plan_anual';
                    $tipo_real = strtolower($aRet[0]->tipo) . '_real_anual';
                    $tipo_rp   = strtolower($aRet[0]->tipo) . '_rp_anual';
                    
                    //S1
                    $tipo_plans1 = strtolower($aRet[0]->tipo) . '_plan_s1';
                    $tipo_reals1 = strtolower($aRet[0]->tipo) . '_real_s1';
                    $tipo_rps1   = strtolower($aRet[0]->tipo) . '_rp_s1';
                    
                    //S2
                    $tipo_plans2 = strtolower($aRet[0]->tipo) . '_plan_s2';
                    $tipo_reals2 = strtolower($aRet[0]->tipo) . '_real_s2';
                    $tipo_rps2   = strtolower($aRet[0]->tipo) . '_rp_s2';
                    
                    //Cor RP Anual
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '0.00') || (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '59.99'))
                    {
                        $cCor = 'Vermelho';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '60.00') && (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '79.99'))
                    {
                        $cCor = 'Amarelo';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '80.00'))
                    {
                        $cCor = 'Verde';
                    }
                    
                    //Anual
                    $html .= '<td title="'. $aRet[0]->$tipo_plan .'">' . $aRet[0]->$tipo_plan . '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_real .'">' . $aRet[0]->$tipo_real . '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rp, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rp, 2, '.', '') . '</td>';
                    
                    //S1
                    $html .= '<td title="'. $aRet[0]->$tipo_plans1.'">' . $aRet[0]->$tipo_plans1. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals1.'">' . $aRet[0]->$tipo_reals1. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps1, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps1, 2, '.', '') . '</td>';
                    
                    //S2
                    $html .= '<td title="'. $aRet[0]->$tipo_plans2.'">' . $aRet[0]->$tipo_plans2. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals2.'">' . $aRet[0]->$tipo_reals2. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps2, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps2, 2, '.', '') . '</td>';
                }
            }
            
            if($dados->Indicador3)
            {
                $html .= '<tr>';
                $html .= '<th></th>';
                $html .= '<td title="'. $dados->Indicador3.'">' . $dados->Indicador3. '</td>';
                $html .= '<td title="'. $dados->Ponderacion3.'">' . $dados->Ponderacion3. '</td>';
                
                //Busca Dados do KPI 3
                $aRet = $model->BuscaDadosGerais($dados->id_pais, $dados->cplanificacion, $dados->Id_3);
                
                if(!empty($aRet))
                {
                    //Anual
                    $tipo_plan = strtolower($aRet[0]->tipo) . '_plan_anual';
                    $tipo_real = strtolower($aRet[0]->tipo) . '_real_anual';
                    $tipo_rp   = strtolower($aRet[0]->tipo) . '_rp_anual';
                    
                    //S1
                    $tipo_plans1 = strtolower($aRet[0]->tipo) . '_plan_s1';
                    $tipo_reals1 = strtolower($aRet[0]->tipo) . '_real_s1';
                    $tipo_rps1   = strtolower($aRet[0]->tipo) . '_rp_s1';
                    
                    //S2
                    $tipo_plans2 = strtolower($aRet[0]->tipo) . '_plan_s2';
                    $tipo_reals2 = strtolower($aRet[0]->tipo) . '_real_s2';
                    $tipo_rps2   = strtolower($aRet[0]->tipo) . '_rp_s2';
                    
                    //Cor RP Anual
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '0.00') || (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '59.99'))
                    {
                        $cCor = 'Vermelho';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '60.00') && (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '79.99'))
                    {
                        $cCor = 'Amarelo';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '80.00'))
                    {
                        $cCor = 'Verde';
                    }
                    
                    //Anual
                    $html .= '<td title="'. $aRet[0]->$tipo_plan .'">' . $aRet[0]->$tipo_plan . '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_real .'">' . $aRet[0]->$tipo_real . '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rp, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rp, 2, '.', '') . '</td>';
                    
                    //S1
                    $html .= '<td title="'. $aRet[0]->$tipo_plans1.'">' . $aRet[0]->$tipo_plans1. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals1.'">' . $aRet[0]->$tipo_reals1. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps1, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps1, 2, '.', '') . '</td>';
                    
                    //S2
                    $html .= '<td title="'. $aRet[0]->$tipo_plans2.'">' . $aRet[0]->$tipo_plans2. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals2.'">' . $aRet[0]->$tipo_reals2. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps2, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps2, 2, '.', '') . '</td>';
                }
            }
            
            if($dados->Indicador4)
            {
                $html .= '<tr>';
                $html .= '<th></th>';
                $html .= '<td title="'. $dados->Indicador4.'">' . $dados->Indicador4. '</td>';
                $html .= '<td title="'. $dados->Ponderacion4.'">' . $dados->Ponderacion4. '</td>';
                
                //Busca Dados do KPI 4
                $aRet = $model->BuscaDadosGerais($dados->id_pais, $dados->cplanificacion, $dados->Id_4);
                
                if(!empty($aRet))
                {
                    //Anual
                    $tipo_plan = strtolower($aRet[0]->tipo) . '_plan_anual';
                    $tipo_real = strtolower($aRet[0]->tipo) . '_real_anual';
                    $tipo_rp   = strtolower($aRet[0]->tipo) . '_rp_anual';
                    
                    //S1
                    $tipo_plans1 = strtolower($aRet[0]->tipo) . '_plan_s1';
                    $tipo_reals1 = strtolower($aRet[0]->tipo) . '_real_s1';
                    $tipo_rps1   = strtolower($aRet[0]->tipo) . '_rp_s1';
                    
                    //S2
                    $tipo_plans2 = strtolower($aRet[0]->tipo) . '_plan_s2';
                    $tipo_reals2 = strtolower($aRet[0]->tipo) . '_real_s2';
                    $tipo_rps2   = strtolower($aRet[0]->tipo) . '_rp_s2';
                    
                    //Cor RP Anual
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '0.00') || (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '59.99'))
                    {
                        $cCor = 'Vermelho';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '60.00') && (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '79.99'))
                    {
                        $cCor = 'Amarelo';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '80.00'))
                    {
                        $cCor = 'Verde';
                    }
                    
                    //Anual
                    $html .= '<td title="'. $aRet[0]->$tipo_plan .'">' . $aRet[0]->$tipo_plan . '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_real .'">' . $aRet[0]->$tipo_real . '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rp, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rp, 2, '.', '') . '</td>';
                    
                    //S1
                    $html .= '<td title="'. $aRet[0]->$tipo_plans1.'">' . $aRet[0]->$tipo_plans1. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals1.'">' . $aRet[0]->$tipo_reals1. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps1, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps1, 2, '.', '') . '</td>';
                    
                    //S2
                    $html .= '<td title="'. $aRet[0]->$tipo_plans2.'">' . $aRet[0]->$tipo_plans2. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals2.'">' . $aRet[0]->$tipo_reals2. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps2, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps2, 2, '.', '') . '</td>';
                }
            }
            
            if($dados->Indicador5)
            {
                $html .= '<tr>';
                $html .= '<th></th>';
                $html .= '<td title="'. $dados->Indicador5.'">' . $dados->Indicador5. '</td>';
                $html .= '<td title="'. $dados->Ponderacion5.'">' . $dados->Ponderacion5. '</td>';
                
                //Busca Dados do KPI 5
                $aRet = $model->BuscaDadosGerais($dados->id_pais, $dados->cplanificacion, $dados->Id_5);
                
                if(!empty($aRet))
                {
                    //Anual
                    $tipo_plan = strtolower($aRet[0]->tipo) . '_plan_anual';
                    $tipo_real = strtolower($aRet[0]->tipo) . '_real_anual';
                    $tipo_rp   = strtolower($aRet[0]->tipo) . '_rp_anual';
                    
                    //S1
                    $tipo_plans1 = strtolower($aRet[0]->tipo) . '_plan_s1';
                    $tipo_reals1 = strtolower($aRet[0]->tipo) . '_real_s1';
                    $tipo_rps1   = strtolower($aRet[0]->tipo) . '_rp_s1';
                    
                    //S2
                    $tipo_plans2 = strtolower($aRet[0]->tipo) . '_plan_s2';
                    $tipo_reals2 = strtolower($aRet[0]->tipo) . '_real_s2';
                    $tipo_rps2   = strtolower($aRet[0]->tipo) . '_rp_s2';
                    
                    //Cor RP Anual
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '0.00') || (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '59.99'))
                    {
                        $cCor = 'Vermelho';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '60.00') && (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '79.99'))
                    {
                        $cCor = 'Amarelo';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '80.00'))
                    {
                        $cCor = 'Verde';
                    }
                    
                    //Anual
                    $html .= '<td title="'. $aRet[0]->$tipo_plan .'">' . $aRet[0]->$tipo_plan . '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_real .'">' . $aRet[0]->$tipo_real . '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rp, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rp, 2, '.', '') . '</td>';
                    
                    //S1
                    $html .= '<td title="'. $aRet[0]->$tipo_plans1.'">' . $aRet[0]->$tipo_plans1. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals1.'">' . $aRet[0]->$tipo_reals1. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps1, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps1, 2, '.', '') . '</td>';
                    
                    //S2
                    $html .= '<td title="'. $aRet[0]->$tipo_plans2.'">' . $aRet[0]->$tipo_plans2. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals2.'">' . $aRet[0]->$tipo_reals2. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps2, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps2, 2, '.', '') . '</td>';
                }
            }
            
            if($dados->Indicador6)
            {
                $html .= '<tr>';
                $html .= '<th></th>';
                $html .= '<td title="'. $dados->Indicador6.'">' . $dados->Indicador6. '</td>';
                $html .= '<td title="'. $dados->Ponderacion6.'">' . $dados->Ponderacion6. '</td>';
                
                //Busca Dados do KPI 6
                $aRet = $model->BuscaDadosGerais($dados->id_pais, $dados->cplanificacion, $dados->Id_6);
                
                if(!empty($aRet))
                {
                    //Anual
                    $tipo_plan = strtolower($aRet[0]->tipo) . '_plan_anual';
                    $tipo_real = strtolower($aRet[0]->tipo) . '_real_anual';
                    $tipo_rp   = strtolower($aRet[0]->tipo) . '_rp_anual';
                    
                    //S1
                    $tipo_plans1 = strtolower($aRet[0]->tipo) . '_plan_s1';
                    $tipo_reals1 = strtolower($aRet[0]->tipo) . '_real_s1';
                    $tipo_rps1   = strtolower($aRet[0]->tipo) . '_rp_s1';
                    
                    //S2
                    $tipo_plans2 = strtolower($aRet[0]->tipo) . '_plan_s2';
                    $tipo_reals2 = strtolower($aRet[0]->tipo) . '_real_s2';
                    $tipo_rps2   = strtolower($aRet[0]->tipo) . '_rp_s2';
                    
                    //Cor RP Anual
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '0.00') || (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '59.99'))
                    {
                        $cCor = 'Vermelho';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '60.00') && (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '79.99'))
                    {
                        $cCor = 'Amarelo';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '80.00'))
                    {
                        $cCor = 'Verde';
                    }
                    
                    //Anual
                    $html .= '<td title="'. $aRet[0]->$tipo_plan .'">' . $aRet[0]->$tipo_plan . '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_real .'">' . $aRet[0]->$tipo_real . '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rp, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rp, 2, '.', '') . '</td>';
                    
                    //S1
                    $html .= '<td title="'. $aRet[0]->$tipo_plans1.'">' . $aRet[0]->$tipo_plans1. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals1.'">' . $aRet[0]->$tipo_reals1. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps1, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps1, 2, '.', '') . '</td>';
                    
                    //S2
                    $html .= '<td title="'. $aRet[0]->$tipo_plans2.'">' . $aRet[0]->$tipo_plans2. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals2.'">' . $aRet[0]->$tipo_reals2. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps2, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps2, 2, '.', '') . '</td>';
                }
            }
            
            if($dados->Indicador7)
            {
                $html .= '<tr>';
                $html .= '<th></th>';
                $html .= '<td title="'. $dados->Indicador7.'">' . $dados->Indicador7. '</td>';
                $html .= '<td title="'. $dados->Ponderacion7.'">' . $dados->Ponderacion7. '</td>';
                
                //Busca Dados do KPI 7
                $aRet = $model->BuscaDadosGerais($dados->id_pais, $dados->cplanificacion, $dados->Id_7);
                
                if(!empty($aRet))
                {
                    //Anual
                    $tipo_plan = strtolower($aRet[0]->tipo) . '_plan_anual';
                    $tipo_real = strtolower($aRet[0]->tipo) . '_real_anual';
                    $tipo_rp   = strtolower($aRet[0]->tipo) . '_rp_anual';
                    
                    //S1
                    $tipo_plans1 = strtolower($aRet[0]->tipo) . '_plan_s1';
                    $tipo_reals1 = strtolower($aRet[0]->tipo) . '_real_s1';
                    $tipo_rps1   = strtolower($aRet[0]->tipo) . '_rp_s1';
                    
                    //S2
                    $tipo_plans2 = strtolower($aRet[0]->tipo) . '_plan_s2';
                    $tipo_reals2 = strtolower($aRet[0]->tipo) . '_real_s2';
                    $tipo_rps2   = strtolower($aRet[0]->tipo) . '_rp_s2';
                    
                    //Cor RP Anual
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '0.00') || (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '59.99'))
                    {
                        $cCor = 'Vermelho';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '60.00') && (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '79.99'))
                    {
                        $cCor = 'Amarelo';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '80.00'))
                    {
                        $cCor = 'Verde';
                    }
                    
                    //Anual
                    $html .= '<td title="'. $aRet[0]->$tipo_plan .'">' . $aRet[0]->$tipo_plan . '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_real .'">' . $aRet[0]->$tipo_real . '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rp, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rp, 2, '.', '') . '</td>';
                    
                    //S1
                    $html .= '<td title="'. $aRet[0]->$tipo_plans1.'">' . $aRet[0]->$tipo_plans1. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals1.'">' . $aRet[0]->$tipo_reals1. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps1, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps1, 2, '.', '') . '</td>';
                    
                    //S2
                    $html .= '<td title="'. $aRet[0]->$tipo_plans2.'">' . $aRet[0]->$tipo_plans2. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals2.'">' . $aRet[0]->$tipo_reals2. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps2, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps2, 2, '.', '') . '</td>';
                }
            }
            
            if($dados->Indicador8)
            {
                $html .= '<tr';
                $html .= '<th></th>';
                $html .= '<td title="'. $dados->Indicador8.'">' . $dados->Indicador8. '</td>';
                $html .= '<td title="'. $dados->Ponderacion8.'">' . $dados->Ponderacion8. '</td>';
                
                //Busca Dados do KPI 8
                $aRet = $model->BuscaDadosGerais($dados->id_pais, $dados->cplanificacion, $dados->Id_8);
                
                if(!empty($aRet))
                {
                    //Anual
                    $tipo_plan = strtolower($aRet[0]->tipo) . '_plan_anual';
                    $tipo_real = strtolower($aRet[0]->tipo) . '_real_anual';
                    $tipo_rp   = strtolower($aRet[0]->tipo) . '_rp_anual';
                    
                    //S1
                    $tipo_plans1 = strtolower($aRet[0]->tipo) . '_plan_s1';
                    $tipo_reals1 = strtolower($aRet[0]->tipo) . '_real_s1';
                    $tipo_rps1   = strtolower($aRet[0]->tipo) . '_rp_s1';
                    
                    //S2
                    $tipo_plans2 = strtolower($aRet[0]->tipo) . '_plan_s2';
                    $tipo_reals2 = strtolower($aRet[0]->tipo) . '_real_s2';
                    $tipo_rps2   = strtolower($aRet[0]->tipo) . '_rp_s2';
                    
                    //Cor RP Anual
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '0.00') || (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '59.99'))
                    {
                        $cCor = 'Vermelho';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '60.00') && (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '79.99'))
                    {
                        $cCor = 'Amarelo';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '80.00'))
                    {
                        $cCor = 'Verde';
                    }
                    
                    //Anual
                    $html .= '<td title="'. $aRet[0]->$tipo_plan .'">' . $aRet[0]->$tipo_plan . '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_real .'">' . $aRet[0]->$tipo_real . '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rp, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rp, 2, '.', '') . '</td>';
                    
                    //S1
                    $html .= '<td title="'. $aRet[0]->$tipo_plans1.'">' . $aRet[0]->$tipo_plans1. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals1.'">' . $aRet[0]->$tipo_reals1. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps1, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps1, 2, '.', '') . '</td>';
                    
                    //S2
                    $html .= '<td title="'. $aRet[0]->$tipo_plans2.'">' . $aRet[0]->$tipo_plans2. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals2.'">' . $aRet[0]->$tipo_reals2. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps2, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps2, 2, '.', '') . '</td>';
                }
            }
            
            if($dados->Indicador9)
            {
                $html .= '<tr>';
                $html .= '<th></th>';
                $html .= '<td title="'. $dados->Indicador9.'">' . $dados->Indicador9. '</td>';
                $html .= '<td title="'. $dados->Ponderacion9.'">' . $dados->Ponderacion9. '</td>';
                
                //Busca Dados do KPI 9
                $aRet = $model->BuscaDadosGerais($dados->id_pais, $dados->cplanificacion, $dados->Id_9);
                
                if(!empty($aRet))
                {
                    //Anual
                    $tipo_plan = strtolower($aRet[0]->tipo) . '_plan_anual';
                    $tipo_real = strtolower($aRet[0]->tipo) . '_real_anual';
                    $tipo_rp   = strtolower($aRet[0]->tipo) . '_rp_anual';
                    
                    //S1
                    $tipo_plans1 = strtolower($aRet[0]->tipo) . '_plan_s1';
                    $tipo_reals1 = strtolower($aRet[0]->tipo) . '_real_s1';
                    $tipo_rps1   = strtolower($aRet[0]->tipo) . '_rp_s1';
                    
                    //S2
                    $tipo_plans2 = strtolower($aRet[0]->tipo) . '_plan_s2';
                    $tipo_reals2 = strtolower($aRet[0]->tipo) . '_real_s2';
                    $tipo_rps2   = strtolower($aRet[0]->tipo) . '_rp_s2';
                    
                    //Cor RP Anual
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '0.00') || (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '59.99'))
                    {
                        $cCor = 'Vermelho';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '60.00') && (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '79.99'))
                    {
                        $cCor = 'Amarelo';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '80.00'))
                    {
                        $cCor = 'Verde';
                    }
                    
                    //Anual
                    $html .= '<td title="'. $aRet[0]->$tipo_plan .'">' . $aRet[0]->$tipo_plan . '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_real .'">' . $aRet[0]->$tipo_real . '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rp, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rp, 2, '.', '') . '</td>';
                    
                    //S1
                    $html .= '<td title="'. $aRet[0]->$tipo_plans1.'">' . $aRet[0]->$tipo_plans1. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals1.'">' . $aRet[0]->$tipo_reals1. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps1, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps1, 2, '.', '') . '</td>';
                    
                    //S2
                    $html .= '<td title="'. $aRet[0]->$tipo_plans2.'">' . $aRet[0]->$tipo_plans2. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals2.'">' . $aRet[0]->$tipo_reals2. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps2, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps2, 2, '.', '') . '</td>';
                }
            }
            
            if($dados->Indicador10)
            {
                $html .= '<tr>';
                $html .= '<th></th>';
                $html .= '<td title="'. $dados->Indicador10.'">' . $dados->Indicador10. '</td>';
                $html .= '<td title="'. $dados->Ponderacion10.'">' . $dados->Ponderacion10. '</td>';
                
                //Busca Dados do KPI 10
                $aRet = $model->BuscaDadosGerais($dados->id_pais, $dados->cplanificacion, $dados->Id_10);
                
                if(!empty($aRet))
                {
                    //Anual
                    $tipo_plan = strtolower($aRet[0]->tipo) . '_plan_anual';
                    $tipo_real = strtolower($aRet[0]->tipo) . '_real_anual';
                    $tipo_rp   = strtolower($aRet[0]->tipo) . '_rp_anual';
                    
                    //S1
                    $tipo_plans1 = strtolower($aRet[0]->tipo) . '_plan_s1';
                    $tipo_reals1 = strtolower($aRet[0]->tipo) . '_real_s1';
                    $tipo_rps1   = strtolower($aRet[0]->tipo) . '_rp_s1';
                    
                    //S2
                    $tipo_plans2 = strtolower($aRet[0]->tipo) . '_plan_s2';
                    $tipo_reals2 = strtolower($aRet[0]->tipo) . '_real_s2';
                    $tipo_rps2   = strtolower($aRet[0]->tipo) . '_rp_s2';
                    
                    //Cor RP Anual
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '0.00') || (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '59.99'))
                    {
                        $cCor = 'Vermelho';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '60.00') && (number_format($aRet[0]->$tipo_rp, 2, '.', '') <= '79.99'))
                    {
                        $cCor = 'Amarelo';
                    }
                    
                    if((number_format($aRet[0]->$tipo_rp, 2, '.', '') >= '80.00'))
                    {
                        $cCor = 'Verde';
                    }
                    
                    //Anual
                    $html .= '<td title="'. $aRet[0]->$tipo_plan .'">' . $aRet[0]->$tipo_plan . '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_real .'">' . $aRet[0]->$tipo_real . '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rp, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rp, 2, '.', '') . '</td>';
                    
                    //S1
                    $html .= '<td title="'. $aRet[0]->$tipo_plans1.'">' . $aRet[0]->$tipo_plans1. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals1.'">' . $aRet[0]->$tipo_reals1. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps1, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps1, 2, '.', '') . '</td>';
                    
                    //S2
                    $html .= '<td title="'. $aRet[0]->$tipo_plans2.'">' . $aRet[0]->$tipo_plans2. '</td>';
                    $html .= '<td title="'. $aRet[0]->$tipo_reals2.'">' . $aRet[0]->$tipo_reals2. '</td>';
                    $html .= '<td class="'.$cCor.'" title="'. number_format($aRet[0]->$tipo_rps2, 2, '.', '').'">'    . number_format($aRet[0]->$tipo_rps2, 2, '.', '') . '</td>';
                }
            }
            
            $i++;
            $html .= '</tbody>';
            $html .= '</table></div>';
            $html .= '</div>';
            $html .= '</br>';
            $html .= '</div>';
        }
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        echo ($html);
        
    }
    
    public function NewProyectos()
    {
        $this->setPageTitle('Proyectos');
        $model = Container::getModel("TInforme");
        
        //Busca Anos
        $this->view->ano = $model->ListAnos();
        $this->renderView('tinforme/newproyectos', 'layout');
    }
     
    public function NewValoresProyecto($aDados)
    {
        $aDados = (array) $aDados;
        
        $cplanificacion  = $aDados['cplanificacion'];
        $pais            = $aDados['idPais'];
        $sede            = $aDados['idSede'];
        $idproyecto      = $aDados['idproyecto'];
        
        $model = Container::getModel("TInforme");
        
        //Busca Dados
        $result = $model->BuscaProyectos($cplanificacion, $pais, $sede, $idproyecto);
        
        $html .= '<table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th data-toggle="true">Indicador</th>';
        $html .= '<th data-hide="all">Peso/Ponderacion</th>';
        $html .= '<th data-hide="all">Plan '.$result[0]->ano.'</th>';
        $html .= '<th data-hide="all">Real '.$result[0]->ano.'</th>';
        $html .= '<th data-hide="all">% (R/P) '.$result[0]->ano.'</th>';
        $html .= '<th data-hide="all">Plan S1</th>';
        $html .= '<th data-hide="all">Real S1</th>';
        $html .= '<th data-hide="all">% (R/P)</th>';
        $html .= '<th data-hide="all">Plan S2</th>';
        $html .= '<th data-hide="all">Real S2</th>';
        $html .= '<th data-hide="all">% (R/P)</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach ($result as $dados)
        {
            //Busca Dados do KPI 1
            $aIndicador1 = $model->BuscaDadosGerais($pais, $cplanificacion, $result[0]->Id_1, $sede);
            $ind1 = (array) $aIndicador1[0];
            $indicador1 = array_filter($ind1);
            $plan1 = strtolower($indicador1['tipo'] . '_' . 'plan_anual');
            $real1 = strtolower($indicador1['tipo'] . '_' . 'real_anual');
            $rp1   = strtolower($indicador1['tipo'] . '_' . 'rp_anual');
            $s1p   = strtolower($indicador1['tipo'] . '_' . 'plan_s1');
            $s1r   = strtolower($indicador1['tipo'] . '_' . 'real_s1');
            $s1rp  = strtolower($indicador1['tipo'] . '_' . 'rp_s1');
            $s2p   = strtolower($indicador1['tipo'] . '_' . 'plan_s2');
            $s2r   = strtolower($indicador1['tipo'] . '_' . 'real_s2');
            $s2rp  = strtolower($indicador1['tipo'] . '_' . 'rp_s2');
            
            
            //Indicador 1
             $html .= '<tr>';
             $html .= '<td>'.$result[0]->Indicador1.'</td>';
             $html .= '<td>'.$result[0]->Ponderacion1.'</td>';
             $html .= '<td>'. (count($aIndicador1) > 1 ? '' : number_format($indicador1[$plan1], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador1) > 1 ? '' : number_format($indicador1[$real1], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador1) > 1 ? '' : number_format($indicador1[$rp1], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador1) > 1 ? '' : number_format($indicador1[$s1p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador1) > 1 ? '' : number_format($indicador1[$s1r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador1) > 1 ? '' : number_format($indicador1[$s1rp], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador1) > 1 ? '' : number_format($indicador1[$s2p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador1) > 1 ? '' : number_format($indicador1[$s2r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador1) > 1 ? '' : number_format($indicador1[$s2rp], 2, '.', '')) .'</td>';
             $html .= '</tr>';
             
             //Busca Dados do KPI 2
             $aIndicador2 = $model->BuscaDadosGerais($pais, $cplanificacion, $result[0]->Id_2, $sede);
             
             $ind2 = (array) $aIndicador2[0];
             $indicador2 = array_filter($ind2);
             $plan2    = strtolower($indicador2['tipo'] . '_' . 'plan_anual');
             $real2    = strtolower($indicador2['tipo'] . '_' . 'real_anual');
             $rp2      = strtolower($indicador2['tipo'] . '_' . 'rp_anual');
             $in2s1p   = strtolower($indicador2['tipo'] . '_' . 'plan_s1');
             $in2s1r   = strtolower($indicador2['tipo'] . '_' . 'real_s1');
             $in2s1rp  = strtolower($indicador2['tipo'] . '_' . 'rp_s1');
             $in2s2p   = strtolower($indicador2['tipo'] . '_' . 'plan_s2');
             $in2s2r   = strtolower($indicador2['tipo'] . '_' . 'real_s2');
             $in2s2rp  = strtolower($indicador2['tipo'] . '_' . 'rp_s2');
             
             //Indicador 2
             $html .= '<tr>';
             $html .= '<td>'.$result[0]->Indicador2.'</td>';
             $html .= '<td>'.$result[0]->Ponderacion2.'</td>';
             $html .= '<td>'. (count($aIndicador2) > 1 ? '' : number_format($indicador2[$plan2], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador2) > 1 ? '' : number_format($indicador2[$real2], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador2) > 1 ? '' : number_format($indicador2[$rp2], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador2) > 1 ? '' : number_format($indicador2[$in2s1p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador2) > 1 ? '' : number_format($indicador2[$in2s1r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador2) > 1 ? '' : number_format($indicador2[$in2s1rp], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador2) > 1 ? '' : number_format($indicador2[$in2s2p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador2) > 1 ? '' : number_format($indicador2[$in2s2r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador2) > 1 ? '' : number_format($indicador2[$in2s2rp], 2, '.', '')) .'</td>';
             $html .= '</tr>';
             
             //Busca Dados do KPI 3
             $aIndicador3 = $model->BuscaDadosGerais($pais, $cplanificacion, $result[0]->Id_3, $sede);
             $ind3 = (array) $aIndicador3[0];
             $indicador3 = array_filter($ind3);
             $plan3    = strtolower($indicador3['tipo'] . '_' . 'plan_anual');
             $real3    = strtolower($indicador3['tipo'] . '_' . 'real_anual');
             $rp3      = strtolower($indicador3['tipo'] . '_' . 'rp_anual');
             $in3s1p   = strtolower($indicador3['tipo'] . '_' . 'plan_s1');
             $in3s1r   = strtolower($indicador3['tipo'] . '_' . 'real_s1');
             $in3s1rp  = strtolower($indicador3['tipo'] . '_' . 'rp_s1');
             $in3s2p   = strtolower($indicador3['tipo'] . '_' . 'plan_s2');
             $in3s2r   = strtolower($indicador3['tipo'] . '_' . 'real_s2');
             $in3s2rp  = strtolower($indicador3['tipo'] . '_' . 'rp_s2');
             
             //Indicador 3
             $html .= '<tr>';
             $html .= '<td>'.$result[0]->Indicador3.'</td>';
             $html .= '<td>'.$result[0]->Ponderacion3.'</td>';
             $html .= '<td>'. (count($aIndicador3) > 1 ? '' : number_format($indicador3[$plan3], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador3) > 1 ? '' : number_format($indicador3[$real3], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador3) > 1 ? '' : number_format($indicador3[$rp3], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador3) > 1 ? '' : number_format($indicador3[$in3s1p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador3) > 1 ? '' : number_format($indicador3[$in3s1r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador3) > 1 ? '' : number_format($indicador3[$in2s1rp], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador3) > 1 ? '' : number_format($indicador3[$in3s2p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador3) > 1 ? '' : number_format($indicador3[$in3s2r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador3) > 1 ? '' : number_format($indicador3[$in3s2rp], 2, '.', '')) .'</td>';
             $html .= '</tr>';
             
             //Busca Dados do KPI 4
             $aIndicador4 = $model->BuscaDadosGerais($pais, $cplanificacion, $result[0]->Id_4, $sede);
             $ind4 = (array) $aIndicador4[0];
             $indicador4 = array_filter($ind4);
             $plan4    = strtolower($indicador4['tipo'] . '_' . 'plan_anual');
             $real4    = strtolower($indicador4['tipo'] . '_' . 'real_anual');
             $rp4      = strtolower($indicador4['tipo'] . '_' . 'rp_anual');
             $in4s1p   = strtolower($indicador4['tipo'] . '_' . 'plan_s1');
             $in4s1r   = strtolower($indicador4['tipo'] . '_' . 'real_s1');
             $in4s1rp  = strtolower($indicador4['tipo'] . '_' . 'rp_s1');
             $in4s2p   = strtolower($indicador4['tipo'] . '_' . 'plan_s2');
             $in4s2r   = strtolower($indicador4['tipo'] . '_' . 'real_s2');
             $in4s2rp  = strtolower($indicador4['tipo'] . '_' . 'rp_s2');
             
             //Indicador 4
             $html .= '<tr>';
             $html .= '<td>'.$result[0]->Indicador4.'</td>';
             $html .= '<td>'.$result[0]->Ponderacion4.'</td>';
             $html .= '<td>'. (count($aIndicador4) > 1 ? '' : number_format($indicador4[$plan4], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador4) > 1 ? '' : number_format($indicador4[$real4], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador4) > 1 ? '' : number_format($indicador4[$rp4], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador4) > 1 ? '' : number_format($indicador4[$in4s1p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador4) > 1 ? '' : number_format($indicador4[$in4s1r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador4) > 1 ? '' : number_format($indicador4[$in4s1rp], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador4) > 1 ? '' : number_format($indicador4[$in4s2p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador4) > 1 ? '' : number_format($indicador4[$in4s2r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador4) > 1 ? '' : number_format($indicador4[$in4s2rp], 2, '.', '')) .'</td>';
             $html .= '</tr>';
             
             //Busca Dados do KPI 5
             $aIndicador5 = $model->BuscaDadosGerais($pais, $cplanificacion, $result[0]->Id_5, $sede);
             $ind5 = (array) $aIndicador5[0];
             $indicador5 = array_filter($ind5);
             $plan5    = strtolower($indicador5['tipo'] . '_' . 'plan_anual');
             $real5    = strtolower($indicador5['tipo'] . '_' . 'real_anual');
             $rp5      = strtolower($indicador5['tipo'] . '_' . 'rp_anual');
             $in5s1p   = strtolower($indicador5['tipo'] . '_' . 'plan_s1');
             $in5s1r   = strtolower($indicador5['tipo'] . '_' . 'real_s1');
             $in5s1rp  = strtolower($indicador5['tipo'] . '_' . 'rp_s1');
             $in5s2p   = strtolower($indicador5['tipo'] . '_' . 'plan_s2');
             $in5s2r   = strtolower($indicador5['tipo'] . '_' . 'real_s2');
             $in5s2rp  = strtolower($indicador5['tipo'] . '_' . 'rp_s2');
             
             //Indicador 5
             $html .= '<tr>';
             $html .= '<td>'.$result[0]->Indicador5.'</td>';
             $html .= '<td>'.$result[0]->Ponderacion5.'</td>';
             $html .= '<td>'. (count($aIndicador5) > 1 ? '' : number_format($indicador5[$plan5], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador5) > 1 ? '' : number_format($indicador5[$real5], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador5) > 1 ? '' : number_format($indicador5[$rp5], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador5) > 1 ? '' : number_format($indicador5[$in5s1p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador5) > 1 ? '' : number_format($indicador5[$in5s1r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador5) > 1 ? '' : number_format($indicador5[$in5s1rp], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador5) > 1 ? '' : number_format($indicador5[$in5s2p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador5) > 1 ? '' : number_format($indicador5[$in5s2r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador5) > 1 ? '' : number_format($indicador5[$in5s2rp], 2, '.', '')) .'</td>';
             $html .= '</tr>';
             
             //Busca Dados do KPI 6
             $aIndicador6 = $model->BuscaDadosGerais($pais, $cplanificacion, $result[0]->Id_6, $sede);
             $ind6 = (array) $aIndicador6[0];
             $indicador6 = array_filter($ind6);
             $plan6    = strtolower($indicador6['tipo'] . '_' . 'plan_anual');
             $real6    = strtolower($indicador6['tipo'] . '_' . 'real_anual');
             $rp6      = strtolower($indicador6['tipo'] . '_' . 'rp_anual');
             $in6s1p   = strtolower($indicador6['tipo'] . '_' . 'plan_s1');
             $in6s1r   = strtolower($indicador6['tipo'] . '_' . 'real_s1');
             $in6s1rp  = strtolower($indicador6['tipo'] . '_' . 'rp_s1');
             $in6s2p   = strtolower($indicador6['tipo'] . '_' . 'plan_s2');
             $in6s2r   = strtolower($indicador6['tipo'] . '_' . 'real_s2');
             $in6s2rp  = strtolower($indicador6['tipo'] . '_' . 'rp_s2');
             
             //Indicador 6
             $html .= '<tr>';
             $html .= '<td>'.$result[0]->Indicador6.'</td>';
             $html .= '<td>'.$result[0]->Ponderacion6.'</td>';
             $html .= '<td>'. (count($aIndicador6) > 1 ? '' : number_format($indicador6[$plan6], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador6) > 1 ? '' : number_format($indicador6[$real6], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador6) > 1 ? '' : number_format($indicador6[$rp6], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador6) > 1 ? '' : number_format($indicador6[$in6s1p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador6) > 1 ? '' : number_format($indicador6[$in6s1r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador6) > 1 ? '' : number_format($indicador6[$in6s1rp], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador6) > 1 ? '' : number_format($indicador6[$in6s2p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador6) > 1 ? '' : number_format($indicador6[$in6s2r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador6) > 1 ? '' : number_format($indicador6[$in6s2rp], 2, '.', '')) .'</td>';
             $html .= '</tr>';
             
             //Busca Dados do KPI 7
             $aIndicador7 = $model->BuscaDadosGerais($pais, $cplanificacion, $result[0]->Id_7, $sede);
             $ind7 = (array) $aIndicador7[0];
             $indicador7 = array_filter($ind7);
             $plan7    = strtolower($indicador7['tipo'] . '_' . 'plan_anual');
             $real7    = strtolower($indicador7['tipo'] . '_' . 'real_anual');
             $rp7      = strtolower($indicador7['tipo'] . '_' . 'rp_anual');
             $in7s1p   = strtolower($indicador7['tipo'] . '_' . 'plan_s1');
             $in7s1r   = strtolower($indicador7['tipo'] . '_' . 'real_s1');
             $in7s1rp  = strtolower($indicador7['tipo'] . '_' . 'rp_s1');
             $in7s2p   = strtolower($indicador7['tipo'] . '_' . 'plan_s2');
             $in7s2r   = strtolower($indicador7['tipo'] . '_' . 'real_s2');
             $in7s2rp  = strtolower($indicador7['tipo'] . '_' . 'rp_s2');
             
             //Indicador 7
             $html .= '<tr>';
             $html .= '<td>'.$result[0]->Indicador7.'</td>';
             $html .= '<td>'.$result[0]->Ponderacion7.'</td>';
             $html .= '<td>'. (count($aIndicador7) > 1 ? '' : number_format($indicador7[$plan7], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador7) > 1 ? '' : number_format($indicador7[$real7], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador7) > 1 ? '' : number_format($indicador7[$rp7], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador7) > 1 ? '' : number_format($indicador7[$in7s1p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador7) > 1 ? '' : number_format($indicador7[$in7s1r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador7) > 1 ? '' : number_format($indicador7[$in7s1rp], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador7) > 1 ? '' : number_format($indicador7[$in7s2p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador7) > 1 ? '' : number_format($indicador7[$in7s2r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador7) > 1 ? '' : number_format($indicador7[$in7s2rp], 2, '.', '')) .'</td>';
             $html .= '</tr>';
             
             //Busca Dados do KPI 8
             $aIndicador8 = $model->BuscaDadosGerais($pais, $cplanificacion, $result[0]->Id_8, $sede);
             $ind8 = (array) $aIndicador8[0];
             $indicador8 = array_filter($ind8);
             $plan8    = strtolower($indicador8['tipo'] . '_' . 'plan_anual');
             $real8    = strtolower($indicador8['tipo'] . '_' . 'real_anual');
             $rp8      = strtolower($indicador8['tipo'] . '_' . 'rp_anual');
             $in8s1p   = strtolower($indicador8['tipo'] . '_' . 'plan_s1');
             $in8s1r   = strtolower($indicador8['tipo'] . '_' . 'real_s1');
             $in8s1rp  = strtolower($indicador8['tipo'] . '_' . 'rp_s1');
             $in8s2p   = strtolower($indicador8['tipo'] . '_' . 'plan_s2');
             $in8s2r   = strtolower($indicador8['tipo'] . '_' . 'real_s2');
             $in8s2rp  = strtolower($indicador8['tipo'] . '_' . 'rp_s2');
             
             //Indicador 8
             $html .= '<tr>';
             $html .= '<td>'.$result[0]->Indicador8.'</td>';
             $html .= '<td>'.$result[0]->Ponderacion8.'</td>';
             $html .= '<td>'. (count($aIndicador8) > 1 ? '' :number_format($indicador8[$plan8], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador8) > 1 ? '' :number_format($indicador8[$real8], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador8) > 1 ? '' :number_format($indicador8[$rp8], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador8) > 1 ? '' : number_format($indicador8[$in8s1p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador8) > 1 ? '' : number_format($indicador8[$in8s1r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador8) > 1 ? '' : number_format($indicador8[$in8s1rp], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador8) > 1 ? '' : number_format($indicador8[$in8s2p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador8) > 1 ? '' : number_format($indicador8[$in8s2r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador8) > 1 ? '' : number_format($indicador8[$in8s2rp], 2, '.', '')) .'</td>';
             $html .= '</tr>';
             
             //Busca Dados do KPI 9
             $aIndicador9 = $model->BuscaDadosGerais($pais, $cplanificacion, $result[0]->Id_9, $sede);
             
             $ind9 = (array) $aIndicador9[0];
             $indicador9 = array_filter($ind9);
             $plan9    = strtolower($indicador9['tipo'] . '_' . 'plan_anual');
             $real9    = strtolower($indicador9['tipo'] . '_' . 'real_anual');
             $rp9      = strtolower($indicador9['tipo'] . '_' . 'rp_anual');
             $in9s1p   = strtolower($indicador9['tipo'] . '_' . 'plan_s1');
             $in9s1r   = strtolower($indicador9['tipo'] . '_' . 'real_s1');
             $in9s1rp  = strtolower($indicador9['tipo'] . '_' . 'rp_s1');
             $in9s2p   = strtolower($indicador9['tipo'] . '_' . 'plan_s2');
             $in9s2r   = strtolower($indicador9['tipo'] . '_' . 'real_s2');
             $in9s2rp  = strtolower($indicador9['tipo'] . '_' . 'rp_s2');
             
             //Indicador 9
             $html .= '<tr>';
             $html .= '<td>'.$result[0]->Indicador9.'</td>';
             $html .= '<td>'.$result[0]->Ponderacion9.'</td>';
             $html .= '<td>'. (count($aIndicador9) > 1 ? '' : number_format($indicador9[$plan9], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador9) > 1 ? '' : number_format($indicador9[$real9], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador9) > 1 ? '' : number_format($indicador9[$rp9], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador9) > 1 ? '' : number_format($indicador9[$in9s1p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador9) > 1 ? '' : number_format($indicador9[$in9s1r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador9) > 1 ? '' : number_format($indicador9[$in9s1rp], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador9) > 1 ? '' : number_format($indicador9[$in9s2p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador9) > 1 ? '' : number_format($indicador9[$in9s2r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador9) > 1 ? '' : number_format($indicador9[$in9s2rp], 2, '.', '')) .'</td>';
             $html .= '</tr>';
             
             //Busca Dados do KPI 10
             $aIndicador10 = $model->BuscaDadosGerais($pais, $cplanificacion, $result[0]->Id_10, $sede);
             
             $ind10 = (array) $aIndicador10[0];
             $indicador10 = array_filter($ind10);
             $plan10    = strtolower($indicador10['tipo'] . '_' . 'plan_anual');
             $real10    = strtolower($indicador10['tipo'] . '_' . 'real_anual');
             $rp10      = strtolower($indicador10['tipo'] . '_' . 'rp_anual');
             $in10s1p   = strtolower($indicador10['tipo'] . '_' . 'plan_s1');
             $in10s1r   = strtolower($indicador10['tipo'] . '_' . 'real_s1');
             $in10s1rp  = strtolower($indicador10['tipo'] . '_' . 'rp_s1');
             $in10s2p   = strtolower($indicador10['tipo'] . '_' . 'plan_s2');
             $in10s2r   = strtolower($indicador10['tipo'] . '_' . 'real_s2');
             $in10s2rp  = strtolower($indicador10['tipo'] . '_' . 'rp_s2');
             
             //Indicador 10
             $html .= '<tr>';
             $html .= '<td>'.$result[0]->Indicador10.'</td>';
             $html .= '<td>'.$result[0]->Ponderacion10.'</td>';
             $html .= '<td>'. (count($aIndicador10) > 1 ? '' : number_format($indicador10[$plan10], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador10) > 1 ? '' : number_format($indicador10[$real10], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador10) > 1 ? '' : number_format($indicador10[$rp10], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador10) > 1 ? '' : number_format($indicador10[$in10s1p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador10) > 1 ? '' : number_format($indicador10[$in10s1r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador10) > 1 ? '' : number_format($indicador10[$in10s1rp], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador10) > 1 ? '' : number_format($indicador10[$in10s2p], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador10) > 1 ? '' : number_format($indicador10[$in10s2r], 2, '.', '')) .'</td>';
             $html .= '<td>'. (count($aIndicador10) > 1 ? '' : number_format($indicador10[$in10s2rp], 2, '.', '')) .'</td>';
             $html .= '</tr>';
             
        }
        $html .= '</tbody>';
        $html .= '</table>';
        
        echo ($html);
    }
    
    public function CarregaProyectos($aDados)
    {
        $aDados = (array) $aDados;
        
        $cplanificacion  = $aDados['cplanificacion'];
        $pais            = $aDados['idPais'];
        $sede            = $aDados['idSede'];
        
        $model = Container::getModel("TInforme");
        
        //Busca Dados
        $result = $model->BuscaProyectos($cplanificacion, $pais, $sede);
        
        if(empty($result))
        {
            $html = '<!DOCTYPE html>
                    <html>
                    <head>
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <style>
                    .alert {
                        padding: 20px;
                        background-color: #f44336;
                        color: white;
                    }
                
                    .closebtn {
                        margin-left: 15px;
                        color: white;
                        font-weight: bold;
                        float: right;
                        font-size: 22px;
                        line-height: 20px;
                        cursor: pointer;
                        transition: 0.3s;
                    }
                
                    .closebtn:hover {
                        color: black;
                    }
                    </style>
                    </head>
                    <body>
                
                    <div class="alert">
                      <strong>Alerta!</strong> No Hay Proyectos Creados!.
                    </div>
                
                    </body>
                    </html>';
            echo ($html);
            die();
        }
        
        $html .= '<div class="col-lg-3">';
        $html .= '<div class="form-group">';
        $html .= '<label for="proyectos">Proyectos</label>';
        $html .= '<select  id="pro" class="form-control" >';
        $html .= '<option value="0">-- SELECCIONE --</option>';
        foreach ($result as $proyecto)
        {
            $html.= '<option value="'.$proyecto->id.'">'.$proyecto->proyecto.'</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        
        echo ($html);
    }
    
}