<?php
/**
	Fichier GetTableauHistoriquesFactures.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations des factures en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

isset( $_POST ["date_histo_facture"] ) ? $date_histo_facture = addslashes(htmlspecialchars($_POST ["date_histo_facture"])) : $date_histo_facture = "";
$id_groupe = "";
if( isset($_SESSION["id_groupe"]) AND $_SESSION["id_groupe"] != NULL AND $_SESSION["id_groupe"] != "" )
{
    $id_groupe = $_SESSION["id_groupe"];
}
//    $histo_factures = $db->getHistoriquesFactures();
$histo_factures = $db->getHistoriquesFacturesByDate( FrenchDateToSQLDate( $date_histo_facture ), $id_groupe );
if( COUNT($histo_factures) > 0 )
{
    foreach ( $histo_factures as &$facture ) 
    {
        $produitsFacture = $db->getAllHistoriquesAchatsByFacture( $facture["idt_historiques_factures"] );
        $facture["produits_associes"] = $produitsFacture;
    }
}

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
    if( count( $histo_factures ) > 0)
    {
        foreach( $histo_factures as $obj ) 
        {
            $prix_total_facture = 0;
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

                    <table cellspacing="2" cellpadding="2" class="blocInfoBis" width="100%">
                        <tr>
                            <td>
                                <tr class="blocInfoBis">
                                    <td class="blocTitreId">Numéro facture : <br/><strong><?php  echo $obj["numero_facture"]; ?></strong></td>
                                    <td class="blocTitreId">Nom fournisseur : <br/><strong><?php  echo $obj["nom_fournisseur"]; ?></strong></td>  
                                    <td class="blocTitreId">Date facture : <br/><strong><?php  echo SQLDateToFrenchDate( $obj["date_facture"] ); ?></strong></td>
                                    <td class="blocTitreId">Enregistrée le : <br/><strong><?php  echo SQLDateTimeToFrenchDateTime( $obj["date_insertion_facture"] ); ?></strong></td>
                                    <td class="blocTitreId">Enregistrée par : <br/><strong></strong></td>                                       
                                </tr>
                                <tr height="5px;"></tr>
                                <tr class="blocInfoBis">
                                    <td class="blocTitre">Nom produit </td>
                                    <td class="blocTitre">Quantité achétée </td>
                                    <td class="blocTitre">Prix d'achat (FCFA)</td>
                                    <td class="blocTitre">Date fabrication </td>  
                                    <td class="blocTitre">Date péremption </strong></td>
                                </tr>
                                <tr height="5px;"></tr>
                                <?php
                                foreach ( $obj["produits_associes"] as $value ) 
                                {
                                    $prix_total_facture += $value["quantite_achat"] * $value["prix_achat"];
                                ?>
                                <tr class="blocInfoBis">
                                    <td class="blocValue"><?php  echo $value["nom_produit"]; ?></td>
                                    <td class="blocValue"><?php  echo $value["quantite_achat"]; ?></td>
                                    <td class="blocValue"><?php  echo number_format($value["prix_achat"], 2, ',', ' '); ?></td>
                                    <td class="blocValue"><?php  echo SQLDateToFrenchDate( $value["date_fabrication"] ); ?></td>  
                                    <td class="blocValue"><?php  echo SQLDateToFrenchDate( $value["date_peremption"] ); ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                
                                <tr>    
                                    <td align="left" valign="middle"><a class="links" filename="filename"><img src="assets/images/tick.jpg" alt="" width="16" height="16" /> Téléchargez la facture</a></td>  
                                    <td class="blocTitre"></td>
                                    <td class="blocTitre"></td>
                                    <td class="blocTitre">Prix total de la facture : </td>
                                    <td class="blocTitre"><?php echo number_format($prix_total_facture, 2, ',', ' ');?> FCFA</td>               
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