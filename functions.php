
<?php

  function VarCheck($var){
    return (isset($var) && !empty($var));

  }

  function LoginInfoCheck($log, $pwd){
    return (VarCheck($log) && VarCheck($pwd));

  }


/* IsClient -------------------------------------------------------------
    /  Verifies whether the person that is trying to connect is allowed
    /  or not, checks for the cordinates in the txt file and returns true 
    /  or false.
    /
    /  Parameters :
    /    - $id: button.
    /    - $pwd : login to be checked.
    / --------------------------------------------------------------------- */

<?php function IsClient($id,$pwd) //fonction qui verifie si le compte existe.
{
	$iddel = "/\b" . $id . "\b/i"; /* car la fonction preg_match a besoin d'une chaine délimité par deux backslashs/
									  on ajoute le i pour rendre la recherche du motif insensible à la casse 
									  on entoure le motif avec l'expression \b pour effectuer la recherche
     								  sur le mot entier uniquement (isolé) */
	$pwddel = "/\b" . $pwd. "\b/i";
	$res = false;
	$clients = fopen('comptes.txt','r'); //fichier txt contient un nickname par ligne suivi par le mot de pass la ligne suivante
	while(!feof($clients))
	{
		$ligne = fgets($clients);
		if(preg_match($iddel,$ligne))
		{
			$ligne=fgets($clients); //pour lire le mot de pass
			if(preg_match($pwddel,$ligne))
			{
				$res = true;
				break;
			}
			
		}
	}
	return $res;
}?>


 ?>
