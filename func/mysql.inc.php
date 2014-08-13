<?php
include_once('base.cfg.php');
if(!$config['mysql']['host'])
	$config['mysql']['host'] = 'localhost';
if(!$config['mysql']['port'])
	$config['mysql']['port'] = 3306;
$mysql = new mysqli(
	$config['mysql']['host'],
	$config['mysql']['user'],
	$config['mysql']['pass'],
	$config['mysql']['data'],
	$config['mysql']['port']
);
?>