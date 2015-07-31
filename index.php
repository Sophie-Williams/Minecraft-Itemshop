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
//----------------------------------------------------+
?>
	<table class="table table-striped table-hover">
		<tbody>
			<tr>
				<th style="width:140px"><center><font>Obrazek</font></center></th>
				<th style="width:110px"><center><font>Nazwa</font></center></th>
				<th style="width:310px"><center><font>Opis</font></center></th>
				<th style="width:110px"><center><font>Opcja</font></center></th>
			</tr>
<?php
	$offerts = mysql_query("SELECT * FROM `offerts` ORDER BY `id` LIMIT 150");
	while($rowsOfferts = mysql_fetch_assoc($offerts))
	{
?>
			<tr class="active">
				<td style="width: 140px; "><center><img style="width:140px; height:130px;" src="<?php echo $rowsOfferts['icon']; ?>"></center></td>
				<td style="width: 110px"><center><p style="width:110px; height:130px; vertical-align: middle; display: table-cell;"><?php echo $rowsOfferts['name']; ?></p></center></td>
				<td style="width: 310px"><center><p style="width:310px; height:130px; vertical-align: middle; display: table-cell;"><?php echo $rowsOfferts['description']; ?></p></center></td>
				<td style="width: 110px"><center><p style="width:110px; height:130px; vertical-align: middle; display: table-cell;"><a href="payment.php?id=<?php echo $rowsOfferts['id']; ?>" style="border-top-right-radius: 10px; border-top-left-radius: 10px; border-bottom-right-radius: 10px; border-bottom-left-radius: 10px; vertical-align: middle; display: table-cell;" class="btn btn-info">Kup!</a></p></center></td>
			</tr>
<?php
	}
?>
		</tbody>
	</table>
<?php
require(STYLE_DIR . "footer.php");
?>