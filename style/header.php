<html>
	<head>
		<link href="./style/css/bootstrap.css" rel="stylesheet">
        <link href="./style/css/bootstrap.min.css" rel="stylesheet">
        <link href="./style/css/font/css/font-awesome.css" rel="stylesheet">
        <link href="./style/css/build.css" rel="stylesheet">
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="./style/js/bootstrap.js"></script>
        <script src="./style/js/bootstrap.min.js"></script>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
        <title>.: Sklep :.</title>
	</head>
	<body style="background-size: 100% 100%; -moz-background-size: 100% 100%;" background="./style/img/tlo.jpg">
    	<!-- Body -->
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
        <br /><br /><br /><br /><br /><br /> 
        <center>
            <div class="panel panel-success" style="width:800px; border-top-left-radius: 20px; border-top-right-radius: 20px">
                <div class="panel-heading" style="border-top-left-radius: 18px; border-top-right-radius: 18px">
                    <h3 class="panel-title">Usługi które można kupić za pomocą płatności sms!</h3>
                </div>
                <div class="panel-body">
                    <div class="bs-example table-responsive">
						<?php
							require(STYLE_DIR . "notifications.php");
						?>  