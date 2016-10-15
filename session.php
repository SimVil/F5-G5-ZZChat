<?php 
session_start();
function IsClient($id,$pwd) //fonction qui verifie si le compte existe.
{
	$iddel = "/\b" . $id . "\b/i"; // car la fonction preg_match a besoin d'une chaine délimité par deux backslashs
	$pwddel = "/\b" . $pwd. "\b/i";
	$res = 0;
	$clients = fopen('comptes.txt','r');
	while(!feof($clients))
	{
		$ligne = fgets($clients);
		if(preg_match($iddel,$ligne))
		{
			if(preg_match($pwddel,$ligne))
			{
				$res = 1;
				break;
			}
			break;
		}
		else
		{
			$ligne = fgets($clients);
		}
	}
	return $res;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Session</title>
</head>
<body>
	<?php 
	if(isset($_POST['password']) AND isset($_POST['nickname']) AND IsClient($_POST['nickname'],$_POST['password']) == 1)
	{
				
		$_SESSION['nickname'] = $_POST['nickname'];
		$_SESSION['password'] = $_POST['password'];
		echo "Bienvenue au chat ZZ";
	}
	else
	{
		echo "Vous n'êtes pas autorisé a rejoindre le chat ZZ2promo18";
	}
	?>
</body>
</html>