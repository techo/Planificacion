<?php 

$route[] = ['/', 'HomeController@index'];

/** Anos **/
$route[] = ['/anos', 'AnosController@index'];

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
$route[] = ['/indicadores/listaArea', 'IndicadoresController@Areas'];

return $route;