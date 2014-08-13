<?php
error_reporting(0);
include_once('../../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
if(!isset($_POST['i']))
	die(false);
$id = $_POST['i'];
//die($id);
$date = date('Y-m-d H:i:s');
$query = $mysql->query("UPDATE notifications SET cheked='$date' WHERE id = $id") or die(false);
die('OK');
?>