<?php
/**
 * Powiadomienia
 */
if(isset($_SESSION['msg1']) && isset($_SESSION['msg-type']))
{
?><div class="alert alert-dismissable alert-<?php
	switch($_SESSION['msg-type'])
	{
		case 'warning':
			echo 'warning';
			break;

		case 'danger':
			echo 'danger';
			break;

		case 'success':
			echo 'success';
			break;

		case 'info':
			echo 'info';
			break;
	} echo '">' . $_SESSION['msg1'] . '</div>';
	
	unset($_SESSION['msg1']);
	unset($_SESSION['msg-type']);
}
?>