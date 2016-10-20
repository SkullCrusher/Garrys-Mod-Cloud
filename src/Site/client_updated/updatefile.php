<?php 

//Check for a post request to update file.
if(isset($_POST['datas'])){

	//New upload.
	if(isset($_POST['newupload'])){
	if(strlen($_POST['newupload']) > 1){
	if(strlen($_POST['datas']) > 1){
		
		$filename = "files\\";
		
		//Split the data;		
		$pieces = explode(":", $_POST['newupload']);
			
		//Make sure we have "SteamID_user:directory:root:Size:time:data"
		if(sizeof($pieces) == 5){

			$filename .= $pieces[0];			
			$filename .= "\\" . $pieces[1];
						
			if (file_exists($filename)) {
				die(); //The file exists so die.
			} else {							
				
				// Write the contents back to the file
				file_put_contents($filename, $_POST['datas'],  LOCK_EX);
				
				//Write the information file
				$filename_information = "information\\";
				$filename_information .= $pieces[0];			
				$filename_information .= "\\" . $pieces[1];
				
				//Construct the information file				
				$Information_Data = $pieces[0] . "\n" . $pieces[4] . "\n" . $pieces[3] . "\n" . $pieces[1] . "\nDATA\ntrue\n" . $_SERVER['REMOTE_ADDR'] . "\n" . date(DATE_RFC2822);
				
				//Write the information file to the hard drive
				file_put_contents($filename_information, $Information_Data,  LOCK_EX);
				
			}				
		}else{die();}
	}else{die();}
	}else{die();}
	}
	
//--Update file.
	if(isset($_POST['newfile'])){
		if(strlen($_POST['newfile']) > 1){
		if(strlen($_POST['datas']) > 1){
		
			$filename = "files\\";
		
			//Split the data;		
			$pieces = explode(":", $_POST['newfile']);
				
			//Make sure we have "SteamID_user:directory:root:Size:time:data"
			if(sizeof($pieces) == 5){

				$filename .= $pieces[0];			
				$filename .= "\\" . $pieces[1];
					
				//If the file is already there we dump it to the history.
				if (file_exists($filename)) {
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

					if ($zip->open($filename2, ZipArchive::CREATE)!==TRUE) {exit("cannot open <$filename>\n");}
					
					//Dump Data.
					$zip->addFromString(time() . '-data-' . $pieces[1], $Files_Data);
					
					//Dump Information.
					$zip->addFromString(time() . '-info-' . $pieces[1], $Information_Data);

					$zip->close();
				} 	
				
				// Write the contents back to the file
				file_put_contents($filename, $_POST['datas'],  LOCK_EX);
					
				//Write the information file
				$filename_information = "information\\";
				$filename_information .= $pieces[0];			
				$filename_information .= "\\" . $pieces[1];
					
				//Construct the information file				
				$Information_Data = $pieces[0] . "\n" . $pieces[4] . "\n" . $pieces[3] . "\n" . $pieces[1] . "\nDATA\ntrue\n" . $_SERVER['REMOTE_ADDR'] . "\n" . date(DATE_RFC2822);
					
				//Write the information file to the hard drive
				file_put_contents($filename_information, $Information_Data,  LOCK_EX);
					
						
			}else{die();}
		
		}else{die();}
		}else{die();}
	}
}
?>
