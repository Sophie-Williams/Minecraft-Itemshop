<?php
require("../config.php");
require(INCLUDES_DIR . "mysql.php");
require(STYLE2_DIR . "header.php");
//----------------------------------------------------+
?>
	<form action="loginprocess.php" method="post" class="form-horizontal">
		<input class="form-control" type="hidden" name="task" value="processlogin">  
		<input class="form-control" type="text" name="username" style="height: 30px; width: 200px;" placeholder="Nick użytkownika">  
		<br />
		<input class="form-control" type="password" name="password" style="height: 30px; width: 200px;" placeholder="Hasło">
		<br />
		<button class="btn btn-primary" type="submit">Zaloguj się!</button>                      
	</form>