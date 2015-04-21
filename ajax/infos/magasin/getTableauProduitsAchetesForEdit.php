<?php
/**
    Fichier GetTableauProduits.php
    -----------------------------------
    Ce fichier crée un tableau contenant les informations des produits présents en base de données.
*/
@session_start();
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

isset( $_POST ["id_facture"] ) ? $id_facture = addslashes(htmlspecialchars($_POST ["id_facture"])) : $id_facture = "";

if($id_facture != NULL)
{
    if($_SESSION["load"])
    {
        $infos = $db->getInfosProduitsAchetesForEdit($id_facture);
        $ok = true;
        foreach ($infos as $info) 
        {
            $id_produit = $info["id_produit"];
            $quantite_achat = $info["quantite_achat"];
            $date_fabrication = $info["date_fabrication"];
            $date_peremption = $info["date_peremption"];

            $sql = "INSERT INTO t_produits_factures(
                                id_produit,
                                quantite_achat,
                                date_fabrication,
                                date_peremption)
                        VALUES('$id_produit',
                                '$quantite_achat',
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

        if( $ok )
        {
            $_SESSION["load"] = false;
            $db->commit ();
        }
        else
        {
            $db->rollBack();
        }
    }
    else
    {

    }
}
else
{

}
?>