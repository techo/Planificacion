<?php 

$route[] = ['/', 'HomeController@index'];

/** Anos **/
$route[] = ['/anos', 'AnosController@index'];
$route[] = ['/anos/add', 'AnosController@add'];
$route[] = ['/anos/save', 'AnosController@save'];
$route[] = ['/anos/show/{id}', 'AnosController@show'];
$route[] = ['/anos/edit', 'AnosController@edit'];

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
$route[] = ['/pilares/lista_pilares', 'PilaresController@GetPilar'];

/** Indicadores **/
$route[] = ['/indicadores', 'IndicadoresController@index'];
$route[] = ['/indicadores/lista_area', 'IndicadoresController@Areas'];
$route[] = ['/indicadores/lista_indicador', 'IndicadoresController@Indicadores'];

return $route;