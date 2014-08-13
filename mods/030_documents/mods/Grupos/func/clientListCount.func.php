<?php
error_reporting(0);
include_once('../../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
include_once('../config.php');
if(is_logged()){
	$query = $mysql->query('SELECT * FROM documents_type');
	echo $query->num_rows;
}else
	header('Location: ../') ;
?>