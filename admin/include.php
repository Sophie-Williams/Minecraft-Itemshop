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
if(is_dir("../install/"))
{
	header( "Location: ../install/");
	die();
}

//----------------------------------------------------+

require(INCLUDES_DIR . "mysql.php");
require(INCLUDES_DIR . "check.php");
require(INCLUDES_DIR . "func.php");
require(INCLUDES_DIR . "auth.php");

//----------------------------------------------------+

if(isLoggedIn() == TRUE)
{
	$verify = query_fetch_assoc( "SELECT * FROM `user` WHERE `id` = '".$_SESSION['id']."'" );
	if(($verify['username'] != $_SESSION['username']) || ($verify['session'] != session_id()))
	{
		logout();
		header( "Location: login.php" );
		die();
	}
}
else
{
	logout();
	header( "Location: login.php" );
	die();
}
?>