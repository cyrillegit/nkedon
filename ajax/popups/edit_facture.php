<?php
@require_once ("../../config/config.php");
@include ("../../include/ClassDB.php");
@require_once ("../../include/function.php");

$db = new Database ();

if( isset( $_POST ["id_facture"] ) )
	$id_facture = $_POST ["id_facture"];
//Mode création
if( $id_facture == 0 )
{
	$infos = false;
}
//Mode édition
else
{
	$infos = $db->getInfoFacture ( $id_facture );
}

$fournisseurs = $db->getAllFournisseurs();
?>

<script language="javascript">
$(document).ready (function ()
{
	$("#date_facture").datepicker({
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
		document.location.href="delete.php?sub=factures";
	});
	
	$("#btnOK").click (function ()
	{
		var ok = false;
		if ( $("#numero_facture").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le numéro de la facture.");			
			
			$("#numero_facture").focus ();
			ok = false;
		}
		else if ( $("#nombre_produit").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le nombre de produit de la facture.");			
			
			$("#nombre_produit").focus ();
			ok = false;
		}
		else if ( $("#date_facture").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir la date de la facture.");			
			
			$("#date_facture").focus ();
			ok = false;
		}
		else if ( $("#id_fournisseur").val () == "" )
		{
			ShowPopupError  ("Veuillez selectionner un fournisseur.");			
			
			$("#id_fournisseur").focus ();
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
					ShowSuccess ("La facture (<strong>" + $("#numero_facture").val () + "</strong>) a bien été enregistrée.");
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
	<div class="TitrePopup">ajouter/modifier <strong style="color:#1c9bd3">une facture</strong></div>
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
                				<td>Numéro de la facture :<span class="champObligatoire">*</span></td>
                				<td><input type="text" name="numero_facture" id="numero_facture" value="<?php if( $infos ) { echo $infos ["numero_facture"]; } ?>"/></td>
                			</tr>
                			<tr>
                				<td>Nombre de produits de la facture:<span class="champObligatoire">*</span></td>
                				<td><input type="text" name="nombre_produit" id="nombre_produit" value="<?php if( $infos ) { echo $infos ["nombre_produit"]; } ?>"/></td>
                			</tr>
                		</table>
                	</td>
                	<!--PARTIE DROITE-->
                	<td>
                		<table>
                			<tr>
                				<td>date de la facture :<span class="champObligatoire">*</span></td>
                				<td>
                					<input type="text" name="date_facture" id="date_facture" value="<?php if( $infos ) { echo SQLDateToFrenchDate($infos ["date_facture"]); } ?>"/>
                				</td>
                			</tr>
                			<tr>
                				<td>Raison sociale du fournisseur :<span class="champObligatoire">*</span></td>
                				<td>
                					<select name="id_fournisseur" id="id_fournisseur">
                						<option value="">Sélectionner la raison sociale</option>
                    					<?php
                    					if( count( $fournisseurs ) > 0 )
                    					{
                    						foreach( $fournisseurs as $obj )
                    						{
                    							if( !$infos )
                    								echo "<option value='" . $obj ["idt_fournisseurs"] . "'>" . $obj ["nom_fournisseur"] . "</option>";
                    							else
                    							{
                    								if( $infos ["idt_fournisseurs"] == $obj ["idt_fournisseurs"] )
                    									$opt = "selected='selected'";
                    								else
                    									$opt = "";
                    								echo "<option value='" . $obj ["idt_fournisseurs"] . "' " . $opt . ">" . $obj ["nom_fournisseur"] . "</option>";
                    							}
                    						}
                    					}
                    					?>
                					</select>
                				</td>
                			</tr>
                		</table>
                	</td>
                </tr>
            </table>
	        <input type="hidden" id="target" name="target" value="factures" />
	        <input type="hidden" id="id_facture" name="id_facture" value="<?=$id_facture;?>" />
	        <input type="hidden" id="date_insertion_facture" name="date_insertion_facture" value="<?php if( $infos ) { echo $infos ["date_insertion_facture"]; } ?>" />
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