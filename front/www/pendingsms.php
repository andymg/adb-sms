<?php
	include 'info.php';

	try 
	{
		$connexion = new PDO('mysql:host='.$PARAM_hote.';port='.$PARAM_port.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
		
		$request = $connexion->prepare("SELECT id, phoneno, sms from request WHERE sent = 0;");
		$request->execute();
		
		$first = true;
		
		echo '[';
		while($l=$request->fetch(PDO::FETCH_OBJ)) {
			if(!$first)
				echo ',';
			
			echo '{';
			echo '  "id": "' . $l->id . '",';
			echo '  "phoneNo": "' . $l->phoneno . '",';
			echo '  "sms": "' . $l->sms . '"';
			echo '}';
			
			$first = false;
		}
		echo ']';
		$request->closeCursor();
		
	} 
	catch(Exception $e) 
	{
		echo 'Erreur : '.$e->getMessage().'<br />';
		echo 'N° : '.$e->getCode();
	}
?>