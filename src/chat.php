<?php


include('functions.php');
if(!isset($_SESSION)){
	session_start();
}

$onlinefile = '../db/online.txt';

if(empty($_SESSION) || !IsConnected($_SESSION['login'], $onlinefile)){
	echo '<meta http-equiv="refresh" content="0;URL=../index.php">';
	exit();
}


if($_GET['lg'] == 'english')
{

	include('english.php');

}
else{
       if($_GET['lg'] == 'french')
       {
       include('french.php');
       }
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
      <a class="navbar-brand" href="logout.php"> <?php echo($logout) ; ?> </a>
      <a class="navbar-brand" href="#"> <?php echo $_SESSION['login'] ; ?></a>

    </nav>

    <div id="page-wrap">
	</br>
	</br>

        <h2>ZZ2 Chat</h2>

        <p id="name-area"></p>

        <div id="chat-wrap"><div id="chat-area"></div></div>

        <form id="send-message-area">
            <p><?php echo($yourmessage) ; ?></p>
	    <textarea id="sendie" maxlength = '100' ></textarea>
	    <div id="toolbar"> Toolbar : <input type="button" value=" I " onclick="javascript:insertTag('[i]','[/i]','sendie')"/> <input type="button" value="  B  " onclick="javascript:insertTag('[b]','[/b]','sendie')"/></div>
        </form>
        </br>
        </br>
		<p id="onlineppl"> <?php echo($connectedpeople) ; ?></p>
		<div id="connected"> <p></p> </br>
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

                  if (e.keyCode === 13) {

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

                  }
             });


        });


	function insertTag(startTag, endTag, textareaId) {
        var field  = document.getElementById(textareaId);
        var scroll = field.scrollTop;
        field.focus();


        if (window.ActiveXObject) {
                var textRange = document.selection.createRange();
                var currentSelection = textRange.text;
        } else {
                var startSelection   = field.value.substring(0, field.selectionStart);
                var currentSelection = field.value.substring(field.selectionStart, field.selectionEnd);
                var endSelection     = field.value.substring(field.selectionEnd);
        }
	if (window.ActiveXObject) {

                textRange.text = startTag + currentSelection + endTag;

                textRange.moveStart("character", -endTag.length - currentSelection.length);

                textRange.moveEnd("character", -endTag.length);

                textRange.select();

        } else {

                field.value = startSelection + startTag + currentSelection + endTag + endSelection;

                field.focus();

                field.setSelectionRange(startSelection.length + startTag.length, startSelection.length + startTag.length + currentSelection.length);

        }


        field.scrollTop = scroll;

}



    </script>

</body>

</html>
