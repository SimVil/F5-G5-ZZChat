<?php
	if(!isset($_SESSION)){
		session_start();
	}
	
	include('functions.php');
	
	$filename = '../db/online.txt';
	
	$arr = ReadOnlineArray($filename);
	unset($arr[array_search($_SESSION['login'])]);
	
	$file = fopen($filename, 'w');
	if($file){
		foreach($arr as $key => $value){
			fwrite($filename, $value."\n");
		}	
	}
	
	fclose($filename);
	$_SESSION = array();
	session_destroy();
	
	//echo '<meta http-equiv="refresh" content="0;URL=../index.php?id=signin">';
	exit();

?>
