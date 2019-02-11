<?php
/**/
if (stripos($_SERVER['SCRIPT_NAME'], 'apps/phpgrid-custom-crm')) {
    define('PHPGRID_DB_HOSTNAME', '127.0.0.1'); // database host name
    define('PHPGRID_DB_USERNAME', 'root');     // database user name
    define('PHPGRID_DB_PASSWORD', ''); // database password
    define('PHPGRID_DB_NAME', 'phpgrid_custom_crm'); // database name
    define('PHPGRID_DB_TYPE', 'mysql');  // database type
    define('PHPGRID_DB_CHARSET','utf8'); // ex: utf8(for mysql),AL32UTF8 (for oracle), leave blank to use the default charset
} else {
	//* mysql example 
	define('PHPGRID_DB_HOSTNAME','localhost'); // database host name
	define('PHPGRID_DB_USERNAME', 'root');     // database user name
	define('PHPGRID_DB_PASSWORD', 'mysql'); // database password
	define('PHPGRID_DB_NAME', 'techo_planificacion'); // database name
	define('PHPGRID_DB_TYPE', 'mysql');  // database type
	define('PHPGRID_DB_CHARSET','utf8'); // ex: utf8(for mysql),AL32UTF8 (for oracle), leave blank to use the default charset
}


// *** You should define SERVER_ROOT manually when use Apache alias directive or IIS virtual directory ***
if (stripos($_SERVER['SCRIPT_NAME'], 'apps/phpgrid-custom-crm')) {
	define('SERVER_ROOT', '/phpGridx/apps/phpgrid-custom-crm/phpGrid_Lite');	
} else {
	define('SERVER_ROOT', str_replace(str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'])),'', str_replace('\\', '/',dirname(__FILE__))));
}
define('THEME', 'start');
define('FRAMEWORK', '');	// indicating framework integrating - not used yet
define('DEBUG', false); // *** MUST SET TO FALSE WHEN DEPLOYED IN PRODUCTION ***
define('CDN', true);        // use Cloud CDN by default. False to use the local libraries




/******** DO NOT MODIFY ***********/
require_once('phpGrid.php');
/**********************************/
?>
