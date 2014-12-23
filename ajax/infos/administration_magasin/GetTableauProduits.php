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

// $datas = $db->getAllProduitsWithAchats ();

$produits = $db->getAllProduits();
if( COUNT( $produits ) > 0 )
{
    foreach ( $produits as &$produit ) 
    {
        $produitsAchats = $db->getProduitWithAchat( $produit["idt_produits"] );
        $produit["produits_achats"] = $produitsAchats;
    }
}
else
{

}
?>
<script language="javascript">
$(document).ready (function ()
{
	$(".edit_produit").each (function ()
	{
		$(this).click (function ()
		{
			update_content ("ajax/popups/edit_produit.php", "popup", "id_produit=" + $(this).attr ("id_produit"));
			ShowPopupHeight (550);
		});
	});
});
</script>
<style type="text/css">
.floatAndMarginLeft{
    float: left;
    margin-left: 10px;
}
</style>
<table class="tablesorter" style="width: 100%;" border="0" id="tableau_produits">
	<thead>
    	<tr>
        	<th>Désignation du produit</th>
            <th>Stock initial</th>
            <th>Quantité en stock</th>
            <th>Quantité achetée</th>
            <th>Quantité vendue</th>
            <th>Prix d'achat par unité (FCFA)</th>
            <th>Prix de vente par unité (FCFA)</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if( count( $produits ) > 0)
        {
            foreach( $produits as &$objs )
            {
                foreach ( $objs["produits_achats"] as $obj ) 
                {
                    ?>
                    <tr>
                        <td align="center"><span class='floatAndMarginLeft'><?php echo $obj["nom_produit"]; ?></span></td>
                        <td align="center"><span class='floatAndMarginLeft'><?php echo $obj["stock_initial"]; ?></span></td>
                        <td align="center"><span class='floatAndMarginLeft'><?php echo $obj["stock_initial"] + $obj["quantite_achat"]; ?></span></td>
                        <td align="center"><span class='floatAndMarginLeft'><?php if( $obj["quantite_achat"] != NULL ) echo $obj["quantite_achat"]; else echo 0; ?></span></td>
                        <td align="center"><span class='floatAndMarginLeft'><?php echo $obj["stock_initial"] + $obj["quantite_achat"] - $obj["stock_physique"]; ?></span></td>
                        <td align="center"><span class='floatAndMarginLeft'><?php echo number_format( $obj["prix_achat"], 2, ',', ' ' ); ?></span></td>
                        <td align="center"><span class='floatAndMarginLeft'><?php echo number_format( $obj["prix_vente"], 2, ',', ' '); ?></span></td>
                        <td align="center">
                        <?php if($_SESSION ["infoUser"]["idt_types_users"] <= 3){?>
                            <img src="css/images/page_white_edit.png" title="modifier" border="0" class="edit_produit" style="cursor: pointer;" id_produit="<?=$obj ["idt_produits"]; ?>" />
                            <a class="delete_link" title="supprimer" url="delete.php?target=produit&id=<?=$obj["idt_produits"]; ?>"><img src="css/images/supprimer.png" border="0" /></a>
                        <?php }?>
                        </td>
                    </tr>
                    <?php
                }
            }
        }
        ?>
    </tbody>
</table>