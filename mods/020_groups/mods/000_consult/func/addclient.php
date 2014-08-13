<?php
include_once('../../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
include_once('../config.php');
if(is_logged()){
	if(isset($_REQUEST['cliente']) && isset($_REQUEST['grupo'])){
		$cliente = $mysql->real_escape_string($_REQUEST['cliente']);
		$grupo = $mysql->real_escape_string($_REQUEST['grupo']);
		$checks = $mysql->query("SELECT (SELECT COUNT(*) FROM clients WHERE id = '$cliente') AS cliente, (SELECT COUNT(*) FROM groups WHERE id = $grupo) AS grupo");
		$checks = $checks->fetch_assoc();
		if(!$checks['cliente'] || !$checks['grupo'])
			die(false);
		$mysql->query("INSERT INTO `clients_groups` VALUES ('$cliente', $grupo)") or die(false);
		echo true;
	}
}
?>