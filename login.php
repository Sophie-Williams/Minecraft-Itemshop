<?php
session_start();
ob_start();
//----------------------------------------
require("./config.php");
require("./include/mysql.php");
require("./include/header.php");
//----------------------------------------
?>
<body style="background-size: 100% 100%; -moz-background-size: 100% 100%;" background="./style/img/tlo.jpg">
	<br /><br /><br /><br /><br /><br />
	<center>
    	<div class="panel panel-success" style="width:800px;">
			<div class="panel-heading">
				<h3 class="panel-title">Logowanie do panelu administratora itemshopu!</h3>
			</div>
			<div class="panel-body">        
				<form action="loginprocess.php" method="post" class="form-horizontal">
                	<input class="form-control" type="hidden" name="task" value="processlogin">  
					<input class="form-control" type="text" name="username" style="height: 30px; width: 200px;" placeholder="Nick użytkownika">  
					<br />
					<input class="form-control" type="password" name="password" style="height: 30px; width: 200px;" placeholder="Hasło">
					<br />
					<button class="btn btn-primary" type="submit">Zaloguj się!</button>                      
                </form>
			</div>
		</div>
	</center>
</body>