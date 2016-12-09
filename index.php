
<!-- ==========================================================================
index.php file :
  main file for ZZChat website

AUTHORS : Amin, Simon
DATE    : 2016.

============================================================================ -->

<?php
include('src/functions.php');

if(!isset($_SESSION)){
	session_start();
}

if(isset($_SESSION) && !empty($_SESSION)){
	if(isset($_SESSION['login']) && IsConnected($_SESSION['login'], './db/online.txt')){
		echo '<meta http-equiv="refresh" content="0;URL=src/chat.php">';
		die();
	}
}

session_destroy();

?>

<!DOCTYPE html>
<html lang="fr-FR">



<!-- ==========================================================================
head marker :
  - define page name
  - refers to needed stylesheets

To avoid loading issues, js files are included at the end of the document
(so that it will be loaded at the end).

============================================================================ -->

<head>
  <title> ZZChat </title>
  <link rel="stylesheet" href="static/css/bootstrap.css">
  <link rel="stylesheet" href="static/css/stylesheet.css">
  <meta charset="UTF-8" >

</head>



<!-- ==========================================================================
body marker :
 We use php to include sign-in or sign-up pages.

============================================================================ -->

<body>
  <div class="main">

    <nav class="navbar navbar-fixed-top">
      <a class="navbar-brand" href="index.php?id=register"> Register </a>
      <a class="navbar-brand" href="index.php?id=signin"> Sign-in </a>

    </nav>

    <?php

      include('src/functions.php');

      $signin = 'src/sign-in.php';
      $register = 'src/register.php';
      $id = '0';
      if(isset($_GET['id'])){
        $id = $_GET['id'];

      }

      switch($id){
        case 'register':
          include($register);
          break;

        case 'signin':
          include($signin);
          break;

        default:
          include($signin);
          break;

      }

    ?>


  </div>


</body>


</html>
