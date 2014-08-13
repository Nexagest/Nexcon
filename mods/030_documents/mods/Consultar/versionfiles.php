<?php
error_reporting(0);
if(!isset($_REQUEST['c']))
	header('location: index.php');
$cid = $_REQUEST['c'];
$file = $_REQUEST['f'];
include_once('../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('session_info.inc.php'));
include_once(lib('mysql.inc.php'));
include_once(lib('base.cfg.php'));
$ftp = ftp_connect($config['ftp']['host']);
$dir = $config['ftp']['dir'] . '/' . $file;
$dir = str_replace('//', '/', $dir);
if(!ftp_login($ftp, $config['ftp']['user'], $config['ftp']['pass'])) die ();
$fileversions = ftp_nlist($ftp, $dir);
//die($file);
$file_params = explode('[nx]', $file);
$file_params[0] = explode('/', $file_params)[0];
$ext = array_pop($file_params);
$file_name = implode('[nx]', $file_params);
$file_name = $cid . $file_name . '.' . $ext;
?>
<!-- NexCon Desarrollo Aisasemi (Jonathan Gómez Naranjo) --> <?php include_once('../../../../func/base.cfg.php');?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<title>NexCon</title>
		<link rel='shortcut icon' href='demos/_assets/favicon.ico'>
		<link rel='stylesheet'  href='../../../../css/jquery.mobile.structure-1.3.1.min.css'>
		<link rel='stylesheet'  href='../../../../css/jquery.mobile.theme-1.3.1.min.css'>
		<link rel='stylesheet'  href='../../../../css/nx.css'>		
		<link rel='stylesheet' href='css/main.css'>
		<script src='../../../../js/jquery-1.9.1.min.js'></script>
		<script src='../../../../js/jquery.mobile-1.3.1.min.js'></script>
		<script src='../../../../js/nx.php?mod_lv=2'></script>
		<script src='js/main.js'></script>
	</head>
	<body>
		<div data-role='page' id='documentsversion' data-theme='b'>
			<div data-role='header' data-position='fixed' data-theme='b'>
				<h1>NexCon</h1>
				<a href='files.php?c=<?php echo $cid;?>' data-icon='back' class='back_button ui-btn-right' data-theme='b' data-rel='external'>Volver</a>
			</div>
			<div data-role='content'>
				<ul data-role='listview' id='clients_list'>
					<li data-role="list-divider" data-theme="a">Clientes / <?php echo $cid . ' / ' . $file_name;?></li>
				<?php
				foreach($fileversions as $version){
					$fversion = explode('.',array_pop(explode('/', $version)))[0];
					try{
						$tversion = ftp_mdtm($ftp, $version);
					}catch(Exception $e){
						$tversion = '';
					}
					if($tversion)
						$tversion = '<font color="#ccc">ultima modificacion: ' . date("Y m d H:i:s", $tversion) . '</font>';
					echo '<li><a href="download.php?fv='.$version.'" rel="external">' . $fversion . ' ' . $tversion . '</a><a href="#" onClick="fileoptions(\''.$version.'\');" data-rel="popup" data-icon="info" style="top:-1px;" data-theme="a"></a></li>';
				}
				?>
				<div data-role="popup" data-corners="false" data-history="false" data-theme="a" data-overlay-theme="a" data-position-to="window" id="moreinfo" style="text-align: center;">
					<h1>¿Qué desea hacer con esta versión?<h1>
					<div data-role="controlgroup" data-theme="b">
						<a href="#" data-role="button" id='downloadthis'>Descargar esta versión</a>
						<a href="#" data-role="button" id='setlast'>Convertir en la última versión</a>
						<a href="#" data-role="button" id='delothers'>Borrar todas las demás versiones</a>
						<a href="#" data-role="button" id='delthis'>Borrar versión</a>
						<a href="#" data-role="button" id='close'>Salir</a>
					</div>
				</div>
				</ul>
			</div>
			<div data-role='footer' data-position='fixed' data-theme='b'>
				<h4><?php echo $config['base']['foot'] ;?></h4>
			</div>
		</div>
	</body>
</html>