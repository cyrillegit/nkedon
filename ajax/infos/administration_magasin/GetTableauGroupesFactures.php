<?php
/**
	Fichier GetTableauRecapitulatifInventaire.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations de l'inventaire en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

isset( $_POST ["date_histo_facture"] ) ? $date_histo_facture = addslashes(htmlspecialchars($_POST ["date_histo_facture"])) : $date_histo_facture = "";

    $groupes_factures = $db->getGroupesFactures();
// $histo_factures = $db->getHistoriquesFacturesByDate( FrenchDateToSQLDate( $date_histo_facture ));
// if( COUNT($histo_factures) > 0 )
// {
//     foreach ( $histo_factures as &$facture ) 
//     {
//         $produitsFacture = $db->getAllHistoriquesAchatsByFacture( $facture["idt_historiques_factures"] );
//         $facture["produits_associes"] = $produitsFacture;
//     }
// }

?>
<script language="javascript">
$(document).ready (function ()
{
    $(".links").each (function ()
    {
        $(this).click (function ()
        {
        //    var filename = $(this).attr("filename");
        //    document.location.href="download.php?filename="+filename;
            alert("Bientot disponible");
        });
    });
});
</script>
<?php
    if( count( $groupes_factures ) > 0)
    {
        foreach( $groupes_factures as $obj ) 
        {
            $nb_factures_groupes = 0;
            $nb_factures_groupes = $db->getNbFacturesInGroupe( $obj["idt_groupes_factures"] );
?>
            <div style="width: 100%;">
                <form name="form_popup" id="form_popup" method="post">

                <style type="text/css">
                    .blocInfoBis
                    {
                        background-image: url("css/images/bg_bloc_alertes.png");
                        background-repeat: repeat;
                        border: 1px solid #313131;
                        padding: 5px 5px 5px;
                    }
                    .maindiv{ 
                        width:690px; 
                        margin:0 auto; 
                        padding:20px; 
                        background:#CCC;
                    }
                    .innerbg{ 
                        padding:6px; 
                        background:#FFF;
                    }
                    .links{ 
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
                    <a href="administration_magasin.php?sub=historiques_factures&id_groupe=<?=$obj ["idt_groupes_factures"]; ?>" style="text-decoration: none;">
                        <table cellspacing="2" cellpadding="2" class="blocInfoBis" width="100%">
                            <tr>
                                <td class="blocTitreId"><img src="assets/images/folder64.png"> <?php echo $obj["libelle"];?></td>
                                <td class="blocValue"> <?php echo  $nb_factures_groupes; if( $nb_factures_groupes <= 1 ){ echo " facture";}else{ echo " factures";}?><br/><br/> Synthése du <?php echo SQLDateTimeToFrenchDateTime( $obj["date_synthese"] );?></td>                                     
                            </tr>
                        </table>
                    </a>
                </form>
            </div>
        <br />    
<?php
        }
    }
?>