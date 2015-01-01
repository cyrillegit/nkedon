<?php
	@session_start();
	@require_once("./config/config.php");
	@require_once("./include/function.php");
//	@require_once("./include/ClassTemplate.php");
	@require_once("./include/ClassUser.php");
//	@require_once("./include/MasterDB.php");
	@require_once("./include/ClassDB.php");
	@require_once("Smarty/libs/Smarty.class.php");

	// On d&eacute;sactive les notices dans les messages d'erreur.
	ini_set("error_reporting",E_ALL & ~E_NOTICE);
	ini_set("display_errors", true);
	
//	$tpl_index = new Templates();
	$tpl_index = new Smarty;

	$User = new User();
	$db = new Database();
	$db->beginTransaction ();
	
	header ("Content-type: text/html; charset=UTF-8");
	if (isset($_GET['logout']))
	{
		unset($_SESSION['login']);
		unset($_SESSION['password']);
		unset($_SESSION['infoUser']);
		@session_destroy();
	   
	   $tpl_index->display ('notLogged.tpl');
	}

	if (isset($_SESSION['login']))
	{
		$User->connection($_SESSION['login'], $_SESSION['password']);
	}
	
	if ($User->Connected() != CONNECTED)
	{
		unset($_SESSION['login']);
		unset($_SESSION['password']);
		session_destroy();

		$tpl_index->display('notLogged.tpl');
	}
	else
	{
		/*
		$sql = "DELETE FROM t_produits_factures";

		if($db->Execute($sql))
		{
			$db->commit ();
		}
		else
		{
			$db->rollBack();
		}
	//*/
		$infos = array ();
		$target = $_GET ["sub"];

		if ($target == "")
		{
			$target = "main";
		}
		else
		{
			if( $target == "comptes_utilisateurs" )
			{
				$nb_comptes_utilisateurs = $db->getNbComptesUtilisateursInDB ();
				$tpl_index->assign("nb_comptes_utilisateurs", $nb_comptes_utilisateurs);

				$target = "gestion_users/comptes_utilisateurs";
			}
			else if( $target == "types_comptes_utilisateurs" )
			{
				$nb_types_users = $db->getNbTypesUsersInDB ();
				$tpl_index->assign("nb_types_users", $nb_types_users);
				$target = "gestion_users/types_comptes_utilisateurs";
			}
			else if( $target == "password_oublie" )
			{
				$nb_comptes_utilisateurs = $db->getNbComptesUtilisateursInDB ();
				$tpl_index->assign("nb_comptes_utilisateurs", $nb_comptes_utilisateurs);

				$target = "gestion_users/password_oublie";
			}
			else
			{
				$target = "main";
			}
		}
		$tpl_index->display('administration/'.$target.'.tpl');
	}
?>