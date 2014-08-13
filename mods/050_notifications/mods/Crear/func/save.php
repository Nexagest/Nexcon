<?php
error_reporting(0);
include_once('../../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
if(!isset($_POST['c']) || !isset($_POST['l']) || !isset($_POST['m']))
	die('ERROR');
$link = $_POST['l'];
$type = 0;
$msg = $_POST['m'];
$clients = $_POST['c'];
$date = date('Y-m-d H:i:s');
$sended = '0000-00-00 00:00:00';
$cheked = '0000-00-00 00:00:00';
if(count($clients) > 1)
	$clients = array_unique($clients);
foreach($clients as $client){
	$mysql->query("INSERT INTO notifications (type, text, link, added, sended, cheked, client) VALUES ($type, '$msg', '$link', '$date', '$sended', '$cheked', '$client')") or die("buu");
}
?>