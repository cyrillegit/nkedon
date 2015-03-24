<?php
@require_once ("../../config/config.php");
@include ("../../include/ClassDB.php");

$db = new Database ();

if( isset( $_POST ["id_compte"] ) )
	$id_compte = $_POST ["id_compte"];
//Mode création
if( $id_compte == 0 )
{
	$infos = false;
}
//Mode édition
else
{
	$infos = $db->GetInfoUser ( $id_compte );
}

$types_comptes_utilisateurs = $db->getAllTypesUsersWithoutAdmin ();

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
		if ( $("#nom").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le nom civil de l'utilisateur.");			
			
			$("#nom").focus ();
			ok = false;
		}
		else if ( $("#prenom").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le prénom de l'utilisateur.");			
			
			$("#prenom").focus ();
			ok = false;
		}
		else if ( $("#login").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le login du compte utilisateur.");			
			
			$("#login").focus ();
			ok = false;
		}
		else if ( $("#password").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le mot de passe du compte utilisateur.");			
			
			$("#password").focus ();
			ok = false;
		}		
		else if ( $("#id_type_user").val () == "" )
		{
			ShowPopupError  ("Veuillez sélectionner le profil utilisateur.");			
			
			$("#id_type_user").focus ();
			ok = false;
		}
		else if ( $("#email").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir l'email du compte utilisateur.");			
			
			$("#email").focus ();
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
                alert(responseText);
				response = eval (responseText);
				if (response.result == "SUCCESS")
				{
					
					ShowSuccess ("Le compte utilisateur (<strong>" + $("#login").val () + "</strong>) a bien été enregistré.");
					$.modal.close ();					
					document.location.href="administration.php?sub=comptes_utilisateurs";
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
	<div class="TitrePopup">ajouter/modifier <strong style="color:#1c9bd3">un compte utilisateur</strong></div>
    	<div class="subTitlePopup" style="color: #ffffff; text-decoration: none; font-size: 12px;">Veuillez saisir les informations du compte utilisateur en remplissant les champs obligatoires.</div>
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
                    				<td>Nom :<span class="champObligatoire">*</span></td>
                    				<td><input type="text" name="nom" id="nom" value="<?php if( $infos ) { echo $infos ["nom_user"]; } ?>"/></td>
                    			</tr>
                    			<tr>
                    				<td>Prénom :<span class="champObligatoire">*</span></td>
                    				<td><input type="text" name="prenom" id="prenom" value="<?php if( $infos ) { echo $infos ["prenom_user"]; } ?>"/></td>
                    			</tr>
                    			<tr>
                    				<td>Adresse :<span class="champObligatoire">*</span></td>
                    				<td><input type="text" name="adresse" id="adresse" value="<?php if( $infos ) { echo $infos ["adresse_user"]; } ?>"/></td>
                    			</tr>
                    			<tr>
                    				<td>Email :<span class="champObligatoire">*</span></td>
                    				<td><input type="text" name="email" id="email" value="<?php if( $infos ) { echo $infos ["email_user"]; } ?>"/></td>
                    			</tr>
                    		</table>
                    	</td>
                    	<!--PARTIE DROITE-->
                    	<td>
                    		<table>
                    			<tr>
                    				<td>Login :<span class="champObligatoire">*</span></td>
                    				<td><input type="text" name="login" id="login" value="<?php if( $infos ) { echo $infos ["login"]; } ?>"/></td>
                    			</tr>
                    			<?php 
                    			if($id_compte == 0)
                    			{
                    			?>
                    			<tr>
                    				<td>Mot de passe:<span class="champObligatoire">*</span></td>
                    				<td><input type="text" name="password" id="password" value="<?php if( $infos ) { echo $infos ["password"]; } ?>"/></td>
                    			</tr>
                    			<?php 
                    			}
                    			else
                    			{
                    			?> 
                    			<tr>
                    				<td><input type="hidden" name="password" id="password" value="<?php if( $infos ) { echo $infos ["password"]; } ?>"/></td>
                    			</tr>
                    			<?php
                    			}
                    			?>                    			                   			
                    			<tr>
                    				<td>Profil utilisateur :<span class="champObligatoire">*</span></td>
                    				<td>
                    					<select name="id_type_user" id="id_type_user">
                    						<option value="">Sélectionner un profil utilisateur</option>
	                    					<?php
	                    					if( count( $types_comptes_utilisateurs ) > 0 )
	                    					{
	                    						foreach( $types_comptes_utilisateurs as $obj )
	                    						{
	                    							if( !$infos )
	                    								echo "<option value='" . $obj ["idt_types_users"] . "'>" . $obj ["nom_type_user"] . "</option>";
	                    							else
	                    							{
	                    								if( $infos ["id_type_user"] == $obj ["idt_types_users"] )
	                    									$opt = "selected='selected'";
	                    								else
	                    									$opt = "";
	                    								echo "<option value='" . $obj ["idt_types_users"] . "' " . $opt . ">" . $obj ["nom_type_user"] . "</option>";
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
		        <input type="hidden" id="target" name="target" value="compte_utilisateur" />
		        <input type="hidden" id="id_compte" name="id_compte" value="<?=$id_compte;?>" />
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
</div>