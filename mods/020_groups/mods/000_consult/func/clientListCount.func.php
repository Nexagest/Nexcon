<?php
include_once('../../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
include_once('../config.php');
if(is_logged()){
	$query = $mysql->query('SELECT * FROM groups');
	echo $query->num_rows;
}else
	header('Location: ../') ;
?>