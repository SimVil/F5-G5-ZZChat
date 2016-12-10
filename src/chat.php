<?php

/* --------------------------------------------------------------------
 * FILE : chat.php
 * Contains the structure of the chat page plus the Ajax request coded 
 * in chat.js and sent to process.php to treat
 *
 * Author : Simon, Amin
 * ------------------------------------------------------------------ */

include('functions.php');
//if there's no session then start one
if(!isset($_SESSION)){
	session_start();
}

$onlinefile = '../db/online.txt';
//redirect anyone that is trying to reach this page without login-in
if(empty($_SESSION) || !IsConnected($_SESSION['login'], $onlinefile)){
	echo '<meta http-equiv="refresh" content="0;URL=../index.php">';
	exit();
}

//gets the langage sent via the GET methode and include the right php file
//the langage is chosen in the index and is english by default
if($_GET['lg'] == 'french')
{
	include('french.php');
}
else{
        include('english.php');
}



?>


<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ChatZZ2</title>
		<link rel="stylesheet" href="../static/css/bootstrap.css">
		<link rel="stylesheet" href="../static/css/stylesheet.css">
  	<link rel="stylesheet" href="../static/css/chatcss.css" type="text/css" />

</head>

<body onload="setInterval('chat.update()', 5000); setInterval('chat.connected()',5000)">

    <nav class="navbar navbar-fixed-top">
      <a class="navbar-brand" href="logout.php"> <?php echo($logout) ; ?> </a> <!-- printing Log-out according to the language -->
      <a class="navbar-brand" href="#"> <?php echo $_SESSION['login'] ; ?></a> <!-- printing the nickname -->

    </nav>

    <div id="page-wrap">
	</br>
	</br>

        <h2>ZZ2 Chat</h2>

        <p id="name-area"></p>

        <div id="chat-wrap"><div id="chat-area"></div></div>

        <form id="send-message-area">
            <p><?php echo($yourmessage) ; ?></p> <!-- printing "Your Message :" or "Ton Message :" according the language -->
	    <textarea id="sendie" maxlength = '100' ></textarea>
	    <div id="toolbar"> Toolbar : <input type="button" value=" I " onclick="javascript:insertTag('[i]','[/i]','sendie')"/> <input type="button" value="  B  " onclick="javascript:insertTag('[b]','[/b]','sendie')"/></div>
        </form>
        </br>
        </br>
		<p id="onlineppl"> <?php echo($connectedpeople) ; ?></p> <!-- printing "Connected People" or "Personne Connectees" according the language -->
		<div id="connected"> <p></p> </br> <!-- div that shows online people -->
		</div>

    </div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="/~ahnahhas/static/js/chat.js"></script>
    <script type="text/javascript">


        var name = '<?php echo $_SESSION['login'] ; ?>';

        // display name on page
        //$("#name-area").html("You are: <span>" + name + "</span>");

        // kick off chat
        var chat =  new Chat();
	//
        $(function() {

             chat.update(); //if there are old messages, so we update the chat first


             chat.getState(); //gets the number of messages and the number of online people

             chat.connected(); //update the list of people connected in the chat

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

                  if (e.keyCode === 13) {

                    var text = $(this).val();
                    var maxLength = $(this).attr("maxlength");
                    var length = text.length;

                    // send the message
                    if (length <= maxLength + 1) {

                        chat.send(text, name);
                        $(this).val(""); //delete the message after sending it

                    } else {

                        $(this).val(text.substring(0, maxLength));

                    }

                  }
             });


        });

	//function that inserts specific tags on the textarea onclick
	function insertTag(startTag, endTag, textareaId) {
        var field  = document.getElementById(textareaId); //field variable gets the textarea
        var scroll = field.scrollTop;
        field.focus();


        if (window.ActiveXObject) { //for internet explorer
                var textRange = document.selection.createRange();
                var currentSelection = textRange.text;
        } else { // for other navigators
                var startSelection   = field.value.substring(0, field.selectionStart); //select the start of the field
                var currentSelection = field.value.substring(field.selectionStart, field.selectionEnd);
                var endSelection     = field.value.substring(field.selectionEnd); //select the end of the field
        }
	if (window.ActiveXObject) { //for internet explorer

                textRange.text = startTag + currentSelection + endTag;

                textRange.moveStart("character", -endTag.length - currentSelection.length);

                textRange.moveEnd("character", -endTag.length);

                textRange.select();

        } else { //for other navigators

                field.value = startSelection + startTag + currentSelection + endTag + endSelection;

                field.focus();

                field.setSelectionRange(startSelection.length + startTag.length, startSelection.length + startTag.length + currentSelection.length);

        }


        field.scrollTop = scroll;

}



    </script>

</body>

</html>
