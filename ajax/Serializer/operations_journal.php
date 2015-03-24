<?php
/* File: operations_journal.php
 * Author: Cyrille MOFFO (cyrille.moffo@nemand-soft.com)
 * -------------------------------------------------
 * Enregistrer/Modifier les operations d'un journal.
 */
//@require_once ('config/config.php');
//@require_once ('include/function.php');
@require_once('include/ClassDB.php');

$db = new Database ();
$db->beginTransaction ();

isset( $_POST ['id_operation'] ) ? $id = $_POST ['id_operation'] : $id = NULL;
if( $id != NULL )
{
//    isset( $_POST ["nom_produit_search"] ) ? $nom_produit = strtoupper(addslashes(htmlspecialchars($_POST ["nom_produit_search"]))) : $nom_produit = "";
//    isset( $_POST ["quantite_vendue"] ) ? $quantite_vendue = $_POST ["quantite_vendue"] : $quantite_vendue = "";
    echo $_POST['quantite_vendue'];

//    //Mode création (post:insert)
//    if( $id == 0 )
//    {
//        if( $nom_produit != NULL && $quantite_vendue != NULL )
//        {
//            $ok = true;
//            $produit = $db->getInfoProduitByNom( $nom_produit );
//            $id_produit = $produit["idt_produits"];
//
//            if($id_produit != NULL)
//            {
//                $ok &= true;
//            }
//            $ok &= isNumber($quantite_vendue);
//
//            $numero_operation = getDateWithUnderscrore(setLocalTime());
//
//            $sql = "INSERT INTO t_produits_operations
//							(id_produit,
//							 quantite_vendue,
//							 numero_operation)
//				VALUES ('$id_produit',
//						'$quantite_vendue',
//						'$numero_operation')";
//
//            if( $ok )
//            {
//                if( $db->Execute ( $sql ) )
//                {
//                    $db->commit ();
//                    echo "({'result': 'SUCCESS'})";
//                }
//                else
//                {
//                    $db->rollBack();
//                    echo "({'result': 'Une erreur est survenue lors de l \'insertion du produit en base de données...'})";
//                }
//            }
//            else
//            {
//                $db->rollBack();
//                echo "({'result': 'Une erreur est survenue lors de l \'insertion du produit en base de données...'})";
//            }
//        }
//        else
//        {
//            $db->rollBack();
//            echo "({'result': 'Une erreur est survenue car certaines values du produit sont nulles... '})";
//        }
//
//    }
//    //Mode mise à jour (post:update)
//    else
//    {
//        if( $nom_produit != NULL && $quantite_vendue != NULL )
//        {
//
//            $ok = true;
//            $produit = $db->getInfoProduitByNom( $nom_produit );
//            $numero_operation = "";
//
//            $ok &= isNumber($quantite_vendue);
//
//            $id_produit = $produit["idt_produits"];
//
//            $sql = "UPDATE t_produits_operations
//					SET id_produit = '$id_produit',
//						quantite_vendue = '$quantite_vendue',
//						numero_operation = '$numero_operation'
//					WHERE idt_produits_factures = $id";
//
//            if($ok){
//                if( $db->Execute ( $sql ) )
//                {
//                    $db->commit ();
//                    echo "({'result': 'SUCCESS'})";
//                }
//                else
//                {
//                    $db->rollBack();
//                    echo "({'result': 'Une erreur est survenue lors de la mise à jour du produit en base de données... '})";
//                }
//            }else{
//                $db->rollBack();
//                echo "({'result': 'Une erreur est survenue lors de la mise à jour du produit en base de données... '})";
//            }
//        }
//        else
//        {
//            $db->rollBack();
//            echo "({'result': 'Une erreur est survenue lors de la mise à jour du produit en base de données car certaines valeurs sont nulles '})";
//        }
//    }
}
else
{
    @header("Location: ../index.php");
}
?>