<?php
include_once('base.cfg.php');
function get_name(){
	global $config;
	return $config['base']['name'];
}
function get_foot(){
	global $config;
	return $config['base']['foot'];
}
function lib($lib){
	global $config;
	return $_SERVER['DOCUMENT_ROOT'] . '/' . $config['base']['bdir'] . 'func/' . $lib;
}
?>