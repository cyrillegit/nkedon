<?php
/**
	Fichier GetTableauMatieresPremieres.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations des matieres premieres présentes en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

$matieres_premieres = $db->getAllMatieresPremieres();

?>
<script language="javascript">
$(document).ready (function ()
{
	$(".edit_matiere_premiere").each (function ()
	{
		$(this).click (function ()
		{
            $("#id_matiere_premiere").val($(this).attr("id_matiere_premiere"));
            $("#nom_matiere_premiere").val($(this).attr ("nom_matiere_premiere"));
            $("#prix_achat").val($(this).attr ("prix_achat"));
            $("#quantite").val($(this).attr ("quantite"));

            $('html, body').animate({ scrollTop: 0 }, 'slow');
            $("#editMatierePremiere").show("slow");

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
<table class="tablesorter" style="width: 100%;" border="0" id="tableau_matieres_premieres">
	<thead>
    	<tr>
        	<th>Désignation de la matiére prémière</th>
            <th>Quantité en stock</th>
            <th>Prix d'achat par unité (FCFA)</th>
            <th>Derniére mis à jour</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if( count( $matieres_premieres ) > 0)
        {
            foreach( $matieres_premieres as &$obj )
            {
                ?>
                <tr>
                    <td align="center"><span class='floatAndMarginLeft'><?php echo $obj["nom_matiere_premiere"]; ?></span></td>
                    <td align="center"><span class='floatAndMarginLeft'><?php echo $obj["quantite"]; ?></span></td>
                    <td align="center"><span class='floatAndMarginLeft'><?php echo number_format( $obj["prix_achat"], 2, ',', ' ' ); ?></span></td>
                    <td align="center"><span class='floatAndMarginLeft'><?php echo SQLDateTimeToFrenchDateTime( $obj["date_matiere_premiere"] ); ?></span></td>
                    <td align="center">
                    <?php if($_SESSION ["infoUser"]["idt_types_users"] <= 3){?>
                        <img src="css/images/edit.png" title="modifier" border="0" class="edit_matiere_premiere" style="cursor: pointer; margin: 1px;" id_matiere_premiere="<?=$obj ["idt_matieres_premieres"]; ?>" nom_matiere_premiere="<?=$obj ["nom_matiere_premiere"]; ?>" prix_achat="<?=$obj ["prix_achat"]; ?>"  quantite="<?=$obj ["quantite"]; ?>"/>
                        <a class="delete_link" style="margin: 1px; cursor: pointer;" title="supprimer" url="delete.php?target=matiere_premiere&id=<?=$obj["idt_matieres_premieres"]; ?>"><img src="css/images/delete.png" border="0" /></a>
                    <?php }?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>