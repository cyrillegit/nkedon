<?php
@require_once ("../../config/config.php");
@include ("../../include/ClassDB.php");
@require_once ("../../include/function.php");

$db = new Database ();

if( isset( $_POST ["id_recapitulatif"] ) )
	$id_recapitulatif = $_POST ["id_recapitulatif"];
//Mode création
if( $id_recapitulatif != NULL )
{
	$infos = false;
}
 $users = $db->getAllComptesUtilisateursCaissier();
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
		if ( $("#nom_caissier").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le nom du caissier.");			
			
			$("#nom_caissier").focus ();
			ok = false;
		}
		else if ( $("#ration").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le montant de la ration.");			
			
			$("#ration").focus ();
			ok = false;
		}
		else if ( $("#dette_fournisseur").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le montant de la dette fournisseur.");			
			
			$("#dette_fournisseur").focus ();
			ok = false;
		}
		else if ( $("#depenses_diverses").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le montant des depenses diverses.");			
			
			$("#depenses_diverses").focus ();
			ok = false;
		}
		else if ( $("#avaries").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le montant des avaries.");			
			
			$("#avaries").focus ();
			ok = false;
		}
		else if ( $("#credit_client").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le montant du credit client.");			
			
			$("#credit_client").focus ();
			ok = false;
		}
		else if ( $("#fonds").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le montant des fonds.");			
			
			$("#fonds").focus ();
			ok = false;
		}
		else if ( $("#capsules").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le montant des capsules.");			
			
			$("#capsules").focus ();
			ok = false;
		}
		else if ( $("#recettes_percues").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le montant des recettes perçues.");			
			
			$("#recettes_percues").focus ();
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
					ShowSuccess ("Le recapitulatif fait par (<strong>" + $("#nom_caissier").val () + "</strong>) a bien été enregistré.");
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
	<div class="TitrePopup">Récapitulatif <strong style="color:#1c9bd3">de l'invantaire</strong></div>
	<div class="subTitlePopup" style="color: #ffffff; text-decoration: none; font-size: 12px;">Veuillez saisir les informations du recapitulatif de l'inventaire en remplissant les champs obligatoires.</div>
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
                				<td>
                					<select name="id_user" id="id_user">
                    						<option value="">Sélectionner le compte utilisateur</option>
	                    					<?php
	                    					if( count( $users ) > 0 )
	                    					{
	                    						foreach( $users as $obj )
	                    						{
	                    							if( !$infos )
	                    								echo "<option value='" . $obj ["idt_users"] . "'>" . $obj ["nom_user"] ." ". $obj ["prenom_user"]. "</option>";
	                    						}
	                    					}
	                    					?>
                    					</select>
                				</td>
                			</tr>
                			<tr>
                				<td>Ration :<span class="champObligatoire">*</span></td>
                				<td><input type="text" name="ration" id="ration" value=""/></td>
                			</tr>
                			<tr>
                				<td>Dette fournisseur :<span class="champObligatoire">*</span></td>
                				<td><input type="text" name="dette_fournisseur" id="dette_fournisseur" value=""/></td>
                			</tr>
                			<tr>
                				<td>Dépenses diverses :<span class="champObligatoire">*</span></td>
                				<td><input type="text" name="depenses_diverses" id="depenses_diverses" value=""/></td>
                			</tr>
                			<tr>
                				<td>Avaries :<span class="champObligatoire">*</span></td>
                				<td><input type="text" name="avaries" id="avaries" value=""/></td>
                			</tr>
                		</table>
                	</td>
                	<!--PARTIE DROITE-->
                	<td>
                		<table>
                			<tr>
                				<td>Crédit client :<span class="champObligatoire">*</span></td>
                				<td><input type="text" name="credit_client" id="credit_client" value=""/></td>
                			</tr>
                			<tr>
                				<td>Fonds :<span class="champObligatoire">*</span></td>
                				<td><input type="text" name="fonds" id="fonds" value=""/></td>
                			</tr>
                			<tr>
                				<td>Capsules :<span class="champObligatoire">*</span></td>
                				<td><input type="text" name="capsules" id="capsules" value=""/></td>
                			</tr>
                			<tr>
                				<td>Recettes perçues :<span class="champObligatoire">*</span></td>
                				<td><input type="text" name="recettes_percues" id="recettes_percues" value=""/></td>
                			</tr>
                		</table>
                	</td>
                </tr>
            </table>
	        <input type="hidden" id="target" name="target" value="recapitulatif_inventaire" />
	        <input type="hidden" id="id_recapitulatif" name="id_recapitulatif" value="<?=$id_recapitulatif;?>" />
        </form>
	</div>
    <hr size="1" style="margin-top: 25px;" />
    <div style="float: left; text-align: left;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
    <div style="float: right; text-align: right;">
        <table border="0" cellspacing="0" cellpadding="0" align="right">
            <tr>
                <td><div id="btnAnnuler"><img src="css/images/boutons/btn_annuler.png" class="" style="cursor: pointer;" width="110" height="30" /></div></td>
                <td>&nbsp;</td>
                <td><div id="btnValider"><img src="css/images/boutons/btn_valider.png" class="" style="cursor: pointer;" width="110" id="btnOK" height="30" /></div></td>
            </tr>
        </table>        
    </div>
</div>    