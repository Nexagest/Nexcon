<?php
	include_once('../../../../../func/base.inc.php');
	include_once('../../../../../func/session/is_logged.inc.php');
	include_once('../../../../../func/session_info.inc.php');
	include_once('valid.func.php');
	include_once('check_id.func.php');
	include_once('../config.php');
	if(is_logged())
		if(in_array($session_info['type'], $config['mod']['access']))
			if(count($_POST) == 8)
				if($_POST['vip']=='true')
					$vip = 1;
				else
					$vip = 0;
				if($_POST['name'] && check_id($_POST['id']) && comprobar_email($_POST['email'])){
					$id = $mysql->real_escape_string($_POST['id']);
					$name = $mysql->real_escape_string($_POST['name']);
					$type = $mysql->real_escape_string($vip);
					$phones = $mysql->real_escape_string($_POST['phone']);
					$web = $mysql->real_escape_string($_POST['web']);
					$email = $mysql->real_escape_string($_POST['email']);
					$logo = $mysql->real_escape_string('');
					$address = $mysql->real_escape_string($_POST['address']);
					$cp = $mysql->real_escape_string($_POST['cp']);
					$mysql->query("UPDATE clients SET
						name='".$name."',
						type=".$type."
					WHERE id='".$id."'") or die(false);
					$mysql->query("UPDATE clients_info SET
						phones='".$phones."',
						web='".$web."',
						email='".$email."',
						logo='".$logo."',
						address='".$address."',
						cp='".$cp."'
					WHERE client='".$id."'") or die(false);
					die(true);
				}
?>