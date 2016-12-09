
<?php

/* --------------------------------------------------------------------
 * FILE : functions.php
 * stands for all the short php functions we will use over the website
 *
 * Author : Amin, Simon
 * ------------------------------------------------------------------ */



/* -------- DecodeFile ---------------------------------------------- */
/* Input  : a file name
 * Output : an array decoded from the file
 *
 * Proceed to decoding an array from a file in json format. The file
 * shall contain names and password of each users
 * ------------------------------------------------------------------ */

function DecodeFile($filename){
  $users = file_get_contents($filename, false, NULL);
  $arr = json_decode($users, true);
  return $arr;

}



/* -------- ExistUser ----------------------------------------------- */
/* Input  : a login, a file name
 * Output : true whenever the user has been found, false otherwise.
 *
 * Check whether a given user exist in the database.
 * ------------------------------------------------------------------ */

function ExistUser($log, $filename){
  $arr = DecodeFile($filename);
  $found = false;
  if($arr){
    foreach($arr as $key => $value){
      $found = ($value["login"] == $log);
      if($found){
        break;
      }
    }
  }

  return $found;

}



/* -------- ValidUser ----------------------------------------------- */
/* Input  : a login, a password, a filename
 * Output : true if data are valid, false otherwise.
 *
 * Verify that log and pwd are joint in database, that is, the username
 * and the password given are valid.
 * ------------------------------------------------------------------ */

function ValidUser($log, $pwd, $filename){
  $arr = DecodeFile($filename);
  $coded_pwd = hash("sha256", "$pwd");
  $tmp = array("login" => "$log", "pass" => "$coded_pwd");
  return !(!$arr || array_search($tmp, $arr) === false);

}



/* -------- IsConnected --------------------------------------------- */
/* Input  : a login, a filename
 * Output : true if the user is connected, false if not.
 *
 * Test if a user si connected or not.
 * ------------------------------------------------------------------ */

function IsConnected($log, $filename){
  $arr = ReadOnlineArray($filename);
  $result = false;

  if($arr){
    $result = !(array_search($log, $arr) === false);
  }

  return $result;

}




/* -------- ReadOnlineArray ----------------------------------------- */
/* Input  : a filename
 * Output : an array containing online users
 *
 * Get the list of online users.
 * ------------------------------------------------------------------ */

function ReadOnlineArray($filename){
	$data = file_get_contents($filename, false, NULL);
	$arr = NULL;
	
	if($data){
		$arr = explode("\n", $data);
	}
	
	return $arr;
}



/* -------- GetConnected -------------------------------------------- */
/* Input  : a login, a filename
 * Output : true if connection succeeded, false otherwise.
 *
 * Get an user connected, if it is not already.
 * ------------------------------------------------------------------ */

function GetConnected($log, $filename){
  $file = fopen($filename, 'a');
  $result = false;

  if($file && !IsConnected($log, $filename)){
    fwrite($file, $log."\n");
    fclose($file);
    $result = true;

  }

  return $result;

}



/* -------- EncodeUser ---------------------------------------------- */
/* Input  : a login, a password, a filename
 * Output : true for success, false for fail.
 *
 * Write the new user into the database file.
 * ------------------------------------------------------------------ */

function EncodeUser($log, $pwd, $filename){
  $arr = DecodeFile($filename);
  $result = false;
  $coded_pwd = hash("sha256", "$pwd");
  $item = array("login" => "$log", "pass" => "$coded_pwd");

  if(!$arr){
    $arr[] = $item;
    $result = true;

  } else {
  	//if(array_search($log, array_column($arr, 'login')) === false){
  	if(array_find($arr, $log) === false){
  		array_push($arr, $item);
  		$result = true;

  	}   
  }

  $json_arr = json_encode($arr);
  file_put_contents($filename, $json_arr);
  return $result;

}




/* -------- array_find ---------------------------------------------- */
/* Input  : an bi-dimensionnal array, a value to find
 * Output : true for success, false for fail.
 *
 * Find a value (or not) into an array.
 * ------------------------------------------------------------------ */

function array_find($arr, $var){
	$count = count($arr);
	$i = 0;
	$found = false;
	while($i < $count && $found === false){
		$found = array_search($var, $arr[$i]);
		$i = $i + 1;
	}
	
	return $found;
}



/* -------- smileys ------------------------------------------------- */
/* Input  : a text with written smileys
 * Output : the text with replaced smileys
 *
 * Given a text, replace each occurence of a smiley with a real one.
 * ------------------------------------------------------------------ */

function smileys($text) {
  $smileys = array(":)",";)","^^",":@",":'(",":p",":(");
  $paths = array("../static/emoticons/smiley.png","../static/emoticons/wink.png","../static/emoticons/content.png","../static/emoticons/angry.gif","../static/emoticons/pleure.png","../static/emoticons/tongue.png","../static/emoticons/triste.png");
  for($i=0;$i<count($smileys);$i++) {
    $text = str_replace($smileys[$i],'<img  src='.$paths[$i].'>',$text);
    }
  return $text ;
}



/* -------- checkVarReg --------------------------------------------- */
/* Input  : a variable to be checked
 * Output : true of false according to the result
 *
 * try to match $var with a given pattern.
 * ------------------------------------------------------------------ */

function checkVarReg($var){
	$pattern = '/^(?=.*[a-z])[0-9A-Za-z]{5,15}/$';
	return (preg_match($pattern, $var);
	
	
}


 ?>

