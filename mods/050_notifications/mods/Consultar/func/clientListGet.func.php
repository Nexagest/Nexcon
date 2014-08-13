<?php
error_reporting(0);
include_once('../../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
if((!isset($_POST['i']) || !isset($_POST['l'])) && (!isset($_REQUEST['i']) || !isset($_REQUEST['l'])))
	die(false);
$query = $mysql->query("SELECT notifications.client, clients.name FROM notifications, clients WHERE clients.id = notifications.client");
if($query->num_rows)
	while($notification = $query->fetch_assoc())
		$clients[$notification['client']][count($clients[$notification['client']])] = $notification;
foreach($clients as $client){
	echo count($client) . ':';
	echo implode(':', $client[0]) . ';';
}
?>