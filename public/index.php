<?php 

//Eso arreglar set timeout
if($_SERVER['SERVER_NAME'] == 'localhost')
{
    ini_set('max_execution_time', 300);
}


ini_set('display_errors',0);
// ini_set('display_startup_erros',1);
// error_reporting(E_ALL);

require_once __DIR__ . "/../vendor/autoload.php";

require_once __DIR__ . "/../core/bootstrap.php";
