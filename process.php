<?php
/*
Projekt sklepu do gry minecraft
stworzony przez użytkownika Najlepszy56
www.github.com/najlepszy56.
Udostępnianie bez zgody właściciela
jest naruszeniem zasad licencji.
*/
require("./config.php");
require("./include.php");

if(isset($_POST['payment']))
{
	$payment = mysql_real_escape_string($_POST['payment']);
}
else if(isset($_GET['payment']))
{
	$payment = mysql_real_escape_string($_GET['payment']);
}
###
if(isset($_POST['id']))
{
	$id = mysql_real_escape_string($_POST['id']);
}
else if(isset($_GET['id']))
{
	$id = mysql_real_escape_string($_GET['id']);
}
###
if(empty($id) && empty($payment))
{
	notifications('Błąd systemu!', 'danger');
	unset($error);
	header( "Location: index.php" );
	die();
}


//----------------------------------------------------+


switch(@$payment)
{
	case 'sms':
		$nick = mysql_real_escape_string($_POST['nick']);
		$code = mysql_real_escape_string($_POST['code']);
		$lenghtNick = strlen($nick);
		$lenghtCode = strlen($code);
		###
		$error = '';
		###
		if(empty($nick))
		{
			$error .= 'Brak nicku. ';
		}
		if(empty($code))
		{
			$error .= 'Brak hasła. ';
		}
		if($lenghtNick < 3)
		{
			$error .= 'Nick jest za krótki. ';
		}
		if($lenghtCode < 3)
		{
			$error .= 'Kod jest za krótki. ';
		}
		###
		if(!empty($error))
		{
			notifications($error, 'danger');
			unset($error);
			header( "Location: product.php?id=".$id."&payment=".$payment."" );
			die();
		}
		###
		if(query_numrows("SELECT `name` FROM `offerts` WHERE `id` = '".$id."'") == 1)
		{
			$offert = query_fetch_assoc("SELECT `amount` FROM `offerts` WHERE `id` = '".$id."'");
			$config = query_fetch_assoc("SELECT * FROM `config`");
			$sms = query_fetch_assoc("SELECT `nsms`, `asms`, `assms` FROM `sms` WHERE `id` = '".$offert['amount']."' LIMIT 1");
			###
			$by = array("{CODE}", "{NSMS}", "{ASMS}", "{ASSMS}");
			$after = array($code, $sms['nsms'], $sms['asms'], $sms['assms']);
			$apicreate = str_replace($by, $after, $config['api']);
			$api_success = str_replace($by, $after, $config['api_success']);
			$api_errorcode = str_replace($by, $after, $config['api_errorcode']);
			###
			$api = file_get_contents($apicreate);
			###
			if(trim($api) == trim($api_errorcode))
			{
				notifications('Błędny kod sms!', 'danger');
				header( "Location: product.php?id=".$id."&payment=".$payment."" );
				die();
			}
			else if(trim($api) == trim($api_success))
			{
				define('MQ_SERVER_ADDR', $config['ip']) ;
				define('MQ_SERVER_PORT', $config['port_rcon']);
				define('MQ_SERVER_PASS', $config['password_rcon']);
				define('MQ_TIMEOUT', 2 );
				###
				include(INCLUDES_DIR . "rcon.php");
				###
				$Rcon = new MinecraftRcon;
				$Rcon->Connect( MQ_SERVER_ADDR, MQ_SERVER_PORT, MQ_SERVER_PASS, MQ_TIMEOUT );
									
				$offerts = mysql_query("SELECT * FROM `offerts` WHERE `id` = '".$id."'");
				while($rowsOfferts = @mysql_fetch_assoc($offerts))
				{
					$commends = explode(",", $rowsOfferts['commends']);
					$output = count($commends);
					###
					for($i=0; $i<$output; $i++)
					{
						$by = array("{NICK}");
						$after = array($nick);
						###
						$commends[$i] = str_replace($by, $after, $commends[$i]);
						$data = $Rcon->Command($commends[$i]);
					}
				}
				$Rcon->Disconnect();
			}
			else
			{
				notifications('Błąd api! '.$api.'', 'danger');
				header( "Location: product.php?id=".$id."&payment=".$payment."" );
				die();
			}
		}
		###
		notifications('Usługa została poprawnie przydzielona!', 'success');
		header( "Location: index.php" );
		die();
		break;
		
	case 'voucher':
		$nick = mysql_real_escape_string($_POST['nick']);
		$code = mysql_real_escape_string($_POST['code']);
		$lenghtNick = strlen($nick);
		$lenghtCode = strlen($code);
		###
		$error = '';
		###
		if(empty($nick))
		{
			$error .= 'Brak nicku. ';
		}
		if(empty($code))
		{
			$error .= 'Brak hasła. ';
		}
		if($lenghtNick < 3)
		{
			$error .= 'Nick jest za krótki. ';
		}
		if($lenghtCode < 3)
		{
			$error .= 'Kod jest za krótki. ';
		}
		if(query_numrows("SELECT `name` FROM `offerts` WHERE `id` = '".$id."'") != 1)
		{
			$error .= 'Taka oferta nie istnieje. ';
		}
		###
		if(!empty($error))
		{
			notifications($error, 'danger');
			unset($error);
			header( "Location: product.php?id=".$id."&payment=".$payment."" );
			die();
		}
		###
		$offert = query_fetch_assoc("SELECT `amount` FROM `offerts` WHERE `id` = '".$id."'");
		$config = query_fetch_assoc("SELECT * FROM `config`");
		$voucher = query_fetch_assoc( "SELECT `amount`, `id` FROM `voucher` WHERE `code` = '".$code."' LIMIT 1" );
		###
		if(query_numrows("SELECT `amount` FROM `voucher` WHERE `code` = '".$code."'") == 1 && $voucher['amount'] != 0)
		{
				$amount = $voucher['amount']-1;
				###
				query_basic( "UPDATE `voucher` SET `amount`='".$amount."' WHERE `id` = '".$voucher['id']."'" );
		}
		else
		{
			notifications('Ten kod jest błędny lub został już wykorzystany!', 'danger');
			unset($error);
			header( "Location: product.php?id=".$id."&payment=".$payment."" );
			die();
		}
		###
		define('MQ_SERVER_ADDR', $config['ip']) ;
		define('MQ_SERVER_PORT', $config['port_rcon']);
		define('MQ_SERVER_PASS', $config['password_rcon']);
		define('MQ_TIMEOUT', 2 );
		###
		include(INCLUDES_DIR . "rcon.php");
		###
		$Rcon = new MinecraftRcon;
		$Rcon->Connect( MQ_SERVER_ADDR, MQ_SERVER_PORT, MQ_SERVER_PASS, MQ_TIMEOUT );
							
		$offerts = mysql_query("SELECT * FROM `offerts` WHERE `id` = '".$id."'");
		while($rowsOfferts = @mysql_fetch_assoc($offerts))
		{
			$commends = explode(",", $rowsOfferts['commends']);
			$output = count($commends);
			###
			for($i=0; $i<$output; $i++)
			{
				$by = array("{NICK}");
				$after = array($nick);
				###
				$commends[$i] = str_replace($by, $after, $commends[$i]);
				$data = $Rcon->Command($commends[$i]);
			}
		}
		$Rcon->Disconnect();
		###
		notifications('Usługa została poprawnie przydzielona!', 'success');
		header( "Location: index.php" );
		die();
		break;

	default:
		exit('<h1><b>Błąd</b></h1>');
}

exit('<h1><b>403 Forbidden</b></h1>');
?>