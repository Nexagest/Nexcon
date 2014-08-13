<?php
include_once('../../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
include_once('../config.php');
if(is_logged()){
	if(isset($_REQUEST['i']) && isset($_REQUEST['l'])){
		$ini = $_REQUEST['i'];
		$num = $_REQUEST['l'];
		$query = $mysql->query("SELECT users.id as id, users.user as user, users.type as type, users_info.name as name, users_info.surname as surname, users_info.email as email, (SELECT client FROM clients_users WHERE user = users.id) as client_id, (SELECT clients.name FROM clients_users, clients WHERE clients_users.client = clients.id AND clients_users.user = users.id) as client_name FROM users, users_info WHERE users.id = users_info.user LIMIT $ini, $num");
		$clients = '';
		while($client = $query->fetch_assoc()){
			// print_r($client);
			foreach($client as $key => $data){
				//if($key != 'user')
					$clients .= $data . ':';
			}
			$clients = substr($clients, 0, -1) . ';';
		}
		echo $clients;
	}
}else
	header('Location: ../') ;
?>