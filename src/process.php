<?php
        
    include("functions.php");  

    $function = $_POST['function'];
    
    $log = array();
    
    switch($function) {
    
    	case('getState'):
            if(file_exists('../db/chat.txt')){
               $lines = file('../db/chat.txt');
               $connected = file('../db/online.txt');
        	}
            $log['state'] = count($lines); //log['state'] contient le nombre de lignes du chat.txt;
            $log['onlinepeople'] = count($connected); //log['connected'] le nombre de lignes du online.txt;
        	break;	
    	
    	case('update'):
        	$state = $_POST['state'];
        	//if(file_exists('../db/chat.txt')){ //No need for it but uh just to let you know david that we ain't playing around !!!
        	   $lines = file('../db/chat.txt');
        	//}
        	$count =  count($lines);
        	if($state == $count){
        		$log['state'] = $state;
        		$log['text'] = false;
        		 
        	}
        	else{
        		$text= array();
        		$log['state'] = count($lines) ;
        		foreach ($lines as $line_num => $line)
                {
                    
        			$text[] =  $line ;

        				
                }
        			 $log['text'] = smileys($text); 
        	}
        	  
             break;
        case('getonline'):
        
			$online = $_POST['online'];
        	//if(file_exists('../db/chat.txt')){ //No need for it but uh just to let you know david that we ain't playing around !!!
        	   $connected = file('../db/online.txt');
        	//}
        	$onlinelines =  count($connected);
        	if($online == $onlinelines){
        		$log['onlinepeople'] = $onlinelines;
        		$log['connected'] = false;
        		 
        	}
        	else{
				$diff = $onlinelines - $online;
        		$persons= array();
        		foreach ($connected as $online_num => $onlineline)
                {
                    
        			$persons[] =  $onlineline ;

        				
                }
        			 $log['connected'] = $persons; 
        			 $log['onlinepeople'] = $onlinelines;
        			 $log['diff']= $diff;
        	}
			
         
         break; 	
    	case('send'):
		  $nickname = htmlentities(strip_tags($_POST['nickname']));
			 $reg_exUrl = "/((http|https|ftp|ftps)\:\/\/|www)[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
			 $reg_bbcode = '#\[b\](.*)\[/b\]#Usi';
			 $reg_iicode = '#\[i\](.*)\[/i\]#Usi';
			  $message = htmlentities(strip_tags($_POST['message']));
		 if(($message) != "\n"){
        	
			 if(preg_match($reg_exUrl, $message, $url)) {
       			$message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message); //pour les liens
				} 
			if(preg_match($reg_bbcode, $message, $url)) { //pour les gras
			$message = preg_replace($reg_bbcode,'<strong>$1</strong>', $message);
			}
	
			if(preg_match($reg_iicode, $message, $url)) { //pour l'italique
			$message = preg_replace($reg_iicode,'<i>$1</i>', $message);
			}
	
        	
        	 fwrite(fopen('../db/chat.txt', 'a'), "<span>". $nickname . "</span>" . $message = str_replace("\n", " ", $message) . "\n"); 
		 }
        	 break;
    	
    }
    
    echo json_encode($log);

?>
