<?php
/**
Fichier GetTableauProduits.php
-----------------------------------
Ce fichier crée un tableau contenant les informations des produits présents en base de données.
 */
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

$id_inventaire = $db->getMaxIdInventaire();
if( $id_inventaire > 0 )
{
    $sql = "DELETE FROM t_inventaires WHERE idt_inventaires = $id_inventaire";
    if( $db->Execute ( $sql ) ) {
            $db->commit();
        } else {
            $db->rollBack();
        }
}
?>