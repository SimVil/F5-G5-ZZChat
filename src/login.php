<?php
include('functions.php');

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



// if action is signin -> check data and connect or reject
// if action is register -> verify uniqueness of login and write in users.txt

if($action == "Signin"){
  if(ValidUser($id, $pass) && !IsConnected($id)){
    GetConnected($id);
    //echo "hourra";
    session_start();
    $_SESSION['login'] = $id;
    $_SESSION['password'] = $pass;
    echo '<meta http-equiv="refresh" content="0;URL=chat.php">';
    exit();

  } else {
    echo '<meta http-equiv="refresh" content="0;URL=../index.php">';
    //echo "bah nan";
    exit();
    // incorporer valeur d'erreur.

  }

} else {
  if(!ExistUser($id)){
    EncodeUser($id, $pass);
    echo '<meta http-equiv="refresh" content="0;URL=../index.php?id=signin">';
    // incorporer message succes.
    //echo "ouahou ca marhce";

  } else {
    //echo "t'existe banane;";
    echo '<meta http-equiv="refresh" content="0;URL=../index.php?id=register">';
  }
}

?>
