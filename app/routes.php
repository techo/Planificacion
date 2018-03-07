<?php 

$route[] = ['/', 'HomeController@index'];

/** Anos **/
$route[] = ['/anos', 'AnosController@index'];

/** Temporalidades **/
$route[] = ['/temporalidades', 'TemporalidadesController@index'];

return $route;