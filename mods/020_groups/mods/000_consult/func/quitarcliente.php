<?php
include_once('../../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
include_once('../config.php');
if(is_logged()){
	if(isset($_POST['cliente']) && isset($_POST['grupo'])){
		$cliente = $_POST['cliente'];
		$grupo = $_POST['grupo'];
		$mysql->query("DELETE FROM `clients_groups` WHERE `client` = '$cliente' AND `group` = $grupo") or die(false);
		echo true;
	}
}
?>