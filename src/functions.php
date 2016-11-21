
<?php

/* --------------------------------------------------------------------
 * FILE : functions.php 
 * 
 * Author : Amin, Simon
 * ------------------------------------------------------------------ */



/* ================================================================== */
/* 
 * 
 * 
 *                                                                    */
/* ================================================================== */

function DecodeFile($filename){
  $users = file_get_contents($filename, false, NULL);
  $arr = json_decode($users, true);
  return $arr;

}



function ExistUser($log){
  $arr = DecodeFile('../db/users.txt');
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



function ValidUser($log, $pwd){
  $arr = DecodeFile('../db/users.txt');

  $tmp = array("login" => "$log", "pass" => "$pwd");
  return !(!$arr || array_search($tmp, $arr) === false);

}



function IsConnected($log){
  $data = file_get_contents('../db/online.txt', false, NULL);
  $result = false;

  if($data){
    $arr = explode("\n", $data);
    $result = !(array_search($log, $arr) === false);
  }

  return $result;

}



function GetConnected($log){
  $filename = fopen('../db/online.txt', 'a');
  if($filename){
    fwrite($filename, $log."\n");
    fclose($filename);
  }

}



function EncodeUser($log, $pwd){
  $arr = DecodeFile('../db/users.txt');

  if(!$arr){
    $arr[] = array("login" => "$log", "pass" => "$pwd");
  } else {
    array_push($arr, array("login" => "$log", "pass" => "$pwd"));

  }

  $json_arr = json_encode($arr);
  file_put_contents('../db/users.txt', $json_arr);

}


 ?>
