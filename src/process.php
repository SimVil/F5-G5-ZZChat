<?php


/* --------------------------------------------------------------------
 * FILE : process.php
 * Gets the Ajax requests and treats them according to the function
 *
 * Author : Simon, Amin
 * ------------------------------------------------------------------ */


    include("functions.php");  

    $function = $_POST['function'];
    
    $log = array();
    
    switch($function) {
    
    	case('getState'):
            if(file_exists('../db/chat.txt')){
               $lines = file('../db/chat.txt');
               $connected = file('../db/online.txt');
        	}
            $log['state'] = count($lines); //log['state'] contains the number of lines in db/chat.txt file
            $log['onlinepeople'] = count($connected); //log['connected'] contains the number of lines in db/online.txt;
        	break;	
    	
    	case('update'):
        	$state = $_POST['state']; //contains the number of lines that were in db/chat.txt from the last request
        	//if(file_exists('../db/chat.txt')){ //No need for it but uh just to let you know david that we ain't playing around !!!
        	   $lines = file('../db/chat.txt');
        	//}
        	$count =  count($lines);
		//if there's aren't new lines in db/chat.txt then there's no new messages
        	if($state == $count){
        		$log['state'] = $state; //don't change the number saved in log['state']
        		$log['text'] = false; //there's no new messages
        		 
        	}
		//if there are new messages
        	else{ 
        		$text= array();
        		$log['state'] = count($lines) ; //save the new number of lines added
        		foreach ($lines as $line_num => $line)
                {
                    
        			$text[] =  $line ; //save the content in an array

        				
                }
        			 $log['text'] = smileys($text); //translating emoticons
        	}
        	  
             break;
        case('getonline'):
        
		$online = $_POST['online']; //contains the number of online people online from the last request
        	//if(file_exists('../db/chat.txt')){ //No need for it but uh just to let you know david that we ain't playing around !!!
        	   $connected = file('../db/online.txt'); 
        	//}
        	$onlinelines =  count($connected); //gets the present number of online people
		//if there aren't new online people
        	if($online == $onlinelines){
        		$log['onlinepeople'] = $onlinelines; //doesn't change the number of online people
        		$log['connected'] = false; //no one is recently connected
        		 
        	}
        	else{
			$diff = $onlinelines - $online; //the new ones
        		$persons= array();
        		foreach ($connected as $online_num => $onlineline)
                	{
                    
        			$persons[] =  $onlineline ; //save the names in an array

        				
                	}
        			 $log['connected'] = $persons; //contains the names this time and not false
        			 $log['onlinepeople'] = $onlinelines; //new number of online people
        			 $log['diff']= $diff; //difference since last time
        	}
			
         
         break; 	
    	case('send'):
		  $nickname = htmlentities(strip_tags($_POST['nickname'])); //strip tags from the nickname for security purposes
		    	 //regular expressions : 1st for URLs 2nd for strong texts and the last for italic
			 $reg_exUrl = "/((http|https|ftp|ftps)\:\/\/|www)[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
			 $reg_bbcode = '#\[b\](.*)\[/b\]#Usi';
			 $reg_iicode = '#\[i\](.*)\[/i\]#Usi';
			 $message = htmlentities(strip_tags($_POST['message'])); //strip tags from the message aswell
		 //don't send blank messages that contains just spacebars
		 if(($message) != "\n"){ 
        		//replace the regular expression above in the message
			if(preg_match($reg_exUrl, $message, $url)) { //for URLs
       			$message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message); //pour les liens
			} 
			if(preg_match($reg_bbcode, $message, $url)) { //for strong texts
			$message = preg_replace($reg_bbcode,'<strong>$1</strong>', $message);
			}
	
			if(preg_match($reg_iicode, $message, $url)) { //for italic texts
			$message = preg_replace($reg_iicode,'<i>$1</i>', $message);
			}
	
        	
        	 fwrite(fopen('../db/chat.txt', 'a'), "<span>". $nickname . "</span>" . $message = str_replace("\n", " ", $message) . "\n"); 
		 }
        	 break;
    	
    }
    
    echo json_encode($log);

?>
