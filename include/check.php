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
?>