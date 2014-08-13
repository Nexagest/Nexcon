<!-- NexCon Desarrollo Aisasemi (Jonathan Gómez Naranjo) --> <?php include_once('../../../../func/base.cfg.php');?>
<?php
error_reporting(0);
include_once('../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
?>
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
		<div data-role='page' id='documents' data-theme='b'>
			<div data-role='header' data-position='fixed' data-theme='b'>
				<h1>NexCon</h1>
				<a href='../../' data-icon='back' class='back_button ui-btn-right' data-theme='b' data-rel='external'>Volver</a>
			</div>
			<div data-role='content'>
				<textarea data-theme='c' id='newTypeText' style='height:75px' maxlength='255' placeholder="Texto..."></textarea>
				<input type='text' data-theme='c' id='newTypeName' placeholder="Link..."/>
				<label for="clients" class="select">Clientes:</label>
				<select data-divider-theme="a" name="clients" id="clients" multiple="multiple" data-native-menu="false" data-icon="grid" data-iconpos="left" data-filter='true'>
					<option>Selecciona 1 o varios clientes</option>
					<?php
						$groups = $mysql->query("SELECT * FROM groups");
						if($groups->num_rows)
							while($group = $groups->fetch_assoc()){
								$gname = $group['name'];
								$gid = $group['id'];
								$clients = $mysql->query("SELECT clients.id, clients.name FROM clients, clients_groups WHERE clients.id = clients_groups.client AND clients_groups.group = $gid");
								if($clients->num_rows){
									echo"<optgroup label='$gname'>";
									while($client = $clients->fetch_assoc()){
										$cid = $client['id'];
										$cna = $client['name'];
										echo"<option value='$cid'>$cna</option>";
									}
									echo"</optgroup>";
								}
							}
						$clients = $mysql->query("SELECT clients.id, clients.name FROM clients WHERE clients.id NOT IN (SELECT clients_groups.client FROM clients_groups)");
						if($clients->num_rows){
							echo"<optgroup label='Sin Grupo'>";
							while($client = $clients->fetch_assoc()){
								$cid = $client['id'];
								$cna = $client['name'];
								echo"<option value='$cid'>$cna</option>";
							}
							echo"</optgroup>";
						}
					?>
				</select>
				<input type='button' id='addType' value='Añadir' data-theme='b' data-icon="plus" data-iconpos="top"/>	
			</div>
			<div data-role='footer' data-position='fixed' data-theme='b'>
				<h4><?php echo $config['base']['foot'] ;?></h4>
			</div>
		</div>
	</body>
</html>