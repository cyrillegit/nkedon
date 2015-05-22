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
			if( $target == "matieres_premieres" )
			{
				$nb_matieres_premieres = $db->getNbMatieresPremieresInDB();
				$tpl_index->assign("nb_matieres_premieres", $nb_matieres_premieres);

				$target = "gestion_produits/matieres_premieres";
			}
            else if( $target == "portions_journalieres" )
            {
                $nb_fournisseurs = $db->getNbFournisseursInDB ();
                $tpl_index->assign("nb_fournisseurs", $nb_fournisseurs);

                $target = "gestion_fournisseurs/fournisseurs";
            }
            else if( $target == "produits_confectionnes" )
            {
                $nb_fournisseurs = $db->getNbFournisseursInDB ();
                $tpl_index->assign("nb_fournisseurs", $nb_fournisseurs);

                $target = "gestion_fournisseurs/fournisseurs";
            }
            else if( $target == "fournisseurs" )
            {
                $nb_fournisseurs = $db->getNbFournisseursInDB ();
                $tpl_index->assign("nb_fournisseurs", $nb_fournisseurs);

                $target = "gestion_fournisseurs/fournisseurs";
            }
            else if( $target == "factures_achats" )
            {
                $nb_fournisseurs = $db->getNbFournisseursInDB ();
                $tpl_index->assign("nb_fournisseurs", $nb_fournisseurs);

                $target = "gestion_fournisseurs/fournisseurs";
            }
            else if( $target == "factures_ventes" )
            {
                $nb_fournisseurs = $db->getNbFournisseursInDB ();
                $tpl_index->assign("nb_fournisseurs", $nb_fournisseurs);

                $target = "gestion_fournisseurs/fournisseurs";
            }
            else if( $target == "operations_journal" )
            {
                $nb_fournisseurs = $db->getNbFournisseursInDB ();
                $tpl_index->assign("nb_fournisseurs", $nb_fournisseurs);

                $target = "gestion_fournisseurs/fournisseurs";
            }
            else if( $target == "inventaire" )
            {
                $nb_fournisseurs = $db->getNbFournisseursInDB ();
                $tpl_index->assign("nb_fournisseurs", $nb_fournisseurs);

                $target = "gestion_fournisseurs/fournisseurs";
            }
			else
			{
				$target = "main";
			}
		}
		$tpl_index->display('production/'.$target.'.tpl');
	}
?>