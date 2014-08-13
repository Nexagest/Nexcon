<?php
include_once('../session.inc.php');
unset($_SESSION[$session_name]);
echo true;
?>