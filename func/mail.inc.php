<?php
require_once("class.phpmailer.php");
include_once("base.cfg.php");
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->CharSet = 'UTF-8';
	$mail->Mailer = 'smtp';
	$mail->SMTPSecure = $config['mail']['secr'];
	$mail->Host = $config['mail']['host'];
	$mail->Port = $config['mail']['port'];
	$mail->SMTPAuth = $config['mail']['auth'];
	$mail->Username = $config['mail']['user']; // SMTP username
	$mail->Password = $config['mail']['pass']; // SMTP password 
function SendMail($email, $subjet, $msg){
	global $mail, $config;
	$name = $config['mail']['name'];
	$user = $config['mail']['user'];
	$mail->From = $user;
	$mail->FromName = $name;
	$mail->SetFrom($user, $name);
	$mail->AddAddress($email);  
	$mail->IsHTML(true);
	$mail->Subject  = $subjet;
	$mail->Body     = $msg;
	if(!$mail->Send()) {
		$mail->ClearAddresses();
		return false;
	} else {
		$mail->ClearAddresses();
		return true;
	}
}
?>