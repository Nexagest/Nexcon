<?php
function curMod() {
 $pageURL = 'http';
 if(isset($_SERVER["HTTPS"]))
	 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 $pageURL = explode('/', $pageURL);
 $modURL = '';
 for($i = 0; $i < count($pageURL) -1; $i++)
	$modURL .= $pageURL[$i] . '/';
 return $modURL;
}
if(!isset($_REQUEST['c'])){
	header('Location: main.php') ;
}
include_once('../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
include_once('config.php');
$id = $_REQUEST['c'];
$groupname = $mysql->query("SELECT * FROM groups WHERE id = $id");
$groupname = $groupname->fetch_assoc();
$groupname = $groupname['name'];
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
		<script>var grupo = <?php echo $id;?>;</script> 
		<script src='js/edit.js'></script>
	</head>
	<body>
		<div data-role='page' id='add_client' data-theme='b'>
			<div data-role='header' data-position='fixed' data-theme='b'>
				<h1>NexCon ~ <?php echo $groupname; ?></h1>
				<a href='main.php' data-icon='back' class='back_button ui-btn-right' data-theme='b' data-rel='external'>Volver</a>
			</div>
			<div data-role='content'>
			<fieldset class="ui-grid-a">
				<div class="ui-block-a">
					<div data-role='fieldcontain'>
						<label for='client'>Cliente: (DNI/CIF)</label>
						<input type='text' name='client' id='client' value='' data-clear-btn='true' placeholder=''/>
					</div>
				</div>
				<div class="ui-block-b">
					<button id='addclient' data-theme="b" data-mini="true">Añadir</button>
				</div>
			</fieldset>
				<div id='add'></div>
				<ul id='clients_list' data-role='listview' data-filter='true' data-filter-placeholder='Buscar cliente...' data-filter-theme='b'>
<?php
$group = $mysql->query("SELECT * FROM `clients_groups` WHERE `group` = '$id'");
while($datagroup = $group->fetch_assoc()){
	$clients = $mysql->query("SELECT * FROM clients WHERE id = '". $datagroup['client']."'");
	$dataclient = $clients->fetch_assoc();
	?>
					<li data-icon='delete'>
						<a href='#' onclick='BorrarCliente(<?php echo '"' . $dataclient['id'] . '","' . $id .'"';?>);' data-rel='external' data-inset='false' data-content-theme='b'
							<h3><?php echo $dataclient['name'];?>    <font size='2' color='#FF7373'>  <?php echo $dataclient['id'];?></font>
						</a>
					</li>
	<?php
}
?>
				</ul>
			</div>
			<div data-role='footer' data-position='fixed' data-theme='b'>
				<h4><?php echo $config['base']['foot'] ;?></h4>
			</div>
		</div>
	</body>
</html>