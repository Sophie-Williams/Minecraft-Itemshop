<?php
session_start();
ob_start();
/**
 * Folder instalacyjny
 */
if(is_dir("./install/"))
{
	header( "Location: ./install/");
	die();
}
?>
<html>
 <head>
  <link href="./styl/css/bootstrap.css" rel="stylesheet">
  <link href="./styl/css/bootstrap.min.css" rel="stylesheet">
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
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
              <a href="index.php">Lista uslug</a>
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