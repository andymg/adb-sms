<?php
	include 'info.php';
	
	if(isset($_POST['phoneNo']) && isset($_POST['sms'])) {
		$escape = array("'", "\"", "-", "<", ">", "&", "|");
		
		$phoneNo = $_POST['phoneNo'];
		$sms = str_replace($escape, "", $_POST['sms']);
		
		try {
			$connexion = new PDO('mysql:host='.$PARAM_hote.';port='.$PARAM_port.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
			
			$connexion->exec('INSERT INTO request (phoneno, sms, sent) VALUES ("' . $phoneNo . '", "' . $sms . '", 0);');
		} catch(Exception $e) {
			echo '0';
			echo 'Erreur : '.$e->getMessage().'<br />';
			echo 'N° : '.$e->getCode();
		}
	} 
?>