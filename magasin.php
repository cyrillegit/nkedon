<?php
	@session_start();
	@require_once("./config/config.php");
	@require_once("./include/function.php");
//	@require_once("./include/ClassTemplate.php");
	@require_once("./include/ClassUser.php");
//	@require_once("./include/MasterDB.php");
	@require_once("./include/ClassDB.php");	
	@require_once("Smarty/libs/Smarty.class.php");
    @require_once('./include/ClassDownloadSyntheseInventaire.php');
    @require_once("./include/ClassBackupDatabase.php");

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
//			else if( $target == "factures" )
//			{
//				$nb_factures = $db->getNbFacturesInDB ();
//				$tpl_index->assign("nb_factures", $nb_factures);
//
//				$target = "gestion_factures/factures";
//			}
			else if( $target == "fournisseurs" )
			{
				$nb_fournisseurs = $db->getNbFournisseursInDB ();
				$tpl_index->assign("nb_fournisseurs", $nb_fournisseurs);

				$target = "gestion_fournisseurs/fournisseurs";
			}
            else if( $target == "edit_operations_journal" )
            {
                $id_journal = $_GET["id_journal"];
                $montant_operation = 0;
                $nb_produits = 0;
                $_SESSION["journal"] = true;

                // check unicity of the journal per day
                $infoAllJournal = $db->getAllJournal();
                $date_now = explode(" ", setLocalTime() )[0];
                foreach ( $infoAllJournal as $info )
                {
                    $date = explode( " ", $info["date_journal"] )[0];
                    if( $date == $date_now )
                    {
                        unset( $_SESSION ["numero"] );
                        $_SESSION ["numero"] = 1;
                        $_SESSION["journal"] = false;
                    }
                }

                if( $id_journal != 0 )
                {
                    $produits_operation = $db->getAllProduitsOperationsJournal();
                    foreach( $produits_operation as $po ){
                        $nb_produits++;
                        $montant_operation += $po["quantite_vendue"] * $po["prix_vente"];
                    }
                }
                else
                {
//                    $sql = "DELETE FROM t_produits_operations";
//                    if( $db->Execute( $sql ))
//                    {
//                        $db->commit ();
//                    }
//                    else
//                    {
//                        $db->rollBack();
//                    }
                }
                $tpl_index->assign("nb_produits", $nb_produits);
                $tpl_index->assign( "montant_journal", number_format( $montant_operation, 2, ',', ' ') );

                $target = "gestion_journal/edit_operations_journal";
            }
            else if( $target == "result_journal" )
            {
                $id_journal = $db->getMaxIdJournal();
                $infosJournal = $db->getInfosJournalById( $id_journal );
                $nb_produits = count( $infosJournal );

                $tpl_index->assign("nb_produits", $nb_produits);

                $target = "gestion_journal/result_journal";
            }
			else if( $target == "edit_facture_achat" )
			{
				$id_facture = $_GET["id_facture"];
                $nb_produits = 0;
				
//				if( $id_facture != 0 )
//				{
					$produits_factures = $db->getAllProduitsOperationsFacture();
                    $montant_facture = 0;

                    foreach( $produits_factures as $pf ){
                        $nb_produits++;
                        $montant_facture += $pf["quantite_achat"] * $pf["prix_achat"];
                    }
//				}
//				else
//				{
//					$sql = "DELETE FROM t_produits_achats";
//					if( $db->Execute( $sql ))
//					{
//						$db->commit ();
//					}
//					else
//					{
//						$db->rollBack();
//					}
//				}

				$fournisseurs = $db->getAllFournisseurs ();

                $tpl_index->assign( "montant_facture", number_format( $montant_facture, 2, ',', ' ') );
                $tpl_index->assign( "nb_produits", $nb_produits );
				$tpl_index->assign( "id_facture", $id_facture );
				$tpl_index->assign( "fournisseurs", $fournisseurs );

				$target = "gestion_factures/edit_facture_achat";
			}
            else if( $target == "result_facture_achat" )
            {
                $id_facture = $db->getMaxIdFactureAchat();
                $infosFacture = $db->getInfosFactureAchatById( $id_facture );
                $nb_produits = count( $infosFacture );

                $tpl_index->assign("nb_produits", $nb_produits);

                $tpl_index->assign( "nb_produits", $nb_produits );
                $target = "gestion_factures/result_facture_achat";
            }
            else if( $target == "edit_facture_vente" )
            {
                $id_facture = $_GET["id_facture"];
                $nb_produits = 0;

//                if( $id_facture != 0 )
//                {
                    $produits_factures = $db->getAllProduitsOperationsVentesFacture();
                    $montant_facture = 0;

                    foreach( $produits_factures as $pf ){
                        $nb_produits++;
                        $montant_facture += $pf["quantite_vendue"] * $pf["prix_vente"];
                    }
//                }
//                else
//                {
//                    $sql = "DELETE FROM t_produits_ventes";
//                    if( $db->Execute( $sql ))
//                    {
//                        $db->commit ();
//                    }
//                    else
//                    {
//                        $db->rollBack();
//                    }
//                }

                $tpl_index->assign( "nb_produits", $nb_produits );
                $tpl_index->assign( "montant_facture", number_format( $montant_facture, 2, ',', ' ') );
                $tpl_index->assign( "id_facture", $id_facture );

                $target = "gestion_factures/edit_facture_vente";
            }
            else if( $target == "result_facture_vente" )
            {
                $id_facture = $db->getMaxIdFactureVente();
                $infosFacture = $db->getInfosFactureVenteyId( $id_facture );
                $nb_produits = count( $infosFacture );

                $tpl_index->assign("nb_produits", $nb_produits);

                $tpl_index->assign( "nb_produits", $nb_produits );
                $target = "gestion_factures/result_facture_vente";
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

                        $sql = "DELETE FROM t_produits_achats";
                        if ($db->Execute($sql)) {
                            foreach ($produits as $info) {
                                $id_produit = $info["id_produit"];
                                $quantite_achat = $info["quantite_achat"];
                                $date_fabrication = $info["date_fabrication"];
                                $date_peremption = $info["date_peremption"];
                            //    $id_fournisseur = $info["id_fournisseur"];


                                $sql = "INSERT INTO t_produits_achats
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

                $target = "gestion_factures/edit_facture_achat";
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
                    $nom_client = $produits[0]["nom_client"];

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
                $tpl_index->assign( "nom_client", $nom_client );

                $target = "gestion_factures/edit_facture_vente";
            }
            else if( $target == "edit_historique_journal" )
            {
                $okFacture = true;
                $nb_produits = 0;
                $montant_journal = 0;
                $_SESSION["journal"] = true;

                if(isset($_GET["id_journal"])) {
                    $id_journal = $_GET["id_journal"];
                    $_SESSION["id_journal"] = $id_journal;
                    $produits = $db->getAllProduitsOperationsByJournal($id_journal);

                    $commentaire = $produits[0]["commentaire"];

                    // si on est en mode suppression, on ne reinitialise pas la table tampon courante
                    if( !isset($_SESSION["delete"])) {

                        $sql = "DELETE FROM t_produits_operations";
                        if ($db->Execute($sql)) {
                            foreach ($produits as $info) {
                                $id_produit = $info["id_produit"];
                                $quantite_vendue = $info["quantite_vendue"];
                                $numero_operation = $info["numero_operation"];

                                $sql = "INSERT INTO t_produits_operations
                                                (id_produit,
                                                 quantite_vendue,
                                                 numero_operation)
                                        VALUES ('$id_produit',
                                                '$quantite_vendue',
                                                '$numero_operation')";

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
                        $produits_journal = $db->getAllProduitsOperationsJournal();

                        foreach( $produits_journal as $pj ){
                            $nb_produits++;
                            $montant_journal += $pj["quantite_vendue"] * $pj["prix_vente"];
                        }
                    }
                    else
                    {
                        $db->rollBack();
                    }
                }

                $tpl_index->assign( "montant_journal", number_format( $montant_journal, 2, ',', ' ') );
                $tpl_index->assign( "id_journal", $id_journal );
                $tpl_index->assign( "nb_produits", $nb_produits );
                $tpl_index->assign( "commentaire", $commentaire );

                $target = "gestion_journal/edit_operations_journal";
            }
            else if( $target == "facture_vente" )
            {
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
                    $nom_client = $produits[0]["nom_client"];
                }

                $produits_factures = $db->getAllProduitsOperationsVentesFacture();

                foreach ($produits_factures as $pf) {
                    $nb_produits++;
                    $montant_facture += $pf["quantite_vendue"] * $pf["prix_vente"];
                }

                $tpl_index->assign( "id_facture", $id_facture );
                $tpl_index->assign( "nb_produits", $nb_produits );
                $tpl_index->assign( "numero_facture", $numero_facture );
                $tpl_index->assign( "commentaire", $commentaire );
                $tpl_index->assign( "nom_client", $nom_client );
                $tpl_index->assign( "date_facture", $date_facture );
                $tpl_index->assign( "montant_facture", number_format( $montant_facture, 2, ',', ' ') );

                $target = "gestion_factures/edit_facture_vente";
            }
            else if( $target == "operation_journal" )
            {
                $nb_produits = 0;
                $id_journal = 0;
                $montant_journal = 0;

                if(isset($_SESSION["id_journal"])) {
                    $id_journal= $_SESSION["id_journal"];
                    $produits = $db->getAllProduitsOperationsByJournal($id_journal);

                    $date_journal = SQLDateToFrenchDate($produits[0]["date_journal"]);
                    $commentaire = $produits[0]["commentaire"];
                }

                $produits_operations = $db->getProduitsOperations();

                foreach ($produits_operations as $po) {
                    $nb_produits++;
                    $montant_journal += $po["quantite_vendue"] * $po["prix_vente"];
                }

                $tpl_index->assign( "id_journal", $id_journal);
                $tpl_index->assign( "nb_produits", $nb_produits);
                $tpl_index->assign( "commentaire", $commentaire );
                $tpl_index->assign( "date_journal", $date_journal );
                $tpl_index->assign( "montant_journal", number_format( $montant_journal, 2, ',', ' ') );

                $target = "gestion_journal/edit_operations_journal";
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
			else if( $target == "produits_achats" )
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

				$target = "gestion_factures/edit_facture_achat";
			}
			else if( $target == "synthese_inventaire" )
			{
                if( isset($_SESSION["synthese"]) ){

                    unset($_SESSION["synthese"]);
                    $ok = true;
                    $id_inventaire = $db->getMaxIdInventaire();

                    $sql1 = "UPDATE t_journal
                            SET id_inventaire = '$id_inventaire'
                            WHERE id_inventaire = 0";

                    $sql2 = "UPDATE t_factures
                            SET id_inventaire = '$id_inventaire'
                            WHERE id_inventaire = 0";

                    if( $db->Execute ( $sql1 ) && $db->Execute ( $sql2 ) )
                    {
                        $db->commit ();
                    }
                    else
                    {
                        $ok &= false;
                        $db->rollBack();
                    }

                    if( $ok ){
                        $html = new SyntheseInventaire( $id_inventaire );
                        $htmlContent = $html->buildHtml();
                        $htmlEcarts = $html->buildHtmlEcarts();
                        $inventaire_filename = $html->getFilename("inventaire");
                        $ecarts_filename = $html->getFilename("ecarts");
                    //    $html->buildPdf( $htmlContent );
                        $html->storeHtml( $htmlContent, $inventaire_filename );
                        $html->storeHtml( $htmlEcarts, $ecarts_filename );
                    //    echo $htmlContent;
                    //    echo $filename;

                        /**
                         * Instantiate Backup_Database and perform backup
                         */
                        $backupDatabase = new BackupDatabase();
                        $status = $backupDatabase->backupTables() ? 'OK' : 'KO';

                        /**
                         * initiliaze db
                         */
                        $isOk = true;
                        $produits = $db->getTableProduits();
                        $db->beginTransaction ();
                        foreach ($produits as $produit)
                        {
                            $idt_produits = $produit["idt_produits"];
                            $stock_physique = $produit["stock_physique"];
                            $sql = "UPDATE t_produits
                                    SET stock_initial = '$stock_physique',
                                        stock_physique = 0
                                    WHERE idt_produits = '$idt_produits'";

                            if($db->Execute ( $sql ))
                            {
                                $ok &= true;
                            }
                            else
                            {
                                $isOk &= false;
                                $ok &= false;
                            }
                        }

                        $filepath_inventaire = $inventaire_filename.".html";
                        $sql = "UPDATE t_inventaires
                            SET filepath = '$filepath_inventaire'
                            WHERE idt_inventaires = $id_inventaire";

                        $filepath_ecarts = $ecarts_filename.".html";
                        $sql1 = "UPDATE t_inventaires
                            SET ecartspath = '$filepath_ecarts'
                            WHERE idt_inventaires = $id_inventaire";

                        if($db->Execute ( $sql ) && $db->Execute ( $sql1 )){
                            $db->commit();
                        }else{
                            $db->rollBack();
                        }
                    }else{

                    }
                //    echo $htmlContent;
                    $target = "gestion_magasin/recapitulatif_inventaire";
                }
                else
                {
                    $target = "main";
                }
            }else{
                $target = "main";
            }
		}
		$tpl_index->display('magasin/'.$target.'.tpl');
	}
?>