<?php
/**
	Fichier GetTableauFactureVente.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations de la facture courante en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

// get the type of the current user
$id_type_user = $_SESSION["infoUser"]["idt_types_users"];
// unset deletion mode
unset( $_SESSION["delete"] );

$id_facture = $db->getMaxIdFactureVente();
$factures = $db->getInfosFactureVenteyId( $id_facture );

?>
<script language="javascript">
$(document).ready (function ()
{
    $(".download_links").each (function ()
    {
        $(this).click (function ()
        {
            window.open(
                'downloads.php?sub=facture_vente&id_facture='+$(this).attr("id_facture"),
                '_blank'
            );
        });
    });

    $(".edit_links").each (function ()
    {
        $(this).click (function ()
        {
            var id_facture = $(this).attr("id_facture");
            document.location.href="magasin.php?sub=edit_historique_facture_vente&id_facture_vente="+$(this).attr("id_facture");
        });
    });
});
</script>
    <style type="text/css">
        .blocInfoBis
        {
            background-image: url("css/images/bg_bloc_alertes.png");
            background-repeat: repeat;
            border: 1px solid #313131;
            padding: 5px 5px 5px;
        }
        .download_links{
            font-weight:bold;
            color: #000000;
            text-decoration:none;
            font-size:12px;
        }
        .edit_links{
            font-weight:bold;
            color:#ff0000;
            text-decoration:none;
            font-size:12px;
        }
        .blocTitreId{
            color: white;
            font-weight: bold;
            width: 20%;
        }
        .blocTitre{
            color: black;
            font-weight: bold;
            width: 20%;
        }
        .blocValue{
            color: white;
            font-weight: bold;
            width: 20%;
        }
    </style>
<?php
    if( count( $factures ) > 0)
    {
            $prix_total_facture = 0;
?>
        <div class="hvr-bounce-to-right" style="width: 100%; margin-bottom: 10px;">
            <form name="form_popup" id="form_popup" method="post">

                <table cellspacing="3" cellpadding="3" class="blocInfoBis" width="100%">
                    <tr>
                        <td>
                    <tr class="blocInfoBis">
                        <td class="blocTitreId">Numéro facture : <br/><strong><?php  echo $factures[0]["numero_facture"]; ?></strong></td>
                        <td class="blocTitreId">Enregistrée le : <br/><strong><?php  echo SQLDateTimeToFrenchDateTime( $factures[0]["date_facture"] ); ?></strong></td>
                        <td class="blocTitreId">Enregistrée par : <br/><strong><?php  echo $factures[0]["nom_user"]."  ".$factures[0]["prenom_user"]; ?></strong></td>
                        <td class="blocTitreId">Nom du client : <br/><strong><?php  echo $factures[0]["nom_client"]; ?></strong></td>
                    </tr>
                    <tr height="5px;"></tr>
                    <tr class="blocInfoBis">
                        <td class="blocTitre">Nom produit </td>
                        <td class="blocTitre">Quantité vendue </td>
                        <td class="blocTitre">Prix de vente (FCFA)</td>
                        <td class="blocTitre">Montant de la vente (FCFA)</td>
                        <td class="blocTitre">Commentaire</td>
                    </tr>
                    <tr height="5px;"></tr>
                    <?php
                    foreach ( $factures as $value )
                    {
                        $prix_total_facture += $value["quantite_vendue"] * $value["prix_vente"];
                        ?>
                        <tr class="blocInfoBis">
                            <td class="blocValue"><?php  echo $value["nom_produit"]; ?></td>
                            <td class="blocValue"><?php  echo $value["quantite_vendue"]; ?></td>
                            <td class="blocValue"><?php  echo number_format($value["prix_vente"], 2, ',', ' '); ?></td>
                            <td class="blocValue"><?php  echo number_format($value["quantite_vendue"] * $value["prix_vente"], 2, ',', ' '); ?></td>
                        </tr>
                    <?php
                    }
                    ?>

                    <tr>
                        <td align="left" valign="middle"><a class="download_links" id_facture="<?=$factures[0]["idt_factures_ventes"]; ?>"><img src="assets/images/arrow_down.png" alt="" width="16" height="16" /> Téléchargez la facture</a></td>
                        <td class="blocTitre"><?php  if( $id_type_user <= 2 ){; ?><a class="edit_links" id_facture="<?=$factures[0]["idt_factures_ventes"]; ?>"><img src="assets/images/edit.png" alt="" width="16" height="16" /> Modifier la facture</a><?php  } ?></td>
                        <td class="blocTitre">Montant de la facture : </td>
                        <td class="blocTitre"><?php echo number_format($prix_total_facture, 2, ',', ' ');?> FCFA</td>
                        <td class="blocTitreId">
                            <textarea style="height: 100%; width: 100%; text-align: left;" readonly="readonly">
                                <?php  echo trim(stripslashes(htmlentities($factures[0]["commentaire"]))); ?>
                            </textarea>
                        </td>
                    </tr>
                    </td>
                    </tr>
                </table>
            </form>
        </div>
        <br />    
<?php
    }
?>