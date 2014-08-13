<?php
    // Sending the file - a pdf in this case
	$name = basename($_REQUEST['f']);
    header('Content-type: application/pdf');

    // Specify what the  file will be called
    header('Content-Disposition: attachment; filename="'.$name.'"');

    // And specify where it is coming from 
    readfile($_REQUEST['f']);
?>