<?php 

$route[] = ['/', 'HomeController@index'];

/** Anos **/
$route[] = ['/anos', 'AnosController@index'];
$route[] = ['/anos/add/', 'AnosController@add'];
$route[] = ['/anos/save', 'AnosController@save'];

/** Temporalidades **/
$route[] = ['/temporalidades', 'TemporalidadesController@index'];
$route[] = ['/temporalidades/lista_temporalidad', 'TemporalidadesController@GetTemporalidad'];

/** Tipos **/
$route[] = ['/tipos', 'TiposController@index'];
$route[] = ['/tipos/lista_tipos', 'TiposController@GetTipo'];

/** Pilares **/
$route[] = ['/pilares', 'PilaresController@index'];
$route[] = ['/pilares/lista_pilares', 'PilaresController@GetPilar'];

/** Indicadores **/
$route[] = ['/indicadores', 'IndicadoresController@index'];
$route[] = ['/indicadores/lista_area', 'IndicadoresController@Areas'];
$route[] = ['/indicadores/lista_indicador', 'IndicadoresController@Indicadores'];

return $route;