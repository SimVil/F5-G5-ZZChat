<?php

/* --------------------------------------------------------------------
 * FILE : index.php
 * main file for register and signin
 *
 * Author : Amin, Simon
 * ------------------------------------------------------------------ */

include('src/functions.php');

// we use a session here to handle the following :
// imagine an user connects, and so get rerouted to the chat page. If he
// destroys the chat's window, and try to come back to index, initialize
// session, and then testing it, will directly reroute the user to the chat
// page since he is still connected.

// if the session is empty, it then means that there is nobody connected
// by this browser, and the session is destroyed at the end.

if(!isset($_SESSION)){
	session_start();
}

// is an user connected ? If so, rerouting to chat.php. We pursue execution
// otherwise.

if(isset($_SESSION) && !empty($_SESSION)){
	if(isset($_SESSION['login']) && IsConnected($_SESSION['login'], './db/online.txt')){
		echo '<meta http-equiv="refresh" content="0;URL=src/chat.php">';
		die();
	}
}

// if the cookie is not set, we define english as a default language
if(!isset($_COOKIE['langzzchat'])){
	$_COOKIE['langzzchat'] = 'english';
	include('./src/english.php');
}

// if a parameter for language is defined, we use it as the language
if(isset($_GET['lg'])){
	  $_COOKIE['langzzchat'] = $_GET['lg'] ;
}


// depending on the chosen language, we include the related namespace
switch($_COOKIE['langzzchat']){
		case 'english':
				include('./src/english.php');
				break;

		case 'french':
				include('./src/french.php');
				break;
}


// in this case, no one is connected, we destroy the arbitrary session we
// created though
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

		<?php
		// depending on the language, we display the appropriate text with a cookie
		// set above
		?>

    <nav class="navbar navbar-fixed-top">
      <a class="navbar-brand" href="index.php?id=register&lg=<?php echo($_COOKIE['langzzchat']); ?>" > <?php echo($registerbar); ?></a>
      <a class="navbar-brand" href="index.php?id=signin&lg=<?php echo($_COOKIE['langzzchat']); ?>"> <?php echo($signinbar); ?> </a>
    </nav>

    <?php

			include('src/functions.php');

			$signin = 'src/sign-in.php';
			$register = 'src/register.php';
			$id = '0';

			if(isset($_GET['id'])){
					$id = $_GET['id'];
			}

			// depending on the id required, we display the chosen page.

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
