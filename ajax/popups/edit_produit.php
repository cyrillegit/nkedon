<?php
@require_once ("../../config/config.php");
@include ("../../include/ClassDB.php");
@require_once ("../../include/function.php");

$db = new Database ();

if( isset( $_POST ["id_produit"] ) )
	$id_produit = $_POST ["id_produit"];
//Mode création
if( $id_produit == 0 )
{
	$infos = false;
}
//Mode édition
else
{
	$infos = $db->getInfoProduit ( $id_produit );
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
	<div class="TitrePopup">ajouter/modifier <strong style="color:#1c9bd3">un produit</strong></div>
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
                				<td>Nom du produit :<span class="champObligatoire">*</span></td>
                				<td><input type="text" name="nom_produit" id="nom_produit" value="<?php if( $infos ) { echo $infos ["nom_produit"]; } ?>"/></td>
                			</tr>
                			<tr>
                				<td>Prix de d'achat par unité :<span class="champObligatoire">*</span></td>
                				<td><input type="text" name="prix_achat" id="prix_achat" value="<?php if( $infos ) { echo $infos ["prix_achat"]; } ?>"/></td>
                			</tr>
                			<tr>
                				<td>Prix de vente par unité :<span class="champObligatoire">*</span></td>
                				<td><input type="text" name="prix_vente" id="prix_vente" value="<?php if( $infos ) { echo $infos ["prix_vente"]; } ?>"/></td>
                			</tr>
                		</table>
                	</td>
                	<!--PARTIE DROITE-->
                	<td>

                	</td>
                </tr>
            </table>
	        <input type="hidden" id="target" name="target" value="produits" />
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