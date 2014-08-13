<?php
error_reporting(0);
include_once('../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('session_info.inc.php'));
include_once(lib('base.cfg.php'));
include_once(lib('mysql.inc.php'));
if(!is_logged())
	header('Location: ../');
$uid = $session_info['id'];
$query = $mysql->query("SELECT client FROM clients_users WHERE user = $uid");
$cid = $query->fetch_assoc()['client'];
$fui = null;
$ftp = ftp_connect($config['ftp']['host']);
$debug = false;
if(!ftp_login($ftp, $config['ftp']['user'], $config['ftp']['pass']))
	return 'Error al conectar con el servidor FTP!.';
if(ftp_mkdir($ftp, $config['ftp']['dir']) && $debug)
	echo "Directorio " . $config['ftp']['dir'] . " creado.";
$no_client = array();
function MainFileName($ftp, $dir, $cid, $fui, $element, $file){
	global $debug;
	if(ftp_mkdir($ftp, $dir) && $debug)
		echo "Directorio $dir creado.";
	$ftpfiles = ftp_nlist($ftp, $dir);
	$filename = basename($file);
	$ext = explode('.', $filename);
	$ext = $ext[count($ext)-1];
	$count = 0;
	$type = $fui . 'n' . $element . 'xform';
	$date = date('Y-m-d_H-i-s');
	$mainfilename = '[nx]' . $type . '[nx]' . $date . '[nx]' . $ext;
	if(in_array($dir . '00' . $mainfilename, $ftpfiles))
		return '00' . $mainfilename;
	else if(in_array($dir . '01' . $mainfilename, $ftpfiles)){
		return '01' . $mainfilename;
	}else if(in_array($dir . '02' . $mainfilename, $ftpfiles)){
		return '02' . $mainfilename;
	}else{
		if(ftp_mkdir($ftp, $dir . '/00' . $mainfilename)){
			if($debug)
				echo "Nuevo fichero creado.";
			$newfile = $dir . '/00' . $mainfilename;
			$newfile = str_replace('//','/',$newfile);
		}
		return '00' . $mainfilename;
	}
}
function VersionLogSQL($mysql, $data, $ver, $debug, $uid, $cid){
	$path = $data;
	$query = $mysql->query("SELECT id FROM documents_path WHERE path = '$path'");
	$document = $query->fetch_assoc()['id'];
	$date = date('Y-m-d H:i:s');
	if(!$mysql->query("INSERT INTO documents VALUES($document, '$date', $uid, 1, $ver)"))
		if($debug)
			echo $mysql->error;
	else
		if($debug)
			echo 'Fichero ' . $data . ' subido en su revision ' . $ver . ' del cliente ' . $cid . '.<br>';
}
function FileLogSQL($mysql, $cid, $data, $debug){
	global $no_client;
	if($debug)
		echo 'Fichero ' . $data . ' creado.<br>';
	if(!$mysql->query("INSERT INTO documents_path (path, client) VALUE ('$data', '$cid')")){
		if(!in_array($cid, $no_client))
			array_push($no_client, $cid);
		if($debug)
			echo $mysql->error;
		return false;
	}else{
		return  $mysql->insert_id;
	}
}
function insertFile($fui, $element, $name, $tmp_name){
	global $mysql;
	global $ftp;
	global $cid;
	global $uid;
	global $config;
	global $debug;
	$dir = $config['ftp']['dir'];
	$dir = $dir . '/' . $cid;
	$dir = str_replace('//','/',$dir);
	$newFileName = MainFileName($ftp, $dir, $cid, $fui, $element, $name);
	$logData = $cid . '/' . $newFileName;
	$logData = str_replace('//','/',$logData);
	$file_id = FileLogSQL($mysql, $cid, $logData, $debug);
	$dir .= '/' . $newFileName;
	$dir = str_replace('//','/',$dir);
	$params = explode('[nx]', $newFileName);
	$ext = $params[count($params)-1];
	$ftpfiles = ftp_nlist($ftp, $dir);
	$count = 0;
	while(in_array($dir . str_pad($count, 4, "0", STR_PAD_LEFT) . '.' . $ext, $ftpfiles))
		$count++;
	$fullFileName = $dir . '/' . str_pad($count, 4, "0", STR_PAD_LEFT) . '.' . $ext;
	$fullFileName = str_replace('//','/',$fullFileName);
	ftp_put($ftp, $fullFileName, $tmp_name, FTP_BINARY);
	VersionLogSQL($mysql, $logData, $count, $debug, $uid, $cid);
	insertPost($fui, $element, $file_id);
}
function insertPost($fui, $element, $data){
	global $mysql;
	$mysql->query("INSERT INTO form_requests (fuid, element, data) VALUES ($fui, $element, '$data')");
}
if(isset($_POST)){
	if(isset($_POST['form_id']))
		$fui = $mysql->real_escape_string($_POST['form_id']);
		unset($_POST['form_id']);
		$query = $mysql->query("SELECT client FROM form_user WHERE id = $fui");
		if($query->fetch_assoc()['client'] != $cid)
			die('BUU!');
	if(count($_POST))
		foreach($_POST as $key => $data)
			insertPost($fui, $key, $mysql->real_escape_string($data));
}
if($fui)
	if(isset($_FILES))
		if(count($_FILES))
			foreach($_FILES as $key => $data)
				insertFile($fui, $key, $mysql->real_escape_string($data['name']), $mysql->real_escape_string($data['tmp_name']));

header('Location: index.php');
?>