<?php
session_start();
ob_start();
//----------------------------------------
require("./config.php");
require("./include/mysql.php");
require("./include/auth.php");
require("./include/check.php");

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
//----------------------------------------


if(isset($_POST['task']))
{
	$task = mysql_real_escape_string($_POST['task']);
}
else if(isset($_GET['task']))
{
	$task = mysql_real_escape_string($_GET['task']);
}


//--------------------------------------------


switch(@$task)
{
	case 'configupdate':
		$password_rcon = mysql_real_escape_string($_POST['password_rcon']);
		$port_rcon = mysql_real_escape_string($_POST['port_rcon']);
		$ip = mysql_real_escape_string($_POST['ip']);
		$port = mysql_real_escape_string($_POST['port']);
		$api = mysql_real_escape_string($_POST['api']);
		###
		$error = '';
		###
		if(empty($password_rcon))
		{
			$error .= 'Brak hasła rcon. ';
		}
		if(!is_numeric($port_rcon))
		{
			$error .= 'Nieprawidłowy port rcon. ';
		}
		if(empty($ip))
		{
			$error .= 'Brak adresu ip. ';
		}
		if(validateIP($ip) == FALSE)
		{
			$error .= 'Błędny adres ip. ';
		}
		if(empty($port))
		{
			$error .= 'Brak portu serwera. ';
		}
		if(!is_numeric($port))
		{
			$error .= 'Port serwera jest nieprawidłowy. ';
		}
		if(empty($api))
		{
			$error .= 'Brak api operatora sms. ';
		}
		###
		if(!empty($error))
		{
			$_SESSION['msg1'] = $error;
			$_SESSION['msg-type'] = 'danger';
			unset($error);
			header( "Location: admin.php?page=1" );
			die();
		}
		###
		query_basic( "UPDATE `config` SET `ip`='".$ip."',`port_rcon`='".$port_rcon."',`password_rcon`='".$password_rcon."',`port`='".$port."', `api`='".$api."' WHERE 1" );
		###
		$_SESSION['msg1'] = 'Dane zostały poprawnie uaktualnione!';
		$_SESSION['msg-type'] = 'success';
		header( "Location: admin.php?page=1" );
		die();
		break;
		
	case 'offertsadd':
		$icon = mysql_real_escape_string($_POST['icon']);
		$name = mysql_real_escape_string($_POST['name']);
		$description = mysql_real_escape_string($_POST['description']);
		$commends = mysql_real_escape_string($_POST['commends']);
		$amount = mysql_real_escape_string($_POST['amount']);
		###
		$error = '';
		###
		if(empty($icon))
		{
			$error .= 'Brak linku do ikony. ';
		}
		if(empty($name))
		{
			$error .= 'Brak nazy oferty. ';
		}
		if(empty($description))
		{
			$error .= 'Brak opisu oferty. ';
		}
		if(empty($commends))
		{
			$error .= 'Brak komendy. ';
		}
		if(empty($amount))
		{
			$error .= 'Brak kwoty. ';
		}
		if(!is_numeric($amount))
		{
			$error .= 'Brak kwoty. ';
		}
		###
		if(!empty($error))
		{
			$_SESSION['msg1'] = $error;
			$_SESSION['msg-type'] = 'danger';
			unset($error);
			header( "Location: admin.php?page=2" );
			die();
		}
		###
		query_basic( "INSERT INTO `offerts` SET
			`icon` = '".$icon."',
			`name` = '".$name."',
			`description` = '".$description."',
			`commends` = '".$commends."',
			`amount` = '".$amount."'" );
		###
		$_SESSION['msg1'] = 'Oferta o nazwie: '.$name.' została dodana!';
		$_SESSION['msg-type'] = 'success';
		header( "Location: admin.php?page=2" );
		die();
		break;
		
	case 'offertsdelete':
		if(isset($_POST['id']))
		{
		$id = mysql_real_escape_string($_POST['id']);
		}
		else if(isset($_GET['id']))
		{
		$id = mysql_real_escape_string($_GET['id']);
		}
		###
		$error = '';
		###
		if(empty($id))
		{
			$error .= 'Brak id oferty. ';
		}
		if(!is_numeric($id))
		{
			$error .= 'Id oferty jest nieprawidłowe. ';
		}
		if(query_numrows( "SELECT `name` FROM `offerts` WHERE `id` = '".$id."'" ) == 0)
		{
			$error .= 'Taka oferta nie istnieje. ';
		}
		###
		if(!empty($error))
		{
			$_SESSION['msg1'] = $error;
			$_SESSION['msg-type'] = 'danger';
			unset($error);
			header( "Location: admin.php?page=2" );
			die();
		}
		###
		query_basic( "DELETE FROM `offerts` WHERE `id` = '".$id."'" );
		###
		$_SESSION['msg1'] = 'Pomyślnie usunięto ofertę o id:'.$id.'!';
		$_SESSION['msg-type'] = 'success';
		header( "Location: admin.php?page=2" );
		die();
		break;
		
	case 'offertsedit':
		$icon = mysql_real_escape_string($_POST['icon']);
		$name = mysql_real_escape_string($_POST['name']);
		$description = mysql_real_escape_string($_POST['description']);
		$commends = mysql_real_escape_string($_POST['commends']);
		$amount = mysql_real_escape_string($_POST['amount']);
		$id = mysql_real_escape_string($_POST['id']);
		###
		$error = '';
		###
		if(empty($icon))
		{
			$error .= 'Brak linku do ikony. ';
		}
		if(empty($name))
		{
			$error .= 'Brak nazy oferty. ';
		}
		if(empty($description))
		{
			$error .= 'Brak opisu oferty. ';
		}
		if(empty($commends))
		{
			$error .= 'Brak komendy. ';
		}
		if(empty($amount))
		{
			$error .= 'Brak kwoty. ';
		}
		if(!is_numeric($amount))
		{
			$error .= 'Brak kwoty. ';
		}
		if(empty($id)) {
			$error .= 'Brak id. ';
		}
		if(!is_numeric($id)) {
			$error .= 'Id jest nieprawidłowe. ';
		}
		if(query_numrows( "SELECT `name` FROM `offerts` WHERE `id` = '".$id."'" ) == 0)
		{
			$error .= 'Taka oferta nie istnieje. ';
		}
		###
		if(!empty($error))
		{
			$_SESSION['msg1'] = $error;
			$_SESSION['msg-type'] = 'danger';
			unset($error);
			header( "Location: admin.php?page=2" );
			die();
		}
		###
		query_basic( "UPDATE `offerts` SET `icon`='".$icon."',`name`='".$name."',`description`='".$description."',`commends`='".$commends."',`amount`='".$account."' WHERE `id` = '".$id."'" );
		###
		$_SESSION['msg1'] = 'Pomyślnie uaktualniono ofertę o id:'.$id.'!';
		$_SESSION['msg-type'] = 'success';
		header( "Location: admin.php?page=2" );
		die();
		break;
		
	case 'menuadd':
		$position = mysql_real_escape_string($_POST['position']);
		$name = mysql_real_escape_string($_POST['name']);
		$address = mysql_real_escape_string($_POST['address']);
		###
		$error = '';
		###
		if(empty($position))
		{
			$error .= 'Brak numeru pozycji. ';
		}
		if(!is_numeric($position))
		{
			$error .= 'Nieprawidłowy numer pozycji. ';
		}
		if(empty($name))
		{
			$error .= 'Brak nazy odnośnika. ';
		}
		if(empty($address))
		{
			$error .= 'Brak adresu strony www. ';
		}
		###
		if(!empty($error))
		{
			$_SESSION['msg1'] = $error;
			$_SESSION['msg-type'] = 'danger';
			unset($error);
			header( "Location: admin.php?page=2" );
			die();
		}
		###
		query_fetch_assoc( "INSERT INTO `menu` VALUES ('".$position."', '".$name."', '".$address."');" );
		###
		$_SESSION['msg1'] = 'Pomyślnie utworzono odnośnik!';
		$_SESSION['msg-type'] = 'success';
		header( "Location: admin.php?page=3" );
		die();
		break;
		
	case 'menudelete':
		$position = mysql_real_escape_string($_GET['position']);
		###
		$error = '';
		###
		if(empty($position))
		{
			$error .= 'Brak takiego odnośnika. ';
		}
		if(!is_numeric($position))
		{
			$error .= 'Nieprawidłowy odnośnik. ';
		}
		if(query_numrows( "SELECT `name` FROM `menu` WHERE `position` = '".$position."'" ) == 0)
		{
			$error .= 'Taki odnośnik nie istnieje. ';
		}
		###
		if(!empty($error))
		{
			$_SESSION['msg1'] = $error;
			$_SESSION['msg-type'] = 'danger';
			unset($error);
			header( "Location: admin.php?page=3" );
			die();
		}
		###
		query_fetch_assoc( "DELETE FROM `menu` WHERE `position` = '".$position."'" );
		###
		$_SESSION['msg1'] = 'Pomyślnie usunięto odnośnik!';
		$_SESSION['msg-type'] = 'success';
		header( "Location: admin.php?page=3" );
		die();
		break;

	default:
		exit('<h1><b>Błąd</b></h1>');
}

exit('<h1><b>403 Forbidden</b></h1>');
?>