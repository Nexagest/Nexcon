<?php
//error_reporting(0);
include_once('../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
print_r($_POST);
if(!isset($_POST['c']))
	die('ERROR CLIENTE');
else if(!isset($_POST['l']))
	die('ERROR FECHA');
else if(!isset($_POST['f']))
	die('ERROR FORM');
$limit = $mysql->real_escape_string($_POST['l']);
$limit = str_replace('T', ' ', $limit) . ':00';
$date = date('Y-m-d H:i:s');
// if($limit <= $date)
	// die('ERROR FECHA');
$forms = $mysql->real_escape_string($_POST['f']);
$clients = $mysql->real_escape_string($_POST['c']);
print_r($clients);
die(count($clients));
if(count($clients) > 1)
	$clients = array_unique($clients);
else
	die('ERROR CLIENTE');
if(count($forms) > 1)
	$forms = array_unique($forms);
else
	die('ERROR FORM');
foreach($clients as $client)
	foreach($forms as $form)
		$mysql->query("INSERT INTO form_user (client, form, limit_date) VALUES ('$client', $form, '$date')") or die("buu");
die();
?>