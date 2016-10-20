<?php 
	require '../steamauth/steamauth.php';
?>
<html>
 <head>
  <title>My Files | GarrysModCloud</title>
  <meta charset="utf-8">
  <meta name="description" content="PLACEHOLDER">
  <meta name="author" content="GarrysmodCloud">
  <meta name="viewport" content="initial-scale=1">
  <meta name="keywords" content="PLACEHOLDER">
  <meta name="robots" content="selection">
  <meta name="revisit-after" content="periode">
  <link rel="shortcut icon" href="../assets/img/favicon_final.ico" type="image/x-icon">
  <link rel="icon" href="../assets/img/favicon_final.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="../assets/css/960.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/theme.css">
  <script type="text/javascript" src="../assets/javascript/jquery.js"></script>
  <!--[if lt IE 9]>
  <script src="../assets/javascript/html5shiv.min.js"></script>
  <![endif]-->
 </head>
 <body>
 
 <div id="wrapper">
 
  <header class="clearfix">
   <div class="container_12">
   <div class="logo"><a href="../index.php"><img src="../assets/img/logolong2.png"></a></div>
   <a href="#" class="resToggle">☰</a>
   <nav class="the-nav">
    <ul>
     <?php
     if(isset($_SESSION['steamid'])) {
      ?>
      
      <li><a href='#'><i class='fa fa-arrow-up'></i> Upload</a></li>
      <li><a href='files.php'><i class='fa fa-cloud'></i> My Files</a></li>
      <li><a href='#'><i class='fa fa-arrow-down'></i> Downloads</a></li>
      <li><a href='http://steamcommunity.com/sharedfiles/filedetails/?id=323125115'><i class='fa fa-download'></i> Install</a></li>
      <li><form input type="hidden" action=\"steamauth/logout.php\" method=\"post\"><a href='steamauth/logout.php' action='steamauth/logout.php' input value=\"\"><i class='fa fa-user'></i> Logout</a></li></form>
      <?php
     } else if(!isset($_SESSION['steamid'])) {
      ?>
      
      <li><a href='http://steamcommunity.com/sharedfiles/filedetails/?id=323125115'><i class='fa fa-download'></i> Install</a></li>
      <li><a href='login.php'><i class='fa fa-user'></i> Login</a></li>
      <?php
     }
     ?>
    </ul>
   </nav>
   </div>
  </header>
  <?php
  $notloggedin = "Hello! GarrysModCloud requires you to login to your steam account so we can verify your files for you! We do not store anything in out system, and everything is handled by steam!";
  if(isset($_SESSION['steamid'])) {
  	?>
	
	<!-- TABLE -->
	<div class="filelist">
<table class="table table-action">
  
  <thead>
    <tr>
      <th class="t-small"></th>
      <th class="t-small">Directory/Name</th>
      <th class="t-medium">File Size</th>
      <th>Date Last Updated</th>
      <th class="t-medium">Permissions</th>
    </tr>
  </thead>
  
  <tbody>
   	
	<?php  
		$id = $_SESSION['steamid'];

		function parseInt($string) {
		if(preg_match('/(\d+)/', $string, $array)) {
			return $array[1];
		} else {
			return 0;
		}}

		// Convert SteamID64 into SteamID
		$subid = substr($id, 4); 
		$steamY = parseInt($subid);
		$steamY = $steamY - 1197960265728; 

		if ($steamY%2 == 1){
			$steamX = 1;
		} else {
			$steamX = 0;
		}

		$steamY = (($steamY - $steamX) / 2);
		$steamID = "STEAM_0_" . (string)$steamX . "_" . (string)$steamY;


		$db = new PDO('mysql:dbname=garrysmodcloud;host=127.0.0.1;charset=utf8', 'GarrysModCloud', 'QvKLnwQ9BW3tHUte');
        
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	   
		$statement = $db->prepare("SELECT root, directory, time, filesize, upload_date, hidden FROM unlisted WHERE owner = :username"); // WHERE owner = :username
		$statement->execute(array(':username' => $steamID)); 

  
		while($row = $statement->fetch()){
		
			echo "<tr>"; 
			echo "<td><label><input type=\"checkbox\"></label></td>";
			echo "<td>".$row['directory']."</td>"; 
			echo "<td>".$row['filesize']." bytes</td>"; 
			echo "<td>".$row['upload_date']."</td>"; 
			
			if($row['hidden'] == "true"){
				echo "<td>Private</td>";
				//echo "<div class='buttons'><button class='highlight'>Download</button></div>";
			}
			echo "</tr>";
      		}  
 
     ?>
	

  </tbody>
</table>
</div>
<!-- END TABLE -->
 
    <section class="section3">
     <footer>
      <p>Copyright © 2014 - 20<?php echo date(y)?> DwarvenKnowledge LLC, All rights reserved.</p>
     </footer>
    </section>
  	<?php
    } else if(!isset($_SESSION['steamid'])) {
  	?>
 	  <section class="sectionlogin">
     <div class="loginsectionbody">
      <h2 style="text-align:center;color:#F64747">Login</h2>
      <?php 
       echo $notloggedin;
       steamlogin();
      ?>
     </div>
 	  </section>
    <section class="section3">
     <footer>
      <p>Copyright © 2014 - 20<?php echo date(y)?> DwarvenKnowledge LLC, All rights reserved.</p>
     </footer>
    </section>
  <?php
   }
  ?>
  <script type="text/javascript">
  $('.resToggle').click(function(){
  $('.the-nav').toggleClass('active');
  });
  </script>
  
  </div><!-- #wrapper -->
  
 </body> 
</html>