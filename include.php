<?php
/**
 * Folder instalacyjny
 */
if(is_dir("./install/"))
{
	header( "Location: ./install/");
	die();
}

//---------------------------------------------

require(INCLUDES_DIR . "check.php");
require(INCLUDES_DIR . "auth.php");
require(INCLUDES_DIR . "mysql.php");

//---------------------------------------------

session_start();
ob_start();
?>