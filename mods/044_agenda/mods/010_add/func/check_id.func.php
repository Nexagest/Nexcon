<?php
	include_once('valid.func.php');
	include_once('../../../../../func/mysql.inc.php');
	function check_id($id){
		global $mysql;
		$id = $mysql->real_escape_string(strtolower($id));
		if(valida_nif_cif_nie($id) > 0){
			$query = $mysql->query("SELECT * FROM clients WHERE id = '$id'");
			if(!$query->num_rows)
				return true;
		}
	return false;
	}
?>