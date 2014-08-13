<?php
error_reporting(0);
include_once('../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('session_info.inc.php'));
include_once(lib('mysql.inc.php'));
if(!isset($_REQUEST['c']))
	header('location: index.php');
$cid = $_REQUEST['c'];
$client = $mysql->query("SELECT * FROM clients WHERE id = '$cid'");
$client = $client->fetch_assoc()['name'];


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
<?php

$forms = $mysql->query("
SELECT DISTINCT
	form_user.id,
	form.name AS form_name,
	form.id AS form_id,
	form_user.limit_date,
	form_elements.name AS element_name,
	form_elements.type,
	form_requests.data
FROM
	form_user,
	form_requests,
	form_elements,
	form
WHERE
	form_user.client='$cid'
AND
	form.id = form_user.form
AND
	form_elements.form = form.id
AND
	form_requests.element = form_elements.id
");

$forms_no = $mysql->query("
SELECT DISTINCT
	form_user.id,
	form.name AS form_name,
	form.id AS form_id,
	form_user.limit_date,
	form_elements.name AS element_name,
	form_elements.type,
	form_elements.id AS element_id
FROM
	form_user,
	form_requests,
	form_elements,
	form
WHERE
	form_user.client='$cid'
AND
	form.id = form_user.form
AND
	form_elements.form = form.id
AND NOT
	(
		SELECT 
			COUNT(*)
		FROM
			form_requests
		WHERE
			form_requests.fuid = form_user.id 
	)
");
if($forms_no->num_rows){
	while($form = $forms_no->fetch_assoc()){
		$forms_no_array[$form['id']][count($forms_no_array[$form['id']])] = $form;
	}
	echo "<li data-role='list-divider' data-theme='a'>Clientes / $cid :: Sin entregar</li>";
	foreach($forms_no_array as $form){
		$form_id = $form[0]['form_id'];
		$form_name = $form[0]['form_name'];
		$form_limit = $form[0]['limit_date'];
		echo "<li>
				<div data-role='collapsible' data-collapsed='true' data-theme='b' data-content-theme='d'>
					<h3><div style='float:left;'>$form_name</div><div style='float:right;'>Fecha limite: $form_limit</div></h3>
					<ul>";
		$file = glob("../../template/fid_$form_id.*");
		if(count($file)>0){
			$file = str_replace('../../', '', $file[0]);
			echo "<li style='margin-top:10px;'><a rel='external' href='../../download.php?f=$file'>Fichero Adjunto!</a></li>";
		}
		foreach($form as $element){
			$element_type = $element['type'];
			$element_name = $element['element_name'];
			echo "<li style='margin-top:10px;'> $element_name:</li>";
		}
		echo "
					</ul>
				</div>
			</li>";
	}
}
$down_url = str_replace('//', '/', $_SERVER["SERVER_NAME"] . '/' . $config['base']['bdir'] . '/download?doc=');
if($forms->num_rows){
	while($form = $forms->fetch_assoc()){
		$forms_array[$form['id']][count($forms_array[$form['id']])] = $form;
	}
	echo "<li data-role='list-divider' data-theme='a'>Clientes / $cid :: Entregados</li>";
	foreach($forms_array as $form){
		$form_id = $form[0]['form_id'];
		$form_name = $form[0]['form_name'];
		$form_limit = $form[0]['limit_date'];
		echo "<li>
				<div data-role='collapsible' data-collapsed='true' data-theme='b' data-content-theme='d'>
					<h3><div style='float:left;'>$form_name</div><div style='float:right;'>Fecha limite: $form_limit</div></h3>
					<ul>";
		$file = glob("../../template/fid_$form_id.*");
		if(count($file)>0){
			$file = str_replace('../../', '', $file[0]);
			echo "<li style='margin-top:10px;'><a rel='external' href='../../download.php?f=$file'>Fichero Adjunto!</a></li>";
		}
		foreach($form as $element){
			$element_type = $element['type'];
			$element_name = $element['element_name'];
			$element_data = $element['data'];
			if($element_type == 5)
				echo "<li style='margin-top:10px;'><a rel='external' href='http://$down_url$element_data'>Fichero subido</a></li>";
			else
				echo "<li style='margin-top:10px;'> $element_name:</br>$element_data</li>";
		}
		echo "
					</ul>
				</div>
			</li>";
	}
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