<?php
error_reporting(0);
include_once('../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('session_info.inc.php'));
include_once(lib('mysql.inc.php'));
$uid = $session_info['id'];
$query = $mysql->query("SELECT client FROM clients_users WHERE user = $uid");
$cid = $query->fetch_assoc()['client'];
$client = $mysql->query("SELECT * FROM clients WHERE id = '$cid'");
$client = $client->fetch_assoc()['name'];
$notifications = $mysql->query("SELECT * FROM notifications WHERE client='$cid'");

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
				<a href='#' onclick='nx.goPage("../../")' data-icon='back' class='back_button ui-btn-right' data-theme='b' data-rel='external'>Volver</a>
			</div>
			<div data-role='content'>
				<ul data-role='listview' id='clients_list'>
					<li data-role="list-divider" data-theme="a">Notificaciones</li>
					<?php
if($notifications->num_rows)
	while($notification = $notifications->fetch_assoc()){
		$sended = false;
		$cheked = '';
		$theme = 'e';
		$noty_id = $notification['id'];
		$noty_add = strtotime($notification['added']);
		$noty_send = strtotime($notification['sended']);
		$noty_chek = strtotime($notification['cheked']);
		if($noty_add <= $noty_send){
			$sended = true;
			$noty_send = date('Y-m-d H:i:s', $noty_send);
		}else
			$noty_send = 'No enviado!';
		if($noty_add <= $noty_chek){
			$cheked = 'showed';
			$theme = 'b';
			$noty_chek = date('Y-m-d H:i:s', $noty_chek);
		}else
			$noty_chek = 'No visto!';
		$type = $notification['type'];
		$noty_text = $notification['text'];
		if($type > 0){
			$noty_type = $mysql->query("SELECT * FROM notification_type WHERE id = $type");
			$noty_type = $noty_type->fetch_assoc()['name'];
		}else{
			$noty_type = 'Mensaje';
		}
		$doc = '<a href="' . $notification['link'] . '">'; 
		$noty_text = str_replace('$DOC$', $doc, $noty_text);
		$noty_text = str_replace('$/DOC$', '</a>', $noty_text);
		$noty_text = str_replace('$CID$', $cid, $noty_text);
		$noty_text = str_replace('$CNA$', $client, $noty_text);
		$created = $notification['added'];
		echo "<li>
				<div data-role='collapsible' id='$noty_id' data-collapsed='true' class='headMsg $cheked' data-theme='$theme' data-content-theme='d'>
					<h3><div style='float:left;'>$noty_type</div><div style='float:right;'>Creado: $created</div></h3>
					<ul>
						<li style='margin-top:10px;'> Texto:</br>
							$noty_text
						</li>
						<li style='margin-top:10px;' class='dateSended'> Enviado al correo: $noty_send</li>
						<li style='margin-top:10px;' class='dateShowed'> Visto en la plataforma: $noty_chek</li>
					</ul>
				</div>
			</li>";
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