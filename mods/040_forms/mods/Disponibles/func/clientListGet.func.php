<?php
error_reporting(0);
include_once('../../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
if((!isset($_POST['i']) || !isset($_POST['l'])) && (!isset($_REQUEST['i']) || !isset($_REQUEST['l'])))
	die(false);
	if(isset($_REQUEST['i']) && isset($_REQUEST['l'])){
		$ini = $_REQUEST['i'];
		$num = $_REQUEST['l'];
	}else{
		$ini = $_POST['i'];
		$num = $_POST['l'];
	}
	$query = $mysql->query("
SELECT 
	clients.id,
	clients.name,
	(
		SELECT 
			COUNT(*)
		FROM
			form_requests
		WHERE
			form_requests.client = clients.id
		AND
			form_requests.fuid = form_user.id 
	) as sended
FROM
	form_user,
	clients
WHERE
	form_user.client = clients.id
LIMIT $ini, $num
");
$clients = null;
$clients_nosend = null;
if($query->num_rows)
	while($form = $query->fetch_assoc()){
		$clients[$form['id']][count($clients[$form['id']])] = $form;
		if(!$form['sended'])
			if(!$clients_nosend[$form['id']])
				$clients_nosend[$form['id']] = 1;
			else
				$clients_nosend[$form['id']]++;
	}
foreach($clients as $client){
	if(!$clients_nosend[$client[0]['id']])
		$clients_nosend[$client[0]['id']] = 0;
		$client_info = $client[0];
		array_pop($client_info);
	echo $clients_nosend[$client[0]['id']] . ':' . implode(':', $client_info) . ';';
}
?>