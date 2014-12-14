<?php
/**
	Fichier GetTableauFournisseurs.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations des produits présents en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

$datas = $db->getAllFournisseurs();
?>
<script language="javascript">
$(document).ready (function ()
{
	$(".edit_fournisseur").each (function ()
	{
		$(this).click (function ()
		{
			update_content ("ajax/popups/edit_fournisseur.php", "popup", "id_fournisseur=" + $(this).attr ("id_fournisseur"));
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
<table class="tablesorter" style="width: 100%;" border="0" id="tableau_fournisseurs">
	<thead>
    	<tr>
        	<th>Raison sociale</th>
        	<th>Adresse du fournisseur</th>
            <th>Numéro du téléphone</th>
            <th>Nombre de factures</th>
            <th>Date enregistrement fournisseur</th>
            <th>Durée dépuis derniére livraison</th>
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
                    <td align="center"><span class="floatAndMarginLeft"><?php echo $obj["nom_fournisseur"]; ?></span></td>
                    <td align="center"><span class="floatAndMarginLeft"><?php echo $obj["adresse_fournisseur"]; ?></span></td>
                    <td align="center"><span class="floatAndMarginLeft"><?php echo $obj["telephone_fournisseur"]; ?></span></td>
                    <td align="center"><span class="floatAndMarginLeft"><?php if( $obj["idt_factures"] != NULL ) echo $obj["nb_factures"]; else echo 0 ;?></span></td>
                    <td align="center"><span class="floatAndMarginLeft"><?php echo SQLDateTimeToFrenchDateTime( $obj["date_insertion"] ); ?></span></td>
                    <td align="center"><span class="floatAndMarginLeft"><?php echo getElaspedDateTime( $obj["date_insertion_facture"], setLocalTime() ); ?></span></td>
                    <td align="center">
                    <?php if( $_SESSION ["infoUser"]["idt_types_users"] <= 3 ){?>
                        <img src="css/images/page_white_edit.png" title="modifier" border="0" class="edit_fournisseur" style="cursor: pointer;" id_fournisseur="<?=$obj ["idt_fournisseurs"]; ?>" />
                        <a class="delete_link" title="supprimer" url="delete.php?target=fournisseur&id=<?=$obj["idt_fournisseurs"]; ?>"><img src="css/images/supprimer.png" border="0" /></a>
                    <?php }?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>