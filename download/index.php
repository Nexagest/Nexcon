<?php
include_once('../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('session_info.inc.php'));
include_once(lib('mysql.inc.php'));
include_once(lib('base.cfg.php'));
if(!is_logged())
	header('Location: ../') ;
$host = 'localhost';
$user = 'prueba';
$pass = 'prueba';
$ftp = ftp_connect($host);
$path = 'tmp';
$uid = $session_info['id'];
if(isset($_REQUEST['doc']))
	$document = $_REQUEST['doc'];
else
	die('El documento no existe!');
$query = $mysql->query("SELECT path FROM documents_path WHERE id=$document");
if(!$query->num_rows)
	die('El documento no existe!');
if(!ftp_login($ftp, $user, $pass))
	return 'Error al conectar con el servidor FTP!.';
$file = str_replace('//','/',$config['ftp']['dir'] . '/' . $query->fetch_assoc()['path']);
$ftp_files = ftp_nlist($ftp, $file);
$filepath = array_pop($ftp_files);


function SeedFile($path){
	$Seeded = false;
	while(!$Seeded){
		$rnd = rand(0, 512);
		$now = date('U');
		$baseSeed = (($rnd . $now) - $rnd) * $rnd;
		$md5seed = md5($baseSeed);
		$miniSeed = substr($md5seed, 0, 32);
		$tmppath = $path . '/' . $miniSeed;
		$tmppath = str_replace('//', '/', $tmppath);
		$testPath = getcwd() . $tmppath;
		if(!file_exists($testPath))
			$Seeded = true;
	}
	return $tmppath;
}

function ReservedTmp($path){
	$SeedFile = SeedFile($path);
	exec("echo RESERVED TMP >> $SeedFile");
	return $SeedFile;
}
$tmp = ReservedTmp($path);
$file = explode('/', $filepath);
$file_name = array_pop($file);
$file_params = array_pop($file);
$id = array_pop($file);
$file_params = explode('[nx]', $file_params);
$ext = array_pop($file_params);
$file_name = implode('[nx]', $file_params);
$file = $id . substr($file_name, 2, strlen($file_name)) . '.' . $ext;
$date = date('Y-m-d H:i:s');
if (ftp_get($ftp, $tmp, $filepath, FTP_BINARY)) {
	$mysql->query("INSERT INTO documents VALUES($document, '$date', $uid, 0, 0)") or die("Ha ocurrido un error vuelva a intentarlo mas tarde por favor.");
} else {
   // echo "Ha habido un problema\n";
}
header("Content-disposition: attachment; filename=$file");
header("Content-type: application/octet-stream");
readfile($tmp);
unlink($tmp);
?>