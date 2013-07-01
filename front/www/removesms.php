<?php
	include 'info.php';
	
	if($_GET['pass'] == 'haha') {
		try {
			$connexion = new PDO('mysql:host='.$PARAM_hote.';port='.$PARAM_port.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
			
			$request = $connexion->prepare('UPDATE request SET sent=1 WHERE id=' . $connexion->quote($_GET['id'], PDO::PARAM_INT));
			$request->execute();
			
			echo '[';
			while($l=$request->fetch(PDO::FETCH_OBJ)) {				
				echo '{';
				echo '  "id": "' . $l->id . '",';
				echo '  "phoneNo": "' . $l->phoneno . '",';
				echo '  "sms": "' . $l->sms . '",';
				echo '},';
			}
			echo ']';
			$request->closeCursor();
		} catch(Exception $e) {
			echo 'Erreur : '.$e->getMessage().'<br />';
			echo 'N° : '.$e->getCode();
		}
	}
?>