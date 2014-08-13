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
$client = $mysql->query("SELECT users.user, users.pass, users.type, users_info.name, users_info.email, (SELECT client FROM clients_users WHERE user = users.id) as client_id FROM users, users_info WHERE users.id = users_info.user AND users.id = '$id'");
$data = $client->fetch_assoc();
$user_type[1] = '';
$user_type[2] = '';
$user_type[3] = '';
$user_type[4] = '';
$user_type[$data['type']] = 'selected';
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
				<a href='#' onclick='nx.goPage("index.php")' data-icon='back' class='back_button ui-btn-right' data-theme='b'>Volver</a>
			</div>
			<input type='hidden' id='id' value='<?php echo $id?>'/>
			<div data-role='content'>
				<div data-role='fieldcontain'>
					<label for='name'>Usuario:</label>
					<input type='text' name='user' id='user' value='<?php echo $data['user']?>' data-clear-btn='true' placeholder='' disabled/>
				</div>
				<div data-role='fieldcontain'>
					<label for='name'>Contraseña:</label>
					<input type='password' name='pass' id='pass' value='' data-clear-btn='true' placeholder=''/>
				</div>
				<div data-role='fieldcontain'>
					<label for='name'>Nombre:</label>
					<input type='text' name='name' id='name' value='<?php echo $data['name']?>' data-clear-btn='true' placeholder=''/>
				</div>
				<div data-role='fieldcontain'>
					<label for='email'>Email:</label>
					<input type='email' name='email' id='email' value='<?php echo $data['email']?>' data-clear-btn='true' placeholder=''/>
				</div>
				<div data-role="fieldcontain">
					<label for="type">Tipo de usuario:</label>
					<select name="type" id='type' name='type'>
						<option value="4" <?php echo $user_type[4]?>>Empleado de Cliente</option>
						<option value="3" <?php echo $user_type[3]?>>Cliente</option>
						<option value="2" <?php echo $user_type[2]?>>Empleado</option>
						<option value="1" <?php echo $user_type[1]?>>Administrador</option>
					</select>
				</div>
				<div data-role='fieldcontain'>
					<label for='client'>Cliente:</label>
					<input type='text' name='client' id='client' value='<?php echo $data['client_id']?>' data-clear-btn='true' placeholder=''/>
				</div>
				<input type='button' value='Guardar' data-theme='b'/>
			</div>
			<div data-role='footer' data-position='fixed' data-theme='b'>
				<h4><?php echo $config['base']['foot'] ;?></h4>
			</div>
		</div>
	</body>
</html>