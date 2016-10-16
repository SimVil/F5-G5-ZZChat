
<!DOCTYPE html>
<html lang="fr-FR">

	<head>
		<title> ZZChat </title>
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

			<!--
				fc.isima.fr/~vilminsi/index.html
				proposer le login que le mec a mis la derniere fois -> cookie
       -->

		</nav>


		<!-- Login container -->

		<div class="container">

			<div class="row">
				<div class="col-md-12">

					<form class="form-signin" action="sign-in.php" method="post">
						<h1 class="form-heading"> ZZ-Chat </h1>
							<div class="form-input-text">
								<input type="text" class="valid" name="login" id="login" placeholder="Login"/>
								<br>

								<input type="password" class ="valid" name="password" id="password" placeholder="Password"/>
								<br>

							</div>

							<div class="form-input-submit">
								<input type="submit" id="signin" value="Sign in"/>

							</div>

					</form>

				</div>
			</div>
		</div>

	</div>
    <script type="text/javascript" src="DynamicValidation.js"></script>

	</body>

</html>
