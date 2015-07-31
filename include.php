<?php
/*
Projekt sklepu do gry minecraft
stworzony przez użytkownika Najlepszy56
www.github.com/najlepszy56.
Udostępnianie bez zgody właściciela
jest naruszeniem zasad licencji.
*/
session_start();
ob_start();

//----------------------------------------------------+

/**
 * Folder instalacyjny
 */
if(is_dir("./install/"))
{
	header( "Location: ./install/");
	die();
}

//----------------------------------------------------+

require(INCLUDES_DIR . "check.php");
require(INCLUDES_DIR . "func.php");
require(INCLUDES_DIR . "mysql.php");
?>