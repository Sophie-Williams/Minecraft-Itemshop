<?php
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
###
if(isset($_POST['payment']))
{
	$payment = mysql_real_escape_string($_POST['payment']);
}
else if(isset($_GET['payment']))
{
	$payment = mysql_real_escape_string($_GET['payment']);
}


//----------------------------------------------------+


if(!empty($id) && !empty($payment))
{
	if(query_numrows( "SELECT `name` FROM `offerts` WHERE `id` = '".$id."'" ) == 1)
	{
		$offerts = query_fetch_assoc( "SELECT * FROM `offerts` WHERE `id` = '".$id."' LIMIT 150" );
		
		$sms = query_fetch_assoc( "SELECT `csms`, `nsms`, `asms` FROM `sms` WHERE `id` = '".$offerts['amount']."' LIMIT 1" );
		?>
		<p style="font-size: 25px">Wybrałeś Ofertę: <b><?php echo $offerts['name']; ?></b>, jej koszt wynosi <b><?php echo $sms['asms']; ?></b> zł.</p>
		</hr>
        <?php
		if($payment == 'sms')
		{
			echo "<p>Wyślij smsa o treści: <b>" . $sms['csms'] . "</b> na numer: <b>" . $sms['nsms'] . "</b>.</p>";
        }
		?>
		<br />
		<form action="process.php" method="post">
			<input type="hidden" value="<?php echo $id; ?>" name="id">
			<input type="hidden" value="<?php echo $payment ?>" name="payment">
			<input type="text" class="form-control" placeholder="Nick z serwera!" name="nick">
			<br />
			<input type="text" class="form-control" placeholder="Kod <?php echo $payment ?>" name="code">
			<br />
			<input style="width:145; border-bottom-right-radius: 10px; border-bottom-left-radius: 10px; border-top-right-radius: 10px; border-top-left-radius: 10px; margin-right: 15px;" type="submit" class="btn btn-primary" value="Kup">
			<a class="btn btn-danger" style="width:145; border-bottom-right-radius: 10px; border-bottom-left-radius: 10px; border-top-right-radius: 10px; border-top-left-radius: 10px" href="index.php">Anuluj</a>
		</form>
		<?php
	}
}
require(STYLE_DIR . "footer.php");
?>