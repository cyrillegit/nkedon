{include file="common/header.tpl"}
{literal}
<script language="javascript">
/**
	Rafraîchissement du tableau des profils utilisateurs.
*/
function RefreshTableTypesUtilisateurs ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration/GetTableauTypesUtilisateurs.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_types_users").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
    $("#editTypeUser").hide();
	RefreshTableTypesUtilisateurs ();

    $("#addTypeUser").click (function ()
    {
        $("#editTypeUser").show("slow");
    });

    $("#btnAnnuler").click (function ()
    {
        $("#nom_type_user").val("");
        $("#warnings_popup").css("display", "none");
        $("#editTypeUser").hide("slow");

    });

    $("#btnValider").click (function ()
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
                ShowPopupError  ("Une erreur est survenue. Veuillez contacter le service technique");
            }
        }
        else
        {
        }
    });

//	$("#addTypeUser").click (function ()
//	{
//		update_content ("ajax/popups/edit_type_user.php", "popup", "id_type_user=0");
//		ShowPopupHeight (550);
//	});
});

</script>
{/literal}
<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Ajouter / Modifier</strong> <strong style="color:black;">un profil utilisateur</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité d'ajouter ou de modifier des profils utilisateurs sur le BackOffice.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="black"><b>{$nb_types_users}</b></font> profils utilisateurs enregistrés, dont <font color="black"><b>2</b></font> profils utilisateurs administrateurs non visibles .
                </td>
                <td>
                {if {$smarty.session.infoUser.id_type_user eq 1} or {$smarty.session.infoUser.id_type_user eq 2}}
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_ajouter" id="addTypeUser"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour ajouter un profil utilisateur :&nbsp;</div>
                {/if}
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="editTypeUser" class="content">
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
                        <!--PARTIE GAUCHE-->
                        <td>
                            <table>
                                <tr>
                                    <td>Nom du profil utilisateur :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="nom_type_user" id="nom_type_user" value="" /></td>
                                </tr>
                            </table>
                        </td>
                        <!--PARTIE DROITE-->
                        <td>
                        </td>
                    </tr>
                </table>
                <input type="hidden" id="target" name="target" value="types_users" />
                <input type="hidden" id="id_type_user" name="id_type_user" value="<?=$id_type_user;?>" />
            </form>
        </div>
        <hr size="1" style="margin-top: 25px;" />
        <div style="float: left; text-align: left;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
        <div style="float: right; text-align: right; padding-bottom: 10px;">
            <table border="0" cellspacing="0" cellpadding="0" align="right">
                <tr>
                    <td><div id="btnAnnuler"><img src="css/images/boutons/btn_annuler.png" class="" style="cursor: pointer;" width="110" height="30" /></div></td>
                    <td>&nbsp;</td>
                    <td><div id="btnValider"><img src="css/images/boutons/btn_valider.png" class="" style="cursor: pointer;" width="110" id="btnOK" height="30" /></div></td>
                </tr>
            </table>
        </div>
        <hr size="5" style="margin-top: 50px; background-color: #ff0000;"/>
    </div>

    <div id="tableau_types_users"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration.php';"></div>
</div>

{include file="common/footer.tpl"}