<?php
include_once(lib('session.inc.php'));
function is_logged(){
	global $session_name;
	if(isset($_SESSION[$session_name]))
		return true;
	else
		return false;
}
?>