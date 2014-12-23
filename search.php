<?php
	$requete = htmlspecialchars($_GET['word']);
	$results = array();
		try{
			$bdd = new PDO('mysql:host=localhost; dbname=nkedon_db','root','');
		}catch(Exception $e){
			die('Erreur : '.$e->getMessage());
		}
		$reponse = $bdd->query("SELECT * FROM t_produits WHERE nom_produit LIKE '$requete%' ORDER BY nom_produit LIMIT 5") or die(print_r($bdd->errorInfo()));
		while ($donnees = $reponse->fetch()){
			if(stripos($donnees['nom_produit'], $requete) === 0){
				array_push($results, $donnees['nom_produit']);
			}
		}				
		$reponse->closeCursor();
		echo implode('|', $results);
?>