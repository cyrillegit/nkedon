{include file="common/header.tpl"}
{literal}
<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableFournisseurs ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/magasin/GetTableauFournisseurs.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_fournisseurs").empty ().html (responseText);

	UpdateTSorter ();
}

function resetInputs(){
    $("#nom_fournisseur").val("");
    $("#adresse_fournisseur").val("");
    $("#telephone_fournisseur").val("");

    $("#warnings_popup").css("display", "none");
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
    $("#editFournisseur").hide();
	RefreshTableFournisseurs ();

	$("#addFournisseur").click (function ()
	{
        resetInputs();
        $("#editFournisseur").show("slow");
	});

    $("#btnAnnuler").click (function ()
    {
        // On ferme la boîte de dialogue affichée juste avant.
        resetInputs();
        $("#editFournisseur").hide("slow");
    });

    $("#btnValider").click (function ()
    {
        var ok = false;
        if ( $("#nom_fournisseur").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir la raison sociale de l'entreprise.");

            $("#nom_fournisseur").focus ();
            ok = false;
        }
        else if ( $("#adresse_fournisseur").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir l'adresse du fournisseur'.");

            $("#adresse_fournisseur").focus ();
            ok = false;
        }
        else if ( $("#telephone_fournisseur").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir le numéro de téléphone du fournisseur.");

            $("#telephone_fournisseur").focus ();
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
                    ShowSuccess ("Le produit (<strong>" + $("#nom_fournisseur").val () + "</strong>) a bien été enregistré.");
                    $.modal.close ();
                    document.location.href="magasin.php?sub=fournisseurs";
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
{/literal}
<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Ajouter / Modifier</strong> <strong style="color:black;">un fournisseur</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité d'ajouter ou de modifier des fournisseurs.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="black"><b>{$nb_fournisseurs}</b></font> fournisseurs enregistrés.
                </td>
                <td>
                {if {$smarty.session.infoUser.id_type_user eq 1} or {$smarty.session.infoUser.id_type_user eq 2} or {$smarty.session.infoUser.id_type_user eq 3} or {$smarty.session.infoUser.id_type_user eq 4}}
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_ajouter" id="addFournisseur"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour ajouter un fournisseur :&nbsp;</div>
                {/if}
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="editFournisseur" class="content">
        <div class="TitrePopup">ajouter/modifier <strong style="color:#1c9bd3">un founisseur</strong></div>
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
                                    <td>Raison sociale :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="nom_fournisseur" id="nom_fournisseur" value="" style="width: 200px;"/></td>
                                </tr>
                                <tr>
                                    <td>Adresse du fournisseur :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="adresse_fournisseur" id="adresse_fournisseur" value="" style="width: 200px;"/></td>
                                </tr>
                                <tr>
                                    <td>Numéro de téléphone :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="telephone_fournisseur" id="telephone_fournisseur" value="" style="width: 200px;"/></td>
                                </tr>
                            </table>
                        </td>
                        <!--PARTIE DROITE-->
                        <td>
                        </td>
                    </tr>
                </table>
                <input type="hidden" id="target" name="target" value="fournisseurs" />
                <input type="hidden" id="id_fournisseur" name="id_fournisseur" value="0" />
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
        <hr size="5" style="margin-top: 50px; background-color: #ff0000;" />
    </div>

    <div id="tableau_fournisseurs"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='magasin.php';"></div>
</div>

{include file="common/footer.tpl"}