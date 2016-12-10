<?php

/* --------------------------------------------------------------------
 * FILE : login.php
 * Manage connexion and file-based database for connexion.
 *
 * Author : Amin, Simon
 * ------------------------------------------------------------------ */

include('functions.php');
$langzzchat = $_GET['lg'];

// if lg is defined in get, we use it to set the whole website language
if($langzzchat == 'english'){
	include('english.php');
} else {
	include('french.php');
}

// testing existence of required data

$idv = isset($_POST['login']) && !empty($_POST['login']);
$passv = isset($_POST['password']) && !empty($_POST['password']);
$actionv = isset($_POST['action']) && !empty($_POST['action']);

// if one of the parameters is not defined or empty -> redirection to index.php

if(!$idv || !$passv || !$actionv){
  echo '<meta http-equiv="refresh" content="0;URL=../index.php">';
  exit();
}

// Get data from the previous POST method, coming from either
// sign-in or register.

// /!\ : values 'login', 'password' and 'action' refers to the <name> attribute
// /!\   of the html tags in form structure.

$id = $_POST['login'];
$pass = $_POST['password'];
$action = $_POST['action'];

$usersfile = '../db/users.txt';
$onlinefile = '../db/online.txt';

// if action is signin -> check data and connect or reject
// if action is register -> verify uniqueness of login and write in users.txt

// if action is signin, if data are valid and the user is not connected, we
// connect him, and start a session and a cookie for the next sign. It is an
// error if those data are not valid.

if($action == $signinbar){
		if(ValidUser($id, $pass, $usersfile) && !IsConnected($id, $onlinefile)){
				GetConnected($id, $onlinefile);
				if(!isset($_SESSION)){
						session_start();
				}

				$_SESSION['login'] = $id;
				$_SESSION['password'] = $pass;
				setcookie('login', $id, time() + 3600, '/', null, false, true);

				echo '<meta http-equiv="refresh" content="0;URL=chat.php?lg='.$langzzchat.'">';
				exit();

		} else {
				echo '<meta http-equiv="refresh" content="0;URL=../index.php?id=signin&err=signerr">';
				exit();

		}

} else {
// if action is register, if data are valid according to regex, if the user
// does not exist, it is added to database. Else it is an error.

  if(checkVarReg($pass) && checkVarReg($id) && !ExistUser($id, $usersfile)){
    EncodeUser($id, $pass, $usersfile);
    echo '<meta http-equiv="refresh" content="0;URL=../index.php?id=signin&err=regv">';

  } else {
    echo '<meta http-equiv="refresh" content="0;URL=../index.php?id=register&err=regerr">';

  }

}

?>
