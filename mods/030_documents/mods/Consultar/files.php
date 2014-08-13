<?php
error_reporting(0);
if(!isset($_REQUEST['c']))
	header('location: index.php');
$cid = $_REQUEST['c'];
include_once('../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('session_info.inc.php'));
include_once(lib('mysql.inc.php'));
include_once(lib('base.cfg.php'));
$ftp = ftp_connect($config['ftp']['host']);
$dir = $config['ftp']['dir'] . '/' . $cid;
$dir = str_replace('//', '/', $dir);
$query = $mysql->query("SELECT * FROM clients WHERE id = '$cid'");
if($query->num_rows){
	$client = true;
	$down_url = str_replace('//', '/', $_SERVER["SERVER_NAME"] . '/' . $config['base']['bdir'] . '/download?doc=');
}else{
	$client = false;
	$down_url = 'download.php?doc=';
}
if(!ftp_login($ftp, $config['ftp']['user'], $config['ftp']['pass'])) die ();
$client_files = ftp_nlist($ftp, $dir);
foreach($client_files as $file){
	$file_src = array_pop(explode('/', $file));
	$file_params = explode('[nx]', $file_src);
	if(!isset($file_group[$file_params[1]]))
		$file_group[$file_params[1]] = array();
	array_push($file_group[$file_params[1]], $file_src);
}
ksort($file_group);
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
		<div data-role='page' id='documentsclient' data-theme='b'>
			<div data-role='header' data-position='fixed' data-theme='b'>
				<h1>NexCon</h1>
				<a href='#' onclick='nx.goPage("index.php")' data-icon='back' class='back_button ui-btn-right' data-theme='b' data-rel='external'>Volver</a>
			</div>
			<div data-role='content'>
				<ul data-role='listview' id='clients_list'>
					<li data-role="list-divider" data-theme="a">Clientes / <?php echo $cid;?></li>
					<?php
foreach($file_group as $key => $files){
	$checkgroup = $mysql->query("SELECT name FROM documents_type WHERE id = '$key'");
	if($checkgroup->num_rows == 0)
		$groupname = $key;
	else{
		$groupname = $checkgroup->fetch_assoc()['name'];
	}
	echo '<li><div data-role="collapsible" data-collapsed="true" data-theme="b" data-content-theme="d"><h4>' . $groupname . '</h4><ul data-role="listview">';
	rsort($files);
	foreach($files as $file){
		$file_params = explode('[nx]', $file);
		$ext = array_pop($file_params);
		$file_name = implode('[nx]', $file_params);
		$file_name = $cid . substr($file_name, 2, strlen($file_name)) . '.' . $ext;
		$file_dir = str_replace('//','/',$cid . '/' . $file);
		if($client){
			$query = $mysql->query("SELECT id FROM documents_path WHERE path = '$file_dir'");
			if($query->num_rows){
				$file_url = $down_url . $query->fetch_assoc()['id'];
			}else{
				if($mysql->query("INSERT INTO documents_path (path, client) VALUES ('$file_dir', '$cid')")){
					$file_url = $down_url . $mysql->insert_id;
				}else{
					$file_url = $down_url . $file_dir;
				}
			}
		}else{
			$file_url = $down_url . $file_dir;
		}
		echo "<li><a href='$file_url' rel='external'>$file_name</a>";
		if($session_info['type'] == 1){
			echo '<a href="#"
			onclick="filemode(\''.$file_dir.'\')"
			class="extrabut" rel="external" style="position:absolute;border-left:1px solid #bbb;right:40px;top:-1px;padding-top:1px;width:45px;height:100%">
				 <span class="ui-btn-inner" style="padding:.0em 10px; top:-1;">
					<span class="ui-btn-text"></span>
					<span data-corners="true" data-shadow="true" data-iconshadow="true"
					 data-iconpos="notext"
					data-theme="b" title="" class="ui-btn ui-btn-up-b ui-shadow ui-btn-corner-all
					ui-btn-icon-notext">
						<span class="ui-btn-inner" style="top:1px;"><span class="ui-btn-text"></span>
							<span class="ui-icon ui-icon-gear ui-icon-shadow">&nbsp;</span>
						</span>
					</span>
				</span>
			</a>';
			echo "<a href='versionfiles.php?c=$cid&f=$file_dir' style='top:-1px;' data-icon='info' rel='external'></a>";
		}echo "</li>";
	}
	echo '</ul></div></li>';
}			
					?>
				</ul>
				<div data-role="popup" data-corners="false" data-history="false" data-theme="a" data-overlay-theme="a" data-position-to="window" id="modewin" style="text-align: center;">
					<h4>¿Desea cambiar la configuracion de visualizacion?<h4>
					<fieldset data-role="controlgroup" data-type="horizontal" id='mode-choice'>
							<input type="radio" name="mode-choice" id="invisible" value="00" data-theme='a'/>
							<label for="invisible">Invisible</label>

							<input type="radio" name="mode-choice" id="visible" value="01" data-theme='a'/>
							<label for="visible">Visible</label>

							<input type="radio" name="mode-choice" id="vip" value="02" data-theme='a'/>
							<label for="vip">Solo Vip</label>
					</fieldset>
					<input type='button' id='modSave' value='Guardar'/>
					<input type='button' id='modClose' value='Salir'/>
				</div>
			</div>
			<div data-role='footer' data-position='fixed' data-theme='b'>
				<h4><?php echo $config['base']['foot'] ;?></h4>
			</div>
		</div>
	</body>
</html>