<?php
include_once('../../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
include_once('../config.php');
if(is_logged()){
	if(isset($_REQUEST['i']) && isset($_REQUEST['l'])){
		$ini = $_REQUEST['i'];
		$num = $_REQUEST['l'];
		$query = $mysql->query("SELECT * FROM groups LIMIT $ini, $num");
		$groups = '';
		while($group = $query->fetch_assoc()){
			$query2 = $mysql->query("SELECT * FROM clients_groups WHERE `group` = " . $group['id']);
			$clients_count = $query2->num_rows;
			$clients = '';
			while($client = $query2->fetch_assoc()){
				$query3 = $mysql->query("SELECT * FROM clients WHERE id = '" . $client['client'] . "'");
				$client_info = $query3->fetch_assoc();
				$clients .= $client_info['name'] . ', ';
			}
			$groups .= $group['id'] . ':' . $group['name'] . ':' . $clients_count . ':' . $clients . ';';
		}
		echo $groups;
	}
}else
	header('Location: ../') ;
?>