<?php 
/** Home **/
$route[] = ['/', 'HomeController@index'];
$route[] = ['/home/userlogado', 'HomeController@UserLogado'];
$route[] = ['/home/gravadashboard', 'HomeController@GravaDashboard'];
$route[] = ['/home/ListaPaises', 'HomeController@ListaPaises'];
$route[] = ['/home/finaliza', 'HomeController@FinalizaDashboard'];
$route[] = ['/home/carregacompleto', 'HomeController@CarregaCompleto'];

/** Anos **/
$route[] = ['/anos', 'AnosController@index'];
$route[] = ['/anos/add', 'AnosController@add'];
$route[] = ['/anos/save', 'AnosController@save'];
$route[] = ['/anos/show/{id}', 'AnosController@show'];
$route[] = ['/anos/edit', 'AnosController@edit'];
$route[] = ['/anos/delete/{id}', 'AnosController@delete'];

/** Temporalidades **/
$route[] = ['/temporalidades', 'TemporalidadesController@index'];
$route[] = ['/temporalidades/add', 'TemporalidadesController@add'];
$route[] = ['/temporalidades/save', 'TemporalidadesController@save'];
$route[] = ['/temporalidades/show/{id}', 'TemporalidadesController@show'];
$route[] = ['/temporalidades/edit', 'TemporalidadesController@edit'];
$route[] = ['/temporalidades/delete/{id}', 'TemporalidadesController@delete'];
$route[] = ['/temporalidades/lista_temporalidad', 'TemporalidadesController@GetTemporalidad'];

/** Tipos **/
$route[] = ['/tipos', 'TiposController@index'];
$route[] = ['/tipos/add', 'TiposController@add'];
$route[] = ['/tipos/save', 'TiposController@save'];
$route[] = ['/tipos/show/{id}', 'TiposController@show'];
$route[] = ['/tipos/edit', 'TiposController@edit'];
$route[] = ['/tipos/delete/{id}', 'TiposController@delete'];
$route[] = ['/tipos/lista_tipos', 'TiposController@GetTipo'];

/** Pilares **/
$route[] = ['/pilares', 'PilaresController@index'];
$route[] = ['/pilares/add', 'PilaresController@add'];
$route[] = ['/pilares/save', 'PilaresController@save'];
$route[] = ['/pilares/show/{id}', 'PilaresController@show'];
$route[] = ['/pilares/edit', 'PilaresController@edit'];
$route[] = ['/pilares/delete/{id}', 'PilaresController@delete'];
$route[] = ['/pilares/lista_pilares', 'PilaresController@GetPilar'];

/** Indicadores **/
$route[] = ['/indicadores', 'IndicadoresController@index'];
$route[] = ['/indicadores/add', 'IndicadoresController@add'];
$route[] = ['/indicadores/SearchSede', 'IndicadoresController@SearchSede'];
$route[] = ['/indicadores/save', 'IndicadoresController@save'];
$route[] = ['/indicadores/show/{id}', 'IndicadoresController@show'];
$route[] = ['/indicadores/edit', 'IndicadoresController@edit'];
$route[] = ['/indicadores/delete/{id}', 'IndicadoresController@delete'];

/** Crear Planificacion **/
$route[] = ['/cplanificacion', 'CPlanificacionController@index'];
$route[] = ['/cplanificacion/add', 'CPlanificacionController@add'];
$route[] = ['/cplanificacion/SearchSede', 'CPlanificacionController@SearchSede'];
$route[] = ['/cplanificacion/save', 'CPlanificacionController@save'];
$route[] = ['/cplanificacion/show/{id}', 'CPlanificacionController@show'];
$route[] = ['/cplanificacion/edit', 'CPlanificacionController@edit'];
$route[] = ['/cplanificacion/duplicar/{id}', 'CPlanificacionController@duplicar'];
$route[] = ['/cplanificacion/delete/{id}', 'CPlanificacionController@delete'];

/** Planificar ano **/
$route[] = ['/planificacion', 'PlanificacionController@index'];
$route[] = ['/planificacion/show/{id}', 'PlanificacionController@show'];
$route[] = ['/planificacion/dados', 'PlanificacionController@carregardados'];
$route[] = ['/planificacion/listagem', 'PlanificacionController@listagem'];
$route[] = ['/planificacion/atualiza', 'PlanificacionController@atualiza'];

/** TInforme - Informe por trimestre **/
$route[] = ['/tinforme', 'TInformeController@index'];
$route[] = ['/tinforme/SearchPais', 'TInformeController@CarregaPais'];
$route[] = ['/tinforme/SearchSede', 'TInformeController@CarregaSede'];
$route[] = ['/tinforme/SearchIndicadores', 'TInformeController@CarregaIndicadores'];
$route[] = ['/tinforme/CarregaTrimestre', 'TInformeController@CarregaTrimestre'];

/** TInforme - Informe por Mes **/
$route[] = ['/tinforme/mensual', 'TInformeController@mensual'];
$route[] = ['/tinforme/CarregaMensal', 'TInformeController@CarregaMensal'];

/** TInforme - Informe por Mes **/
$route[] = ['/tinforme/anual', 'TInformeController@anual'];
$route[] = ['/tinforme/CarregaAnual', 'TInformeController@CarregaAnual'];

/** Monitoreo de Kpis **/
$route[] = ['/tinforme/monitoreo', 'TInformeController@Monitoreo'];
$route[] = ['/tinforme/BuscaValoresMonitoreo', 'TInformeController@BuscaValoresMonitoreo'];

/** Generador de Informes **/
$route[] = ['/generador', 'GeneradorController@index'];
$route[] = ['/generador/SearchPais', 'GeneradorController@CarregaPais'];
$route[] = ['/generador/SearchIndicador', 'GeneradorController@GeraIndicador'];
$route[] = ['/generador/GeraPais', 'GeneradorController@GeraPais'];

/** Proyectos **/
$route[] = ['/proyecto/add', 'ProyectosController@add'];
$route[] = ['/proyecto/save', 'ProyectosController@save'];

return $route;