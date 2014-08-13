<?php
error_reporting(0);
ini_set('max_execution_time', 300);
include_once('../../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('session_info.inc.php'));
include_once(lib('mysql.inc.php'));
include_once(lib('base.cfg.php'));
include_once(lib('addFileNoty.inc.php'));
if(!is_logged())
	header('Location: ../') ;
$uid = $session_info['id'];
$bad_files = null;
$no_client = array();
function unlinkRecursive($dir, $deleteRootToo) 
{ 
    if(!$dh = @opendir($dir)) 
    { 
        return; 
    } 
    while (false !== ($obj = readdir($dh))) 
    { 
        if($obj == '.' || $obj == '..') 
        { 
            continue; 
        } 

        if (!@unlink($dir . '/' . $obj)) 
        { 
            unlinkRecursive($dir.'/'.$obj, true); 
        } 
    } 

    closedir($dh); 
    
    if ($deleteRootToo) 
    { 
        @rmdir($dir); 
    } 
    
    return; 
}
function Unzip($file, $path){
	$dir = '';
	$zip = new ZipArchive;
	$unzipped = false;
	$zip->open($file);
	if($zip->extractTo($path) === true){
		$unzipped = true;
	}
	$zip->close();
	if($unzipped){
		return true;
	}else{
		return false;
	}
}
function SeedDir($path){
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
function scandir2($path){
	return array_diff(scandir($path), array('..', '.'));
}
function SuperDir($path){
	$files = array();
	foreach(scandir2($path) as $tmp)
		if(is_dir($path . $tmp) && $tmp != '.' && $tmp != '..'){
			$files = array_push_all($files, SuperDir($path . $tmp . '/'));
		}else if($tmp != '.' && $tmp != '..'){
			array_push($files, $path . $tmp);
		}
	return $files;
}
function array_push_all($src,$add){
	foreach($add as $item){
		array_push($src, $item);
	}
	return $src;
}
function CheckUnzip($file, $path){
	$path = getcwd() . SeedDir($path) . '/';
	$path = str_replace("\\","/",$path);
	if(Unzip($file, $path))
		return $files = array_merge((array)$path, SuperDir($path));
	else
		return array();
}
function CheckFiles($UnzippedDir, $struct, $debug){
	global $bad_files;
	$validFiles = array();
	$invalidFiles = array();
	$count = 0;
	foreach($UnzippedDir as $file){
		if($count > 0){
			$filename = basename($file);
			$params = explode('[nx]', $filename);
			if(count($params) == count($struct))
				array_push($validFiles, $file);
			else
				array_push($invalidFiles, $file);
		}
		$count++;
	}
	$bad_files = $invalidFiles;
	if($debug)
		print_r($invalidFiles);
	return $validFiles;
}
function FileUpload($ftp, $file, $dir, $struct, $mysql, $debug){
	$filename = basename($file);
	$count = 0;
	$params = explode('[nx]', $filename);
	$params[count($params)-1] = explode('.', $params[count($params)-1])[0];
	foreach($struct as $param){
		if($param == 'DNI'){
			$id = $params[$count];
			$dir .= $params[$count] . '/';
			if(ftp_mkdir($ftp, $dir) && $debug)
				echo "Directorio $param creado.";
		}
		$count++;
	}
	$mainfilename = MainFileName($ftp, $file, $dir, $struct, $mysql, $debug) . '/';
	$newfilename = FileName($ftp, $file, $dir, $struct, $mysql, $debug);
	ftp_put($ftp, $dir . $mainfilename . $newfilename[0] . '.' . $newfilename[1], $file, FTP_BINARY);
	return array($dir, $id, $mainfilename, $newfilename[0], $newfilename[1]);
}
function VersionLogSQL($mysql, $data, $debug, $uid){
	print_r($data[2]);
	$path = $data[0] . '/' . $data[2];
	$path = str_replace('//', '/', $path);
	$query = $mysql->query("SELECT id FROM documents_path WHERE path = '$path'");
	if($query->num_rows == 0){
		$document = FileLogSQL($mysql, $path, $debug);
	}else
		$document = $query->fetch_assoc()['id'];
	$date = date('Y-m-d H:i:s');
	$client = $data[2];
	$vip = $mysql->query("SELECT type FROM clients WHERE id = '$client'");
	$vip = $vip->fetch_assoc()['type'];
	if(substr($data[2], 0, 2) != '00' || (substr($data[2], 0, 2) != '02' && $vip))
		addAutoNoty($mysql, $data[1], $document, $date);
	$ver = $data[3];
	if(!$mysql->query("INSERT INTO documents VALUES($document, '$date', $uid, 1, $ver)"))
		if($debug)
			echo $mysql->error;
	else{
		if($debug)
			echo 'Fichero ' . $data[2] . ' subido en su revision ' . $data[3] . ' del cliente ' . $data[1] . ' en formato ' . $data[4] . '<br>';

	}
}
function FileLogSQL($mysql, $data, $debug){
	global $no_client;
	$tmp_file = explode('/', $data);
	$cid = array_pop($tmp_file);
	$cid = array_pop($tmp_file);
	$cid = array_pop($tmp_file);
	if($tmp_file[0] != $cid)
		$data = str_replace($tmp_file[0] . '/', '', $data);
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
function UploadFiles($uid, $files, $struct, $host, $user, $pass, $dir, $mysql = null, $debug = null){
		$dir .= '/';
		$dir = str_replace('//', '/', $dir);
		$validFiles = CheckFiles($files, $struct, $debug);
		if(count($validFiles) >= 1){
			$ftp = ftp_connect($host);
			if(!ftp_login($ftp, $user, $pass))
				return 'Error al conectar con el servidor FTP!.';
			if(ftp_mkdir($ftp, $dir) && $debug)
				echo "Directorio $dir creado.";
			foreach($validFiles as $file){
				$uploaded = FileUpload($ftp, $file, $dir, $struct, $mysql, $debug);
				if($mysql){
					array_push($dir, $uploaded);
					VersionLogSQL($mysql, $uploaded, $debug, $uid);
				}
			}
		}
		UnlinkRecursive($files[0], true);
}
function MainFileName($ftp, $file, $dir, $struct, $mysql, $debug){
	$dir = $dir . '/';
	$dir = str_replace('//','/',$dir);
	$ftpfiles = ftp_nlist($ftp, $dir);
	$filename = basename($file);
	$params = explode('[nx]', $filename);
	$ext = explode('.', $params[count($params)-1])[1];
	$params[count($params)-1] = explode('.', $params[count($params)-1])[0];
	$count = 0;
	$type = $params[array_search('TYPE', $struct)];
	$date = $params[array_search('DATE', $struct)];
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
			//FileLogSQL($mysql, $newfile, $debug);
		}
		return '00' . $mainfilename;
	}
	
}
function FileName($ftp, $file, $dir, $struct, $mysql, $debug){
	$mainfilename = MainFileName($ftp, $file, $dir, $struct, $mysql, $debug);
	$params = explode('[nx]', $file);
	$ext = explode('.', $params[count($params)-1])[1];
	$dir = $dir . '/' . $mainfilename;
	$dir = str_replace('//', '/', $dir) . '/';
	$ftpfiles = ftp_nlist($ftp, $dir);
	$count = 0;
	while(in_array($dir . str_pad($count, 4, "0", STR_PAD_LEFT) . '.' . $ext, $ftpfiles))
		$count++;
	return array(str_pad($count, 4, "0", STR_PAD_LEFT), $ext);
	//ftp_put($ftp, $dir . str_pad($count, 4, "0", STR_PAD_LEFT) . $ext, $file, FTP_BINARY);
}
$struct = array('DNI', 'TYPE', 'DATE');
$files = CheckUnzip($_FILES['uploadedfile']['tmp_name'], '/tmp');
UploadFiles($uid, $files, $struct, $config['ftp']['host'], $config['ftp']['user'], $config['ftp']['pass'], $config['ftp']['dir'], $mysql, false);
?>
<!-- NexCon Desarrollo Aisasemi (Jonathan Gómez Naranjo) --> <?php include_once('../../../../func/base.cfg.php');?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<title>NexCon</title>
		<link rel='shortcut icon' href='demos/_assets/favicon.ico'>
		<link rel='stylesheet'  href='../../../../../css/jquery.mobile.structure-1.3.1.min.css'>
		<link rel='stylesheet'  href='../../../../../css/jquery.mobile.theme-1.3.1.min.css'>
		<link rel='stylesheet'  href='../../../../../css/nx.css'>		
		<link rel='stylesheet' href='css/main.css'>
		<script src='../../../../../js/jquery-1.9.1.min.js'></script>
		<script src='../../../../../js/jquery.mobile-1.3.1.min.js'></script>
		<script src='../../../../../js/nx.php?mod_lv=2'></script>
		<script src='js/main.js'></script>
	</head>
	<body>
		<div data-role='page' id='add_client' data-theme='b'>
			<div data-role='header' data-position='fixed' data-theme='b'>
				<h1>NexCon</h1>
				<a href='../../' data-icon='back' class='back_button ui-btn-right' data-theme='b' data-rel='external'>Volver</a>
			</div>
			<?php
			echo "<ul data-role='listview'>
			<li>";
			if($bad_files){
				foreach($bad_files as $bad_file){
					echo $bad_file;
				}
			}else{
				echo "Se ha subido todo correctamente!</br>";
			}
			echo "</li>";
			if($no_client){
				echo "<li data-role='list-divider' data-theme='a'>Se han subido ficheros a los siguientes clientes sin crear:</li>";
				foreach($no_client as $client){
					echo '<li data-theme="c">' . $client . '</li>';
				}
			}
			echo "</ul>";
			?>
			<div data-role='footer' data-position='fixed' data-theme='b'>
				<h4><?php echo $config['base']['foot'] ;?></h4>
			</div>
		</div>
	</body>
</html>