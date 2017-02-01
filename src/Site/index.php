<?php
  include "steamauth/steamauth.php";
?>
<html>
 <head>
  <title>Home | GarrysModCloud</title>
  <meta charset="utf-8">
  <meta name="description" content="PLACEHOLDER">
  <meta name="author" content="GarrysmodCloud">
  <meta name="viewport" content="initial-scale=1">
  <meta name="keywords" content="PLACEHOLDER">
  <meta name="robots" content="selection">
  <meta name="revisit-after" content="periode">
  <link rel="shortcut icon" href="assets/img/favicon_final.ico" type="image/x-icon">
  <link rel="icon" href="assets/img/favicon_final.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="assets/css/960.css">
  <link rel="stylesheet" type="text/css" href="assets/css/normalize.css">
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/theme.css">
  <script type="text/javascript" src="assets/javascript/jquery.js"></script>
  <!--[if lt IE 9]>
  <script src="assets/javascript/html5shiv.min.js"></script>
  <![endif]-->
 </head>
 <body>
  <header class="clearfix">
   <div class="container_12">
   <div class="logo"><a href="index.php"><img src="assets/img/logolong2.png"></a></div>
   <a href="#" class="resToggle">☰</a>
   <nav class="the-nav">
    <ul>
     <?php
     if(!isset($_SESSION['steamid'])) {
      ?>
      
      <li><a href='http://steamcommunity.com/sharedfiles/filedetails/?id=323125115'><i class='fa fa-download'></i> Install</a></li>
      <li><a href='profile/login.php'><i class='fa fa-user'></i> Login</a></li>
      <?php
     } else {
      ?>
   
      <li><a href='#'><i class='fa fa-arrow-up'></i> Upload</a></li>
      <li><a href='profile/files.php'><i class='fa fa-cloud'></i> My Files</a></li>
      <li><a href='#'><i class='fa fa-arrow-down'></i> Downloads</a></li>
      <li><a href='http://steamcommunity.com/sharedfiles/filedetails/?id=323125115'><i class='fa fa-download'></i> Install</a></li>
      <li><form input type="hidden" action=\"steamauth/logout.php\" method=\"post\"><a href='steamauth/logout.php' action='steamauth/logout.php' input value=\"\"><i class='fa fa-user'></i> Logout</a></li></form>
      <?php
     }
     ?>
    </ul>
   </nav>
   </div>
  </header>
  <section id="hero">
   <div id="mast">
    <h1><img src="assets/img/logoSection2.png"></h1>
    <h2>The first 3rd party cloud for garrysmod</h2>
    <a href="http://steamcommunity.com/sharedfiles/filedetails/?id=323125115"><button><i class="fa fa-download"></i> Download</button></a>
   </div>
   <div style="color: #F5F5F5;text-shadow: 1px 0 0 #000, 0 -1px 0 #000, 0 1px 0 #000, -1px 0 0 #000;" class="arrow"><a style="color: #F5F5F5" data-scroll data-speed="750" data-easing="easeInOutCubic" data-url="false" href="#section2"><i class="fa fa-angle-double-down"></i></a></div>
  </section>
  <section id="section2">
   <div class="container_12">
    <div class="grid_4">
     <div class="circle1" style="margin: 0 auto"></div>
      <p style="margin: 0 auto;padding-top:10px">We offer you the most secure way in storing your files, and we have a simple method of doing so.</p>
     </div>
    <div class="grid_4">
     <div class="circle2" style="margin: 0 auto"></div>
      <p style="margin: 0 auto;padding-top:10px">You can download them on the go! You can login from a different computer and choose to download whichever creation you want!</p>
     </div>
    <div class="grid_4">
     <div class="circle3" style="margin: 0 auto"></div>
      <p style="margin: 0 auto;padding-top:10px">We offer to secure your files for you, and give you the abilty to download them wherever. All for free!</p>
     </div>
    </div>
  </section>
  <!--<section class="section3">
   <footer>
    <p>Copyright © 2014 - 20<?php echo date(y)?> Company, All rights reserved.</p>
   </footer>
  </section>-->
  <script type="text/javascript">
  $('.resToggle').click(function(){
  $('.the-nav').toggleClass('active');
  });
  </script>
 </body> 
</html>