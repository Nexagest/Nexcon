<!-- NexCon Desarrollo Aisasemi (Jonathan Gómez Naranjo) --> <?php include_once('../../../../func/base.cfg.php');?>
<?php
if(!isset($_REQUEST['c'])){
	header('Location: main.php') ;
}
include_once('../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
include_once('config.php');
$id = $_REQUEST['c'];
$client = $mysql->query("SELECT * FROM clients, clients_info WHERE clients.id = clients_info.client AND clients.id = '$id'");
$data = $client->fetch_assoc();
?>
?>
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
		<link rel='stylesheet' href='css/edit.css'>
		<script src='../../../../js/jquery-1.9.1.min.js'></script>
		<script src='../../../../js/jquery.mobile-1.3.1.min.js'></script>
		<script src='../../../../js/nx.php?mod_lv=2'></script>
		<script src='js/edit.js'></script>
	</head>
	<body>
		<div data-role='page' id='add_client' data-theme='b'>
			<div data-role='header' data-position='fixed' data-theme='b'>
				<h1>NexCon</h1>
				<a href='#' onclick='nx.goPage("main.php")' data-icon='back' class='back_button2 ui-btn-right' data-theme='b' data-rel='external'>Volver</a>
			</div>
			<div data-role='content'>
				<div data-role='fieldcontain'>
					<label for='name'>Nombre:</label>
					<input type='text' name='name' id='name' value='<?php echo $data['name']?>' data-clear-btn='true' placeholder=''/>
				</div>
				<div data-role='fieldcontain'>
					<label for='id'>NIF/CIF:</label>
					<input type='text' name='id' id='id' disabled value='<?php echo $id?>' data-clear-btn='true' placeholder=''/>
				</div>
				<div data-role='fieldcontain'>
					<label for='address'>Dirección:</label>
					<input type='text' name='address' id='address' value='<?php echo $data['address']?>' data-clear-btn='true' placeholder=''/>
				</div>
				<div data-role='fieldcontain'>
					<label for='cp'>Código Postal:</label>
					<input type='text' name='cp' id='cp' value='<?php echo $data['cp']?>' data-clear-btn='true' placeholder=''/>
				</div>
				<div data-role='fieldcontain'>
					<label for='phone'>Teléfono:</label>
					<input type='tel' name='phone' id='phone' value='<?php echo $data['phones']?>' data-clear-btn='true' placeholder=''/>
				</div>
				<div data-role='fieldcontain'>
					<label for='email'>Email:</label>
					<input type='email' name='email' id='email' value='<?php echo $data['email']?>' data-clear-btn='true' placeholder=''/>
				</div>
				<div data-role='fieldcontain'>
					<label for='web'>Web:</label>
					<input type='url' name='web' id='web' value='<?php echo $data['web']?>' data-clear-btn='true' placeholder=''/>
				</div>
				<?php
					$checked = '';
					if($data['type'])
						$checked = 'checked';
				?>
				<div data-role='fieldcontain'>
					<label for='vip'>VIP</label>
					<input type='checkbox' name='vip' id='vip' data-clear-btn='true' placeholder='' <?php echo $checked?>/>
				</div>
				<!--
				<div data-role='fieldcontain'>
					<label for='logo'>Logo:</label>
					<input type='file' name='logo' id='logo' value='' data-clear-btn='true' placeholder=''/>
				</div>
				-->
				<input type='button' value='Guardar' data-theme='b'/>
			</div>
			<div data-role='footer' data-position='fixed' data-theme='b'>
				<h4><?php echo $config['base']['foot'] ;?></h4>
			</div>
		</div>
	</body>
</html>