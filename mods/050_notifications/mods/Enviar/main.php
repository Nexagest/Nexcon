<?php  
error_reporting(0);
include_once('../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once(lib('mysql.inc.php'));
include_once(lib('mail.inc.php'));
$now = date('Y-m-d H:i:s');
$query = $mysql->query("
SELECT
	notifications.id,
	notifications.client,
	notifications.text,
	notifications.link,
	notifications.added,
	clients.name,
	clients_info.email
FROM
	notifications,
	clients,
	clients_info
WHERE
	clients.id = notifications.client
AND
	clients_info.client = notifications.client
AND
	notifications.added >= notifications.sended
");
if($query->num_rows){
	while($client = $query->fetch_assoc()){
		if(!isset($clients[$client['client']]))
			$clients[$client['client']][0] = $client;
		else
			$clients[$client['client']][count($clients[$client['client']])] = $client;
	}
}
foreach($clients as $client){
	$email = $client[0]['email'];
	$cid = $client[0]['client'];
	$cna = $client[0]['name'];
	$subjet = 'Correo de la asesoría ' . $config['base']['foot'];
	$msg = '';
	$notys = null;
	foreach($client as $notification){
$cabecera = 'Notificación del día: ' . date('Y-m-d H:i:s', $notification['added']) . '
';
$cabecera .= '----------------------------------------------
';
$cabecera .= '
';
$doc = '<a href="http://' . $notification['link'] . '">'; 
$noty_text = $notification['text'];
$noty_text = str_replace('$DOC$', $doc, $noty_text);
$noty_text = str_replace('$/DOC$', '</a>', $noty_text);
$noty_text = str_replace('$CID$', $cid, $noty_text);
$noty_text = str_replace('$CNA$', $cna, $noty_text);
$cabecera .= $noty_text;
$msg .= $cabecera . '
----------------------------------------------

';
$notys[count($notys)] = $notification['id'];
	};
	// $msg = str_replace('
// ', '<br>', $msg);
	// echo "<div style='border:1px solid #000'>$cid: $cna<br>$email<br>$subjet<br><br>$msg</div><br>";
	if(SendMail($email,$subjet,$msg)){
		foreach($notys as $noty){
			$mysql->query("UPDATE notifications SET sended = '$now' WHERE id = $noty");
		}
		header('location: ../');
	}else{
		header('location: ../');
	}
}
// if(SendMail('info@nexagest.es', 'Probando el asunto!', 'No veas como mola!')){
	// echo 'Cojonudo!';
// }else{
	// echo 'Que mierda!';
// }
// if(SendMail('info@nexagest.es', 'Probando el asunto!2', 'No veas como mola!2')){
	// echo 'Cojonudo!2';
// }else{
	// echo 'Que mierda!2';
// }
header('location: ../');
?>