<?php
	include_once('valid.func.php');
	include_once('../../../../../func/mysql.inc.php');
	function check_id($id){
		global $mysql;
		$id = $mysql->real_escape_string(strtolower($id));
		if(valida_nif_cif_nie($id) > 0){
			return true;
		}
	return false;
	}
?>