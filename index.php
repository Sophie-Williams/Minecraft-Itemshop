<?php
require("./config.php");
require("./include/mysql.php");
require("./include/header.php");

if(isset($_POST['id']))
{
	$id = mysql_real_escape_string($_POST['id']);
}
else if(isset($_GET['id']))
{
	$id = mysql_real_escape_string($_GET['id']);
}
//-----------------------------
?>
<body style="background-size: 100% 100%; -moz-background-size: 100% 100%;" background="./style/img/tlo.jpg">
	<br /><br /><br /><br /><br /><br />
    <?php
		include( "./include/notifications.php" );
	?>   
	<center>
		<div class="panel panel-success" style="width:800px; border-top-left-radius: 20px; border-top-right-radius: 20px">
			<div class="panel-heading" style="border-top-left-radius: 18px; border-top-right-radius: 18px">
				<h3 class="panel-title">Usługi które można kupić za pomocą płatności sms!</h3>
			</div>
			<div class="panel-body">
				<div class="bs-example table-responsive">
<?php
if(empty($id))
{
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
								<td style="width: 110px"><center><p style="width:110px; height:130px; vertical-align: middle; display: table-cell;"><a href="?id=<?php echo $rowsOfferts['id']; ?>" style="border-top-right-radius: 10px; border-top-left-radius: 10px; border-bottom-right-radius: 10px; border-bottom-left-radius: 10px; vertical-align: middle; display: table-cell;" class="btn btn-info">Kup!</a></p></center></td>
							</tr>
<?php
	}
?>
					</table>
				</div>
<?php
}
//----------------------------------------------------
if(!empty($id))
{
	if(query_numrows( "SELECT `name` FROM `offerts` WHERE `id` = '".$id."'" ) == 1)
	{
		$offerts = query_fetch_assoc( "SELECT * FROM `offerts` WHERE `id` = '".$id."' LIMIT 150" );
	?>
		<p style="font-size: 25px">
        	Wybrałeś Ofertę: <b><?php echo $offerts['name']; ?></b>, jej koszt wynosi <b><?php echo $offerts['amount']; ?></b> zł.
        </p>
		</hr>
		<p>
        	Wyślij smsa o treści: <b>HPAY.FH</b> na numer: <b>
			<?php
            $kw = $offerts['amount'];
            if($kw == '0.62') {
            echo '7055';
            $kw1 = '7055';
            }else if($kw == '0.62') {
            echo '7155';
            $kw1 = '7155';
            }else if($kw == '1.23') {
            echo '7255';
            $kw1 = '7255';
            }else if($kw == '3.69') {
            echo '7355';
            $kw1 = '7355';
            }else if($kw == '4.92') {
            echo '7455';
            $kw1 = '7455';
            }else if($kw == '6.15') {
            echo '7555';
            $kw1 = '7555';
            }else if($kw == '7.38') {
            echo '7655';
            $kw1 = '7655';
            }else if($kw == '11.07') {
            echo '7955';
            $kw1 = '7955';
            }else if($kw == '12.30') {
            echo '91055';
            $kw1 = '91055';
            }else if($kw == '13.53') {
            echo '91155';
            $kw1 = '91155';
            }else if($kw == '17.22') {
            echo '91455';
            $kw1 = '91455';
            }else if($kw == '23.37') {
            echo '91955';
            $kw1 = '91955';
            }else if($kw == '24.60') {
            echo '92055';
            $kw1 = '92055';
            }else if($kw == '30.75') {
            echo '92555';
            $kw1 = '92555';
            }
            ?>
			</b>.
		</p>
        <br />
		<div>
            <form method="post">
                <input type="text" class="form-control" placeholder="Nick z serwera!"  name="nick">
                <br>
                <input type="text" class="form-control" placeholder="Kod z sms'a" name="code">
                <br>
                <input style="width:145; border-bottom-right-radius: 10px; border-bottom-left-radius: 10px; border-top-right-radius: 10px; border-top-left-radius: 10px; margin-right: 15px;" type="submit" class="btn btn-primary" value="Kup">
                <a class="btn btn-danger" style="width:145; border-bottom-right-radius: 10px; border-bottom-left-radius: 10px; border-top-right-radius: 10px; border-top-left-radius: 10px" href="index.php?">Anuluj</a>
            </form>
		</div>
	<?php
	}
}
//----------------------------------------------------
if(!empty($id) && isset($_POST['nick']) && isset($_POST['code']))
{
	if(query_numrows( "SELECT `name` FROM `offerts` WHERE `id` = '".$id."'" ) == 1)
	{
		$config = query_fetch_assoc("SELECT * FROM `config`");
		###
		$nick = mysql_real_escape_string($_POST['nick']);
		$code = mysql_real_escape_string($_POST['code']);
		###
		$api = @file_get_contents("http://fiberhost.pl/api/payment/api_code_verify.php?payment=homepay_sms&amount=".$amount."&userid=".$userid."&code=".$kod."");
		
		
		
		
		
		
		//Dokończyć kwotę
		###
		if(isset($api))
		{
			$api = json_decode($api);
			if(is_object($api))
			{
				if(isset($api->error) && $api->error)
				{
					echo '<div class="alert alert-dismissable alert-danger">Błędny kod</div>';
				}
				else
				{    
					if($api->status=='OK')
					{
						echo '<div class="alert alert-dismissable alert-success">Poprawny kod. Usługa została przydzielona!</div>';
						###
						define('MQ_SERVER_ADDR', $config['ip']) ;
						define('MQ_SERVER_PORT', $config['port_rcon']);
						define('MQ_SERVER_PASS', $config['password_rcon']);
						define('MQ_TIMEOUT', 2 );
						###
						include("./include/rcon.php");
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
								$by = array("{NICK}", "{nick}");
								$after = array($nick, $nick);
								###
								$commends[$i] = str_replace($by, $after, $commends[$i]);
								$data = $Rcon->Command($commends[$i]);
							}
						}
						$Rcon->Disconnect();
					}
					else
					{ 
						echo '<div class="alert alert-dismissable alert-danger">Błędny kod</div>';  
					}
				}
			}
			else
			{
				echo '<div class="alert alert-dismissable alert-danger">Nieoczekiwany błąd API</div>';
			}
		}
		else
		{
			echo '<div class="alert alert-dismissable alert-danger">Brak połączania z API</div>';
		}
	}
}
?>
              </div>
             </div>
            </center>
           </body>