<?php 

	//check if they post the correct data
	if(isset($_GET['id'])){
		$db = new PDO('mysql:dbname=garrysmodcloud;host=127.0.0.1;charset=utf8', 'GarrysModCloud', 'QvKLnwQ9BW3tHUte');
				
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$statement = $db->prepare("SELECT root, directory, time, filesize FROM unlisted WHERE owner = :username"); 
		$statement->execute(array(':username' => $_GET['id']));
		
		$stack = array();
		
		while($row = $statement->fetch()){
			array_push($stack, "F:" . $row['root'] . ':' . $row['directory'] . ':' . $row['filesize'] . ':' . $row['time']);
		}
		
		$db = null; //kill
		
		$loop = 0;
		while($loop < count ($stack)){
			echo $stack[$loop];
			echo "\n";
			$loop++;
		}
	
	}
?>
