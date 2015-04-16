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
		$infos = array ();
		$target = $_GET ["sub"];

		if ($target == "")
		{
			$target = "main";
		}
		else
		{
			if( $target == "stats_factures_achats" )
            {
                $target = "stats_factures_achats";
            }
            else if( $target == "stats_factures_ventes" )
            {
                $target = "stats_factures_ventes";
            }
            else if( $target == "stats_fournisseurs_factures" )
            {
                $target = "stats_fournisseurs_factures";
            }
            else if( $target == "stats_operations_journal" )
            {
                $target = "stats_operations_journal";
            }
            else if( $target == "stats_recapitulatifs" )
            {
                $target = "stats_recapitulatifs";
            }
            else if( $target == "stats_produits" )
            {
                $target = "stats_produits";
            }
            else if( $target == "stats_produits_achetes_vendus" )
            {
                $target = "stats_produits_achetes_vendus";
            }
			else
			{
				$target = "main";
			}
		}
		$tpl_index->display('statistiques/'.$target.'.tpl');
	}
?>