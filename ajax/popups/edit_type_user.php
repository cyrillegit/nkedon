<?php
@require_once ("../../config/config.php");
@require_once ("../../include/ClassDB.php");

$db = new Database ();

if( isset( $_POST ["id_type_user"] ) )
	$id_type_user = $_POST ["id_type_user"];
//Mode création
if( $id_type_user == 0 )
{
	$mode = 1;
	$infos = false;
}
//Mode édition
else
{
	$infos = $db->getInfoTypeUser ( $id_type_user );
	$mode = 2;
}
$users = $db->getAllTypesUsersWithoutAdmin ();
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
		if ( $("#nom_type_user").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le nom du profil utilisateur.");			
			
			$("#nom_type_user").focus ();
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
					
					ShowSuccess ("Le profil utilisateur (<strong>" + $("#nom_type_user").val () + "</strong>) a bien été enregistré.");
					$.modal.close ();					
					document.location.href="administration.php?sub=types_comptes_utilisateurs";
				}
				else
				{
					ShowPopupError  (response.result);
					
				}
			}
			else
			{
				ShowPopupError  ("Une erreur est survenue. Veuillez contacter le service technique (technique@id2tel.com) pour avoir plus d'informations.");
			}
		}
		else
		{
		}
	});
});
</script>
<div class="content">
	<div class="TitrePopup">ajouter/modifier <strong style="color:black;">un profil utilisateur</strong></div>
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
        				<td>Nom du profil utilisateur :<span class="champObligatoire">*</span></td>
        				<td><input type="text" name="nom_type_user" id="nom_type_user" value="<?php if( $infos ) { echo $infos ["nom_type_user"]; } ?>"/></td>
                    </tr>
                </table>
		        <input type="hidden" id="target" name="target" value="types_users" />
		        <input type="hidden" id="id_type_user" name="id_type_user" value="<?=$id_type_user;?>" />
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
</div>