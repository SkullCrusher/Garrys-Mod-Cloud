<?php 

	header("HTTP/1.0 200");
		
	$Path = "files/" . $_POST['id'] . '/'. $_POST['file'];
		
	//Load the file

	$fh = fopen($Path, 'r');
	$theData = fread($fh, 20000000);
	fclose($fh);

	echo $theData;
?>
