<?php
	/**
		@index.php
		Auteur : Jérôme Perciot
		
		Permet d'éviter de faire une requête sur ce répertoire et d'avoir la liste des fichiers.
		Module de sécurité interne du serveur.
	*/
	header ("Location: ../index.php");
?>