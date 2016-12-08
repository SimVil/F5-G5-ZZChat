<?php
        
    include("functions.php");  

    $function = $_POST['function'];
    
    $log = array();
    
    switch($function) {
    
    	case('getState'):
            if(file_exists('../db/chat.txt')){
               $lines = file('../db/chat.txt');
        	}
            $log['state'] = count($lines); //log['state'] contient le nombre de lignes;
        	break;	
    	
    	case('update'):
        	$state = $_POST['state'];
        	if(file_exists('../db/chat.txt')){
        	   $lines = file('../db/chat.txt');
        	}
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
          	 
    	case('send'):
		  $nickname = htmlentities(strip_tags($_POST['nickname']));
			 $reg_exUrl = "/((http|https|ftp|ftps)\:\/\/|www)[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
			  $message = htmlentities(strip_tags($_POST['message']));
		 if(($message) != "\n"){
        	
			 if(preg_match($reg_exUrl, $message, $url)) {
       			$message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message); //pour les liens
				} 
			 
        	
        	 fwrite(fopen('../db/chat.txt', 'a'), "<span>". $nickname . "</span>" . $message = str_replace("\n", " ", $message) . "\n"); 
		 }
        	 break;
    	
    }
    
    echo json_encode($log);

?>
