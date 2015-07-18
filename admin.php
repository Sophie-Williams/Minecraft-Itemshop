<?php
session_start();
ob_start();
//----------------------------------------
require("./config.php");
require("./include/mysql.php");
require("./include/auth.php");
require("./include/check.php");
require("./include/header.php");

if(isLoggedIn() == TRUE)
{
	$verify = query_fetch_assoc( "SELECT * FROM `user` WHERE `id` = '".$_SESSION['id']."'" );
	if(($verify['username'] != $_SESSION['username']) || ($verify['session'] != session_id()))
	{
		logout();
		header( "Location: login.php" );
		die();
	}
} else {
	logout();
	header( "Location: login.php" );
	die();
}

if(isset($_GET['id']))
{
	$id = mysql_real_escape_string($_GET['id']);
}
//----------------------------------------
?>
<body style="background-size: 100% 100%; -moz-background-size: 100% 100%;" background="./style/img/tlo.jpg">
	<br /><br /><br /><br /><br /><br />
    <?php
		include( "./include/notifications.php" );
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
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                    <li><a href="loginprocess.php?task=logout"><font><font>Wyloguj</font></font></a></li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
           </br>
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
			<input type="submit" class="btn btn-primary" value="Zapisz">
		</form>
        <br />
		<br />
		<div class="well" style="width:600px">
			Informacje:
            <br />
            1. W api kod przejmuje alias: "{KOD}"
            <br />
            1. W api numer sms przejmuje alias: "{NSMS}"
            <br />
            1. W api kwotę sms przejmuje alias: "{ASMS}"
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
        ?>
			<div class="bs-example table-responsive">
				<tr>
					<th style="max-width:1px"><font><font><?php echo $rowsOfferts['id']; ?></font></font></th>
					<th style="max-width:150px; height:150"><font><font><img style="width:150px; height:150px;" src="<?php echo $rowsOfferts['icon']; ?>"></font></font></th>
					<th style="max-width:75px"><font><font><?php echo $rowsOfferts['name']; ?></font></font></th>
					<th style="max-width:50px"><font><font><?php echo $rowsOfferts['amount']; ?></font></font></th>
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
	?>
		<form action="process.php" method="post">
            <input type="hidden" name="task" value="offertsadd" />
            Ikona<input type="text" name="icon" class="form-control" style="width:600px" placeholder="Ikonka" /></br>
            Nazwa<input type="text" name="name" class="form-control" style="width:600px" placeholder="Nazwa" /></br>
            Opis<input type="text" name="description" class="form-control" style="width:600px" placeholder="Opis" /></br>
            Komenda/y<input type="text" name="commends" class="form-control" style="width:600px" placeholder="Komenda/y" /></br>
            Kwota sms'a<select class="form-control" name="amount" style="width:600px;">
            <option>0.62</option>
            <option>1.23</option>
            <option>2.46</option>
            <option>3.69</option>
            <option>4.92</option>
            <option>6.15</option>
            <option>7.38</option>
            <option>11.07</option>
            <option>12.30</option>
            <option>13.53</option>
            <option>17.22</option>
            <option>23.37</option>
            <option>24.60</option>
            <option>30.75</option>
            </select>
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
	if($_GET['page'] == 'offertsedit')
	{
		$data = query_fetch_assoc( "SELECT * FROM `offerts` WHERE `id` = '".$id."' " ); 
		{
			{
			?>
			<form action="process.php" method="post">
            	<input type="hidden" name="task" value="offertsedit" />
			Ikona<input value="<?php echo $data['icon']; ?>" type="text" name="icon" class="form-control" style="width:600px" placeholder="Ikonka" /></br>
			Nazwa<input value="<?php echo $data['name']; ?>" type="text" name="name" class="form-control" style="width:600px" placeholder="Nazwa" /></br>
			Opis<input value="<?php echo $data['description']; ?>" type="text" name="description" class="form-control" style="width:600px" placeholder="Opis" /></br>
			Komenda/y<input value="<?php echo $data['commends']; ?>" type="text" name="commends" class="form-control" style="width:600px" placeholder="Komenda/y" /></br>
			Kwota sms'a<select class="form-control" name="account" style="width:600px;">
                    <option>0.62</option>
                    <option>1.23</option>
                    <option>2.46</option>
                    <option>3.69</option>
                    <option>4.92</option>
                    <option>6.15</option>
                    <option>7.38</option>
                    <option>11.07</option>
                    <option>12.30</option>
                    <option>13.53</option>
                    <option>17.22</option>
                    <option>23.37</option>
                    <option>24.60</option>
                    <option>30.75</option>
                </select>
                </br>
                <input type="submit" class="btn btn-primary" value="Zapisz zmiany w tej ofercie!" />
            </form>
			</br>
			</br>
			<div class="well" style="width:600px">
			Informacje:
			</br>
			1. Nick gracza w komendach przejmuje alias: "{NICK}"
			<br>
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
            </br>
            Nazwa <input style="width:600px" type="text" name="name" placeholder="Zazwa odnośnika" class="form-control" />
            </br>
            Adres <input style="width:600px" type="text" name="address" placeholder="Adres odnośnika" class="form-control" />
            </br>
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