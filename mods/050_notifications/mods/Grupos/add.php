<?php
//error_reporting(0);
include_once('../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
include_once('config.php');
if(is_logged()){
	if(isset($_REQUEST['t']) && isset($_REQUEST['n'])){
		$id = 0;
		if(isset($_REQUEST['i']))
			$id = $_REQUEST['i'];
		$name = $_REQUEST['n'];
		$text = $_REQUEST['t'];
		//die("$id $name $text");
		if(!$id){
			$mysql->query("INSERT INTO notification_type (name, text) VALUES ('$name', '$text')");
		}else{
			$mysql->query("UPDATE notification_type SET name='$name', text='$text' WHERE id = '$id'");
		}
		header('Location: index.php') ;
	}
	header('Location: index.php') ;
}else
	header('Location: index.php') ;
?>