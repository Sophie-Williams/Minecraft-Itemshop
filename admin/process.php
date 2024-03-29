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
require("../config.php");
require("./include.php");

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
	case 'configupdate':
		$password_rcon = mysql_real_escape_string($_POST['password_rcon']);
		$port_rcon = mysql_real_escape_string($_POST['port_rcon']);
		$ip = mysql_real_escape_string($_POST['ip']);
		$port = mysql_real_escape_string($_POST['port']);
		$api = mysql_real_escape_string($_POST['api']);
		$api_success = mysql_real_escape_string($_POST['api_success']);
		$api_errorcode = mysql_real_escape_string($_POST['api_errorcode']);
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
		if(empty($api_success))
		{
			$error .= 'Brak api success code';
		}
		if(empty($api_errorcode))
		{
			$error .= 'Brak api error code';
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
		query_basic( "UPDATE `config` SET `ip`='".$ip."',`port_rcon`='".$port_rcon."',`password_rcon`='".$password_rcon."',`port`='".$port."', `api`='".$api."', `api_success`='".$api_success."', `api_errorcode`='".$api_errorcode."' WHERE 1" );
		###
		$_SESSION['msg1'] = 'Dane zostały poprawnie uaktualnione!';
		$_SESSION['msg-type'] = 'success';
		header( "Location: admin.php?page=1" );
		die();
		break;
		
//----------------------------------------------------+
		
	case 'offertsadd':
		$icon = mysql_real_escape_string($_POST['icon']);
		$name = mysql_real_escape_string($_POST['name']);
		$description = mysql_real_escape_string($_POST['description']);
		$commends = mysql_real_escape_string($_POST['commends']);
		$amount = mysql_real_escape_string($_POST['amount']);
		$sms = mysql_real_escape_string($_POST['sms']);
		$voucher = mysql_real_escape_string($_POST['voucher']);
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
			$error .= 'Błędny format kwoty. ';
		}
		if(query_numrows( "SELECT `csms` FROM `sms` WHERE `id` = '".$amount."'" ) == 0)
		{
			$error .= 'Taki sms nie istnieje. ';
		}
		if(empty($sms))
		{
			$sms = 0;
		}
		else if(!is_numeric($sms))
		{
			$error .= 'Błędny format sposobu płatności. ';
		}
		if(empty($voucher))
		{
			$voucher = 0;
		}
		else if(!is_numeric($voucher))
		{
			$error .= 'Błędny format sposobu płatności. ';
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
			`amount` = '".$amount."'
			`sms` = '".$sms."',
			`voucher` = '".$voucher."'" );
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
		$sms = mysql_real_escape_string($_POST['sms']);
		$voucher = mysql_real_escape_string($_POST['voucher']);
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
			$error .= 'Nieprawidłowy format kwoty. ';
		}
		if(query_numrows( "SELECT `csms` FROM `sms` WHERE `id` = '".$amount."'" ) == 0)
		{
			$error .= 'Taki sms nie istnieje. ';
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
		if(empty($sms))
		{
			$sms = 0;
		}
		else if(!is_numeric($sms))
		{
			$error .= 'Błędny format sposobu płatności. ';
		}
		if(empty($voucher))
		{
			$voucher = 0;
		}
		else if(!is_numeric($voucher))
		{
			$error .= 'Błędny format sposobu płatności. ';
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
		query_basic( "UPDATE `offerts` SET `icon`='".$icon."',`name`='".$name."',`description`='".$description."',`commends`='".$commends."',`amount`='".$amount."', `sms`='".$sms."', `voucher`='".$voucher."' WHERE `id` = '".$id."'" );
		###
		$_SESSION['msg1'] = 'Pomyślnie uaktualniono ofertę o id:'.$id.'!';
		$_SESSION['msg-type'] = 'success';
		header( "Location: admin.php?page=2" );
		die();
		break;

//----------------------------------------------------+
		
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
		
//----------------------------------------------------

	case 'smsadd':
		$csms = mysql_real_escape_string($_POST['csms']);
		$nsms = mysql_real_escape_string($_POST['nsms']);
		$asms = mysql_real_escape_string($_POST['asms']);
		$assms = mysql_real_escape_string($_POST['assms']);
		###
		$error = '';
		###
		if(empty($csms))
		{
			$error .= 'Brak treści sms. ';
		}
		if(empty($nsms))
		{
			$error .= 'Brak numeru sms. ';
		}
		if(!is_numeric($nsms))
		{
			$error .= 'Nieprawidłowy numer sms. ';
		}
		if(empty($asms))
		{
			$error .= 'Kwota sms. ';
		}
		if(!is_numeric($asms))
		{
			$error .= 'Nieprawidłowa kwota sms. ';
		}
		if(empty($assms))
		{
			$error .= 'Brak kwoty doładowania sms. ';
		}
		if(!is_numeric($assms))
		{
			$error .= 'Nieprawidłowa kwota doładowania sms. ';
		}
		###
		if(!empty($error))
		{
			$_SESSION['msg1'] = $error;
			$_SESSION['msg-type'] = 'danger';
			unset($error);
			header( "Location: admin.php?page=4" );
			die();
		}
		###
		query_basic( "INSERT INTO `sms` SET
			`csms` = '".$csms."',
			`nsms` = '".$nsms."',
			`asms` = '".$asms."',
			`assms` = '".$assms."'" );
		###
		$_SESSION['msg1'] = 'Sms został dodany!';
		$_SESSION['msg-type'] = 'success';
		header( "Location: admin.php?page=4" );
		die();
		break;
		
	case 'smsdelete':
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
			$error .= 'Brak id. ';
		}
		if(!is_numeric($id))
		{
			$error .= 'Id sms jest nieprawidłowe. ';
		}
		if(query_numrows( "SELECT `name` FROM `sms` WHERE `id` = '".$id."'" ) == 0)
		{
			$error .= 'Taki sms nie istnieje. ';
		}
		###
		if(!empty($error))
		{
			$_SESSION['msg1'] = $error;
			$_SESSION['msg-type'] = 'danger';
			unset($error);
			header( "Location: admin.php?page=4" );
			die();
		}
		###
		query_basic( "DELETE FROM `sms` WHERE `id` = '".$id."'" );
		###
		$_SESSION['msg1'] = 'Pomyślnie usunięto sms o id:'.$id.'!';
		$_SESSION['msg-type'] = 'success';
		header( "Location: admin.php?page=2" );
		die();
		break;
		
	case 'smsedit':
		$csms = mysql_real_escape_string($_POST['csms']);
		$nsms = mysql_real_escape_string($_POST['nsms']);
		$asms = mysql_real_escape_string($_POST['asms']);
		$assms = mysql_real_escape_string($_POST['assms']);
		$id = mysql_real_escape_string($_POST['id']);
		###
		$error = '';
		###
		if(empty($csms))
		{
			$error .= 'Brak treści sms. ';
		}
		if(empty($nsms))
		{
			$error .= 'Brak numeru sms. ';
		}
		if(!is_numeric($nsms))
		{
			$error .= 'Nieprawidłowy numer sms. ';
		}
		if(empty($asms))
		{
			$error .= 'Kwota sms. ';
		}
		if(!is_numeric($asms))
		{
			$error .= 'Nieprawidłowa kwota sms. ';
		}
		if(empty($assms))
		{
			$error .= 'Kwota doładowania sms. ';
		}
		if(!is_numeric($assms))
		{
			$error .= 'Nieprawidłowa kwota doładowania sms. ';
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
			header( "Location: admin.php?page=4" );
			die();
		}
		###
		query_basic( "UPDATE `offerts` SET `csms`='".$csms."',`nsms`='".$nsms."',`asms`='".$asms."',`assms`='".$assms."' WHERE `id` = '".$id."'" );
		###
		$_SESSION['msg1'] = 'Pomyślnie uaktualniono sms o id:'.$id.'!';
		$_SESSION['msg-type'] = 'success';
		header( "Location: admin.php?page=4" );
		die();
		break;
		
//----------------------------------------------------+

	case 'voucheradd':
		$code = mysql_real_escape_string($_POST['code']);
		$amount = mysql_real_escape_string($_POST['amount']);
		###
		$error = '';
		###
		if(empty($amount))
		{
			$error .= 'Brak ilości użyć. ';
		}
		if(!is_numeric($amount))
		{
			$error .= 'Błędna ilość użyć';
		}
		###
		if(!empty($error))
		{
			$_SESSION['msg1'] = $error;
			$_SESSION['msg-type'] = 'danger';
			unset($error);
			header( "Location: admin.php?page=5" );
			die();
		}
		###
		if(empty($code))
		{
			$code = pass_generator();
		}
		###
		query_basic( "INSERT INTO `voucher` SET
			`code` = '".$code."',
			`amount` = '".$amount."'" );
		###
		$_SESSION['msg1'] = 'Voucher został dodany!';
		$_SESSION['msg-type'] = 'success';
		header( "Location: admin.php?page=5" );
		die();
		break;
		
	case 'voucherdelete':
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
			$error .= 'Brak id. ';
		}
		if(!is_numeric($id))
		{
			$error .= 'Id vouchera jest nieprawidłowe. ';
		}
		if(query_numrows( "SELECT `code` FROM `voucher` WHERE `id` = '".$id."'" ) == 0)
		{
			$error .= 'Taki voicher nie istnieje. ';
		}
		###
		if(!empty($error))
		{
			$_SESSION['msg1'] = $error;
			$_SESSION['msg-type'] = 'danger';
			unset($error);
			header( "Location: admin.php?page=5" );
			die();
		}
		###
		query_basic( "DELETE FROM `voucher` WHERE `id` = '".$id."'" );
		###
		$_SESSION['msg1'] = 'Pomyślnie usunięto voucher o id:'.$id.'!';
		$_SESSION['msg-type'] = 'success';
		header( "Location: admin.php?page=5" );
		die();
		break;
		
	case 'logdelete':
		query_basic( "TRUNCATE `log`" );
		$_SESSION['msg1'] = 'Logi zostały usunięte!';
		$_SESSION['msg-type'] = 'success';
		header( "Location: admin.php?page=6" );
		die();
		break;

	default:
		exit('<h1><b>Błąd</b></h1>');
}

exit('<h1><b>403 Forbidden</b></h1>');
?>