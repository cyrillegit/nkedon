<?php
/**
	Fichier GetTableauHistoriquesFacturesAchats.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations des factures en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

isset( $_POST ["annee"] ) ? $annee = addslashes(htmlspecialchars($_POST ["annee"])) : $annee = "";
isset( $_POST ["mois"] ) ? $mois = addslashes(htmlspecialchars($_POST ["mois"])) : $mois = "";
isset( $_POST ["date_histo_journal"] ) ? $date_histo_journal = addslashes(htmlspecialchars($_POST ["date_histo_journal"])) : $date_histo_journal = "";
// get the type of the current user
$id_type_user = $_SESSION["infoUser"]["idt_types_users"];
// unset deletion mode
unset( $_SESSION["delete"] );

if(  $date_histo_journal == "" ) {
    $histo_journal = $db->getAllJournalByMoisAnnee( "", $mois, $annee );
}else{
    $jour = explode( "/", $date_histo_facture )[0];

    $histo_journal = $db->getAllJournalByMoisAnnee( $jour, $mois, $annee );
}

if( COUNT($histo_journal) > 0 )
{
    foreach ( $histo_journal as &$journal )
    {
        $operationJournal = $db->getAllHistoriquesOperationsByJournal( $journal["idt_journal"] );
        $journal["operations_associees"] = $operationJournal;
    }
}

?>
<script language="javascript">
$(document).ready (function ()
{
    $(".download_links").each (function ()
    {
        $(this).click (function ()
        {
            window.open(
                'downloads.php?sub=journal&id_journal='+$(this).attr("id_journal"),
                '_blank'
            );
        });
    });

    $(".edit_links").each (function ()
    {
        $(this).click (function ()
        {
            document.location.href="administration_magasin.php?sub=edit_historique_journal&id_journal="+$(this).attr("id_journal");
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
    if( count( $histo_journal ) > 0)
    {
        foreach( $histo_journal as $obj )
        {
            $montant_journal = 0;
?>
            <div class="hvr-bounce-to-right" style="width: 100%; margin-bottom: 10px;">
                <form name="form_popup" id="form_popup" method="post">

                    <table cellspacing="2" cellpadding="2" class="blocInfoBis" width="100%">
                        <tr>
                            <td>
                                <tr class="blocInfoBis">
                                    <td class="blocTitreId">Enregistrée le : <br/><strong><?php  echo SQLDateTimeToFrenchDateTime( $obj["date_journal"] ); ?></strong></td>
                                    <td class="blocTitreId">Enregistrée par : <br/><strong><?php  echo $obj["nom_user"]."  ".$obj["prenom_user"]; ?></strong></td>
                                    <td class="blocTitreId">Commentaire : </strong></td>
                                    <td class="blocTitreId" colspan="2" >
                                        <textarea style="height: 50px; width: 100%;" readonly="readonly">
                                            <?php  echo $obj["commentaire"]; ?>
                                        </textarea>
                                    </td>
                                </tr>
                                <tr height="5px;"></tr>
                                <tr class="blocInfoBis">
                                    <td class="blocTitre">Numéro de l'opération </td>
                                    <td class="blocTitre">Nom produit </td>
                                    <td class="blocTitre">Quantité vendue </td>
                                    <td class="blocTitre">Prix de vente (FCFA)</td>
                                    <td class="blocTitre">Montant de l'opération (FCFA)</td>
                                </tr>
                                <tr height="5px;"></tr>
                                <?php
                                foreach ( $obj["operations_associees"] as $value )
                                {
                                    $montant_journal += $value["quantite_vendue"] * $value["prix_vente"];
                                ?>
                                <tr class="blocInfoBis">
                                    <td class="blocValue"><?php  echo $value["numero_operation"]; ?></td>
                                    <td class="blocValue"><?php  echo $value["nom_produit"]; ?></td>
                                    <td class="blocValue"><?php  echo $value["quantite_vendue"]; ?></td>
                                    <td class="blocValue"><?php  echo number_format($value["prix_vente"], 2, ',', ' '); ?></td>
                                    <td class="blocValue"><?php  echo number_format($value["quantite_vendue"] * $value["prix_vente"], 2, ',', ' '); ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                
                                <tr>    
                                    <td align="left" valign="middle"><a class="download_links" id_journal="<?=$obj["idt_journal"]; ?>"><img src="assets/images/arrow_down.png" alt="" width="16" height="16" /> Téléchargez le journal</a></td>
                                    <td class="blocTitre"><?php  if( $id_type_user <= 2 ){; ?><a class="edit_links" id_journal="<?=$obj["idt_journal"]; ?>"><img src="assets/images/edit.png" alt="" width="16" height="16" /> Modifier le journal</a><?php  } ?></td>
                                    <td class="blocTitre"></td>
                                    <td class="blocTitre">Montant du journal : </td>
                                    <td class="blocTitre"><?php echo number_format($montant_journal, 2, ',', ' ');?> FCFA</td>
                                </tr>                                                                                                                                  
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        <br />    
<?php
        }
    }
?>