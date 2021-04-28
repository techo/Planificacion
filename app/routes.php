<?php 

/** Gestion y Tendencias **/
$route[] = ['/gestion', 'GestionController@index'];
$route[] = ['/visual/pilares', 'GestionController@pilares'];
$route[] = ['/visual/pilares/pais/{idPais}/ano/{idAno}', 'GestionController@DadosPais'];
$route[] = ['/visual/pilares/pais/{idPais}/ano/{idAno}/sede/{idSede}', 'GestionController@DadosSede'];
$route[] = ['/visual/pilares/region', 'GestionController@DadosRegion'];
$route[] = ['/visual/pilares/latam', 'GestionController@DadosLatam'];

$route[] = ['/visual/focos', 'GestionController@focos'];
$route[] = ['/visual/focos/pais', 'GestionController@FocoPais'];
$route[] = ['/visual/focos/sede', 'GestionController@FocoSede'];

$route[] = ['/visual/indicadores', 'GestionController@indicadores'];
$route[] = ['/visual/indicadores/sede', 'GestionController@IndicadoresSede'];
$route[] = ['/visual/indicadores/pais', 'GestionController@IndicadoresPais'];
$route[] = ['/visual/indicadores/region', 'GestionController@IndicadoresRegion'];
$route[] = ['/visual/indicadores/latam', 'GestionController@IndicadoresLatam'];

$route[] = ['/visual/tendencias', 'GestionController@tendencias'];
$route[] = ['/visual/tendencias/pais/{idPais}/sede/{idSede}', 'GestionController@TendenciaSede'];
$route[] = ['/visual/tendencias/pais/{idPais}', 'GestionController@TendenciaPais'];
$route[] = ['/visual/tendencias/region', 'GestionController@TendenciaRegion'];
$route[] = ['/visual/tendencias/latam', 'GestionController@TendenciaLatam'];


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
$route[] = ['/indicadores/redirect', 'IndicadoresController@redirect'];

/** Crear Planificacion **/
$route[] = ['/cplanificacion', 'CPlanificacionController@index'];
$route[] = ['/cplanificacion/add', 'CPlanificacionController@add'];
$route[] = ['/cplanificacion/SearchSede', 'CPlanificacionController@SearchSede'];
$route[] = ['/cplanificacion/save', 'CPlanificacionController@save'];
$route[] = ['/cplanificacion/show/{id}', 'CPlanificacionController@show'];
$route[] = ['/cplanificacion/edit', 'CPlanificacionController@edit'];
$route[] = ['/cplanificacion/duplicar/{id}', 'CPlanificacionController@duplicar'];
$route[] = ['/cplanificacion/delete/{id}', 'CPlanificacionController@delete'];
$route[] = ['/cplanificacion/redirect', 'CPlanificacionController@redirect'];

/** Planificar ano **/
$route[] = ['/planificacion', 'PlanificacionController@index'];
$route[] = ['/planificacion/show/{id}', 'PlanificacionController@show'];/*old method DEPRECATED*/
$route[] = ['/planificacion/dados', 'PlanificacionController@carregardados'];/*old method DEPRECATED*/
$route[] = ['/planificacion/listagem', 'PlanificacionController@listagem']; /*old method DEPRECATED*/
$route[] = ['/planificacion/atualiza', 'PlanificacionController@atualiza'];
$route[] = ['/planificacion/show/new/{id}', 'PlanificacionController@show2'];
$route[] = ['/planificacion/colunas', 'PlanificacionController@Colunas'];
$route[] = ['/planificacion/planificado', 'PlanificacionController@Planificado'];

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
$route[] = ['/tinforme/monitoreo2', 'TInformeController@Monitoreo2'];
$route[] = ['/tinforme/BuscaValoresMonitoreo2', 'TInformeController@BuscaValoresMonitoreo2'];

/** Monitoreo de Proyectos **/
$route[] = ['/tinforme/mproyecto', 'TInformeController@MonitoreoProyecto'];
$route[] = ['/tinforme/BuscaValoresProyecto', 'TInformeController@BuscaValoresProyecto'];
$route[] = ['/tinforme/newproyectos', 'TInformeController@NewProyectos'];
$route[] = ['/tinforme/CarregaProyectos', 'TInformeController@CarregaProyectos'];
$route[] = ['/tinforme/NewValoresProyecto', 'TInformeController@NewValoresProyecto'];

/** Generador de Informes **/
$route[] = ['/generador', 'GeneradorController@index'];
$route[] = ['/generador/SearchPais', 'GeneradorController@CarregaPais'];
$route[] = ['/generador/SearchIndicador', 'GeneradorController@GeraIndicador'];
$route[] = ['/generador/GeraPais', 'GeneradorController@GeraPais'];

/** Proyectos **/
$route[] = ['/proyecto/add', 'ProyectosController@add'];
$route[] = ['/proyecto/save', 'ProyectosController@save'];
$route[] = ['/proyecto/delete/{id}', 'ProyectosController@delete'];
$route[] = ['/proyecto/show/{id}', 'ProyectosController@show'];
$route[] = ['/proyecto/edit', 'ProyectosController@edit'];

/** Indicadores Extras **/
$route[] = ['/extras', 'ExtrasController@index'];
$route[] = ['/extras/add', 'ExtrasController@add'];

/** Feedback **/
$route[] = ['/feedback', 'FeedbackController@index'];
$route[] = ['/feedback/enviar', 'FeedbackController@save'];

/** Gambis **/
$route[] = ['/gambis', 'GambisController@index'];
/** API **/
$route[] = ['/api', 'GambisController@api'];
$route[] = ['/api/valores', 'GambisController@valores'];
$route[] = ['/api/IndicesExcelencia', 'GambisController@IndicesExcelencia'];
$route[] = ['/api/MX', 'GambisController@MX'];
$route[] = ['/api/datastudio/ano/{Ano}', 'GambisController@DataStudio'];
$route[] = ['/api/datastudio1/ano/{Ano}', 'GambisController@GraphicsData'];

/** New Planificacion **/
$route[] = ['/new', 'NewPlanificacionController@index'];

/** Power BI **/
$route[] = ['/kpis2019', 'PowerBiController@index'];
$route[] = ['/infografia2019', 'PowerBiController@inforgrafia2019'];

/** MdG **/
$route[] = ['/proposito', 'PropositoController@index'];
$route[] = ['/proposito/agregar', 'PropositoController@save'];
$route[] = ['/proposito/filtro', 'PropositoController@filter'];
$route[] = ['/proposito/delete/{id}', 'PropositoController@delete'];
$route[] = ['/proposito/edit', 'PropositoController@edit'];
$route[] = ['/proposito/update', 'PropositoController@update'];
$route[] = ['/proposito/relacionar/{id}', 'PropositoController@relacionar'];
$route[] = ['/proposito/relacion', 'PropositoController@relacion'];

$route[] = ['/propuesta', 'PropuestaController@index'];
$route[] = ['/propuesta/agregar', 'PropuestaController@save'];
$route[] = ['/propuesta/filtro', 'PropuestaController@filter'];
$route[] = ['/propuesta/delete/{id}', 'PropuestaController@delete'];
$route[] = ['/propuesta/edit', 'PropuestaController@edit'];
$route[] = ['/propuesta/update', 'PropuestaController@update'];
$route[] = ['/propuesta/relacionar/{id}', 'PropuestaController@relacionar'];
$route[] = ['/propuesta/relacion', 'PropuestaController@relacion'];

$route[] = ['/proceso', 'ProcesoController@index'];
$route[] = ['/proceso/agregar', 'ProcesoController@save'];
$route[] = ['/proceso/filtro', 'ProcesoController@filter'];
$route[] = ['/proceso/delete/{id}', 'ProcesoController@delete'];
$route[] = ['/proceso/edit', 'ProcesoController@edit'];
$route[] = ['/proceso/update', 'ProcesoController@update'];
$route[] = ['/proceso/relacionar/{id}', 'ProcesoController@relacionar'];
$route[] = ['/proceso/relacion', 'ProcesoController@relacion'];

$route[] = ['/aprendizaje', 'AprendizajeController@index'];
$route[] = ['/aprendizaje/agregar', 'AprendizajeController@save'];
$route[] = ['/aprendizaje/filtro', 'AprendizajeController@filter'];
$route[] = ['/aprendizaje/delete/{id}', 'AprendizajeController@delete'];
$route[] = ['/aprendizaje/edit', 'AprendizajeController@edit'];
$route[] = ['/aprendizaje/update', 'AprendizajeController@update'];
$route[] = ['/aprendizaje/relacionar/{id}', 'AprendizajeController@relacionar'];
$route[] = ['/aprendizaje/relacion', 'AprendizajeController@relacion'];

/** Focos **/
$route[] = ['/foco', 'FocoController@index'];
$route[] = ['/foco/add', 'FocoController@add'];
$route[] = ['/foco/save', 'FocoController@save'];
$route[] = ['/foco/show/{id}', 'FocoController@show'];
$route[] = ['/foco/edit', 'FocoController@edit'];
$route[] = ['/foco/delete/{id}', 'FocoController@delete'];
$route[] = ['/foco/SearchSede', 'FocoController@SearchSede'];

/** Genericos SelectBox **/
$route[] = ['/selectbox/paises', 'GestionController@SelectBoxPais'];
$route[] = ['/selectbox/sedes/{idPais}', 'GestionController@SelectBoxSede'];

return $route;