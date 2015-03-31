<?php
/**
	Fichier GetTableauProduitsForInventaire.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations des produits pour un inventaire présents en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

$produits = $db->getAllProduits();
//$datasAchats = $db->getAllProduitsAchetesNonInventories();
//$datasVentes = $db->getAllProduitsVendusNonInventories();
?>
<script language="javascript">
$(document).ready (function ()
{
	$(".consult_produit").each (function ()
	{
		$(this).click (function ()
		{
            $("#id_produit").val($(this).attr("id_produit"));
            $("#nom_produit").val($(this).attr("nom_produit"));
            $("#stock_physique").val($(this).attr ("stock_physique"));

            $("#addInventaire").hide();
            $("#msgInventaire").hide();
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            $("#editStockPhysique").show("slow");

//			update_content ("ajax/popups/edit_produit_inventaire.php", "popup", "id_produit=" + $(this).attr ("id_produit"));
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
        	<th>Quantité en stock</th>
            <th>Quantité vendue</th>
            <th>Stock physique</th>
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
                    <td align="center"><span class="floatAndMarginLeft"><?php echo $obj["nom_produit"]; ?></span></td>
                    <td align="center"><span class="floatAndMarginLeft"><?php echo $obj["stock_initial"] + $quantite_achetee - $quantite_vendue; ?></span></td>
                    <td align="center"><span class="floatAndMarginLeft"><?php echo $quantite_vendue; ?></span></td>
                    <td align="center"><span class="floatAndMarginLeft"><?php echo $obj["stock_physique"]; ?></span></td>
                    <td align="center"><span class="floatAndMarginLeft"><?php echo number_format( $obj["prix_achat"], 2, ',', ' '); ?></span></td>
                    <td align="center"><span class="floatAndMarginLeft"><?php echo number_format( $obj["prix_vente"], 2, ',', ' '); ?></span></td>
                    <td align="center">
                        <img src="css/images/bullseye.png" title="réaliser un inventaire" border="0" class="consult_produit" style="cursor: pointer; margin: 1px;" id_produit="<?=$obj ["idt_produits"]; ?>" stock_physique="<?=$obj ["stock_physique"]; ?>" nom_produit="<?=$obj ["nom_produit"]; ?>" />
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>