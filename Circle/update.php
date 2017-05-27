<?php
	$filename = 'update.csv';	
	$d = array('lastModifiedDate' => filemtime($filename));
	echo json_encode($d);
?>