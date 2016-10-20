<?php 

//if it is new
//Check for a post request to update file.
if(isset($_POST['newupload']) && isset($_POST['datas'])){
	
	if(strlen($_POST['newupload']) > 1){
	if(strlen($_POST['datas']) > 1){
	
		$pieces = explode(":", $_POST['newupload']);
		
		//Make sure we have "SteamID_user:directory:root:Size:time:data"
		if(sizeof($pieces) == 5){
			//echo "pre UPDATED----";
			
			$db_update = new PDO('mysql:dbname=garrysmodcloud;host=127.0.0.1;charset=utf8', 'GarrysModCloud', 'QvKLnwQ9BW3tHUte');
		
			$db_update->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$db_update->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$statement_update = $db_update->prepare("INSERT INTO unlisted (owner, time, filesize, directory, root, data, ip, upload_date) VALUES (:owner, :time, :filesize, :directory, :root, :data, :ip, :upload_date)");

			$statement_update->execute(array(':filesize' => $pieces[3],':time' => $pieces[4], ':data' => $_POST['datas'],':owner' => $pieces[0], ':directory' => $pieces[1], ':root' => $pieces[2], ':ip' => $_SERVER['REMOTE_ADDR'], ':upload_date' => date(DATE_RFC2822)));
				
			echo "Uploaded new";	
		
			$db_update = null; //kill
		}
	}
	}
}


//Check for a post request to update file.
if(isset($_POST['newfile']) && isset($_POST['datas'])){
	
	$pieces = explode(":", $_POST['newfile']);

	//Make sure we have "SteamID_user:directory:root:Size:time:data"	
	if(sizeof($pieces) == 5){
		
		$db = new PDO('mysql:dbname=garrysmodcloud;host=127.0.0.1;charset=utf8', 'GarrysModCloud', 'QvKLnwQ9BW3tHUte');
	
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$statement = $db->prepare("SELECT * FROM unlisted WHERE owner = :owner AND directory = :directory AND root = :root"); 
		
		$statement->execute(array(':owner' => $pieces[0], ':directory' => $pieces[1], ':root' => $pieces[2])); //array(':name' => $_SESSION['user_name'])
		
		$amount = 0;
			
		//Only runs once. (copy the current one into history)
		while($row = $statement->fetch()){
			$amount = 1;
			
			$db = new PDO('mysql:dbname=garrysmodcloud;host=127.0.0.1;charset=utf8', 'GarrysModCloud', 'QvKLnwQ9BW3tHUte');
	
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$statement = $db->prepare("INSERT INTO history (owner, time, filesize, directory, root, data, hidden, ip, comit_ip, creation_date) VALUES (:owner, :time, :filesize, :directory, :root, :data, :hidden, :ip, :comit_ip, :creation_date)"); 
		
			date_default_timezone_set('UTC');
		
			$statement->execute(array(':owner' => $row['owner'], ':time' => $row['time'], ':filesize' => $row['filesize'], ':directory' => $row['directory'],':root' => $row['root'], ':data' => $row['data'], ':hidden' => $row['hidden'],':ip' => $row['ip'],':comit_ip' => $_SERVER['REMOTE_ADDR'], ':creation_date' => date(DATE_RFC2822)));
		
			$db = null; //kill
		
			$db_update = new PDO('mysql:dbname=garrysmodcloud;host=127.0.0.1;charset=utf8', 'GarrysModCloud', 'QvKLnwQ9BW3tHUte');
	
			$db_update->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$db_update->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$statement_update = $db_update->prepare("UPDATE unlisted SET filesize = :filesize, time = :time, data = :data, ip = :ip WHERE owner = :owner AND directory = :directory AND root = :root"); 
		
			$statement_update->execute(array(':filesize' => $pieces[3],':time' => $pieces[4], ':data' => $_POST['datas'],':owner' => $pieces[0], ':directory' => $pieces[1], ':root' => $pieces[2], ':ip' => $_SERVER['REMOTE_ADDR']));			
		
			$db_update = null; //kill
		}
		
		if($amount ==0){
			$db = new PDO('mysql:dbname=garrysmodcloud;host=127.0.0.1;charset=utf8', 'GarrysModCloud', 'QvKLnwQ9BW3tHUte');
	
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$statement = $db->prepare("INSERT INTO unlisted (owner, time, filesize, directory, root, data, hidden, ip, upload_date) VALUES (:owner, :time, :filesize, :directory, :root, :data, :hidden, :ip, :upload_date)"); 
		
			date_default_timezone_set('UTC'); //date(DATE_RFC2822);
		
			$statement->execute(array(':owner' => $pieces[0], ':time' => $pieces[4], ':filesize' => $pieces[3], ':directory' => $pieces[1],':root' => $pieces[2], ':data' => $_POST['datas'], ':hidden' => 'false',':ip' => $_SERVER['REMOTE_ADDR'], ':upload_date' => date(DATE_RFC2822)));
		
		
			$db = null; //kill
		}
		
		$db = null; //kill
	}	
}
?>
