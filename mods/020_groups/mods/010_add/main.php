<?php
include_once('../../../../func/base.inc.php');
include_once(lib('session/is_logged.inc.php'));
include_once('config.php');
if(is_logged()){
	header('Location: index.php') ;
}else
	header('Location: ../') ;
?>