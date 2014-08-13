<!-- NexCon Desarrollo Aisasemi (Jonathan Gómez Naranjo) --> <?php include_once('func/base.cfg.php');?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<title>NexCon</title>
		<link rel='shortcut icon' href='demos/_assets/favicon.ico'>
		<link rel='stylesheet'  href='css/jquery.mobile.structure-1.3.1.min.css'>
		<link rel='stylesheet'  href='css/jquery.mobile.theme-1.3.1.min.css'>
		<link rel='stylesheet' href='css/nx.css'>
		<link rel='stylesheet' href='css/main.css'>
		<script src='js/jquery-1.9.1.min.js'></script>
		<script src='js/jquery.mobile-1.3.1.min.js'></script>
		<script src='js/nx.php'></script>
		<script src='js/main.js'></script>
	</head>
	<body>
		<div data-role='page' id='login' data-theme='b'>
			<div data-role='header' data-position='fixed' data-theme='b'>
				<h1>NexCon</h1>
			</div>
			<div data-role='content' data-view='unique-small'>
				<img src='imgs/logo.png' id='login_content_logo'/>
				<input type='text' id='login_user' name='user' data-clear-btn="true" placeholder="Nombre de Usuario"/>
				<input type='password' id='login_pass' name='pass' data-clear-btn="true" placeholder="Contraseña"/>
				<input type='button' id='login_button' value='Iniciar Sesion' data-theme='b'/>
			</div>
			<div data-role='footer' data-position='fixed' data-theme='b'>
				<h4><?php echo $config['base']['foot'] ;?></h4>
			</div>
		</div>
	</body>
</html>
