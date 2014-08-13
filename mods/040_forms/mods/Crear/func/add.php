<?php
error_reporting(0);
include_once('../../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
include_once('config.php');
if(is_logged()){
	if(isset($_POST['t']) && isset($_POST['n']) && isset($_POST['f'])){
		$form = $mysql->real_escape_string($_POST['f']);
		$name = $mysql->real_escape_string($_POST['n']);
		$type = $mysql->real_escape_string($_POST['t']);
		$mysql->query("INSERT INTO form_elements (name, type, form) VALUES ('$name', $type, $form)");
		if($type == 5){
			$id = $form . 'n' . $mysql->insert_id . 'xform';
			$query = $mysql->query("SELECT * FROM documents_type WHERE id='$id'");
			if($query->num_rows == 0){
				$mysql->query("INSERT INTO documents_type VALUES ('$id', '$name')");
			}else{
				$mysql->query("UPDATE documents_type SET name='$name' WHERE id = '$id'");
			}
		}
		die($mysql->error);
	}
	die('0');
}else
	die('0');
?>