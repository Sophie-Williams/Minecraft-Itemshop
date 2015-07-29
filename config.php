<?php
// Ip do bazy mysql
define('DBHOST', '');

// Nazwa bazy danych
define('DBNAME', '');

// Nazwa u¿ytkownika bazy danych
define('DBUSER', '');

// Has³o do bazy danych
define('DBPASSWORD', '');
	
/**
 * Wyœwietlanie b³êdów
 */
error_reporting(E_ALL);

/**
* Definiowanie drzewa katalogów
*/
define('DIR', realpath(dirname(__FILE__)));
define('BASE_URL', dirname($_SERVER['PHP_SELF']).'/');

define('INSTALL_DIR', DIR.'/install/');
define('LIBS_DIR', DIR.'/libs/');
define('STYLE_DIR', DIR.'/style/');
define('INCLUDES_DIR', DIR.'/include/');
	
define('REQUEST_URI', $_SERVER["REQUEST_URI"]);
?>