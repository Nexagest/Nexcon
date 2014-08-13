<?php
error_reporting(0);
include_once('../../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
include_once('config.php');
if(is_logged()){
	if(isset($_POST['n'])){
		$name = $mysql->real_escape_string($_POST['n']);
		$mysql->query("INSERT INTO form (name) VALUES ('$name')");
		die(''.$mysql->insert_id);
	}
	die('0');
}else
	die('0');
?>