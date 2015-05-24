<?php
/**
	Fichier GetTableauProduitsFactureAchat.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations des produits d'une facture en.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

$datas = $db->getAllProduitsFactureAchats ();
?>
<script language="javascript">
$(document).ready (function ()
{
	$(".edit_produit_facture").each (function ()
	{
		$(this).click (function ()
		{
            $("#id_produit_achat").val($(this).attr("id_produit_achat"));
            $("#nom_produit_search").val($(this).attr ("nom_produit"));
            $("#quantite_achat").val($(this).attr ("quantite_achat"));
            $("#date_fabrication").val( $(this).attr ("date_fabrication") );
            $("#date_peremption").val( $(this).attr ("date_peremption") );

            $('html, body').animate({ scrollTop: 0 }, 'slow');
            $("#editProduitFacture").show("slow");
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
            <th>Montant (FCFA)</th>
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
                        <img src="css/images/edit.png" title="modifier" border="0" class="edit_produit_facture" style="cursor: pointer;" id_produit_achat="<?=$obj ["idt_produits_achats"]; ?>" nom_produit="<?=$obj ["nom_produit"]; ?>" quantite_achat="<?=$obj ["quantite_achat"]; ?>" date_fabrication="<?= SQLDateToFrenchDate( $obj ["date_fabrication"] ); ?>" date_peremption="<?= SQLDateToFrenchDate( $obj ["date_peremption"] ); ?>" />
                        <a class="delete_link" title="supprimer" url="delete.php?target=produit_facture&id=<?=$obj["idt_produits_achats"]; ?>"><img src="css/images/delete.png" border="0" /></a>
                    <?php }?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>