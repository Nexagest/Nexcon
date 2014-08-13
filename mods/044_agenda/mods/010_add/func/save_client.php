<?php
	include_once('../../../../../func/base.inc.php');
	include_once('../../../../../func/session/is_logged.inc.php');
	include_once('../../../../../func/session_info.inc.php');
	include_once('valid.func.php');
	include_once('check_id.func.php');
	include_once('../config.php');
	if(is_logged())
		if(in_array($session_info['type'], $config['mod']['access']))
			if(count($_POST) == 6)
				if($_POST['name'] && $_POST['user'] && $_POST['pass']){
					$name = $mysql->real_escape_string($_POST['name']);
					$surname = $mysql->real_escape_string('');
					$user = $mysql->real_escape_string($_POST['user']);
					$pass = $mysql->real_escape_string($_POST['pass']);
					$pass = md5($pass);
					$type = $mysql->real_escape_string($_POST['type']);
					$email = $mysql->real_escape_string($_POST['email']);
					$img = $mysql->real_escape_string('');
					$client = $mysql->real_escape_string($_POST['client']);
					$mysql->query("INSERT INTO users (user, pass, type) VALUE (
						'".$user."',
						'".$pass."',
						".$type."
					)") or die(false);
					$id = $mysql->insert_id;
					$mysql->query("INSERT INTO users_info VALUE(
						'".$id."',
						'".$name."',
						'".$surname."',
						'".$email."',
						'".$img."'
					)") or die(false);
					if($client){
						$mysql->query("INSERT INTO clients_users VALUE ('$client' ,'$id')");
					}
					die(true);
				}
?>