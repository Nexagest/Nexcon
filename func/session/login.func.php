<?php
	include_once('../base.inc.php');
	include_once(lib('mysql.inc.php'));
	include_once(lib('session.inc.php'));
	if(isset($_POST['user']) && isset($_POST['pass'])){
		$user = $mysql->real_escape_string($_POST['user']);
		$pass = $mysql->real_escape_string($_POST['pass']);
		$login = $mysql->query("SELECT * FROM users WHERE user = '$user' AND pass = MD5('$pass')");
		if($login->num_rows){
			$login = $login->fetch_assoc();
			if($login['user'] == $user && $login['pass'] == md5($pass)){
				$_SESSION[$session_name]['id'] = $login['id'];
				$_SESSION[$session_name]['user'] = $login['user'];
				$_SESSION[$session_name]['pass'] = $login['pass'];
				$_SESSION[$session_name]['type'] = $login['type'];
				echo true;
			}
		}
	}
?>