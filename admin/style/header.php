<html>
 <head>
  <link href="../style/css/bootstrap.css" rel="stylesheet">
  <link href="../style/css/bootstrap.min.css" rel="stylesheet">
  <link href="../style/css/font/css/font-awesome.css" rel="stylesheet">
  <link href="../style/css/build.css" rel="stylesheet">
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="../style/js/bootstrap.js"></script>
  <script src="../style/js/bootstrap.min.js"></script>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
  <title>.: Sklep :.</title>
 </head>
 <body>
 
<div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="index.php" class="navbar-brand"><p style="font-size: 30px">ItemShop</p></a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
            <li>
              <a href="../index.php">Lista uslug</a>
            </li>
<?php
				$menu = mysql_query( "SELECT * FROM `menu` ORDER BY `position`"); 
				while ($rowsMenu = mysql_fetch_assoc($menu))
				{
					echo  ' <li><a href="'.$rowsMenu['address'].'">'.$rowsMenu['name'].'</a></li> ';
				}
?>
          </ul>
        </div>
      </div>
    </div>
    <body style="background-size: 100% 100%; -moz-background-size: 100% 100%;" background="../style/img/tlo.jpg">
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
                        <li <?php if($_GET['page'] == 6) {echo 'class="active"';} ?>><a href="?page=6"><font><font>Logi</font></font></a></li>
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