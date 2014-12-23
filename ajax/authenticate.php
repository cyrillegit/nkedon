<?php
	/**
	 * Page d'authentification du site Internet.
	 * Cette page permet de vérifier la connexion au site.
	 */
	@require_once("../config/config.php");
	@require_once("../include/function.php");
//	@require_once("../include/ClassTemplate.php");
	@require_once("../include/ClassUser.php");
//	@require_once("../include/MasterDB.php");
	@require_once("../include/ClassDB.php");

	@session_start();
//	$masterDB = new MasterDB();
	
	if (isset($_POST))
	{
		$_SESSION['login'] = (!empty($_POST['login'])) ? trim($_POST['login']) : "";
		$_SESSION['password'] = (!empty($_POST['password'])) ? $_POST['password'] : "";

		// On tente alors la connexion sur le serveur.
	//	$masterDB->ConnectNormal();
	//	$_SESSION ["ConnectionInfo"] = $masterDB->GetConnectionInfo();
		$User = new User();
		$User->connection ($_SESSION['login'], $_SESSION['password']);
		if ($User->Connected())
		{
		//	$_SESSION ["KeySignature"] = Configuration::getValue("SIGNATURE");
		}
		if ($User !== NULL)
			echo "({'connected' : ".($User->Connected() == CONNECTED ? "true" : "false")."})";	
		else
		{
			echo "({'connected' : false})";
		}
	}
?>