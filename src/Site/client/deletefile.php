<?php 

//Check for a post request to update file.
if(isset($_POST['delete'])){
	
	//split the request.
	$pieces = explode(":", $_POST['delete']);
	
	if(sizeof($pieces) == 5){
		//echo "pre UPDATED";
		
		$db = new PDO('mysql:dbname=garrysmodcloud;host=127.0.0.1;charset=utf8', 'GarrysModCloud', 'QvKLnwQ9BW3tHUte');
	
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$statement = $db->prepare("SELECT * FROM unlisted WHERE owner = :owner AND directory = :directory AND root = :root"); 
		
		$statement->execute(array(':owner' => $pieces[0], ':directory' => $pieces[1], ':root' => $pieces[2])); //array(':name' => $_SESSION['user_name'])
				
		//Only runs once. (copy the current one into history)
		while($row = $statement->fetch()){
			
			$db = new PDO('mysql:dbname=garrysmodcloud;host=127.0.0.1;charset=utf8', 'GarrysModCloud', 'QvKLnwQ9BW3tHUte');
	
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$statement = $db->prepare("INSERT INTO history (owner, time, filesize, directory, root, data, hidden, ip, comit_ip, creation_date, reason) VALUES (:owner, :time, :filesize, :directory, :root, :data, :hidden, :ip, :comit_ip, :creation_date, :reason)"); 
		
			date_default_timezone_set('UTC'); //date(DATE_RFC2822);
		
			$statement->execute(array(':owner' => $row['owner'], ':time' => $row['time'], ':filesize' => $row['filesize'], ':directory' => $row['directory'],':root' => $row['root'],':reason' => 'Delete', ':data' => $row['data'], ':hidden' => $row['hidden'],':ip' => $row['ip'],':comit_ip' => $_SERVER['REMOTE_ADDR'], ':creation_date' => date(DATE_RFC2822)));
		
		
			$db_update = new PDO('mysql:dbname=garrysmodcloud;host=127.0.0.1;charset=utf8', 'GarrysModCloud', 'QvKLnwQ9BW3tHUte');
	
			$db_update->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$db_update->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$statement_update = $db_update->prepare("UPDATE unlisted SET filesize = :filesize, time = :time, data = :data, ip = :ip WHERE owner = :owner AND directory = :directory AND root = :root"); 
		
			$statement_update->execute(array(':filesize' => $pieces[3],':time' => $pieces[4], ':data' => $_POST['datas'],':owner' => $pieces[0], ':directory' => $pieces[1], ':root' => $pieces[2], ':ip' => $_SERVER['REMOTE_ADDR']));			
		}
		
		//delete
		$db_update = new PDO('mysql:dbname=garrysmodcloud;host=127.0.0.1;charset=utf8', 'GarrysModCloud', 'QvKLnwQ9BW3tHUte');
	
		$db_update->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$db_update->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$statement_update = $db_update->prepare("DELETE FROM unlisted WHERE owner = :owner AND directory = :directory AND root = :root"); 
		
		$statement_update->execute(array(':owner' => $pieces[0], ':directory' => $pieces[1], ':root' => $pieces[2]));	
		
		echo "DELETED";		
	}
	
}

	


?>
