<?php
@require_once ("../../config/config.php");
@include ("../../include/ClassDB.php");
@require_once ("../../include/function.php");

$db = new Database ();

if( isset( $_POST ["id_produit_facture"] ) )
	$id_produit_facture = $_POST ["id_produit_facture"];
//Mode création
if( $id_produit_facture == 0 )
{
	$infos = false;
}
//Mode édition
else
{
	$infos = $db->getInfoProduitFacture ( $id_produit_facture );
}
?>

<script language="javascript">

$(document).ready (function ()
{
	$("#date_fabrication").datepicker({
	    beforeShow:function(input) {
	        $(input).css({
	            "position": "relative",
	            "z-index": 999999
	        });
	    }
	});

	$("#date_peremption").datepicker({
	    beforeShow:function(input) {
	        $(input).css({
	            "position": "relative",
	            "z-index": 999999
	        });
	    }
	});

	$("#btnAnnuler").click (function ()
	{
		// On ferme la boîte de dialogue affichée juste avant.
		$.modal.close ();
	});
	
	$("#btnValiderProduit").click (function ()
	{
		var ok = false;
		if ( $("#nom_produit").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le nom du produit.");			
			
			$("#nom_produit").focus ();
			ok = false;
		}
		else if ( $("#quantite_achat").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir la quantité achetée.");			
			
			$("#quantite_achat").focus ();
			ok = false;
		}		
		else
		{
			ok = true;
		}
		
		if (ok)
		{
			var param = $("#form_popup_produit").serialize ();
				
			var responseText = Serialize (param);
			
			if (responseText != "")
			{
				response = eval (responseText);
				if (response.result == "SUCCESS")
				{	
					ShowSuccess ("Le produit (<strong>" + $("#nom_produit").val () + "</strong>) a bien été enregistré dans la facture.");
					$.modal.close ();					
					document.location.href="administration_magasin.php?sub=produits_facture";
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
	<div class="TitrePopup">ajouter/modifier <strong style="color:#1c9bd3">un produit de la facture</strong></div>
	<div class="subTitlePopup" style="color: #ffffff; text-decoration: none; font-size: 12px;">Veuillez saisir les informations du produit en remplissant les champs obligatoires.</div>
    <br style="clear: both; " />
    <div style="width: 100%;">
        <form name="form_popup_produit" id="form_popup_produit" method="post">
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
                				<td>Nom du produit :<span class="champObligatoire">*</span></td>
                				<td><input type="text" name="nom_produit" id="nom_produit" value="<?php if( $infos ) { echo $infos ["nom_produit"]; } ?>"/><div id="results" style="position:absolute; margin-left:0px; color:black; "></div></td>
                			</tr>
                			<tr>
                				<td>Quantité achetée :<span class="champObligatoire">*</span></td>
                				<td><input type="text" name="quantite_achat" id="quantite_achat" value="<?php if( $infos ) { echo $infos ["quantite_achat"]; } ?>"/></td>
                			</tr>
                		</table>
                	</td>
                	<!--PARTIE DROITE-->
                	<td>
                		<table>
                			<tr>
                				<td>Date de fabrication : </td>
                				<td><input type="text" name="date_fabrication" id="date_fabrication" value="<?php if( $infos ) { echo SQLDateToFrenchDate( $infos ["date_fabrication"] ); } ?>"/></td>
                			</tr>
                			<tr>
                				<td>Date de peremption : </td>
                				<td><input type="text" name="date_peremption" id="date_peremption" value="<?php if( $infos ) { echo SQLDateToFrenchDate( $infos ["date_peremption"] ); } ?>"/></td>
                			</tr>
                		</table>
                	</td>
                </tr>
            </table>
	        <input type="hidden" id="target" name="target" value="produits_facture" />
	        <input type="hidden" id="id_produit_facture" name="id_produit_facture" value="<?=$id_produit_facture;?>" />
        </form>
	</div>
    <hr size="1" style="margin-top: 25px;" />
    <div style="float: left; text-align: left;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
    <div style="float: right; text-align: right;">
        <table border="0" cellspacing="0" cellpadding="0" align="right">
            <tr>
                <td><div id="btnAnnuler"><img src="css/images/boutons/btn_annuler.png" class="" style="cursor: pointer;" width="110" height="30" /></div></td>
                <td>&nbsp;</td>
                <td><div id="btnValiderProduit"><img src="css/images/boutons/btn_valider.png" class="" style="cursor: pointer;" width="110" id="btnOKProduit" height="30" /></div></td>
            </tr>
        </table>        
    </div>
</div>
<script src="assets/js/autocomplete.js"></script>    