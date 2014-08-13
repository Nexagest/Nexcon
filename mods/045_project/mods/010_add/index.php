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
		<div data-role='page' id='add_client' data-theme='b'>
			<div data-role='header' data-position='fixed' data-theme='b'>
				<h1>NexCon</h1>
				<a href='../../' data-icon='back' class='back_button ui-btn-right' data-theme='b' data-rel='external'>Volver</a>
			</div>
			<div data-role='content'>
				<div data-role='fieldcontain'>
					<label for='name'>Usuario:</label>
					<input type='text' name='user' id='user' value='' data-clear-btn='true' placeholder=''/>
				</div>
				<div data-role='fieldcontain'>
					<label for='name'>Contraseña:</label>
					<input type='password' name='pass' id='pass' value='' data-clear-btn='true' placeholder=''/>
				</div>
				<div data-role='fieldcontain'>
					<label for='name'>Nombre:</label>
					<input type='text' name='name' id='name' value='' data-clear-btn='true' placeholder=''/>
				</div>
				<div data-role='fieldcontain'>
					<label for='email'>Email:</label>
					<input type='email' name='email' id='email' value='' data-clear-btn='true' placeholder=''/>
				</div>
				<div data-role="fieldcontain">
					<label for="type">Tipo de usuario:</label>
					<select name="type" id='type' name='type'>
						<option value="4">Empleado de Cliente</option>
						<option value="3">Cliente</option>
						<option value="2">Empleado</option>
						<option value="1">Administrador</option>
					</select>
				</div>
				<div data-role='fieldcontain'>
					<label for='client'>Cliente:</label>
					<input type='text' name='client' id='client' value='' data-clear-btn='true' placeholder=''/>
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