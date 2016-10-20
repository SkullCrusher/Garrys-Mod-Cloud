<?php 

$_POST['delete'] = "STEAM_0_0_1057196:scarcams.txt:data:7:1413077239";
	
//Check for a post request to update file.
if(isset($_POST['delete'])){

	$filename = "files\\";
		
	//Split the data;		
	$pieces = explode(":", $_POST['delete']);

	//Make sure we have "SteamID_user:directory:root:Size:time:data"
	if(sizeof($pieces) == 5){

		$filename .= $pieces[0];
		$filename .= "\\" . $pieces[1];
					
		if(!file_exists($filename)){
			die(); //The file does not exists so die.
		}
			
		//We pack the old files into a history								
		$zip = new ZipArchive();
		$filename2 = "./packed/" . $pieces[0] . ".zip";
						
		//Load Data file;
		$Files_Path = "files/" . $pieces[0] . '/' . $pieces[1];
		$information_Path = "information/" . $pieces[0] . '/' . $pieces[1];
						
		//Load the data
		$fh = fopen($Files_Path, 'r');
		$Files_Data = fread($fh, 20000000);
		fclose($fh);
						
		//Load the Information file
		$fh2 = fopen($information_Path, 'r');
		$Information_Data = fread($fh2, 20000000);
		fclose($fh2);
		
		//Store the update information.
		$Information_Data .= "\n--\n" . 'delete' . "\n" . $_SERVER['REMOTE_ADDR'] . "\n" . date(DATE_RFC2822);									

		if ($zip->open($filename2, ZipArchive::CREATE)!==TRUE) {exit("cannot open <$filename>\n");}
						
		//Dump Data.
		$zip->addFromString(time() . '-data-' . $pieces[1], $Files_Data);
						
		//Dump Information.
		$zip->addFromString(time() . '-info-' . $pieces[1], $Information_Data);

		$zip->close();	
		
	
		//We packed the file so now we delete.	
		if(unlink ($Files_Path)){
			echo "delete";
		}
		unlink ($information_Path);	
		echo "yes";
	}

}
echo "no";

?>
