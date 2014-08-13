<?php
include_once('base.cfg.php');
session_start();
$session_name = $config['session']['pfix'] . '.' . $config['session']['name'];
?>