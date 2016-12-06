
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
/* Input  : a login
 * Output : true if the user is connected, false if not.
 *
 * Test if a user si connected or not.
 * ------------------------------------------------------------------ */

function IsConnected($log){
  $data = file_get_contents('../db/online.txt', false, NULL);
  $result = false;

  if($data){
    $arr = explode("\n", $data);
    $result = !(array_search($log, $arr) === false);
  }

  return $result;

}



/* -------- GetConnected -------------------------------------------- */
/* Input  : a login
 * Output : true if connection succeeded, false otherwise.
 *
 * Get an user connected, if it is not already.
 * ------------------------------------------------------------------ */

function GetConnected($log){
  $filename = fopen('../db/online.txt', 'a');
  $result = false;

  if($filename && !IsConnected($log)){
    fwrite($filename, $log."\n");
    fclose($filename);
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

  if(!$arr){
    $arr[] = array("login" => "$log", "pass" => "$coded_pwd");
    $result = true;

  } else {
  	if(array_search($log, $arr) === false){
  		array_push($arr, array("login" => "$log", "pass" => "$coded_pwd"));
  		$result = true;

  	}

  }

  $json_arr = json_encode($arr);
  file_put_contents($filename, $json_arr);
  return $result;

}



/* -------- smileys ------------------------------------------------- */
/* Input  : a text with written smileys
 * Output : the text with replaced smileys
 *
 * Given a text, replace each occurence of a smiley with a real one.
 * ------------------------------------------------------------------ */

function smileys($text) {
  $smileys = array(":)",";)","^^",":@",":'(",":p",":(");
  $paths = array("./emoticons/smiley.png","./emoticons/wink.png","./emoticons/content.png","./emoticons/angry.gif","./emoticons/pleure.png","./emoticons/tongue.png","./emoticons/triste.png");
  for($i=0;$i<count($smileys);$i++) {
    $text = str_replace($smileys[$i],'<img  src='.$paths[$i].'>',$text);
    }
  return $text ;
}

 ?>
