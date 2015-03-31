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
//$datasAchats = $db->getAllProduitsAchetesNonInventories();
//$datasVentes = $db->getAllProduitsVendusNonInventories();

//if( COUNT( $produits ) > 0 )
//{
//    foreach ( $produits as &$produit )
//    {
//        $produitsAchats = $db->getProduitWithAchat( $produit["idt_produits"] );
//        $produit["produits_achats"] = $produitsAchats;
//    }
//}
//else
//{
//
//}
?>
<script language="javascript">
$(document).ready (function ()
{
	$(".edit_produit").each (function ()
	{
		$(this).click (function ()
		{
            $("#id_produit").val($(this).attr("id_produit"));
            $("#nom_produit").val($(this).attr ("nom_produit"));
            $("#prix_vente").val( $(this).attr ("prix_vente") );
            $("#prix_achat").val($(this).attr ("prix_achat"));

            $('html, body').animate({ scrollTop: 0 }, 'slow');
            $("#editProduit").show("slow");

//			update_content ("ajax/popups/edit_produit.php", "popup", "id_produit=" + $(this).attr ("id_produit"));
//			ShowPopupHeight (550);
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
            foreach( $produits as &$obj )
            {
                $quantite_achetee = 0;
                $quantite_vendue = 0;

                $dataAchat = $db->getProduitAcheteNonInventorie( $obj["idt_produits"]);
                $dataVente = $db->getProduitVenduNonInventorie( $obj["idt_produits"] );

                if( count( $dataAchat ) > 0 ){
                    $quantite_achetee = $dataAchat[0]["quantite_achetee"];
                }

                if( count( $dataVente ) > 0 ){
                    $quantite_vendue = $dataVente[0]["quantite_vente"];
                }

                    ?>
                    <tr>
                        <td align="center"><span class='floatAndMarginLeft'><?php echo $obj["nom_produit"]; ?></span></td>
                        <td align="center"><span class='floatAndMarginLeft'><?php echo $obj["stock_initial"]; ?></span></td>
                        <td align="center"><span class='floatAndMarginLeft'><?php echo $obj["stock_initial"] + $quantite_achetee - $quantite_vendue; ?></span></td>
                        <td align="center"><span class='floatAndMarginLeft'><?php echo $quantite_achetee; ?></span></td>
                        <td align="center"><span class='floatAndMarginLeft'><?php echo $quantite_vendue; ?></span></td>
                        <td align="center"><span class='floatAndMarginLeft'><?php echo number_format( $obj["prix_achat"], 2, ',', ' ' ); ?></span></td>
                        <td align="center"><span class='floatAndMarginLeft'><?php echo number_format( $obj["prix_vente"], 2, ',', ' '); ?></span></td>
                        <td align="center">
                        <?php if($_SESSION ["infoUser"]["idt_types_users"] <= 3){?>
                            <img src="css/images/edit.png" title="modifier" border="0" class="edit_produit" style="cursor: pointer; margin: 1px;" id_produit="<?=$obj ["idt_produits"]; ?>" nom_produit="<?=$obj ["nom_produit"]; ?>" prix_vente="<?=$obj ["prix_vente"]; ?>" prix_achat="<?=$obj ["prix_achat"]; ?>"/>
                            <a class="delete_link" style="margin: 1px; cursor: pointer;" title="supprimer" url="delete.php?target=produit&id=<?=$obj["idt_produits"]; ?>"><img src="css/images/delete.png" border="0" /></a>
                        <?php }?>
                        </td>
                    </tr>
                    <?php
            }
        }
        ?>
    </tbody>
</table>