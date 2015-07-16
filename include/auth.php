<?php
/**
 * Sprawdzanie użytkowników
 */
function validate()
{
	session_regenerate_id();
	###
	$session = session_id();
	###
	mysql_query( "UPDATE `user` SET `session` = '".$session."' WHERE `id` = '".$_SESSION['id']."'" );
}

/**
 * Sprawdzanie, czy użytkownik jest zalogowany
 */
function isLoggedIn()
{
	if(!empty($_SESSION['id']) && is_numeric($_SESSION['id']))
	{
		$verify = mysql_query( "SELECT `username` FROM `user` WHERE `id` = '".$_SESSION['id']."' AND `session` = '".session_id()."'" );
		if(mysql_num_rows($verify) == 1)
		{
			return TRUE;
		}
		unset($adminverify);
	}
	return FALSE;
}

/**
 * Wylogowywanie
 */
function logout()
{
	$_SESSION = array();
	session_destroy();
}
?>