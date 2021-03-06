# Garrys Mod Cloud
Dropbox for Garry's Mod.

## Long description
I love Garry's Mod, it gives a huge amount of depth to build interesting creations. There was an issue where I would lose all of the creations I built because they were saved locally.

My solution to this was to create something that would automatically sync my saved files while I was playing. I figured that while I was building this I might as well let others use it also. So I set up garrysmodcloud, but it was too resource heavy to host on my internet so I shut it down.

## Design overview
Garry's Mod allows for amazing levels of scripting via LUA so I wrote a script that will do the following:

1. On startup: Request file list from server, if any files are not on the local machine that are on the list download them.
2. Running: Scan for any changes, if file is created or modified send change to server or if file is missing send delete.
3. On close: Dumps the list of files to the server (this won't finish if the person force closes the application).

On the backend I have a simple php backend with a mysql server to store the records. I have two versions of the program, one stores the files on the hard disk and the other stores it on the file system. The current configuration for this is for saving them on the file system (make sure it has access to read, write, and delete).

## HUGE disclaimer
This is literally the second web application I had ever built in my life. I came from the nice sharp world of C++ and dove into this pool of fuzzy web development. You probably could build something better for the backend in a week, I would recommend that. The lua is very nice in my opinion, it would be worth looking at for sure. I know this worked almost two years ago but I haven't touched it since so no guarantee.

## To install this
I wrote this over two years ago so it's really fuzzy but it should be as simple as drag and drop the files onto apache and install the sql database. You need to set up the permissions so it can read and write to the file system also. To enable the lua, launch garrys mod and inside the console you can launch via a command or stick it into the auto run folder and restart.

A better description lives here: https://github.com/SkullCrusher/Garrys-Mod-Cloud/issues/1
