<?php
/**
	Fichier GetTableauProduitsOperation.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations des produits d'un journal.
*/
//@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

$datas = $db->getProduitsOperations();
?>
<script language="javascript">
$(document).ready (function ()
{
	$(".edit_produit_operation").each (function ()
	{
		$(this).click (function ()
		{
            $("#id_operation_journal").val($(this).attr("id_operation_journal"));
            $("#nom_produit_search").val($(this).attr ("nom_produit"));
            $("#quantite_vendue").val( $(this).attr ("quantite_vendue") );

            $('html, body').animate({ scrollTop: 0 }, 'slow');
            $("#editOperationJournal").show("slow");

//			update_content ("ajax/popups/edit_operation.php", "popup", "id_produit_operation=" + $(this).attr ("id_produit_facture"));
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
            <th>Numéro opération</th>
        	<th>Désignation du produit</th>
        	<th>Prix de vente (FCFA)</th>
            <th>Quantité vendue</th>
            <th>Montant total (FCFA)</th>
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
                    <td align="center"><span class='floatAndMarginLeft'><?php echo $obj["numero_operation"]; ?></span></td>
                    <td align="center"><span class='floatAndMarginLeft'><?php echo $obj["nom_produit"]; ?></span></td>
                    <td><span class='floatAndMarginLeft'><?php echo number_format( $obj["prix_vente"], 2, ',', ' '); ?></span></td>
                    <td align="center"><span class='floatAndMarginLeft'><?php echo $obj["quantite_vendue"]; ?></span></td>
                    <td><span class='floatAndMarginLeft'><?php echo number_format( $obj["prix_vente"] * $obj["quantite_vendue"], 2, ',', ' '); ?></span></td>
                    <td align="center">
                    <?php if($_SESSION ["infoUser"]["idt_types_users"] <= 4){?>
                        <img src="css/images/edit.png" title="modifier" border="0" class="edit_produit_operation" style="cursor: pointer; margin: 1px;" id_operation_journal="<?=$obj ["idt_produits_operations"]; ?>" nom_produit="<?=$obj ["nom_produit"]; ?>" quantite_vendue="<?=$obj ["quantite_vendue"]; ?>" />
                        <a class="delete_link" style="margin: 1px;" title="supprimer" url="delete.php?target=produit_operation&id=<?=$obj["idt_produits_operations"]; ?>"><img src="css/images/delete.png" border="0" /></a>
                    <?php }?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>