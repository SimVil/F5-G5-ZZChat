<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Chat</title>
	<link rel="stylesheet" href="../static/css/bootstrap.css">
	<link rel="stylesheet" href="../static/css/stylesheet.css">
    <link rel="stylesheet" href="../static/css/chatcss.css" type="text/css" />
    
</head>

<body>
    <nav class="navbar navbar-fixed-top">
      <a class="navbar-brand" href="logout.php"> Log-out </a>
      <a class="navbar-brand" href="#"> <?php echo $_SESSION['login'] ?></a>

    </nav>
    
    <div class="chat-area" id="conversation"></div><br />
    
    <form action="#" method="POST">
		<input type="text" id="message" />
		<input type="submit" value="SendMessage" />
		<button type="button" value="B" onclick="Bold()"> <b> B </b> </button>
		<button type="button" value="I" onclick="Italic()"> <i> I</i> </button>
    </form>

	<script> </script>

</body>
