<?php 
  require '../steamauth/steamauth.php';
?>
<html>
 <head>
  <title>Logout | GarrysModCloud</title>
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
      ?>
      
      <li><a href='#'><i class='fa fa-arrow-up'></i> Upload</a></li>
      <li><a href='files.php'><i class='fa fa-cloud'></i> My Files</a></li>
      <li><a href='#'><i class='fa fa-arrow-down'></i> Downloads</a></li>
      <li><a href='http://steamcommunity.com/sharedfiles/filedetails/?id=323125115'><i class='fa fa-download'></i> Releases</a></li>
     
	    <li><form input type="hidden" action=\"steamauth/logout.php\" method=\"post\"><a href='steamauth/logout.php' action='steamauth/logout.php' input value=\"\"><i class='fa fa-user'></i> Logout</a></li></form>
      <?php
	  // <li><a href='logout.php'><i class='fa fa-user'></i> Logout</a></li>
	  //  echo "<form action=\"steamauth/logout.php\" method=\"post\"><input value=\"\" type=\"submit\" /></form>"; //logout button
	  
      
     } else if(!isset($_SESSION['steamid'])) {
      ?>
     
      <li><a href='http://steamcommunity.com/sharedfiles/filedetails/?id=323125115'><i class='fa fa-download'></i> Releases</a></li>
      <li><a href='login.php'><i class='fa fa-user'></i> Login</a></li>
      <?php
     }
     ?>
    </ul>
   </nav>
   </div>
  </header>
  <section class="section1">
 
   <h2 style="left:28.5%;"><span>You can <a href="logout.php">Logout</a> here, just follow the directions below!</span></h2>
  </section> 
  <section class="sectionlogin">
   <div class="loginsectionbody">
    <h2 style="text-align:center;color:#F64747">Logout</h2>
    <?php
    $loggedin = "If you wish to logout, please click the button below! You can leave the page if you choose not to logout.";
    $notloggedin = "It appears you are not logged in! To login please click <a href='login.php' style='color #333'>here</a>.";
    if(isset($_SESSION['steamid']))  {
      echo $loggedin;
      logoutbutton();
    } else if(!isset($_SESSION['GCSteamAuth'])) {
      echo $notloggedin;
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