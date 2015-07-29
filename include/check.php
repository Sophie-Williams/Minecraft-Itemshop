<?php
/**
 * Sprawdzanie adresu ip
 */
function validateIP($ip)
{
	$regex = "#[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}#";
	$validate = preg_match($regex, $ip);
	if($validate == 1)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

/**
 * Generator haseł
 */
function pass_generator() {
	$length = 8;
	$t = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWYZ";
	###
	srand((double)microtime() * 1000000);
	###
	while(strlen($pass) < $length)
	{
		$character = $t[rand(0, strlen($t)-1)];
		if(!is_integer(strpos($pass, $character)))
		{
			$pass .= $character;
		}
	}
	return $pass;
}
?>