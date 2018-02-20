<?php 

$route[] = ['/', 'HomeController@index'];
$route[] = ['/paises', 'PaisesController@index'];
$route[] = ['/paises/{id}/show', 'PaisesController@show'];
$route[] = ['/pessoa/{id}/{sexo}/{idade}', 'PaisesController@teste'];

return $route;