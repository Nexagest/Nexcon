<?php
include_once('../../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
include_once('../config.php');
if(is_logged()){
	if(isset($_REQUEST['i']) && isset($_REQUEST['l'])){
		$ini = $_REQUEST['i'];
		$num = $_REQUEST['l'];
		$query = $mysql->query("SELECT * FROM clients, clients_info WHERE clients.id = clients_info.client LIMIT $ini, $num");
		$clients = '';
		while($client = $query->fetch_assoc()){
			// print_r($client);
			foreach($client as $key => $data){
				if($key != 'client')
					$clients .= $data . ':';
			}
			$clients = substr($clients, 0, -1) . ';';
		}
		echo $clients;
	}
}else
	header('Location: ../') ;
?>