<!-- NexCon Desarrollo Aisasemi (Jonathan Gómez Naranjo) --> <?php include_once('../../../../func/base.cfg.php');?>
<?php
error_reporting(0);
include_once('../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
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
				<ul data-role='listview' id='form_props'>
					<li>
						<div style='position:relative;width:calc(100%);float:left;'>
							<input type='text' id='form_name' placeholder="Nombre del formulario..."/>
						</div>
						<div style='clear:both;'></div>
					</li>
					<li>
						<form id="theuploadform" data-ajax="false" enctype="multipart/form-data" encoding="multipart/form-data" action="upload_file.php" method="post">
							<label for='form_file'>Fichero a adjuntar</label>
							<input type='file' name='form_file' id='form_file'/>
							<input type='hidden' name='form_id' id='form_id'/>
						</form>
					</li>
				</ul>
				<ul data-role='listview' style='margin-top:15px' id='form_elements'>
				
				
				
				</ul>
				<ul data-role='listview' style='margin-top:15px' id='nx-controller'>
					<li>
						<input type='text' id='newElementName' placeholder="Nombre campo nuevo..."/>
						<div style='position:relative;width:calc(50% - 2px);float:left;padding-right:2px;'>
							<select data-native-menu="false" id="newElementType">
								<option value="1">Texto</option>
								<option value="6">Area de Texto</option>
								<option value="2">Numerico</option>
								<option value="3">Contraseña</option>
								<option value="4">Fecha</option>
								<option value="5">Fichero</option>
							</select>
						</div>
						<div style='position:relative;width:calc(50% - 2px);float:left;padding-left:2px;'>
							<input type='button' id='addElement' value='Añadir' onClick='addNewElement();'/>
						</div>
						<div style='clear:both;'></div>
					</li>
					<li>
						<input type='button' id='addType' value='Guardar' data-theme='b' data-icon="plus" data-iconpos="top"/>	
					</li>
				</ul>
				</div>
			<div data-role='footer' data-position='fixed' data-theme='b'>
				<h4><?php echo $config['base']['foot'] ;?></h4>
			</div>
		</div>
	</body>
</html>