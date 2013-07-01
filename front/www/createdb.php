<?php
	include 'info.php';
	
	try {
		$connexion = new PDO('mysql:host='.$PARAM_hote.';port='.$PARAM_port.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
		
		$request = $connexion->exec('CREATE TABLE IF EXISTS `request` (' .
			'`id` int(11) NOT NULL AUTO_INCREMENT,' .
			'`phoneno` varchar(10) NOT NULL,' .
			'`sms` text NOT NULL,' .
			'`sent` int(11) NOT NULL,' .
			'PRIMARY KEY (`id`)' .
			') ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');		
	} catch(Exception $e) {
		echo 'Erreur : '.$e->getMessage().'<br />';
		echo 'N° : '.$e->getCode();
	}
?>