<?php
require("./config.php");
require("./include.php");
require(STYLE_DIR . "header.php");

if(isLoggedIn() == TRUE)
{
	$verify = query_fetch_assoc( "SELECT * FROM `user` WHERE `id` = '".$_SESSION['id']."'" );
	if(($verify['username'] != $_SESSION['username']) || ($verify['session'] != session_id()))
	{
		logout();
		header( "Location: login.php" );
		die();
	}
}
else
{
	logout();
	header( "Location: login.php" );
	die();
}

if(isset($_POST['id']))
{
	$id = mysql_real_escape_string($_POST['id']);
}
else if(isset($_GET['id']))
{
	$id = mysql_real_escape_string($_GET['id']);
}
//----------------------------------------
?>
<body style="background-size: 100% 100%; -moz-background-size: 100% 100%;" background="./style/img/tlo.jpg">
	<br /><br /><br /><br /><br /><br />
    <?php
		include(STYLE_DIR . "notifications.php");
	?>
	<center>
    <div style="border-top-right-radius: 20px; border-top-left-radius: 20px; width:800px" class="panel panel-success">
              <div style="border-top-right-radius: 19px; border-top-left-radius: 18px" class="panel-heading">
                <h3 class="panel-title">Panel</h3>
              </div>
              <div class="panel-body">
<div class="navbar navbar-inverse">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="#"><font><font>Panel admina</font></font></a>
                </div>
                <div class="navbar-collapse collapse navbar-inverse-collapse">
                  <ul class="nav navbar-nav">
                    <li <?php if($_GET['page'] == 1) {echo 'class="active"';} ?>><a href="?page=1"><font><font>Ustawienia</font></font></a></li>
                    <li <?php if($_GET['page'] == 2) {echo 'class="active"';} ?>><a href="?page=2"><font><font>Oferty</font></font></a></li>
                    <li <?php if($_GET['page'] == 3) {echo 'class="active"';} ?>><a href="?page=3"><font><font>Menu</font></font></a></li>
                    <li <?php if($_GET['page'] == 4) {echo 'class="active"';} ?>><a href="?page=4"><font><font>Sms</font></font></a></li>
                    <li <?php if($_GET['page'] == 5) {echo 'class="active"';} ?>><a href="?page=5"><font><font>Voucher</font></font></a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                    <li><a href="loginprocess.php?task=logout"><font><font>Wyloguj</font></font></a></li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
           <br />
    <?php
	//----------------------------------------------------
	if($_GET['page'] == '1')
	{
		$data = query_fetch_assoc( "SELECT * FROM `config`" );
		?>
		<form action="process.php" method="post">
        	<input value="configupdate" type="hidden" name="task">
			Ip serwera bez portu<input placeholder="Ip serwera bez portu" value="<?php echo $data['ip']  ?>" style="width:600px" type="text" class="form-control" name="ip">
			<br />
			Port rcon<input placeholder="Port rcon serwera" value="<?php echo $data['port_rcon']  ?>" style="width:600px" type="text" class="form-control" name="port_rcon">
			<br />
			Hasło rcon<input placeholder="Hasło rcon" value="<?php echo $data['password_rcon']  ?>" style="width:600px" type="text" class="form-control" name="password_rcon">
			<br />
			Port serwera<input placeholder="Port serwera" value="<?php echo $data['port']  ?>" style="width:600px" type="text" class="form-control" name="port">
			<br />
			Api<input placeholder="Port serwera" value="<?php echo $data['api']  ?>" style="width:600px" type="text" class="form-control" name="api">
			<br />
			<input type="submit" class="btn btn-primary" value="Zapisz zmiany!">
		</form>
        <br />
		<br />
		<div class="well" style="width:600px">
			Informacje:
            <br />
            1. W api kod przejmuje alias: {CODE}
            <br />
            2. W api numer sms przejmuje alias: {NSMS}
            <br />
            3. W api kwotę sms przejmuje alias: {ASMS}
            <br />
            4. W api kwotę doładowania sms przejmuje alias: {ASSMS}
            <br />
		</div>
		<?php
	}
	//----------------------------------------------------
	if($_GET['page'] == 2)
	{
	?>
        <a href="?page=offertsadd" class="btn btn-info">Utwórz nową ofertę</a>
        <br>
        <br>
        <table class="table table-striped table-hover">
            <tbody>
                <tr>
                    <th style="max-width:1px"><font><font>Id</font></font></th>
                    <th style="max-width:150px"><font><font>Ikona(link)</font></font></th>
                    <th style="max-width:75px"><font><font>Nazwa</font></font></th>
                    <th style="max-width:50px"><font><font>Kwota</font></font></th>
                    <th style="max-width:200px"><center><font><font>Opcja</font></font></center></th>
                </tr>
        <?php
        $offerts = mysql_query("SELECT * FROM `offerts`"); 
        while($rowsOfferts = mysql_fetch_assoc($offerts))
		{
			$amount = query_fetch_assoc( "SELECT `asms` FROM `sms` WHERE `id` = '".$rowsOfferts['amount']."' LIMIT 1" );
        ?>
			<div class="bs-example table-responsive">
				<tr>
					<th style="max-width:1px"><font><font><?php echo $rowsOfferts['id']; ?></font></font></th>
					<th style="max-width:150px; height:150"><font><font><img style="width:150px; height:150px;" src="<?php echo $rowsOfferts['icon']; ?>"></font></font></th>
					<th style="max-width:75px"><font><font><?php echo $rowsOfferts['name']; ?></font></font></th>
					<th style="max-width:50px"><font><font><?php echo $amount['asms']; ?></font></font></th>
					<th style="max-width:200px"><center><font><font><?php echo '<a href="?page=offertsedit&id='.$rowsOfferts['id'].'" class="btn btn-default">Edycja</a>' ?>&nbsp;<?php echo '<a href="process.php?task=offertsdelete&id='.$rowsOfferts['id'].'" class="btn btn-danger">Usuń</a>' ?></font></font></center></th>
				</tr>
    <?php
		}
	}
	?>
			</tbody>
		</table>
    <?php
	//----------------------------------------------------
	if($_GET['page'] == 'offertsadd')
	{
		$sms = mysql_query( "SELECT `id`, `asms` FROM `sms` ORDER BY `asms`" );
	?>
		<form action="process.php" method="post">
            <input type="hidden" name="task" value="offertsadd" />
            Ikona<input type="text" name="icon" class="form-control" style="width:600px" placeholder="Ikonka" /><br />
            Nazwa<input type="text" name="name" class="form-control" style="width:600px" placeholder="Nazwa" /><br />
            Opis<input type="text" name="description" class="form-control" style="width:600px" placeholder="Opis" /><br />
            Komenda/y<input type="text" name="commends" class="form-control" style="width:600px" placeholder="Komenda/y" /><br />
            Kwota sms'a<select class="form-control" name="amount" style="width:600px;">
				<?php
                while ($rowsSms = mysql_fetch_assoc($sms))
                {
                    ?>
                    <option value="<?php echo $rowsSms['id']; ?>">#<?php echo $rowsSms['id'].' - '.htmlspecialchars($rowsSms['asms'], ENT_QUOTES); ?> zł</option>
                    <?php
                }
                ?>
			</select><br />
            Sposoby płatności: <br />
                <div class="checkbox checkbox-success">
                    <input id="checkbox" class="styled" type="checkbox" name="sms" value="1" checked>
                    <label for="checkbox">
                        Sms
                    </label>
                </div>
                <div class="checkbox checkbox-success">
                    <input id="checkbox1" class="styled" type="checkbox" name="voucher" value="1" checked>
                    <label for="checkbox1">
                        Voucher
                    </label>
                </div>
            <br />
            <input type="submit" class="btn btn-primary" value="Stwórz nową ofertę!" />
        </form>
		<br />
		<br />
		<div class="well" style="width:600px">
			Informacje:
            <br>
            1. Nick gracza w komendach przejmuje alias: "{NICK}"
            <br>
            2. Jeżeli chcesz wpisać więcej niż jedną komendę oddzielaj je: "," po przecinku nie rób spacji aby komenda została wykonana!
		</div>
	<?php
	}
	//----------------------------------------------------
	if($_GET['page'] == 'offertsedit' && isset($id))
	{
		$data = query_fetch_assoc( "SELECT * FROM `offerts` WHERE `id` = '".$id."'" );
		 
		$sms = mysql_query( "SELECT `id`, `asms` FROM `sms` ORDER BY `asms`" );
		{
			{
			?>
			<form action="process.php" method="post">
            	<input type="hidden" name="task" value="offertsedit" />
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                Ikona<input value="<?php echo $data['icon']; ?>" type="text" name="icon" class="form-control" style="width:600px" placeholder="Ikonka" /><br />
                Nazwa<input value="<?php echo $data['name']; ?>" type="text" name="name" class="form-control" style="width:600px" placeholder="Nazwa" /><br />
                Opis<input value="<?php echo $data['description']; ?>" type="text" name="description" class="form-control" style="width:600px" placeholder="Opis" /><br />
                Komenda/y<input value="<?php echo $data['commends']; ?>" type="text" name="commends" class="form-control" style="width:600px" placeholder="Komenda/y" /><br />
                 Kwota sms'a<select class="form-control" name="amount" style="width:600px;">
                    <?php
                    while ($rowsSms = mysql_fetch_assoc($sms))
                    {
                        ?>
                        <option <?php if($data['amount'] == $rowsSms['id']) {echo 'selected';} ?> value="<?php echo $rowsSms['id']; ?>">#<?php echo $rowsSms['id'].' - '.htmlspecialchars($rowsSms['asms'], ENT_QUOTES); ?> zł</option>
                        <?php
                    }
                    ?>
                </select><br />
                Sposoby płatności<br />
                    <div class="checkbox checkbox-success">
                        <input id="checkbox" class="styled" type="checkbox" name="sms" value="1" <?php if($data['sms'] == 1) {echo 'checked';} ?>>
                        <label for="checkbox">
                            Sms
                        </label>
                    </div>
                    <div class="checkbox checkbox-success">
                        <input id="checkbox1" class="styled" type="checkbox" name="voucher" value="1" <?php if($data['voucher'] == 1) {echo 'checked';} ?>>
                        <label for="checkbox1">
                            Voucher
                        </label>
                    </div>
                <br />
                <input type="submit" class="btn btn-primary" value="Zapisz zmiany!" />
            </form>
			<br />
			<br />
			<div class="well" style="width:600px">
			Informacje:
			<br />
			1. Nick gracza w komendach przejmuje alias: "{NICK}"
			<br />
			2. Jeżeli chcesz wpisać więcej niż jedną komendę oddzielaj je: "," po przecinku nie rób spacji aby komenda została wykonana!
			</div>
			<?php
			}
		}
	}
	//----------------------------------------------------
	if($_GET['page'] == 3)
	{
	?>
        <a href="?page=menuadd" class="btn btn-info">Dodaj nowy odnośnik</a>
        <br />
        <br />
        <table class="table table-striped table-hover">
            <tr>
                <td>Pozycja odnośnika</td>
                <td>Nazwa odnośnika</td>
                <td>Odnośnik/link</td>
                <td>Opcja</td>
            </tr>
		<?php
        $menu = mysql_query( "SELECT * FROM `menu` ORDER BY `position`" ); 
        while($rowsMenu = mysql_fetch_assoc($menu))
		{
        ?>
            <div class="bs-example table-responsive">
                <tr>
                    <th><font><font><?php echo $rowsMenu['position']; ?></font></font></th>
                    <th><font><font><?php echo $rowsMenu['name']; ?></font></font></th>
                    <th><font><font><?php echo $rowsMenu['address']; ?></font></font></th>
                    <th><a class="btn btn-default" href="process.php?task=menudelete&position=<?php echo $rowsMenu['position']; ?>">Usuń</a></th>
                </tr>
        <?php
        }
	}
	//----------------------------------------------------
	if($_GET['page'] == 'menuadd')
	{
		?>
		<form action="process.php" method="post">
            <input type="hidden" value="menuadd" name="task" />
            Pozycja <input style="width:600px" type="text" name="position" placeholder="Pozycja odnośnika" class="form-control" />
            <br />
            Nazwa <input style="width:600px" type="text" name="name" placeholder="Zazwa odnośnika" class="form-control" />
            <br />
            Adres <input style="width:600px" type="text" name="address" placeholder="Adres odnośnika" class="form-control" />
            <br />
            <input type="submit" class="btn btn-primary" value="Dodaj" />
		</form>
    	<?php
	}
	//----------------------------------------------------
	if($_GET['page'] == 4)
	{
	?>
        <a href="?page=smsadd" class="btn btn-info">Dodaj nowy sms</a>
        <br />
        <br />
        <table class="table table-striped table-hover">
            <tr>
                <td>Id</td>
                <td>Treść sms</td>
                <td>Numer sms</td>
                <td>Kwota sms</td>
                <td>Kwota doładowania</td>
                <td>Opcja</td>
            </tr>
		<?php
        $sms = mysql_query( "SELECT * FROM `sms` ORDER BY `id`" ); 
        while($rowsSms = mysql_fetch_assoc($sms))
		{
        ?>
            <div class="bs-example table-responsive">
                <tr>
                    <th><font><font><?php echo $rowsSms['id']; ?></font></font></th>
                    <th><font><font><?php echo $rowsSms['csms']; ?></font></font></th>
                    <th><font><font><?php echo $rowsSms['nsms']; ?></font></font></th>
                    <th><font><font><?php echo $rowsSms['asms']; ?></font></font></th>
                    <th><font><font><?php echo $rowsSms['assms']; ?></font></font></th>
                    <th><center><font><font><?php echo '<a href="?page=smssedit&id='.$rowsSms['id'].'" class="btn btn-default">Edycja</a>' ?>&nbsp;<?php echo '<a href="process.php?task=smsdelete&id='.$rowsSms['id'].'" class="btn btn-danger">Usuń</a>' ?></font></font></center></th>
                </tr>
        <?php
        }
	}
	//----------------------------------------------------
	if($_GET['page'] == 'smsadd')
	{
		?>
		<form action="process.php" method="post">
            <input type="hidden" value="smsadd" name="task" />
            Treść <input style="width:600px" type="text" name="csms" placeholder="Treść sms" class="form-control" />
            <br />
            Numer <input style="width:600px" type="text" name="nsms" placeholder="Numer sms" class="form-control" />
            <br />
            Kwota <input style="width:600px" type="text" name="asms" placeholder="Kwota sms" class="form-control" />
            <br />
            Kwota doładowania <input style="width:600px" type="text" name="assms" placeholder="Kwota doładowania sms" class="form-control" />
            <br />
            <input type="submit" class="btn btn-primary" value="Dodaj" />
		</form>
    <?php
	}
	//----------------------------------------------------
	if($_GET['page'] == 'smsedit' && isset($id))
	{
		$data = query_fetch_assoc( "SELECT * FROM `sms` WHERE `id` = '".$id."' " ); 
		?>
		<form action="process.php" method="post">
			<input type="hidden" name="task" value="smsedit" />
			<input type="hidden" name="id" value="<?php echo $data['id'] ?>" />
			Treść <input style="width:600px" type="text" name="csms" value="<?php echo $data['csms'] ?>" placeholder="Treść sms" class="form-control" />
            <br />
            Numer <input style="width:600px" type="text" name="nsms" value="<?php echo $data['nsms']; ?>" placeholder="Numer sms" class="form-control" />
            <br />
            Kwota <input style="width:600px" type="text" name="asms" value="<?php echo $data['asms']; ?>" placeholder="Kwota sms" class="form-control" />
            <br />
            Kwota doładowania <input style="width:600px" type="text" name="assms" value="<?php echo $data['assms']; ?>" placeholder="Kwota doładowania sms" class="form-control" />
			<br />
			<input type="submit" class="btn btn-primary" value="Zapisz zmiany!" />
		</form>
		<?php
	}
	//----------------------------------------------------
	if($_GET['page'] == 5)
	{
	?>
        <a href="?page=voucheradd" class="btn btn-info">Dodaj nowy voucher</a>
        <br />
        <br />
        <table class="table table-striped table-hover">
            <tr>
                <td>Id</td>
                <td>Kod</td>
                <td>Ilość użyć</td>
                <td><center>Opcja</center></td>
            </tr>
		<?php
        $voucher = mysql_query( "SELECT * FROM `voucher` ORDER BY `id`" ); 
        while($rowsVoucher = mysql_fetch_assoc($voucher))
		{
        ?>
            <div class="bs-example table-responsive">
                <tr>
                    <th><font><font><?php echo $rowsVoucher['id']; ?></font></font></th>
                    <th><font><font><?php echo $rowsVoucher['code']; ?></font></font></th>
                    <th><font><font><?php echo $rowsVoucher['amount']; ?></font></font></th>
                    <th><center><font><font><?php echo '<a href="process.php?task=voucherdelete&id='.$rowsVoucher['id'].'" class="btn btn-default">Usuń</a>' ?></font></font></center></th>
                </tr>
        <?php
        }
	}
	//----------------------------------------------------
	if($_GET['page'] == 'voucheradd')
	{
		?>
		<form action="process.php" method="post">
            <input type="hidden" value="voucheradd" name="task" />
            Kod(pozostaw puste aby wygenerować losowy kod) <input style="width:600px" type="text" name="code" placeholder="Kod" class="form-control" />
            <br />
            Ilość użyć <input style="width:600px" type="text" name="amount" placeholder="Ilość użyć" class="form-control" />
            <br />
            <input type="submit" class="btn btn-primary" value="Dodaj" />
		</form>
    	<?php
	}
	?>
	             </div>
                </div>
               </div>
              </center>
             </body>