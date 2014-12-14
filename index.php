<?php
	/**
		Fichier index.php
		-----------------
		Page d'index du site Internet, il permet d'initialiser les pages de connexion, et de données
		communes dans le milieu de la page.
		
		On teste si on est connecté, en vérifiant $smarty.session.connected en booléen.
	*/
	
	@session_start();

	@require_once("Smarty/libs/Smarty.class.php");
	
	@require_once("config/config.php");
	@require_once("include/function.php");
//	@require_once("include/ClassTemplate.php");
	@require_once ("include/MasterDB.php");
	@require_once ("include/ClassDB.php");
	@require_once("include/ClassUser.php");

	
	// On d&eacute;sactive les notices dans les messages d'erreur.
	$tpl_index = new Smarty;
//	$tpl_index = new Templates ();

	$User = new User();
	$db = new Database ();
	$db->beginTransaction ();

	header ("Content-type: text/html; charset=UTF-8");
	if (isset($_GET['logout']))
	{
		unset($_SESSION['login']);
		unset($_SESSION['password']);
		unset($_SESSION['infoUser']);
	//	@session_destroy();
	   echo "first";
	   header ("Location: index.php");
	}
	// Modification des locales pour le site Internet.
	@setlocale(LC_ALL, array('fr_FR.utf8','fr_FR@euro','fr_FR','french'));

	if (isset($_SESSION['login']))
	{
		$User->connection($_SESSION['login'], $_SESSION['password']);
	}
	
	if ($User->Connected() != CONNECTED)
	{
		unset($_SESSION['login']);
		unset($_SESSION['password']);
	//	unset($_SESSION['infoUser']);
		@session_destroy();
		$wasDisconnected = true;
		$tpl_index->display('notLogged.tpl');
	}
	else
	{
		if( !$_SESSION["wasConnected"] )
		{
			$master = new MasterDB ();
			$datetime_last_connected = setLocalTime();
			$nombre_connexion = $_SESSION["infoUser"]["nombre_connexion"] + 1;
			$id_user = $_SESSION["infoUser"]["idt_users"] ;

			$sql = "UPDATE t_users
					SET datetime_last_connected = '$datetime_last_connected',
						nombre_connexion = $nombre_connexion
					WHERE idt_users = $id_user";

			if( $db->Execute ( $sql ) )
			{
				$db->commit ();
				// On récupère donc toutes les informations utiles ici.
				$_SESSION["wasConnected"] = true;
				$db->fixEncodingArray($_SESSION);
			}
			else
			{
				$db->rollBack();
			}
		}
		$_SESSION["infoUser"]["datetime_last_connected"] = SQLDateTimeToFrenchDateTime( $_SESSION["infoUser"]["datetime_last_connected"] );
		$tpl_index->display('index.tpl');	
	}
?>