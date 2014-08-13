<?php
	include_once('../../../../../func/base.inc.php');
	include_once('../../../../../func/session/is_logged.inc.php');
	include_once('../../../../../func/session_info.inc.php');
	include_once('valid.func.php');
	include_once('check_id.func.php');
	include_once('../config.php');
	if(is_logged())
		if(in_array($session_info['type'], $config['mod']['access']))
			if(count($_POST) == 7)
				if($_POST['name'] && $_POST['id'] && comprobar_email($_POST['email'])){
					$id = $mysql->real_escape_string($_POST['id']);
					$name = $mysql->real_escape_string($_POST['name']);
					$email = $mysql->real_escape_string($_POST['email']);
					$client = $mysql->real_escape_string($_POST['client']);
					$type = $mysql->real_escape_string($_POST['type']);
					if($_POST['pass'] != ''){
						$pass = md5($mysql->real_escape_string($_POST['pass']));
						$mysql->query("UPDATE users SET
							pass='$pass'
						WHERE id='$id'") or die(false);
					}
					if($_POST['type'] != ''){
						$mysql->query("UPDATE users SET
							type='$type' 
						WHERE id='$id'") or die(false);
					}
					$mysql->query("UPDATE users_info SET
						name='".$name."',
						email='".$email."'
					WHERE user='".$id."'") or die(false);
					if($_POST['client'] != ''){
						$query = $mysql->query("SELECT * FROM clients_users WHERE user = $id");
						if($query->num_rows)
							$mysql->query("UPDATE clients_users SET client='$client' WHERE user = $id");
						else
							$mysql->query("INSERT INTO clients_users VALUES ('$client', $id)");
					}
					die(true);
				}
?>