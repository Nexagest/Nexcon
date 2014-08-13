<?php
error_reporting(0);
include_once('../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
include_once('config.php');
if(is_logged()){
	if(isset($_REQUEST['i'])){
		$id = $mysql->real_escape_string($_REQUEST['i']);
		$mysql->query("DELETE FROM documents_type WHERE id = '$id'");
		header('Location: index.php') ;
	}
}else
	header('Location: ../') ;
?>