<?php
/**
	Fichier GetTableauGenerateSynthese.php
	-----------------------------------
	Ce fichier permet de generer la synthese de l'inventaire.
*/
@session_start ();
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");
@require_once('../../../include/ClassDownloadSyntheseInventaire.php');
@require_once("../../../include/ClassBackupDatabase.php");

$db = new Database ();

$ok = true;

if (!$_SESSION["connected"])
{
    // On est plus connecté, on sort.
    $ok &= false;
    $_SESSION ["sessionExpired"] = true;
    header ("Location: ../index.php");
}
else
{
    //register_shutdown_function('errorHandler');
    if ((!isset ($_SESSION ['infoUser'])))
    {
        $ok &= false;
        echo "({'result': 'FAILED', 'message': 'Erreur de sécurité. Vous êtes déconnecté.'})";
    }
    else
    {
        echo "({'result': 'SUCCESS', 'message': 'Vous etes connecté.'})";
  /*      try
        {
            $id_inventaire = $db->getMaxIdInventaire();
            var_dump( $id_inventaire );
            echo "Synthese";
            $sql1 = "UPDATE t_journal
						SET id_inventaire = '$id_inventaire'
						WHERE id_inventaire = 0";

            $sql2 = "UPDATE t_factures
						SET id_inventaire = '$id_inventaire'
						WHERE id_inventaire = 0";

            $db->beginTransaction ();

            if( $db->Execute ( $sql1 ) && $db->Execute ( $sql2 ) )
            {
                $db->commit ();
            }
            else
            {
                $ok &= false;
                $db->rollBack();
            }

            $html = new SyntheseInventaire( $id_inventaire );
            $htmlContent = $html->buildHtml();
            $html->buildPdf( $htmlContent );
            $filename = $html->getFilename();
            var_dump( $filename );*/


            /**
             * Instantiate Backup_Database and perform backup
             */
//            $backupDatabase = new BackupDatabase();
//            $status = $backupDatabase->backupTables() ? 'OK' : 'KO';

            /**
            * initiliaze db
            */  
//                $isOk = true;
//                $produits = $db->getTableProduits();
//                $db->beginTransaction ();
//                foreach ($produits as $produit)
//                {
//                    $idt_produits = $produit["idt_produits"];
//                    $stock_physique = $produit["stock_physique"];
//                    $sql = "UPDATE t_produits
//                            SET stock_initial = '$stock_physique',
//                                stock_physique = 0
//                            WHERE idt_produits = '$idt_produits'";
//
//                    if($db->Execute ( $sql ))
//                    {
//                        $ok &= true;
//                    }
//                    else
//                    {
//                        $isOk &= false;
//                        $ok &= false;
//                    }
//                }
//
//                if($isOk){
//                    $db->commit();
//                }else{
//                    $db->rollBack();
//                }
//            }
//            else
//            {
//            //    header("Location:../magasin.php?sub=recapitulatif_inventaire");
//            }
  /*      }
        catch (Exception $e)
        {
            $msg = $e->getMessage();
            $ok &= false;
            echo "({'result': 'FAILED', 'message': 'Exception : ".$msg."'})";
        }*/
    }
}

//    $path_to_file = "Inventaire/".$file_inventaire.".pdf";
//    $sql = "UPDATE t_inventaires
//            SET filepath = '$path_to_file'
//            WHERE idt_inventaires = $id_inventaire";
//
//    $db->beginTransaction ();
//    if($db->Execute ( $sql ))
//    {
//        $ok &= true;
//        $db->commit();
//    }
//    else
//    {
//        $ok &= false;
//        $db->rollBack();
//    }

?>
