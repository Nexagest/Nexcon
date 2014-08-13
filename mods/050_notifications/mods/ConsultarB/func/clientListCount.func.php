<?php
error_reporting(0);
include_once('../../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
$query = $mysql->query("SELECT * FROM notifications");
echo $query->num_rows;
?>