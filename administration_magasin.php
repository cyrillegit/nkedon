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
			if( $target == "produits" )
			{
				$nb_produits = $db->getNbProduitsInDB ();
				$tpl_index->assign("nb_produits", $nb_produits);

				$target = "gestion_produits/produits";
			}
			else if( $target == "factures" )
			{
				$nb_factures = $db->getNbFacturesInDB ();
				$tpl_index->assign("nb_factures", $nb_factures);

				$target = "gestion_factures/factures";
			}
			else if( $target == "fournisseurs" )
			{
				$nb_fournisseurs = $db->getNbFournisseursInDB ();
				$tpl_index->assign("nb_fournisseurs", $nb_fournisseurs);

				$target = "gestion_fournisseurs/fournisseurs";
			}
            else if( $target == "operations_journal" )
            {
                $nb_operations = $db->getNbOperationsInDB ();
                if(!isset($nb_operations)) $nb_operations = 0;
                $tpl_index->assign("nb_operations", $nb_operations);

                $target = "gestion_journal/operations_journal";
            }
			else if( $target == "edit_facture" )
			{
				$id_facture = $_GET["id_facture"];
				
				if( $id_facture =! 0 )
				{
					$_SESSION["GET"] = $_GET;

					$id_facture = $_GET["id_facture"];
					$numero_facture = $_GET["numero_facture"];
					$id_fournisseur = $_GET["id_fournisseur"];
					$nom_fournisseur = $_GET["nom_fournisseur"];
					$date_facture = $_GET["date_facture"];
					$prix_total_produits = $db->getPrixTotalProduitsFacture();
					if( $prix_total_produits == NULL || $prix_total_produits == "" )
					{
						$prix_total_produits = 0;
					}

					$tpl_index->assign( "numero_facture", $numero_facture );
					$tpl_index->assign( "id_fournisseur", $id_fournisseur );
					$tpl_index->assign( "nom_fournisseur", $nom_fournisseur );
					$tpl_index->assign( "date_facture", $date_facture );
					$tpl_index->assign( "prix_total_produits", number_format( $prix_total_produits, 2, ',', ' ') );
				}
				else
				{
					$sql = "DELETE FROM t_produits_factures";
					if( $db->Execute( $sql ))
					{
						$db->commit ();
					}
					else
					{
						$db->rollBack();
					}
				}


				$fournisseurs = $db->getAllFournisseurs ();
				$tpl_index->assign( "id_facture", $id_facture );
				$tpl_index->assign( "fournisseurs", $fournisseurs );
				$target = "gestion_factures/edit_facture";
			}
			else if( $target == "inventaire" )
			{
				$nb_produits = $db->getNbProduitsInDB ();
				$tpl_index->assign("nb_produits", $nb_produits);
				$target = "gestion_magasin/inventaire";
			}
			else if( $target == "recapitulatif_inventaire" )
			{
				$nb_recapitulatif = $db->getNbRecapitulatifInventaireInDB ();
				$tpl_index->assign("nb_recapitulatif", $nb_recapitulatif);
				$target = "gestion_magasin/recapitulatif_inventaire";
			}
			else if( $target == "generate_synthese" )
			{
				$nb_histo_syntheses = $db->getNbHistoriqueSyntheseInDB ();
				$tpl_index->assign("nb_histo_syntheses", $nb_histo_syntheses);
				$target = "gestion_magasin/generate_synthese";
			}
			else if( $target == "historiques_factures" )
			{
				$id_groupe = $_GET ["id_groupe"];
				$_SESSION["id_groupe"] = $id_groupe;
				$nb_histo_factures = $db->getNbHistoriquesFacturesByGroupInDB( $id_groupe );
				$tpl_index->assign("nb_histo_factures", $nb_histo_factures);
				$target = "gestion_magasin/historiques_factures";
			}	
			else if( $target == "groupes_factures" )
			{
				$nb_groupes_factures = $db->getNbGroupesFacturesInDB ();
				$tpl_index->assign("nb_groupes_factures", $nb_groupes_factures);
				$target = "gestion_magasin/groupes_factures";
			}					
			else if( $target == "historiques_syntheses" )
			{
				$nb_histo_syntheses = $db->getNbHistoriqueSyntheseInDB ();
				$tpl_index->assign("nb_histo_syntheses", $nb_histo_syntheses);
				$target = "gestion_magasin/historique_syntheses";
			}
			else if( $target == "statistiques" )
			{
				$target = "statistiques/statistiques";
			}
			else if( $target == "produits_facture" )
			{
				$_GET = $_SESSION["GET"];

				$id_facture = $_GET["id_facture"];
				$numero_facture = $_GET["numero_facture"];
				$id_fournisseur = $_GET["id_fournisseur"];
				$nom_fournisseur = $_GET["nom_fournisseur"];
				$date_facture = $_GET["date_facture"];
				$nb_produits = $db->getNbProduitsInFacture ();
				$fournisseurs = $db->getAllFournisseurs();
				$prix_total_produits = $db->getPrixTotalProduitsFacture();
				if( $prix_total_produits == NULL || $prix_total_produits == "" )
				{
					$prix_total_produits = 0;
				}

				$tpl_index->assign( "nb_produits", $nb_produits );
				$tpl_index->assign( "fournisseurs", $fournisseurs );
				$tpl_index->assign( "id_facture", $id_facture );
				$tpl_index->assign( "numero_facture", $numero_facture );
				$tpl_index->assign( "id_fournisseur", $id_fournisseur );
				$tpl_index->assign( "nom_fournisseur", $nom_fournisseur );
				$tpl_index->assign( "date_facture", $date_facture );
				$tpl_index->assign( "prix_total_produits", number_format( $prix_total_produits, 2, ',', ' ') );

				$target = "gestion_factures/edit_facture";
			}
			else if( $target == "stats_users_types_users" )
			{
				$target = "statistiques/stats_users_types_users";
			}
			else if( $target == "stats_connections_users" )
			{
				$target = "statistiques/stats_connections_users";
			}
			else if( $target == "stats_fournisseurs_factures" )
			{
				$target = "statistiques/stats_fournisseurs_factures";
			}
			else if( $target == "stats_fournisseurs_factures_archivees" )
			{
				$target = "statistiques/stats_fournisseurs_factures_archivees";
			}			
			else if( $target == "stats_graphes_progression" )
			{
				$target = "statistiques/stats_graphes_progression";
			}
			else if( $target == "stats_produits" )
			{
				$target = "statistiques/stats_produits";
			}
			else if( $target == "stats_produits_achetes_vendus" )
			{
				$target = "statistiques/stats_produits_achetes_vendus";
			}		
			else if( $target == "backupdb" )
			{
				
			}																										
			else
			{
				$target = "main";
			}
		}
		$tpl_index->display('administration_magasin/'.$target.'.tpl');
	}
?>