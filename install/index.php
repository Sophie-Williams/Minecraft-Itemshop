<html>
	<head>
	<link href="../styl/css/bootstrap.css" rel="stylesheet">
	<link href="../styl/css/bootstrap.min.css" rel="stylesheet">
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
            </div>
        </div>
		<br /><br /><br /><br /><br /><br /><br /><br />
<?php
if($_GET['page'] == '')
{
?>
        <center>
            <div class="panel panel-success" style="width:800px;">
                <div class="panel-heading">
                    <h3 class="panel-title">Instalacja itemshopu!</h3>
                </div>
                <div class="panel-body">
                    Witaj użytkowniku!
                    <br />
                    Zostaniesz przeprowadzony przez bardzo prostą instalację itemshopu!
                    <br />
                    <br />
                    <a href="?page=1" class="btn btn-primary">Zaczynajmy!</a>
                </div>
            </div>
        </center>
<?php
}
if($_GET['page'] == '1')
{
?>
        <center>
            <div class="panel panel-success" style="width:800px;">
                <div class="panel-heading">
                    <h3 class="panel-title">Instalacja itemshopu! Krok - 1</h3>
                </div>
                <div class="panel-body">
                    Proszę uzupełnić dane w pliku config.php,
                    <br />
                    następnie proszę kliknąć przycisk "dalej".
                    <br />
                    <a href="?page=2" class="btn btn-primary">Dalej!</a>
                </div>
            </div>
        </center>
<?php
}
if($_GET['page'] == '2')
{
?>
        <center>
            <div class="panel panel-success" style="width:800px;">
                <div class="panel-heading">
                    <h3 class="panel-title">Instalacja itemshopu! Krok - 2</h3>
                </div>
                <div class="panel-body">
<?php
require("../config.php");
require("../include/mysql.php");
//Menu
query_basic( "DROP TABLE IF EXISTS `menu`;" );
query_basic( "CREATE TABLE `menu` (
		  `position` TEXT NOT NULL,
		  `name` text NOT NULL,
		  `address` text NOT NULL
		) ENGINE=MyISAM;" );

//Sms
query_basic( "DROP TABLE IF EXISTS `sms`;" );
query_basic( "CREATE TABLE `sms` (
		  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
		  `csms` text NOT NULL,
		  `nsms` text NOT NULL,
		  `asms` text NOI NULL
		) ENGINE=MyISAM;" );
		
//Oferts
query_basic( "DROP TABLE IF EXISTS `offerts`;" );
query_basic( "CREATE TABLE `offerts` (
		`id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
        `icon` TEXT NOT NULL,
        `name` TEXT NOT NULL,
        `commends` TEXT NOT NULL,
        `description` TEXT NOT NULL,
        `amount` TEXT NOT NULL,
		KEY `setting` (`id`)
		) ENGINE=MyISAM;" );

//config
query_basic( "DROP TABLE IF EXISTS `config`;" );
query_basic( "CREATE TABLE `config` (
		`ip` TEXT NOT NULL,
		`port_rcon` TEXT NOT NULL,
		`password_rcon` TEXT NOT NULL,
		`port` TEXT NOT NULL,
		`api` TEXT NOT NULL
		) ENGINE=MyISAM;" );

//User
query_basic( "DROP TABLE IF EXISTS `user`;" );
query_basic( "CREATE TABLE `user` (
		`id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
		`username` TEXT NOT NULL,
        `password` TEXT NOT NULL,
		`session` TEXT NOT NULL,
		KEY `setting` (`id`)
		) ENGINE=MyISAM;" );

query_basic( "INSERT INTO `config` VALUES ('Zmień', 'Zmień', 'Zmień', 'Zmień', 'Zmień');" );

echo '<br /><a href="?page=3" class="btn btn-primary">Dalej!</a>';
           
}
?>
                    <br />
                    <br />
                </div>
            </div>
        </center>
<?php
if($_GET['page'] == '3')
{
	if($_POST['login'] && $_POST['password']) {
		require("../config.php");
		require("../include/mysql.php");
		$login = mysql_real_escape_string($_POST['login']);
		$password = mysql_real_escape_string($_POST['password']);
		$password2 = MD5($password);
		query_basic( "INSERT INTO `user` VALUES ('".$login."', '".$password2."', '');" );
		header('Location: ?page=4');
	}
?>
        <center>
            <div class="panel panel-success" style="width:800px;">
                <div class="panel-heading">
                    <h3 class="panel-title">Instalacja itemshopu! Krok - 3</h3>
                </div>
                <div class="panel-body">
                    Wpisz login i hasło administratora itemshopu!
                    <br />
                    <br />
                    <form method="POST">
                        Login <input class="form-control" type="text" style="width: 200px; height: 30px;" name="login" />
                        Hasło <input class="form-control" type="text" style="width: 200px; height: 30px;" name="password" />
                        <br />
                        <input type="submit" class="btn btn-info" value="Dalej" />
                     </form> 
                    <br />
                    <br />
                </div>
            </div>
        </center>
<?php
}
if($_GET['page'] == '4')
{
?>
        <center>
            <div class="panel panel-success" style="width:800px;">
                <div class="panel-heading">
                    <h3 class="panel-title">Instalacja itemshopu zakończona!</h3>
                </div>
                <div class="panel-body">
                    Usuń plik install.php i kliknij przycisk "Zakończ!"!
                    <br />
                    <br />
                    <a href="../index.php" class="btn btn-primary">Zakończ!</a>
                </div>
            </div>
        </center>
<?php
}
?>