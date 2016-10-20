<?php 
	header("HTTP/1.0 200");
		
	$db = new PDO('mysql:dbname=garrysmodcloud;host=127.0.0.1;charset=utf8', 'GarrysModCloud', 'QvKLnwQ9BW3tHUte');
	
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$statement = $db->prepare("SELECT data FROM unlisted WHERE owner = :username AND directory = :directory");
	$statement->execute(array(':username' => $_POST['id'], ':directory' => $_POST['file'])); 
	$result = $statement->fetch();
	
	echo $result['data'];
		
	$db = null; //kill
	

?>
