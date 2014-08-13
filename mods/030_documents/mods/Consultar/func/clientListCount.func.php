<?php
error_reporting(0);
include_once('../../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('base.cfg.php'));
$ftp = ftp_connect($config['ftp']['host']);
$dir = $config['ftp']['dir'];
if(!ftp_login($ftp, $config['ftp']['user'], $config['ftp']['pass'])) die ();
$ftp_clients = ftp_nlist($ftp, $dir);
print(count($ftp_clients));
?>