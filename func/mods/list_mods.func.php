<?php
function list_mods($ruta){
	$mods = null;
	if (is_dir($ruta)) { 
		if ($dh = opendir($ruta)) {
			$modules = count(readdir($dh)) - 3;
			while (($file = readdir($dh)) !== false) {
				if (is_dir($ruta . '/' . $file) && $file!="." && $file!=".."){ 
					if(file_exists($ruta . '/' . $file . '/config.php')){
						include_once($ruta . '/' . $file . '/config.php');
						if(
							isset($config['mod']['id']) &&
							isset($config['mod']['name']) &&
							isset($config['mod']['icon']) &&
							isset($config['mod']['enabled']) &&
							isset($config['mod']['access'])
						){
							$mods[$config['mod']['id']]['id'] = $config['mod']['id'];
							$mods[$config['mod']['id']]['name'] = $config['mod']['name'];
							$mods[$config['mod']['id']]['icon'] = $config['mod']['icon'];
							$mods[$config['mod']['id']]['enabled'] = $config['mod']['enabled'];
							$mods[$config['mod']['id']]['access'] = $config['mod']['access'];
							$mods[$config['mod']['id']]['dir'] = $file;
						}
					}
				}
			} 
			closedir($dh); 
		} 
	}
	return $mods;
} 
?>