<?php
$connection = mysql_connect(DBHOST, DBUSER, DBPASSWORD);
if(!$connection)
{
	exit("Błąd krytyczny bazy mysql!");
}

$db_connection = mysql_select_db(DBNAME);
if(!$db_connection)
{
	exit("Błąd krytyczny bazy mysql!");
}

function query_basic($query)
{
	$result = mysql_query($query);
	if($result == FALSE)
	{
		echo $msg = 'Błąd: '.mysql_error();
	}
}

function query_numrows($query)
{
	$result = mysql_query($query);
	if($result == FALSE)
	{
		echo 'Błąd: '.mysql_error();
	}
	return (mysql_num_rows($result));
}

function query_fetch_assoc($query)
{
	$result = mysql_query($query);
	if($result == FALSE)
	{
		echo 'Błąd: '.mysql_error();
	}
	return (mysql_fetch_assoc($result));
}
?>