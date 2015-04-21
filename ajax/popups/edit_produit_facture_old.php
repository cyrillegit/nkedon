<?php
@require_once ("../../config/config.php");
@require_once ("../../include/ClassDB.php");

$db = new Database ();

if( isset( $_POST ["id_produit_facture"] ) )
{
	$id_produit_facture = $_POST ["id_produit_facture"];

	$infos = $db->getInfoProduitAchete ( $id_produit_facture );
	$id_produit = $infos["id_produit"];
}
else
{

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
		if ( $("#quantite_achetee").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir la quantité du produit.");			
			
			$("#quantite_achetee").focus ();
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
					
					ShowSuccess ("La quantité du produit a bien été enregistré.");
					$.modal.close ();					
					document.location.href="../../magasin.php";
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
	<div class="TitrePopup">Modifier <strong style="color:black;">le produit d'une facture</strong></div>
    	<div class="subTitlePopup" style="color: #ffffff; text-decoration: none; font-size: 12px;">Veuillez saisir les informations du profil utilisateur en remplissant les champs obligatoires.</div>
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
        				<td>Nom du produit :<span class="champObligatoire">*</span></td>
        				<td>
    						<?php if( $infos ) { echo $infos ["nom_produit"]; } ?>
        				</td>
        			</tr>
		            <tr>
        				<td>Quantité achetée du produit :<span class="champObligatoire">*</span></td>
        				<td>
    						<input type="text" name="quantite_achetee" id="quantite_achetee" value="<?php if( $infos ) { echo $infos ["quantite_achat"]; } ?>"/>
        				</td>
        			</tr>
                </table>
		        <input type="hidden" id="target" name="target" value="edit_produit_achete" />
		        <input type="hidden" id="id_produit" name="id_produit" value="<?=$id_produit;?>" />
		        <input type="hidden" id="id_produit_facture" name="id_produit_facture" value="<?=$id_produit_facture;?>" />
            </form>
		</div>
        <hr size="1" style="margin-top: 25px;" />
        <div style="float: left; text-align: left;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
        <div style="float: right; text-align: right;">
            <table border="0" cellspacing="0" cellpadding="0" align="right">
                <tr>
                    <td><div id="btnAnnuler"><img src="css/images/boutons/btn_annuler.png" class="button" width="110" height="30" id="btnAnnuler"/></div></td>
                    <td>&nbsp;</td>
                    <td><div id="btnValider"><img src="css/images/boutons/btn_valider.png" class="button" width="110" id="btnOK" height="30" /></div></td>
                </tr>
            </table>        
        </div>
    </div>
</div>