<?php
include_once('base.inc.php');
include_once(lib('session/is_logged.inc.php'));
if(is_logged()){
	$session_info['id'] = $_SESSION[$session_name]['id'];
	$session_info['user'] = $_SESSION[$session_name]['user'];
	$session_info['pass'] = $_SESSION[$session_name]['pass'];
	$session_info['type'] = $_SESSION[$session_name]['type'];
}else{
	$session_info['id'] = null;
	$session_info['user'] = null;
	$session_info['pass'] = null;
	$session_info['type'] = null;
}
?>