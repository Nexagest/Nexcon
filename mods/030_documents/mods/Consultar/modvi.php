<?php
//error_reporting(0);
if(!isset($_REQUEST['f']) || !isset($_REQUEST['m']))
	header('location: index.php');
include_once('../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('session_info.inc.php'));
include_once(lib('mysql.inc.php'));
include_once(lib('base.cfg.php'));
include_once(lib('addFileNoty.inc.php'));
function FileLogSQL($mysql, $data, $debug){
	global $no_client;
	$tmp_file = explode('/', $data);
	$cid = $tmp_file[0];
	if($tmp_file[0] != $cid)
		$data = str_replace($tmp_file[0] . '/', '', $data);
	if($debug)
		echo 'Fichero ' . $data . ' creado.<br>';
	if(!$mysql->query("INSERT INTO documents_path (path, client) VALUE ('$data', '$cid')")){
		if($debug)
			echo $mysql->error;
		return false;
	}else{
		return  $mysql->insert_id;
	}
}
$ftp = ftp_connect($config['ftp']['host']);
if(!ftp_login($ftp, $config['ftp']['user'], $config['ftp']['pass'])) die ();
$file = $mysql->real_escape_string($_REQUEST['f']);
$mode = $mysql->real_escape_string($_REQUEST['m']);
$cid = explode('/', $file)[0];
$query = $mysql->query("SELECT * FROM clients WHERE id = '$cid'");
if(!$query->num_rows)
	header("location: files.php?c=$cid");
$filename = explode('/', $file)[1];
$fileparams = explode('[nx]', $filename);
$fileparams[0] = str_pad($mode, 2, "0", STR_PAD_LEFT);
$new_filename = implode('[nx]', $fileparams);
//die($file);
$mysql->query("UPDATE documents_path SET path = '$cid/$new_filename' WHERE path = '$file'");
$document = $mysql->query("SELECT id FROM documents_path WHERE path = '$cid/$new_filename'");
$document = $document->fetch_assoc()['id'];
$date = date('Y-m-d H:i:s');
$vip = $mysql->query("SELECT type FROM clients WHERE id = '$cid'");
$vip = $vip->fetch_assoc()['type'];
if($fileparams[0] == '01' || ($fileparams[0] == '02' && $vip))
	addAutoNoty($mysql, $cid, $document, $date);
$filepath = $config['ftp']['dir'] . '/' . $file;
$filepath = str_replace('//','/',$filepath);
$new_filepath = $config['ftp']['dir'] . '/' . $cid . '/' . $new_filename;
$new_filepath = str_replace('//','/',$new_filepath);
ftp_rename($ftp, $filepath, $new_filepath);
header("location: files.php?c=$cid");
?>