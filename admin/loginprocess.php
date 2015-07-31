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
require("../config.php");
require(INCLUDES_DIR . "mysql.php");
require(INCLUDES_DIR . "check.php");
require(INCLUDES_DIR . "func.php");
require(INCLUDES_DIR . "auth.php");


if(isset($_POST['task']))
{
	$task = mysql_real_escape_string($_POST['task']);
}
else if(isset($_GET['task']))
{
	$task = mysql_real_escape_string($_GET['task']);
}


//----------------------------------------------------+


switch(@$task)
{
	case 'processlogin':
		if(isLoggedIn() == TRUE)
		{
			$_SESSION = array();
			session_destroy();
		}
		$username = mysql_real_escape_string($_POST['username']);
		$password = mysql_real_escape_string($_POST['password']);
		###
		if(!empty($username) && !empty($password))
		{
			###
			$salt = hash('sha512', $username);
			$password = hash('sha512', $salt.$password);
			###
			$numrows = query_numrows( "SELECT * FROM `user` WHERE `username` = '".$username."' AND `password` = '".$password."'" );
			if($numrows == 1)
			{
				$rows = query_fetch_assoc( "SELECT * FROM `user` WHERE `username` = '".$username."' AND `password` = '".$password."'" );
				###
				$_SESSION['id'] = $rows['id'];
				$_SESSION['username'] = $rows['username'];
				###
				validate();
				###
				$_SESSION['msg1'] = 'Zostałeś poprawnie zalogowany!';
				$_SESSION['msg-type'] = 'success';
				header( "Location: admin.php?page=1" );
				die();
			}
		}
		$_SESSION['msg1'] = 'Błędny login lub złe hasło!';
		$_SESSION['msg-type'] = 'danger';
		header( "Location: login.php" );
		die();
		break;
		
	case 'logout':
		logout();
		header( "Location: login.php" );
		die();
		break;

	default:
		exit('<h1><b>Błąd</b></h1>');
}

exit('<h1><b>403 Forbidden</b></h1>');
?>