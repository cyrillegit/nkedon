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

$datas = $db->getAllProduitsFacture ();
?>
<script language="javascript">
$(document).ready (function ()
{
	$(".edit_produit_facture").each (function ()
	{
		$(this).click (function ()
		{
			update_content ("ajax/popups/edit_produit_facture.php", "popup", "id_produit_facture=" + $(this).attr ("id_produit_facture"));
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
            <th>Prix d'achat (FCFA)</th>
        	<th>Quantité achetée</th>
            <th>Prix total (FCFA)</th>
            <th>Date fabrication</th>
            <th>Date peremption</th>
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
                    <td align="center"><span class='floatAndMarginLeft'><?php echo $obj["nom_produit"]; ?></span></td>
                    <td><span class='floatAndMarginLeft'><?php echo number_format( $obj["prix_achat"], 2, ',', ' '); ?></span></td>
                    <td align="center"><span class='floatAndMarginLeft'><?php echo $obj["quantite_achat"]; ?></span></td>
                    <td><span class='floatAndMarginLeft'><?php echo number_format( $obj["prix_achat"] * $obj["quantite_achat"], 2, ',', ' '); ?></span></td>
                    <td align="center"><span class='floatAndMarginLeft'><?php echo SQLDateToFrenchDate( $obj["date_fabrication"] ); ?></span></td>
                    <td align="center"><span class='floatAndMarginLeft'><?php echo SQLDateToFrenchDate( $obj["date_peremption"] ); ?></span></td>
                    <td align="center">
                    <?php if($_SESSION ["infoUser"]["idt_types_users"] <= 4){?>
                        <img src="css/images/page_white_edit.png" title="modifier" border="0" class="edit_produit_facture" style="cursor: pointer;" id_produit_facture="<?=$obj ["idt_produits_factures"]; ?>" />
                        <a class="delete_link" title="supprimer" url="delete.php?target=produit_facture&id=<?=$obj["idt_produits_factures"]; ?>"><img src="css/images/supprimer.png" border="0" /></a>
                    <?php }?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>