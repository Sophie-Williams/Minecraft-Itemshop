<?php
/**
 * Powiadomienia
 */
function notifications($text, $func) {
	$_SESSION['msg1'] = $text;
	$_SESSION['msg-type'] = $func;
}
?>