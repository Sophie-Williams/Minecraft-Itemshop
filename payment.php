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
require(STYLE_DIR . "header.php");

if(isset($_POST['id']))
{
	$id = mysql_real_escape_string($_POST['id']);
}
else if(isset($_GET['id']))
{
	$id = mysql_real_escape_string($_GET['id']);
}


//----------------------------------------------------+


if(!empty($id))
{
	$offerts = query_fetch_assoc( "SELECT `sms`, `voucher` FROM `offerts` WHERE `id` = '".$id."' LIMIT 150" );
	?>
    <p style="font-size: 25px">Wybierz sposób płatności:</p>
	</hr>
    <?php
	if($offerts['sms'] == 1)
	{
    	echo "<a href=\"product.php?id=$id&payment=sms\" class=\"btn btn-primary\" style=\"margin-bottom: 10px;\">Sms</a><br />";
	}
	if($offerts['voucher'] == 1)
	{
    	echo "<a href=\"product.php?id=$id&payment=voucher\" class=\"btn btn-primary\">Voucher</a>";
	}
	if($offerts['sms'] == 0 && $offerts['sms'] == 0)
	{
		echo "<div class=\"alert alert-dismissable alert-danger\">Tej oferty nie można kupić!</div>";
	}
}
require(STYLE_DIR . "footer.php");
?>