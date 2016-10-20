<?php 

function SpiderFolder($path, &$FileStack){

	// Open a known directory, and proceed to read its contents
	if (is_dir($path)) {
		if ($dh = opendir($path)) {
			while (($file = readdir($dh)) !== false) {
				//echo "filename: $file : filetype: " . filetype($path . $file) . "\n";
				
				//echo $path . "/" . $file;
				
				if($file != '.' && $file != '..'){
					//echo filetype($path . "/" . $file);
					if(filetype($path . "/" . $file) == 'dir'){
						SpiderFolder($path . "/" . $file);
					} else
					if(filetype($path . "/" . $file) == 'file'){
						//echo $path . "/" . $file;
						$value = $path . "/" . $file;
						//array_merge($FileStack, $value);
						array_push($FileStack, $value);
					}
				}
			}
			closedir($dh);
		}
	}
}



	//check if they post the correct data
	if(isset($_GET['id'])){
	
		$Results = array();
	
		$FileStack = SpiderFolder("files/" . $_GET['id'], $Results);
	
		//echo count($Results);
	
		
		$loop = 0;
		//Dump them for the client
		while($loop < count ($Results)){
		
			//print_r($Results);
		
		
			$Arrayloop = 5;
			$CleanedPath = "";
			
			$Path = $Results[$loop];
			
			while($Arrayloop < strlen($Path)){
				$CleanedPath .= $Path[$Arrayloop];
				
				$Arrayloop += 1;
			}
			
			$Path = "information";
			$Path .= $CleanedPath;
			
			//$test = file($Path);
				
			//print_r($test);
			$file_informantion = file($Path);
			
			$loop_nl = 0;
			//Dump them for the client
			while($loop_nl < count ($file_informantion)){
					
				$file_informantion[$loop_nl] = str_replace("\n", '', $file_informantion[$loop_nl]);
				$loop_nl++;
			}
			
			
			//cut out the /files/STEAM_ID_00000/
							
			$replace = "files/" . $_GET['id'] . '/';
					
			$Results[$loop] = str_replace($replace, '', $Results[$loop]);
			
			
		
			//F:DATA:hashpipe.txt:10:0001537600
			echo $stack, "F:" . 'data' . ':' . $Results[$loop] . ':' . $file_informantion[2] . ':' . $file_informantion[1];		
		
			echo "\n";
			$loop++;
		}
	
	}
?>
