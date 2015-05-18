{include file="common/header.tpl"}
{literal}
<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableProduits ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/magasin/GetTableauProduitsForInventaire.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_produits").empty ().html (responseText);

	UpdateTSorter ();
}

function fetchAllUsers( ){
    $.ajax({
        type: "POST",
        url: 'ajax/populate.php',
        data: {'target': "users",'isAjax':true},
        dataType:'json',
        success: function(data) {
            var select = $("#user_select"), options = '';
            select.empty();
            options = "<option value=0>Sélectionner le nom du caissier</option>";
            for (var i = 0; i < data.length; i++) {
                options += "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
            }
            select.append(options);
        }
    });
}

/**
 * reset the inputs of the form
 */
function resetInputs(){
    $("#user_select").val("");
    $("#ration").val("");
    $("#dette_fournisseur").val("");
    $("#depenses_diverses").val("");
    $("#avaries").val("");
    $("#credit_client").val("");
    $("#fonds").val("");
    $("#capsules").val("");
    $("#recettes_percues").val("");
    $("#commentaire").val("");

    fetchAllUsers();

    $("#warnings_popup").css("display", "none");
}

/**
	jQuery init.
*/
$(document).ready (function ()
{
    $("#editInventaire").hide();
    $("#editStockPhysique").hide();
    fetchAllUsers();
	RefreshTableProduits ();

    $("#btnAnnulerStockPhysique").click (function ()
    {
        // On ferme la boîte de dialogue affichée juste avant.
        $("#addInventaire").show();
        $("#msgInventaire").show();
        $("#editStockPhysique").hide("slow");
    });

    $("#btnValiderStockPhysique").click (function ()
    {
        var ok = false;
        if ( $("#stock_physique").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir le stock physique.");

            $("#stock_physique").focus ();
            ok = false;
        }
        else
        {
            ok = true;
        }

        if (ok)
        {
            var param = $("#form_popup_stock_physique").serialize ();

            var responseText = Serialize (param);

            if (responseText != "")
            {
                response = eval (responseText);
                if (response.result == "SUCCESS")
                {
                    ShowSuccess ("Le produit (<strong>" + $("#nom_produit").val () + "</strong>) a bien été enregistré.");
                    $.modal.close ();
                    document.location.href="../../../magasin.php";
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
        $("#msgInventaire").show();
        $("#addInventaire").show();
    });

	$("#addInventaire").click (function ()
	{
        resetInputs();
        $("#editInventaire").show("slow");
	});

    $("#btnAnnulerInventaire").click (function ()
    {
        // On ferme la boîte de dialogue affichée juste avant.
        resetInputs();
        $("#editInventaire").hide("slow");
    });

    $("#btnValiderInventaire").click (function ()
    {
        var ok = false;
        if ( $("#user_select").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir le nom du caissier.");

            $("#user_select").focus ();
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
            var param = $("#form_popup_inventaire").serialize ();

            var responseText = Serialize (param);

            if (responseText != "")
            {
                response = eval (responseText);
                if (response.result == "SUCCESS")
                {
                    ShowSuccess ("Le recapitulatif fait par (<strong>" + $("#nom_caissier").val () + "</strong>) a bien été enregistré.");
                    $.modal.close ();
                    document.location.href="magasin.php?sub=synthese_inventaire";
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
                <div class="title"><strong>Réaliser l'inventaire</strong> <strong style="color:black;">du magasin</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de réaliser l'inventaire en entrant le stock physique du produit. Pour entrer le stock physique, cliquez sur les icones dans la colonne Actions.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="black"><b>{$nb_produits}</b></font> produits enregistrés.
                </td>
                <td>
                {if $smarty.session.infoUser.id_type_user <= 5}
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_valider" id="addInventaire"></div></div>
                <div id="msgInventaire" style="margin-left:20px; margin-right: 20px; float: right;">Pour valider l'inventaire :&nbsp;</div>
                {/if}
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="editInventaire" class="content">
        <div class="TitrePopup">Récapitulatif <strong style="color:#1c9bd3">de l'invantaire</strong></div>
        <div class="subTitlePopup" style="color: #ffffff; text-decoration: none; font-size: 12px;">Veuillez saisir les informations du recapitulatif de l'inventaire en remplissant les champs obligatoires.</div>
        <br style="clear: both; " />
        <div style="width: 100%;">
            <form name="form_popup_inventaire" id="form_popup_inventaire" method="post">
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
                                        <select name="user_select" id="user_select">
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
                            </table>
                        </td>
                        <!--PARTIE DROITE-->
                        <td>
                            <table>
                                <tr>
                                    <td>Avaries :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="avaries" id="avaries" value=""/></td>
                                </tr>
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
                <table>
                    <tr>
                        <td>Commenatire :</td>
                        <td><textarea name="commentaire" id="commentaire" cols="30" rows="10" style="height: 100px; width: 400px; margin-left: 40px;"></textarea></td>
                    </tr>
                </table>
                <input type="hidden" id="target" name="target" value="inventaire" />
                <input type="hidden" id="id_inventaire" name="id_inventaire" value="0" />
            </form>
        </div>
        <hr size="1" style="margin-top: 25px;" />
        <div style="float: left; text-align: left;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
        <div style="float: right; text-align: right; padding-bottom: 10px;">
            <table border="0" cellspacing="0" cellpadding="0" align="right">
                <tr>
                    <td><div id="btnAnnulerInventaire"><img src="css/images/boutons/btn_annuler.png" class="" style="cursor: pointer;" width="110" height="30" /></div></td>
                    <td>&nbsp;</td>
                    <td><div id="btnValiderInventaire"><img src="css/images/boutons/btn_valider.png" class="" style="cursor: pointer;" width="110" id="btnOK" height="30" /></div></td>
                </tr>
            </table>
        </div>
        <hr size="5" style="margin-top: 50px; background-color: #ff0000;" />
    </div>

    <div class="content" id="editStockPhysique">
        <div class="TitrePopup">Modifier l'inventaire <strong style="color:#1c9bd3">d'un produit</strong></div>
        <div class="subTitlePopup" style="color: #ffffff; text-decoration: none; font-size: 12px;">Veuillez saisir les informations du produit en remplissant les champs obligatoires.</div>
        <br style="clear: both; " />
        <div style="width: 100%;">
            <form name="form_popup_stock_physique" id="form_popup_stock_physique" method="post">
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
                                    <td><strong><input type="text" name="nom_produit" id="nom_produit" readonly="readonly" style="width: 200px;"/></strong></td>
                                </tr>
                                <tr>
                                    <td>Stock physique :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="stock_physique" id="stock_physique" style="width: 200px;"/></td>
                                </tr>
                            </table>
                        </td>
                        <!--PARTIE DROITE-->
                        <td>

                        </td>
                    </tr>
                </table>
                <input type="hidden" id="target" name="target" value="inventaire_produit" />
                <input type="hidden" id="id_produit" name="id_produit" value="0" />
            </form>
        </div>
        <hr size="1" style="margin-top: 25px;" />
        <div style="float: left; text-align: left;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
        <div style="float: right; text-align: right;">
            <table border="0" cellspacing="0" cellpadding="0" align="right">
                <tr>
                    <td><div id="btnAnnulerStockPhysique"><img src="css/images/boutons/btn_annuler.png" class="" style="cursor: pointer;" width="110" height="30" /></div></td>
                    <td>&nbsp;</td>
                    <td><div id="btnValiderStockPhysique"><img src="css/images/boutons/btn_valider.png" class="" style="cursor: pointer;" width="110" id="btnOK" height="30" /></div></td>
                </tr>
            </table>
        </div>
        <hr size="5" style="margin-top: 50px; background-color: #ff0000;" />
    </div>

    <div id="tableau_produits"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='../../../magasin.php';"></div>
</div>

{include file="common/footer.tpl"}