-- Written by SkullCrusher <garrysmodcloud@gmail.com>
--

SteamID_user = "STEAM_0:0:0"

function checkfolders(path, root, index)	
	words = string.Explode( "/", path )
	
	if( table.Count(words) >= index) then	
		
		local tempdirectory = words[1]
		
		for i=2,index do 			
			tempdirectory = tempdirectory .. "/" .. words[i]
		end
		
		if(string.find( tempdirectory, ".", 0, true ) == nil) then		

			if(file.Exists(tempdirectory, root ) == false) then
				file.CreateDir(tempdirectory)
			end	
			checkfolders(path,root, index + 1)
		end
	end	
end

function getsteamid()
	local Temp = LocalPlayer():SteamID()
	
	if( Temp == nil) then
		SteamID_user = "STEAM_0:0:0"
	else
		words = string.Explode( ":", Temp )		
		SteamID_user = words[1].."_"..words[2].."_"..words[3]
	end
end

function client_updatefile(directory, root)

		local url = "http://www.garrysmodcloud.com/client/requestfile.php"
		
		local TEMP = { id = SteamID_user, file = directory }

		http.Post(url, TEMP,
		function( responseText, contentLength, responseHeaders, statusCode )
					
			file.Write( directory, responseText )
				
			times = file.Time( directory, root )
			
			local var = SteamID_user ..":"..directory..":".. times
			
			local TEMP = { a = var }
			local url = "http://www.garrysmodcloud.com/client/updatefile.php"

			http.Post( url, TEMP,
				function( responseText, contentLength, responseHeaders, statusCode )
				end,
				function( error )
				end);		
			
		end,
		function( error )
		end)			

end

function server_updatefile(directory, root)
	local timess = file.Time( directory, root )
	
	local data = file.Read( directory, root )
				
	local complete_data = SteamID_user .. ":" .. directory .. ":" .. root .. ":" .. file.Size( directory, root ) .. ":" .. timess
	
	local TEMP = { newfile = complete_data, datas = data }
	local url = "http://www.garrysmodcloud.com/client/updatefile.php"

	http.Post( url, TEMP,
		function( responseText, contentLength, responseHeaders, statusCode )
		end,
		function( error )
		end);
end

function checkfile(root, directory, filesize, lastmodified, first)
	if(file.Exists( directory, root) == false) then
		if(first == true) then
			checkfolders(directory, root, 1)
			client_updatefile(directory, root) 
		end
	else		
		if(file.Time( directory, root ) != tonumber(lastmodified, 10)) then		
			if(file.Time( directory, root ) > tonumber(lastmodified, 10)) then
				server_updatefile(directory, root)
			else
				checkfolders(directory, root, 1)
				client_updatefile(directory, root)
			end
		end
	end
end

function checkmanifest(manifest_argument, first)	
	temp_workspace = string.Explode( "\n", manifest_argument )
	
	for i=1,table.Count(temp_workspace) do 
	
		temp_split = string.Explode( ":", temp_workspace[i] )
	
		if( table.Count(temp_split) == 5) then
		
			if(temp_split[1] == "F") then
				checkfile(temp_split[2], temp_split[3], temp_split[4], temp_split[5], first)			
			else
			
			end
		end
	end 

end

function download_manifest(first)
	http.Fetch( "http://www.garrysmodcloud.com/client/manifestquery.php?id=" .. SteamID_user,
		function( body, len, headers, code )
			Manifest = body
			print( body)
			print("ASD")
			
			checkmanifest(body, first)
		end,
		function( error )
			Manifest = "Manifest: Error"
		end
	 );	
end

function download_manifest_checkfornewfiles()
	http.Fetch( "http://www.garrysmodcloud.com/client/manifestquery.php?id=" .. SteamID_user,
		function( body, len, headers, code )
			checkfornewfiles(body)
		end,
		function( error )
			Manifest = "Manifest: Error"
		end
	 );	
end

function delete_updatefile(directory, root)
	local timess = file.Time( directory, root )
					
	local complete_data = SteamID_user .. ":" .. directory .. ":" .. root .. ":" .. file.Size( directory, root ) .. ":" .. timess
	
	local TEMP = { delete = complete_data }
	local url = "http://www.garrysmodcloud.com/client/deletefile.php"

	http.Post( url, TEMP,
		function( responseText, contentLength, responseHeaders, statusCode )

		end,
		function( error )

		end);
end

function dc_checkfordeletion(root, directory, filesize, lastmodified)
	if(file.Exists( directory, root ) == true) then
	else
		print("(GarrysModCloud) Deleting ", directory)
		delete_updatefile(directory, root)
	end
end

function dc_checkmanifest(manifest_argument)	
	temp_workspace = string.Explode( "\n", manifest_argument )
	
	for i=1,table.Count(temp_workspace) do 
	
		temp_split = string.Explode( ":", temp_workspace[i] )
	
		if( table.Count(temp_split) == 5) then
		
			if(temp_split[1] == "F") then
				dc_checkfordeletion(temp_split[2], temp_split[3], temp_split[4], temp_split[5])								
			end
		end
	end 
end

function dc_download_manifest()
	http.Fetch( "http://www.garrysmodcloud.com/client/manifestquery.php?id=" .. SteamID_user,
		function( body, len, headers, code )
			Manifest = body;
			dc_checkmanifest(body)
		end,
		function( error )
			Manifest = "Manifest: Error"
		end
	 );	
end

function c2_uploadnewfile(directory, root)

	times_newfile = file.Time( directory, root )
	
	//Update the server
	local data = file.Read( directory, root )
				
	local complete_data = SteamID_user .. ":" .. directory .. ":" .. root .. ":" .. file.Size( directory, root ) .. ":" .. times_newfile
	
	local newanswer = "yes";
	
	local TEMP = { newupload = complete_data, datas = data }
	local url = "http://www.garrysmodcloud.com/client/updatefile.php"

	http.Post( url, TEMP,
		function( responseText, contentLength, responseHeaders, statusCode )
		end,
		function( error )
		end);
end

function c2_checkforfileinmanifest(file, manifest)
		
	local foundinmanifest = false	
	local temp_workspace = string.Explode( "\n", manifest )
	
	for i=1,table.Count(temp_workspace) do 
	
		temp_split = string.Explode( ":", temp_workspace[i] )
	
		if( table.Count(temp_split) == 5) then
			if(temp_split[1] == "F") then
				
				if(temp_split[3] == file) then
					foundinmanifest = true
				end				
			end
		end
	end

	if(foundinmanifest == false) then
		c2_uploadnewfile(file, "DATA")
	end
end

function c2_collectfiles(path, manifest)	
	local files, directories = file.Find( path .. "/*", "DATA" )
	
	for i=1,table.Count(files) do 
		newpath = path.."/"..files[i]
			
		c2_checkforfileinmanifest(newpath, manifest)
	end 
	
	for i=1,table.Count(directories) do 
		newpath = path.."/"..directories[i]
			
		c2_collectfiles(newpath, manifest)
	end 

end

function c2_Fcollectfiles(manifest)	
	local files, directories = file.Find( "*", "DATA" )
	
	for i=1,table.Count(files) do 					
		c2_checkforfileinmanifest(files[i], manifest)
	end 
	
	for i=1,table.Count(directories) do 
		c2_collectfiles(directories[i], manifest)
	end 
end

function c2_download_manifest_checkfornewfiles()
	http.Fetch( "http://www.garrysmodcloud.com/client/manifestquery.php?id=" .. SteamID_user,
		function( body, len, headers, code )
			c2_Fcollectfiles(body)
		end,
		function( error )
			Manifest = "Manifest: Error"
		end
	 );	
end

function CallGameTimer()
	timer.Create( "filecheck", 60, 0, function() 
		print("(GarrysModCloud) Checking for files to sync.")
		getsteamid()
		if(SteamID_user != "STEAM_0:0:0") then
			download_manifest(false)
			c2_download_manifest_checkfornewfiles()
			dc_download_manifest()		
		end
	end )
end

function init()--GameInitialize()
	timer.Create( "filecheck", 60, 1, function() 
		print("(GarrysModCloud) Starting sync.")
		getsteamid()
		if(SteamID_user != "STEAM_0:0:0") then
			download_manifest(true)
			CallGameTimer()
		end
	end )	

end

hook.Add( "Initialize", "some_unique_name", init )
--hook.Add( "Initialize", "call filecheck", GameInitialize )
