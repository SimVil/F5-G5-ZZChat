<?php

/* ------------------------------------------------------------------ */
/* FILE : logout.php
 * this page handles deconnection from website.
 *
 * Author : Amin, Simon
 * ------------------------------------------------------------------ */


// getting session

	if(!isset($_SESSION)){
		session_start();
	}

	include('functions.php');

	$filename = '../db/online.txt';

	// Firstly, get the online.txt array. Then, deleting the current user
	// from the array.

	$arr = ReadOnlineArray($filename);
	unset($arr[array_search($_SESSION['login'], $arr)]);

	// Then, rewrite the array into online.txt.

	$file = fopen($filename, 'w');
	if($file){
		foreach($arr as $key => $value){
			if($value !== "" && $value !== "\n"){
				fwrite($file, $value."\n");
			}
		}
	}

	fclose($file);

	// destroying session
	session_destroy();
	unset($_SESSION);

	// get back to signin page

	echo '<meta http-equiv="refresh" content="0;URL=../index.php?id=signin">';
	exit();

?>
