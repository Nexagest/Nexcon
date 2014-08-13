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
		<div data-role='page' id='documents' data-theme='b'>
			<div data-role='header' data-position='fixed' data-theme='b'>
				<h1>NexCon</h1>
				<a href='../../' data-icon='back' class='back_button ui-btn-right' data-theme='b' data-rel='external'>Volver</a>
			</div>
			<div data-role='content'>
				<ul data-role='listview' id='clients_list'>
					<li data-role='list-divider' data-theme='a'>
						<div style='float:left; width:calc(100% - 100px);'>
							<input type='text' data-theme='c' id='newTypeId' placeholder="Identificador..."/>
							<input type='text' data-theme='c' id='newTypeName' placeholder="Nombre a mostrar..."/>
						</div>
						<div style='float:left; width:95px; padding-left:5px; margin-top:3px;'>
							<input type='button' id='addType' value='Añadir' data-theme='b' data-icon="plus" data-iconpos="top"/>
						</div>
						<div style='clear:both'></div>
					</li>
				</ul>
				<div data-role="popup" data-corners="false" data-history="false" data-theme="a" data-overlay-theme="a" data-position-to="window" id="moreinfo" style="text-align: center;">
					<h3>¿Qué desea hacer con esta versión?<h3>
					<div data-role="controlgroup" data-theme="b">
						<input type='text' id='nameMod'/>
						<a href="#" data-role="button" id='mod'>Modificar nombre</a>
						<a href="#" data-role="button" id='delthis'>Borrar tipo</a>
						<a href="#" data-role="button" id='close'>Salir</a>
					</div>
				</div>
			</div>
			<div data-role='footer' data-position='fixed' data-theme='b'>
				<h4><?php echo $config['base']['foot'] ;?></h4>
			</div>
		</div>
	</body>
</html>