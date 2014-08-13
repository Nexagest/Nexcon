<?php
error_reporting(0);
include_once('../../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
include_once('../config.php');
if(is_logged()){
	if(isset($_REQUEST['i']) && isset($_REQUEST['l'])){
		$ini = $_REQUEST['i'];
		$num = $_REQUEST['l'];
		$query = $mysql->query("SELECT * FROM notification_type WHERE 1 LIMIT $ini, $num");
		$clients = '';
		while($client = $query->fetch_assoc()){
			foreach($client as $key => $data){
					$clients .= $data . ':';
			}
			$clients = substr($clients, 0, -1) . ';';
		}
		echo $clients;
	}
}else
	header('Location: ../') ;
?>