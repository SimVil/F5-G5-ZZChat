
<!DOCTYPE html>
<html lang="fr-FR">

	<head>
		<title> answer </title>
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="stylesheet.css">

	</head>

	<body>
	<div class="main">

		<!-- Navigation Bar -->

		<nav class="navbar navbar-fixed-top">

			<a class="navbar-brand" href="Index.php"> Home </a>
			<a class="navbar-brand" href="Chat.php"> Chat </a>
			<a class="navbar-brand" href="Infos.php"> CV-R&eacute;sum&eacute; </a>
			<a class="navbar-brand" href="Contact.php"> Contact </a>


		</nav>

    <div class="container">

      <?php
        include("functions.php");

        $login = $_POST["login"];
        $pass = $_POST["password"];

        if(LoginInfoCheck($login, $pass)){
					echo "Les donnees sont valides <br/>";
					$file = fopen("pouet.txt", "w");
					fwrite($file, "mouibouiboui");
					fclose($file);

				} else {
				    die("this is the end for you");

				}

       ?>

    </div>


	</div>

	</body>



</html>
