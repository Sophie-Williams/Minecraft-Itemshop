<?
session_start();
ob_start();
//-----------------------------
require("./config.php");
require("./include/mysql.php");
require("./include/header.php");
?>
<body style="background-attachment: fixed;" background="img/tlo.jpg">
	<br /><br /><br /><br /><br /><br />
	<center>
    	<div class="panel panel-success" style="width:800px;">
			<div class="panel-heading">
				<h3 class="panel-title">Logowanie do panelu administratora itemshopu!</h3>
			</div>
			<div class="panel-body">
               
               
<?         
if($_GET['logout'] == '1')
{
	$_SESSION = array();
	session_destroy();
}

if(isset($_POST['login']) && isset($_POST['password']))
{
	$login = mysql_real_escape_string($_POST['login']);
	$password = mysql_real_escape_string($_POST['password']);
	if($login == NULL)
	{
		echo '<div id="info" class="alert alert-dismissable alert-warning">
		  <button type="button" class="close" onclick="close_info()" data-dismiss="alert">&times;</button>
		  <strong>Konto:</strong> Nie wpisano loginu konta!.
		</div>';
	}
	else 
	{
		if($password == NULL)
		{
		echo '<div id="info" class="alert alert-dismissable alert-warning">
		  <button type="button" class="close" onclick="close_info()" data-dismiss="alert">&times;</button>
		  <strong>Konto:</strong> Nie wpisano hasła konta!.
		</div>';
		}
		else
		{
			$password2 = MD5($password);
			$numrows = query_numrows( "SELECT * FROM `user` WHERE `login` = '".$login."' AND `password` = '".$password2."'" );
			if($numrows == 1)
			{
				session_regenerate_id();
				###
				$session = session_id();
				###
				mysql_query( "UPDATE `user` SET `session` = '".$session."'" );
				###
				$_SESSION['username'] = $login;
				header("location:admin.php");
			}
			else
			{
				echo '<div id="info" class="alert alert-dismissable alert-warning">
				  <button type="button" class="close" onclick="close_info()" data-dismiss="alert">&times;</button>
				  <strong>Konto:</strong> Wpisano nieprawidłowy login lub hasło!.</div>';
			}
		}
	}
}
        ?>         
				<form method="POST" class="form-horizontal">            
					<input class="form-control" type="text" name="login" style="height: 30px; width: 200px;" placeholder="Login">  
					<br />
					<input class="form-control" type="password" name="password" style="height: 30px; width: 200px;" placeholder="Hasło">
					<br />
					<button class="btn btn-primary" type="submit">Zaloguj się!</button>                      
                </form>
			</div>
		</div>
	</center>
</body>