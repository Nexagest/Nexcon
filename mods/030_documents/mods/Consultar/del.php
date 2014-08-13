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
$all = isset($_REQUEST['o']);
$file = $mysql->real_escape_string($_REQUEST['fv']);
$file_src = explode('/', $file);
array_pop($file_src);
$filedir = $file_src[count($file_src) - 1];
$cid = $file_src[count($file_src) - 2];
$filepath = implode('/', $file_src);
$files = ftp_nlist($ftp, $filepath);
foreach($files as $cfile){
	if($all){
		if($file != $cfile)
			ftp_delete($ftp, $cfile);
	}else{
		if($file == $cfile){
			ftp_delete($ftp, $cfile);
			break;
		}
	}
}
header("location: versionfiles.php?c=$cid&f=$cid/$filedir");
?>