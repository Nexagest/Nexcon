<?php
	include_once('valid.func.php');
	$email = $_POST['email'];
	if(comprobar_email($email) > 0){
		die(true);
	}
?>