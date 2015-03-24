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

$datas = $db->getAllProduitsWithAchats ();
?>
<script language="javascript">
$(document).ready (function ()
{
	$(".edit_produit").each (function ()
	{
		$(this).click (function ()
		{
			update_content ("ajax/popups/edit_produit_inventaire.php", "popup", "id_produit=" + $(this).attr ("id_produit"));
			ShowPopupHeight (550);
		});
	});

    $(".consult_produit").each (function ()
    {
        $(this).click (function ()
        {
            update_content ("ajax/popups/consult_produit.php", "popup", "id_produit=" + $(this).attr ("id_produit"));
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
        	<th>Quantité en stock</th>
            <th>Stock physique</th>
            <th>Prix d'achat par unité (FCFA)</th>
            <th>Prix de vente par unité (FCFA)</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if( count( $datas ) > 0)
        {
            foreach( $datas as &$obj )
            {
                ?>
                <tr>
                    <td align="center"><span class="floatAndMarginLeft"><?php echo $obj["nom_produit"]; ?></span></td>
                    <td align="center"><span class="floatAndMarginLeft"><?php if( $obj["quantite_achat"] != NULL ) echo $obj["stock_initial"] + $obj["quantite_achat"]; else echo $obj["stock_initial"]; ?></span></td>
                    <td align="center"><span class="floatAndMarginLeft"><?php echo $obj["stock_physique"]; ?></span></td>
                    <td align="center"><span class="floatAndMarginLeft"><?php echo number_format( $obj["prix_achat"], 2, ',', ' '); ?></span></td>
                    <td align="center"><span class="floatAndMarginLeft"><?php echo number_format( $obj["prix_vente"], 2, ',', ' '); ?></span></td>
                    <td align="center">
                        <img src="css/images/bullseye.png" title="réaliser un inventaire" border="0" class="consult_produit" style="cursor: pointer; margin: 1px;" id_produit="<?=$obj ["idt_produits"]; ?>" />
                    <?php if($_SESSION ["infoUser"]["idt_types_users"] <= 3){?>
                        <img src="css/images/edit.png" title="modifier un inventaire" border="0" class="edit_produit" style="cursor: pointer; margin: 1px;" id_produit="<?=$obj ["idt_produits"]; ?>" />
                    <?php }?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>