<?php
/**
	Fichier GetIdProduitByNom.php
	-----------------------------------
	Ce fichier retourne l'id d'un produit connaissant son nom.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

isset( $_POST ["nom_produit"] ) ? $nom_produit = addslashes(htmlspecialchars($_POST ["nom_produit"])) : $nom_produit = "";
if( $nom_produit != "" )
{
    $id_produit = $db->getIdProduitByNom( $nom_produit );
}
else
{
    $id_produit = -1;
}

?>
<div><?php echo $id_produit;?></div>