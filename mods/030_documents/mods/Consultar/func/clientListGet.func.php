<?php
error_reporting(0);
include_once('../../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
include_once(lib('base.cfg.php'));
$ftp = ftp_connect($config['ftp']['host']);
$dir = $config['ftp']['dir'];
if(!ftp_login($ftp, $config['ftp']['user'], $config['ftp']['pass'])) die ();
$ftp_clients = ftp_nlist($ftp, $dir);
foreach($ftp_clients as $client){
	$client = str_replace($dir, '', $client);
	$query = $mysql->query("SELECT * FROM clients WHERE id = '$client'");
	if($query->num_rows)
		echo $client . ':' . $query->fetch_assoc()['name'] . ';';
	else
		echo $client . ': (Cliente no registrado);';
}
?>