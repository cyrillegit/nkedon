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
            else if( $target == "edit_operations_journal" )
            {
                $nb_operations = $db->getNbOperationsInDB ();
                if(!isset($nb_operations)) $nb_operations = 0;

                $produits_operation = $db->getAllProduitsOperationsJournal();
                $montant_operation = 0;
                foreach( $produits_operation as $po ){
                    $montant_operation += $po["quantite_vendue"] * $po["prix_vente"];
                }

                $tpl_index->assign("nb_operations", $nb_operations);
                $tpl_index->assign( "montant_operation", number_format( $montant_operation, 2, ',', ' ') );

                $target = "gestion_journal/edit_operations_journal";
            }
			else if( $target == "edit_facture" )
			{
				$id_facture = $_GET["id_facture"];
                $nb_produits = 0;
				
				if( $id_facture != 0 )
				{
					$produits_factures = $db->getAllProduitsOperationsFacture();
                    $montant_facture = 0;

                    foreach( $produits_factures as $pf ){
                        $nb_produits++;
                        $montant_facture += $pf["quantite_achat"] * $pf["prix_achat"];
                    }
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

                $tpl_index->assign( "montant_facture", number_format( $montant_facture, 2, ',', ' ') );
                $tpl_index->assign( "nb_produits", $nb_produits );
				$tpl_index->assign( "id_facture", $id_facture );
				$tpl_index->assign( "fournisseurs", $fournisseurs );

				$target = "gestion_factures/edit_facture";
			}
            else if( $target == "edit_historique_facture_achat" )
            {
                $okFacture = true;
                $nb_produits = 0;
                $montant_facture = 0;

                if(isset($_GET["id_facture_achat"])) {
                    $id_facture = $_GET["id_facture_achat"];
                    $_SESSION["id_facture"] = $id_facture;
                    $produits = $db->getAllProduitsAchetesByFacture($id_facture);

                    $numero_facture = $produits[0]["numero_facture"];
                    $date_facture = SQLDateToFrenchDate($produits[0]["date_facture"]);
                    $commentaire = $produits[0]["commentaire"];
                    $id_fournisseur = $produits[0]["id_fournisseur"];

                    // si on est en mode suppression, on ne reinitialise pas la table tampon courante
                    if( !isset($_SESSION["delete"])) {

                        $sql = "DELETE FROM t_produits_factures";
                        if ($db->Execute($sql)) {
                            foreach ($produits as $info) {
                                $id_produit = $info["id_produit"];
                                $quantite_achat = $info["quantite_achat"];
                                $date_fabrication = $info["date_fabrication"];
                                $date_peremption = $info["date_peremption"];
                            //    $id_fournisseur = $info["id_fournisseur"];


                                $sql = "INSERT INTO t_produits_factures
                                                (id_produit,
                                                 quantite_achat,
                                                 date_fabrication,
                                                 date_peremption)
                                        VALUES ('$id_produit',
                                                '$quantite_achat',
                                                '$date_fabrication',
                                                '$date_peremption')";

                                if ($db->Execute($sql)) {
                                    $okFacture &= true;
                                } else {
                                    $okFacture &= false;
                                }
                            }
                        } else {
                            $db->rollBack();
                        }
                    }

                    if($okFacture)
                    {
                        $db->commit ();
                        $produits_factures = $db->getAllProduitsOperationsFacture();

                        foreach( $produits_factures as $pf ){
                            $nb_produits++;
                            $montant_facture += $pf["quantite_achat"] * $pf["prix_achat"];
                        }
                    }
                    else
                    {
                        $db->rollBack();
                    }
                }

                $fournisseurs = $db->getAllFournisseurs ();

                $tpl_index->assign( "montant_facture", number_format( $montant_facture, 2, ',', ' ') );
                $tpl_index->assign( "nb_produits", $nb_produits );
                $tpl_index->assign( "id_facture", $id_facture );
                $tpl_index->assign( "numero_facture", $numero_facture );
                $tpl_index->assign( "date_facture", $date_facture );
                $tpl_index->assign( "fournisseurs", $fournisseurs );
                $tpl_index->assign( "id_fournisseur", $id_fournisseur );
                $tpl_index->assign( "commentaire", $commentaire );

                $target = "gestion_factures/edit_facture";
            }
            else if( $target == "edit_historique_facture_vente" )
            {
                $okFacture = true;
                $nb_produits = 0;
                $montant_facture = 0;

                if(isset($_GET["id_facture_vente"])) {
                    $id_facture = $_GET["id_facture_vente"];
                    $_SESSION["id_facture"] = $id_facture;
                    $produits = $db->getAllProduitsVendusByFacture($id_facture);

                    $numero_facture = $produits[0]["numero_facture"];
                    $date_facture = SQLDateToFrenchDate($produits[0]["date_facture"]);
                    $commentaire = $produits[0]["commentaire"];

                    // si on est en mode suppression, on ne reinitialise pas la table tampon courante
                    if( !isset($_SESSION["delete"])) {

                        $sql = "DELETE FROM t_produits_ventes";
                        if ($db->Execute($sql)) {
                            foreach ($produits as $info) {
                                $id_produit = $info["id_produit"];
                                $quantite_vendue = $info["quantite_vendue"];

                                $sql = "INSERT INTO t_produits_ventes
                                                (id_produit,
                                                 quantite_vendue)
                                        VALUES ('$id_produit',
                                                '$quantite_vendue')";

                                if ($db->Execute($sql)) {
                                    $okFacture &= true;
                                } else {
                                    $okFacture &= false;
                                }
                            }
                        } else {
                            $db->rollBack();
                        }
                    }

                    if($okFacture)
                    {
                        $db->commit ();
                        $produits_factures = $db->getAllProduitsOperationsVentesFacture();

                        foreach( $produits_factures as $pf ){
                            $nb_produits++;
                            $montant_facture += $pf["quantite_vendue"] * $pf["prix_vente"];
                        }
                    }
                    else
                    {
                        $db->rollBack();
                    }
                }

                $tpl_index->assign( "montant_facture", number_format( $montant_facture, 2, ',', ' ') );
                $tpl_index->assign( "id_facture", $id_facture );
                $tpl_index->assign( "numero_facture", $numero_facture );
                $tpl_index->assign( "date_facture", $date_facture );
                $tpl_index->assign( "commentaire", $commentaire );

                $target = "gestion_factures/edit_facture_vente";
            }
            else if( $target == "edit_facture_vente" )
            {
//                $produits_factures = $db->getAllProduitsVendusFacture();
//                $montant_facture = 0;
//
//                foreach( $produits_factures as $pf ){
//                    $nb_produits++;
//                    $montant_facture += $pf["quantite_vendue"] * $pf["prix_vente"];
//                }
//
//                $tpl_index->assign("montant_facture", number_format( $montant_facture, 2, ',', ' '));
//
//                $target = "gestion_factures/edit_facture_vente";

                $nb_produits = 0;
                $montant_facture = 0;
                $id_facture = 0;
                $montant_facture = 0;

                if(isset($_SESSION["id_facture"])) {
                    $id_facture = $_SESSION["id_facture"];
                    $produits = $db->getAllProduitsVendusByFacture($id_facture);

                    $numero_facture = $produits[0]["numero_facture"];
                    $date_facture = SQLDateToFrenchDate($produits[0]["date_facture"]);
                    $commentaire = $produits[0]["commentaire"];
                }

                $produits_factures = $db->getAllProduitsOperationsVentesFacture();

                foreach ($produits_factures as $pf) {
                    $montant_facture += $pf["quantite_vendue"] * $pf["prix_vente"];
                }

                $tpl_index->assign( "id_facture", $id_facture );
                $tpl_index->assign( "numero_facture", $numero_facture );
                $tpl_index->assign( "commentaire", $commentaire );
                $tpl_index->assign( "date_facture", $date_facture );
                $tpl_index->assign( "montant_facture", number_format( $montant_facture, 2, ',', ' ') );

                $target = "gestion_factures/edit_facture_vente";
            }
			else if( $target == "inventaire" )
			{
				$nb_produits = $db->getNbProduitsInDB ();
				$tpl_index->assign("nb_produits", $nb_produits);
				$target = "gestion_magasin/inventaire";
			}
			else if( $target == "recapitulatif_inventaire" )
			{
				$target = "gestion_magasin/recapitulatif_inventaire";
			}
			else if( $target == "produits_facture" )
			{
                $nb_produits = 0;
                $montant_facture = 0;
                $id_facture = 0;
                $id_fournisseur = 0;
                $montant_facture = 0;

                if(isset($_SESSION["id_facture"])) {
                    $id_facture = $_SESSION["id_facture"];
                    $produits = $db->getAllProduitsAchetesByFacture($id_facture);

                    $numero_facture = $produits[0]["numero_facture"];
                    $date_facture = SQLDateToFrenchDate($produits[0]["date_facture"]);
                    $commentaire = $produits[0]["commentaire"];
                    $id_fournisseur = $produits[0]["id_fournisseur"];
                }

                $nb_produits = $db->getNbProduitsInFacture();

                $produits_factures = $db->getAllProduitsOperationsFacture();

                foreach ($produits_factures as $pf) {
                    $montant_facture += $pf["quantite_achat"] * $pf["prix_achat"];
                }


                $fournisseurs = $db->getAllFournisseurs();

				$tpl_index->assign( "nb_produits", $nb_produits );
				$tpl_index->assign( "fournisseurs", $fournisseurs );
				$tpl_index->assign( "id_facture", $id_facture );
				$tpl_index->assign( "numero_facture", $numero_facture );
				$tpl_index->assign( "id_fournisseur", $id_fournisseur );
				$tpl_index->assign( "commentaire", $commentaire );
				$tpl_index->assign( "date_facture", $date_facture );
				$tpl_index->assign( "montant_facture", number_format( $montant_facture, 2, ',', ' ') );

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