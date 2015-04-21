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

isset( $_POST ["date_histo_synthese"] ) ? $date_histo_synthese = addslashes(htmlspecialchars($_POST ["date_histo_synthese"])) : $date_histo_synthese = "";

if($date_histo_synthese == "")
{
    $histo_syntheses = $db->getHistoriqueSynthese();
}
else
{
    $histo_syntheses = $db->getHistoriqueSyntheseByDate(FrenchDateToSQLDate($date_histo_synthese));
}


?>
<script language="javascript">
$(document).ready (function ()
{
    $(".links").each (function ()
    {
        $(this).click (function ()
        {
            var filename = $(this).attr("filename");
            document.location.href="download.php?filename="+filename;
        });
    });
});
</script>
<?php
    if( count( $histo_syntheses ) > 0)
    {
        foreach ($histo_syntheses as $obj) 
        {
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
                    .td_width{
                        width: 50%;
                    }
                    .float_right{
                        float: right;
                    }
                </style>

                    <table cellspacing="2" cellpadding="2" class="blocInfoBis" width="100%">
                        <tr>
                            <!--PARTIE GAUCHE-->
                            <td  class="td_width">
                                <table cellspacing="5" cellpadding="2" width="100%">
                                    <tr class="blocInfoBis">
                                        <td>Nom du caissier :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php  echo $obj["nom_user"]." ".$obj["prenom_user"]; ?></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Achats mensuels :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php  echo number_format( $obj["achats_mensuels"], 2, ',', ' '); ?>  <span class="float_right">FCFA</span></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Ventes mensuelles :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo number_format( $obj["ventes_mensuelles"], 2, ',', ' '); ?>  <span class="float_right">FCFA</span></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Montant marchandises en stock :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo number_format( $obj["montant_stock"], 2, ',', ' '); ?>  <span class="float_right">FCFA</span></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Montant charges diverses  :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo number_format( $obj["montant_charges_diverses"], 2, ',', ' '); ?>  <span class="float_right">FCFA</span></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Ration :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo number_format( $obj["ration"], 2, ',', ' '); ?>  <span class="float_right">FCFA</span></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Dette fournisseur :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo number_format( $obj["dette_fournisseur"], 2, ',', ' '); ?>  <span class="float_right">FCFA</span></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Dépenses diverses  :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo number_format( $obj["depenses_diverses"], 2, ',', ' '); ?>  <span class="float_right">FCFA</span></strong></td>
                                    </tr>                            
                                    <tr class="blocInfoBis">
                                        <td>Date inventaire :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo SQLDateTimeToFrenchDateTime( $obj["date_inventaire"] ); ?></strong></td>
                                    </tr>
                                    <tr>    
                                        <td align="left" valign="middle"><a class="links" filename="<?=$obj ["filepath"]; ?>"><img src="assets/images/tick.jpg" alt="" width="16" height="16" /> Téléchargez le fichier de synthése</a></td>                     
                                    </tr>                                                                                                                                  
                                </table>
                            </td>
                            <!--PARTIE DROITE-->
                            <td class="td_width">
                                <table cellspacing="5" cellpadding="2" width="100%">
                                    <tr class="blocInfoBis">
                                        <td>Fonds en espéces :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo number_format( $obj["fonds_especes"], 2, ',', ' '); ?>  <span class="float_right">FCFA</span></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Patrimoine :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo number_format( $obj["patrimoine"], 2, ',', ' '); ?>  <span class="float_right">FCFA</span></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Recettes perçues :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo number_format( $obj["recettes_percues"], 2, ',', ' '); ?>  <span class="float_right">FCFA</span></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Bénéfice brut :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo number_format( $obj["benefice_brut"], 2, ',', ' '); ?>  <span class="float_right">FCFA</span></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Bénéfice net  :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo number_format( $obj["benefice_net"], 2, ',', ' '); ?>  <span class="float_right">FCFA</span></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Avaries :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo number_format( $obj["avaries"], 2, ',', ' '); ?>  <span class="float_right">FCFA</span></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Crédit client :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo number_format( $obj["credit_client"], 2, ',', ' '); ?>  <span class="float_right">FCFA</span></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Capsules :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo number_format( $obj["capsules"], 2, ',', ' '); ?>  <span class="float_right">FCFA</span></strong></td>
                                    </tr>                          
                                    <tr class="blocInfoBis">
                                        <td>Ecart :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo number_format( $obj["ecart"], 2, ',', ' '); ?>  <span class="float_right">FCFA</span></strong></td>
                                    </tr> 
                                    <tr class="blocInfoBis">
                                        <td>Solde  :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo number_format( $obj["solde"], 2, ',', ' '); ?>  <span class="float_right">FCFA</span></strong></td>
                                    </tr>                                                       
                                </table>
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