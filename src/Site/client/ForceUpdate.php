<?php 

if(set_time_limit ( 3600 )){
	echo "Set timeout starting.\n";

	$db_update = new PDO('mysql:dbname=garrysmodcloud;host=127.0.0.1;charset=utf8', 'GarrysModCloud', 'QvKLnwQ9BW3tHUte');
		
	$db_update->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$db_update->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$statement_update = $db_update->prepare("UPDATE unlisted SET hidden = 'true'"); 
			
	$statement_update->execute();			
			
	$db_update = null; //kill

}else{
	echo "Unable to set timeout.\n";
}

echo "end of commands";

?>
