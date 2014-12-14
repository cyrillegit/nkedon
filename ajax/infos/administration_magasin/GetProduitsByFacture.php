<?php
/**
	Fichier GetTableauProduitsFacture.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations des produits d'une facture en.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

    $sql = "DELETE FROM t_produits_factures";
    if( $db->Execute ( $sql ) )
    {
        $ok &= true;
    }
    else
    {
        $ok &= false;
    }

    isset( $_POST ["id_facture"] ) ? $id_facture = $_POST ["id_facture"] : $id_facture = "";

    if( $id_facture != "" )
    {
        $ok = true;
        $datas = $db->getProduitsByFacture ( $id_facture );
        foreach ($datas as $obj) 
        {
           $prix_total_produits = 0;
           $id_produit = $obj["id_produit"];
           $quantite_achat = $obj["quantite_achat"];
           $date_fabrication = $obj["date_fabrication"];
           $date_peremption = $obj["date_peremption"];
           $prix_total_produits = $obj["quantite_achat"] * $obj["prix_achat"];

            $sql = "INSERT INTO t_produits_factures
                        (id_produit,
                         quantite_achat,
                         prix_total_produits,
                         date_fabrication,
                         date_peremption)
            VALUES ('$id_produit',
                    '$quantite_achat',
                    '$prix_total_produits',
                    '$date_fabrication',
                    '$date_peremption')";

            if( $db->Execute ( $sql ) )
            {
                $ok &= true;
            }
            else
            {
                $ok &= false;
            }
        }
    }
    else
    {
        $ok = false;
    }

    if( $ok )
    {
        $db->commit ();
    //    echo "({'result': 'SUCCESS'})";
    }
    else
    {
        $db->rollBack();
    //    echo "({'result': 'Une erreur est survenue'})";
    }
?>
<script language="javascript">
$(document).ready (function ()
{

});
</script>