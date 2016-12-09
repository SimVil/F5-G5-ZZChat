<?php
	if(!isset($_SESSION)){
		session_start();
	}
	
	include('functions.php');
	
	$filename = '../db/online.txt';
	
	$arr = ReadOnlineArray($filename);
	unset($arr[array_search($_SESSION['login'], $arr)]);
	
	$file = fopen($filename, 'w');
	if($file){
		foreach($arr as $key => $value){
			if($value !== "" && $value !== "\n"){
				fwrite($file, $value."\n");
			}
		}	
	}
	
	fclose($file);
	session_destroy();
	unset($_SESSION);
	
	echo '<meta http-equiv="refresh" content="0;URL=../index.php?id=signin">';
	exit();

?>
