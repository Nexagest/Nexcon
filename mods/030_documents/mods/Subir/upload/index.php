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
				<form id='form1' enctype='multipart/form-data' method='post' action='upload/upload.php' data-ajax='false'>
					<input type='file' id='file' name='uploadedfile'/>
					<input type='button' id='send' value='Subir' data-theme='b'/>
				</form>
			</div>
			<div data-role='footer' data-position='fixed' data-theme='b'>
				<h4><?php echo $config['base']['foot'] ;?></h4>
			</div>
		</div>
	</body>
</html>