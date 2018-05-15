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
    
}