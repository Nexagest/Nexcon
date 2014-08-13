<?php
	include_once('../../../../../func/base.inc.php');
	include_once('../../../../../func/session/is_logged.inc.php');
	include_once('../../../../../func/session_info.inc.php');
	include_once('valid.func.php');
	include_once('check_id.func.php');
	include_once('../config.php');
	if(is_logged())
		if(in_array($session_info['type'], $config['mod']['access']))
			if(count($_POST) == 1)
				if($_POST['name']){
					$name = $mysql->real_escape_string($_POST['name']);
					$mysql->query("INSERT INTO groups (name) VALUE (
						'".$name."'
					)") or die(false);
				}
?>