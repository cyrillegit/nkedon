<?php
@require_once ("../../config/config.php");
@include ("../../include/ClassDB.php");
@require_once ("../../include/function.php");

$db = new Database ();

if( isset( $_POST ["id_recapitulatif"] ) )
	$id_recapitulatif = $_POST ["id_recapitulatif"];

if( $id_recapitulatif != NULL )
{
	$datas = $db->getRecapitulatifById ( $id_recapitulatif );
	print_r($datas);
}
?>

<script language="javascript">
$(document).ready (function ()
{
	$("#btnAnnuler").click (function ()
	{
		// On ferme la boîte de dialogue affichée juste avant.
		$.modal.close ();
	});
	
	$("#btnOK").click (function ()
	{
		var ok = false;
		if ( $("#nom_produit").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le nom du produit.");			
			
			$("#nom_produit").focus ();
			ok = false;
		}
		else if ( $("#prix_achat").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le prix d'achat par unité.");			
			
			$("#prix_achat").focus ();
			ok = false;
		}
		else if ( $("#prix_vente").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le prix de vente par unité.");			
			
			$("#prix_vente").focus ();
			ok = false;
		}		
		else
		{
			ok = true;
		}
		
		if (ok)
		{
			var param = $("#form_popup").serialize ();
				
			var responseText = Serialize (param);
			
			if (responseText != "")
			{
				response = eval (responseText);
				if (response.result == "SUCCESS")
				{	
					ShowSuccess ("Le produit (<strong>" + $("#nom_produit").val () + "</strong>) a bien été enregistré.");
					$.modal.close ();					
					document.location.href="administration_magasin.php?sub=produits";
				}
				else
				{
					ShowPopupError  (response.result);
				}
			}
			else
			{
				ShowPopupError  ("Une erreur est survenue.");
			}
		}
		else
		{
		}
	});
});
</script>

<div class="content">
	<div class="TitrePopup">Récapitulatif <strong style="color:#1c9bd3">d'un inventaire</strong></div>
	<div class="subTitlePopup" style="color: #ffffff; text-decoration: none; font-size: 12px;">Veuillez saisir les informations du produit en remplissant les champs obligatoires.</div>
    <br style="clear: both; " />
    <div style="width: 100%;">
        <form name="form_popup" id="form_popup" method="post">
            <table width="100%">
                <tr>
                	<td colspan="2">
                        <div class="warnings" id="warnings_popup" style="display: none;">
                            <b>Certains champs n'ont pas &eacute;t&eacute; remplis correctement :</b>
                            <div></div>
                        </div>
                    </td>
                </tr>
                <tr>
                	<!--PARTIE GAUCHE-->
                	<td>
                		<table>
                			<tr>
                				<td>Nom du caissier :<span class="champObligatoire">*</span></td>
                				<td><strong><?php echo $id_recapitulatif; ?></strong></td>
                			</tr>
                			<tr>
                				<td>Achats mensuels :<span class="champObligatoire">*</span></td>
                				<td><strong><?php if( $infos ) { echo $infos ["achats_totales"]; } ?></strong></td>
                			</tr>
                			<tr>
                				<td>Ventes mensuelles :<span class="champObligatoire">*</span></td>
                				<td><strong><?php if( $infos ) { echo $infos ["ventes_totales"]; } ?></strong></td>
                			</tr>
                			<tr>
                				<td>Montant marchandises en stock :<span class="champObligatoire">*</span></td>
                				<td><strong><?php if( $infos ) { echo $infos ["montant_en_stock"]; } ?></strong></td>
                			</tr>
                			<tr>
                				<td>Montant charges diverses  :<span class="champObligatoire">*</span></td>
                				<td><strong><?php if( $infos ) { echo $infos ["montant_charges"]; } ?></strong></td>
                			</tr>
                			<tr>
                				<td>Date inventaire :<span class="champObligatoire">*</span></td>
                				<td><strong><?php if( $infos ) { echo $infos ["date_inventaire"]; } ?></strong></td>
                			</tr>                			                			
                		</table>
                	</td>
                	<!--PARTIE DROITE-->
                	<td>
                		<table>
                			<tr>
                				<td>Fonds en espéces :<span class="champObligatoire">*</span></td>
                				<td><strong><?php if( $infos ) { echo $infos ["fonds_especes"]; } ?></strong></td>
                			</tr>
                			<tr>
                				<td>Patrimoine :<span class="champObligatoire">*</span></td>
                				<td><strong><?php if( $infos ) { echo $infos ["patrimoine"]; } ?></strong></td>
                			</tr>
                			<tr>
                				<td>Recettes perçues :<span class="champObligatoire">*</span></td>
                				<td><strong><?php if( $infos ) { echo $infos ["recettes_percues"]; } ?></strong></td>
                			</tr>
                			<tr>
                				<td>Bénéfice brut :<span class="champObligatoire">*</span></td>
                				<td><strong><?php if( $infos ) { echo $infos ["benefice_brut"]; } ?></strong></td>
                			</tr>
                			<tr>
                				<td>Bénéfice net  :<span class="champObligatoire">*</span></td>
                				<td><strong><?php if( $infos ) { echo $infos ["benefice_net"]; } ?></strong></td>
                			</tr>
                			<tr>
                				<td>Ecart :<span class="champObligatoire">*</span></td>
                				<td><strong><?php if( $infos ) { echo $infos ["ecart"]; } ?></strong></td>
                			</tr>                			                			
                		</table>
                	</td>
                </tr>
            </table>
	        <input type="hidden" id="target" name="target" value="inventaire_produit" />
	        <input type="hidden" id="id_produit" name="id_produit" value="<?=$id_produit;?>" />
        </form>
	</div>
    <hr size="1" style="margin-top: 25px;" />
    <div style="float: left; text-align: left;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
    <div style="float: right; text-align: right;">
        <table border="0" cellspacing="0" cellpadding="0" align="right">
            <tr>
                <td><div id="btnAnnuler"><img src="css/images/boutons/btn_annuler.png" class="button" width="110" height="30" /></div></td>
                <td>&nbsp;</td>
                <td><div id="btnValider"><img src="css/images/boutons/btn_valider.png" class="button" width="110" id="btnOK" height="30" /></div></td>
            </tr>
        </table>        
    </div>
</div>    