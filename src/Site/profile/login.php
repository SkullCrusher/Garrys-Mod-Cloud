<?php
  require '../steamauth/steamauth.php';
?>
<html>
 <head>
  <title>Sign In | GarrysModCloud</title>
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
  <header class="clearfix">
   <div class="container_12">
   <div class="logo"><a href="../index.php"><img src="../assets/img/logolong2.png"></a></div>
   <a href="#" class="resToggle">☰</a>
   <nav class="the-nav">
    <ul>
     <?php
     if(isset($_SESSION['steamid'])) {
	 
	 	header("Location: http://garrysmodcloud.com/profile/files.php");
		die();
      ?>
	  

	  
	  
      
      <li><a href='#'><i class='fa fa-arrow-up'></i> Upload</a></li>
      <li><a href='files.php'><i class='fa fa-cloud'></i> My Files</a></li>
      <li><a href='#'><i class='fa fa-arrow-down'></i> Downloads</a></li>
      <li><a href='http://steamcommunity.com/sharedfiles/filedetails/?id=323125115'><i class='fa fa-download'></i> Install</a></li>
	  
      <li><a href='steamauth/logout.php' ><i class='fa fa-user'></i> Logout</a></li>
      <?php
	  //  echo "<form action=\"steamauth/logout.php\" method=\"post\"><input value=\"\" type=\"submit\" /></form>"; //logout button
	  
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

  <section class="sectionlogin" style="text-align:center;">
   <div class="loginsectionbody">
    <h2 style="text-align:center;color:#F64747;font-size: 18px;">Login</h2>
    <?php
    $loggedin = "It appears your already logged in. To logout please click <a href='logout.php' style='color:#333'>here</a>.";
    $notloggedin = "Hello! GarrysModCloud requires you to login to your steam account so we can verify your files for you! We do not store anything in out system, and everything is handled by steam!<br><br>";
	
    if(isset($_SESSION['steamid'])){
      echo $loggedin;
    } else if(!isset($_SESSION['steamid'])) {
      echo $notloggedin;
      steamlogin();
    }
    ?>
   </div>
  </section>
  <script type="text/javascript">
  $('.resToggle').click(function(){
  $('.the-nav').toggleClass('active');
  });
  </script>
 </body> 
</html>