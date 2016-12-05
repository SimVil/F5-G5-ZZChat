
<!-- ==========================================================================
index.php file :
  main file for ZZChat website

AUTHORS : Amin, Simon
DATE    : 2016.

============================================================================ -->

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
<<<<<<< HEAD
  <meta charset="UTF-8" >
=======
  <meta charset="UTF-8">
>>>>>>> connection

</head>



<!-- ==========================================================================
body marker :
 We use php to include sign-in or sign-up pages.

============================================================================ -->

<body>
  <div class="main">

    <!-- Navigation bar -->
    <!-- to be improved : get 'a' tags into a list -->
    <!-- beware of css modifications -->


    <nav class="navbar navbar-fixed-top">
      <a class="navbar-brand" href="index.php?id=register"> Register </a>
      <a class="navbar-brand" href="index.php?id=signin"> Sign-in </a>

    </nav>



    <!-- PHP inclusion script -->

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
          echo "1";
          break;

        case 'signin':
          include($signin);
          echo "2";
          break;

        default:
          include($signin);
          echo "default";
          break;

      }

    ?>


  </div>


</body>


</html>
