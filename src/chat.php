<?php
include('functions.php');
session_start();
if(empty($_SESSION) || !IsConnected($_SESSION['login'])){
	echo '<meta http-equiv="refresh" content="0;URL=../index.php">';
	exit();
}
?>


<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Chat</title>
	<link rel="stylesheet" href="../static/css/bootstrap.css">
	<link rel="stylesheet" href="../static/css/stylesheet.css">
    <link rel="stylesheet" href="../static/css/chatcss.css" type="text/css" />

</head>

<body onload="setInterval('chat.update()', 5000); setInterval('chat.connected()',5000)">

    <nav class="navbar navbar-fixed-top">
      <a class="navbar-brand" href="logout.php"> Log-out </a>
      <a class="navbar-brand" href="#"> <?php echo $_SESSION['login'] ?></a>

    </nav>

    <div id="page-wrap">

        <h2>ZZ2 Chat</h2>

        <p id="name-area"></p>

        <div id="chat-wrap"><div id="chat-area"></div></div>

        <form id="send-message-area">
            <p>Your message: </p>
            <input id="sendie" maxlength = '100' >
        </form>
        <div id="connected"> <p> Connected People :</p>
		</div>

    </div>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="../static/js/chat.js"></script>
    <script type="text/javascript">


        var name = '<?php echo $_SESSION['login']; ?>' ;

        // display name on page
        $("#name-area").html("You are: <span>" + name + "</span>");

        // kick off chat
        var chat =  new Chat();

        $(function() {

             chat.update(); //if there's old messages

             chat.getState();

             chat.connected();

             // watch textarea for key presses
             $("#sendie").keydown(function(event) {

                 var key = event.which;

                 //all keys including return.
                 if (key >= 33) {

                     var maxLength = $(this).attr("maxlength");
                     var length = this.value.length;

                     // don't allow new content if length is maxed out
                     if (length >= maxLength) {
                         event.preventDefault();
                     }
                  }
                                                                                                                                                                                                            });
             // watch textarea for release of key press
             $("#sendie").keyup(function(e) {

                  if (e.keyCode == 13) {

                    var text = $(this).val();
                    var maxLength = $(this).attr("maxlength");
                    var length = text.length;

                    // send
                    if (length <= maxLength + 1) {

                        chat.send(text, name);
                        $(this).val(""); //delete the message after sending it

                    } else {

                        $(this).val(text.substring(0, maxLength));

                    }

                    $('#chat-area').load('../db/chat.txt');


                  }
             });


        });
    </script>

</body>

</html>
