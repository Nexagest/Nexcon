<?php
include_once('../base.inc.php');
include_once('list_mods.func.php');
include_once(lib('session_info.inc.php'));
$mods = '';
if(isset($_REQUEST['dir'])){
	$dir = $_REQUEST['dir'];
}else{
	$dir = 'mods';
}
$dir = '../../' . $dir;
$list_mods = list_mods($dir);
foreach($list_mods as $mod){
	if($mod['enabled']){
		if(in_array(0, $mod['access']) || in_array($session_info['type'], $mod['access'])){
			$mods .= $mod['id'] . '|' . $mod['name'] . '|' . $mod['icon'] . '|' . $mod['dir'] . ';';
		}
	}
}
echo $mods;
?>