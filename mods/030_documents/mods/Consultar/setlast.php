<?php
error_reporting(0);
if(!isset($_REQUEST['fv']))
	header('location: index.php');
include_once('../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('session_info.inc.php'));
include_once(lib('mysql.inc.php'));
include_once(lib('base.cfg.php'));
$ftp = ftp_connect($config['ftp']['host']);
if(!ftp_login($ftp, $config['ftp']['user'], $config['ftp']['pass'])) die ();
$file = $_REQUEST['fv'];
$file_src = explode('/', $file);
array_pop($file_src);
$filedir = $file_src[count($file_src) - 1];
$cid = $file_src[count($file_src) - 2];
$filepath = implode('/', $file_src);
$files = ftp_nlist($ftp, $filepath);
$last_file = array_pop(ftp_nlist($ftp, $filepath));
$ext = array_pop(explode('.', $last_file));
$count = 0;
foreach($files as $cfile){
	if($file == $cfile){
		$new_file = str_replace('//', '/', $filepath . '/tmp');
		ftp_rename($ftp, $cfile, $new_file);
	}else{
		$new_file = str_replace('//', '/', $filepath . '/' . str_pad($count, 4, "0", STR_PAD_LEFT) . '.' . $ext);
		ftp_rename($ftp, $cfile, $new_file);
		$count++;
	}
}
$new_file = str_replace('//', '/', $filepath . '/' .  str_pad($count, 4, "0", STR_PAD_LEFT) . '.' . $ext);
ftp_rename($ftp, $filepath . '/tmp', $new_file);
header("location: versionfiles.php?c=$cid&f=$cid/$filedir");
?>