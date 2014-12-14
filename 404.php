<?php
	/**
		Fichier index.php
		-----------------
		Page d'index du site Internet, il permet d'initialiser les pages de connexion, et de données
		communes dans le milieu de la page.
		
		On teste si on est connecté, en vérifiant $smarty.session.connected en booléen.
	*/
	session_start();
	require_once("config/config.php");
	require_once("include/function.php");
	require_once("include/ClassTemplate.php");
	require_once("include/ClassUser.php");
	require_once("include/ClassMail.php");
	require_once("include/ClassDB.php");
		
	// On d&eacute;sactive les notices dans les messages d'erreur.
	ini_set("error_reporting",E_ALL & ~E_NOTICE);
	ini_set("display_errors", true);
		
	$tpl_index = new Templates ();
	$User = new User();
	$db = new Database();
	
	header ("Content-type: text/html; charset=UTF-8");
	if (isset($_GET['logout']))
	{
	   $db->StoreDeconnectionInfo ($_SESSION ["infoUser"]["idt_logins"]);
	   @session_unregister('login');
	   @session_unregister('password');
	   @session_unregister('info');
	   @session_unregister('droits');
	   
	   header ("Location: index.php");
	}
	
	// Modification des locales pour le site Internet.
	setlocale(LC_ALL, array('fr_FR.utf8','fr_FR@euro','fr_FR','french'));
	if (isset($_SESSION['login']))
	{
		$User->connection($_SESSION['login'], $_SESSION['password'], $_SESSION ["CodeClient"]);
	}
	
	if ($User->Connected() != CONNECTED)
	{
		@session_unregister('login');
		@session_unregister('password');
		session_destroy();
		$tpl_index->display('notLogged.tpl');
	}
	else
	{
		$idTheme = $db->GetLoginPreference ("id_theme", $_SESSION ["infoUser"]["idt_logins"]);
		$themes = $db->GetAllThemes ();
		$db->fixEncodingArray($themes);
		
		// 7°) Les actualités du client.
		$actualites = $db->GetAllActualites ($_SESSION ["infoUser"]["idt_cliniques"]);
		$db->fixEncodingArray($actualites);
		$tpl_index->assign ("actualites", $actualites);
		
		// On récupère donc toutes les informations utiles ici.
		$db->fixEncodingArray($_SESSION);
		$date = $db->GetLastConnectionDateTime ($_SESSION ["infoUser"]["idt_logins"]);
		
		$tpl_index->assign ("idTheme", $idTheme);
		$tpl_index->assign ("themes", $themes);
		$tpl_index->assign ("date_derniere_connexion", $date);
		$tpl_index->display('index.tpl');
	}
?>