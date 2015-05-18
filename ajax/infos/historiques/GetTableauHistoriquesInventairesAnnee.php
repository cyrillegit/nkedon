<?php
/**
	Fichier GetTableauHistoriquesInventairesAnnee.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations des factures en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

isset( $_POST ["annee"] ) ? $annee = addslashes(htmlspecialchars($_POST ["annee"])) : $annee = "";
isset( $_POST ["date_histo_inventaire"] ) ? $date_histo_inventaire = addslashes(htmlspecialchars($_POST ["date_histo_inventaire"])) : $date_histo_inventaire = "";
// get the type of the current user
$id_type_user = $_SESSION["infoUser"]["idt_types_users"];

if(  $date_histo_inventaire == "" ) {
    $recaps = $db->getAllInventairesAnnee( "", "", $annee );
}else{
    $mois = explode( "/", $date_histo_inventaire )[1];
    $jour = explode( "/", $date_histo_inventaire )[0];
    $recaps = $db->getAllInventairesAnnee( $jour, $mois, $annee );
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
                        'downloads.php?sub=inventaire&id_inventaire='+$(this).attr("id_inventaire"),
                        '_blank'
                    );
                });
            });

            $(".download_ecarts").each (function ()
            {
                $(this).click (function ()
                {
                    window.open(
                        'downloads.php?sub=ecarts&id_inventaire='+$(this).attr("id_inventaire"),
                        '_blank'
                    );
                });
            });
        });
    </script>
    <style type="text/css">
        .blocInfoBis {
            background-image: url("css/images/bg_bloc_alertes.png");
            background-repeat: repeat;
            border: 1px solid #313131;
            padding: 5px 5px 5px;
        }

    </style>

<?php
if( count( $recaps ) > 0)
{
    foreach( $recaps as $recap ) {

        $operationInventaire = $db->getAllAchatsInventaire( $recap["idt_inventaires"] );

        $ventes_totales = 0;
        $achats_totales = 0;
        $montant_en_stock = 0;
        $benefice_brut = 0;
        $montant_charges_diverses = 0;
        $fonds_especes = 0;
        $patrimoine = 0;
        $benefice_net = 0;
        $ecart = 0;
        $filename = "";

        foreach ( $operationInventaire as $info)
        {
            if( $info["quantite_achetee"] == NULL ){ $info["quantite_achetee"] = 0;}
            $ventes_totales += ($info["stock_initial"] + $info["quantite_achetee"] - $info["stock_physique"]) * $info["prix_vente"];
            $achats_totales += $info["quantite_achetee"] * $info["prix_achat"];
            $montant_en_stock += $info["stock_physique"] * $info["prix_vente"];
            $benefice_brut += ($info["prix_vente"] - $info["prix_achat"]) * ($info["stock_initial"] + $info["quantite_achetee"] - $info["stock_physique"]);
        }

        $montant_charges_diverses = $recap["ration"] + $recap["dette_fournisseur"] + $recap["depenses_diverses"] + $recap["avaries"] + $recap["credit_client"];
        $fonds_especes = $recap["fonds"];
        $patrimoine = $fonds_especes + $montant_en_stock + $recap["capsules"];
        $benefice_net = $benefice_brut - $montant_charges_diverses;
        $ecart = $ventes_totales - $recap["recettes_percues"] - $fonds_especes;
        $solde = $montant_charges_diverses - $ecart;
        $ration = $recap["ration"];
        $dette_fournisseur = $recap["dette_fournisseur"];
        $depenses_diverses = $recap["depenses_diverses"];
        $avaries = $recap["avaries"];
        $credit_client = $recap["credit_client"];
        $capsules = $recap["capsules"];
        $filename = $recap["filepath"];
        ?>
        <div style="width: 100%;" class="hvr-bounce-to-right">
            <form name="form_popup" id="form_popup" method="post">
                <table cellspacing="2" cellpadding="2" class="blocInfoBis " width="100%">
                    <tr>
                        <!--PARTIE GAUCHE-->
                        <td>
                            <table cellspacing="5" cellpadding="2" width="100%">
                                <tr class="blocInfoBis">
                                    <td>Nom du caissier :<span class="champObligatoire">*</span></td>
                                    <td><strong><?php echo $recap["nom_user"] . " " . $recap["prenom_user"]; ?></strong>
                                    </td>
                                </tr>
                                <tr class="blocInfoBis">
                                    <td>Achats mensuels :<span class="champObligatoire">*</span></td>
                                    <td><strong><?php echo number_format($achats_totales, 2, ',', ' '); ?> <span
                                                style="float: right; margin-right: 10px;">FCFA</span></strong></td>
                                </tr>
                                <tr class="blocInfoBis">
                                    <td>Ventes mensuelles :<span class="champObligatoire">*</span></td>
                                    <td><strong><?php echo number_format($ventes_totales, 2, ',', ' '); ?><span
                                                style="float: right; margin-right: 10px;">FCFA</span></strong></td>
                                </tr>
<!--                                <tr class="blocInfoBis">-->
<!--                                    <td>Montant marchandises en stock :<span class="champObligatoire">*</span></td>-->
<!--                                    <td><strong>--><?php //echo number_format($montant_en_stock, 2, ',', ' '); ?><!--<span-->
<!--                                                style="float: right; margin-right: 10px;">FCFA</span></strong></td>-->
<!--                                </tr>-->
                                <tr class="blocInfoBis">
                                    <td>Montant charges diverses :<span class="champObligatoire">*</span></td>
                                    <td><strong><?php echo number_format($montant_charges_diverses, 2, ',', ' '); ?>
                                            <span style="float: right; margin-right: 10px;">FCFA</span></strong></td>
                                </tr>
                                <tr class="blocInfoBis">
                                    <td>Ration :<span class="champObligatoire">*</span></td>
                                    <td><strong><?php echo number_format($ration, 2, ',', ' '); ?><span
                                                style="float: right; margin-right: 10px;">FCFA</span></strong></td>
                                </tr>
                                <tr class="blocInfoBis">
                                    <td>Dette fournisseur :<span class="champObligatoire">*</span></td>
                                    <td><strong><?php echo number_format($dette_fournisseur, 2, ',', ' '); ?><span
                                                style="float: right; margin-right: 10px;">FCFA</span></strong></td>
                                </tr>
                                <tr class="blocInfoBis">
                                    <td>Date inventaire :<span class="champObligatoire">*</span></td>
                                    <td>
                                        <strong><?php echo SQLDateTimeToFrenchDateTime($recap["date_inventaire"]); ?></strong>
                                    </td>
                                </tr>
                                <tr class="blocInfoBis">
                                    <td style="width: 200px;">Commentaire :</td>
                                    <td>
                                        <textarea style="height: 100%; width: 100%;" readonly="readonly"><?php echo $recap["commentaire"]; ?>
                                        </textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" valign="middle">
                                        <a class="download_links" id_inventaire="<?=$recap["idt_inventaires"]; ?>">
                                            <img src="assets/images/arrow_down.png" alt="" width="16" height="16" /> Téléchargez la synthèse
                                        </a>
                                    </td>
                                    <td align="left" valign="middle">
                                        <a class="download_ecarts" id_inventaire="<?=$recap["idt_inventaires"]; ?>">
                                            <img src="assets/images/arrow_down.png" alt="" width="16" height="16" /> <span style="color: red;">Téléchargez le fichier des écarts</span>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <!--PARTIE DROITE-->
                        <td>
                            <table cellspacing="5" cellpadding="2" width="100%">
                                <tr class="blocInfoBis">
                                    <td>Dépenses diverses :<span class="champObligatoire">*</span></td>
                                    <td><strong><?php echo number_format($depenses_diverses, 2, ',', ' '); ?><span
                                                style="float: right; margin-right: 10px;">FCFA</span></strong></td>
                                </tr>
                                <tr class="blocInfoBis">
                                    <td>Fonds en espéces :<span class="champObligatoire">*</span></td>
                                    <td><strong><?php echo number_format($fonds_especes, 2, ',', ' '); ?><span
                                                style="float: right; margin-right: 10px;">FCFA</span></strong></td>
                                </tr>
                                <tr class="blocInfoBis">
                                    <td>Patrimoine :<span class="champObligatoire">*</span></td>
                                    <td><strong><?php echo number_format($patrimoine, 2, ',', ' '); ?><span
                                                style="float: right; margin-right: 10px;">FCFA</span></strong></td>
                                </tr>
                                <tr class="blocInfoBis">
                                    <td>Recettes perçues :<span class="champObligatoire">*</span></td>
                                    <td><strong><?php echo number_format($recap["recettes_percues"], 2, ',', ' '); ?>
                                            <span style="float: right; margin-right: 10px;">FCFA</span></strong></td>
                                </tr>
                                <tr class="blocInfoBis">
                                    <td>Avaries :<span class="champObligatoire">*</span></td>
                                    <td><strong><?php echo number_format($avaries, 2, ',', ' '); ?><span
                                                style="float: right; margin-right: 10px;">FCFA</span></strong></td>
                                </tr>
                                <tr class="blocInfoBis">
                                    <td>Crédit client :<span class="champObligatoire">*</span></td>
                                    <td><strong><?php echo number_format($credit_client, 2, ',', ' '); ?><span
                                                style="float: right; margin-right: 10px;">FCFA</span></strong></td>
                                </tr>
                                <tr class="blocInfoBis">
                                    <td>Capsules :<span class="champObligatoire">*</span></td>
                                    <td><strong><?php echo number_format($capsules, 2, ',', ' '); ?><span
                                                style="float: right; margin-right: 10px;">FCFA</span></strong></td>
                                </tr>
                                <tr class="blocInfoBis">
                                    <td>Bénéfice brut :<span class="champObligatoire">*</span></td>
                                    <td><strong><?php echo number_format($benefice_brut, 2, ',', ' '); ?><span
                                                style="float: right; margin-right: 10px;">FCFA</span></strong></td>
                                </tr>
                                <tr class="blocInfoBis">
                                    <td>Bénéfice net :<span class="champObligatoire">*</span></td>
                                    <td><strong><?php echo number_format($benefice_net, 2, ',', ' '); ?><span
                                                style="float: right; margin-right: 10px;">FCFA</span></strong></td>
                                </tr>
                                <tr class="blocInfoBis">
                                    <td>Ecart :<span class="champObligatoire">*</span></td>
                                    <td><strong><?php echo number_format($ecart, 2, ',', ' '); ?><span
                                                style="float: right; margin-right: 10px;">FCFA</span></strong></td>
                                </tr>
                                <tr class="blocInfoBis">
                                    <td>Solde :<span class="champObligatoire">*</span></td>
                                    <td><strong><?php echo number_format($solde, 2, ',', ' '); ?><span
                                                style="float: right; margin-right: 10px;">FCFA</span></strong></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <hr size="1" style="margin-top: 25px;" />
    <?php
    }
}
?>