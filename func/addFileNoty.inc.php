<?php
include_once('../../../../func/base.inc.php');
function addAutoNoty($mysql, $client, $file, $time){
	global $config;
	$url = str_replace('//', '/', $config['base']['domain'] . '/' . $config['base']['bdir'] . '/download?doc=' . $file);
	$date = date('Y-m-d H:i:s');
	$text = "Se ha agregado un nuevo fichero el dia $date \$DOC\$Descargar\$/DOC\$";
	$mysql->query("INSERT INTO notifications (client, link, text, added) VALUE ('$client', '$url', '$text', '$date')");
}
?>