{include file="common/header.tpl"}
{literal}
<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableOperations ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/GetTableauProduitsOperation.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_journal").empty ().html (responseText);

	UpdateTSorter ();
}

/**
 Rafraîchissement du tableau des chaînes de tri.
 */
function RegisterOperation ( params )
{
    var responseText = $.ajax({
        type	: "POST",
        url		: "ajax/Serializer/operations_journal.php",
        data: {keyword:params},
        success	: function (msg){
            alert("msg : "+msg);
        }
    }).responseText;
    return responseText;
}

function storeOperation( ) {

    var id_operation = 0;
    var nom_produit = $('#nom_produit_search').val();
    var quantite_vendue = $('#quantite_vendue').val();

        var responseText = $.ajax({
            url: 'ajax/Serializer/operations_journal.php',
            type: 'POST',
            async	: false,
            data: {id_operation:id_operation, nom_produit:nom_produit, quantite_vendue:quantite_vendue},
            success:function(data){
                responseText = data;
            }
        }).responseText;
    return responseText;
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
    $("#editOperation").hide();
    RefreshTableOperations ();
    var i = 0;

	$("#addOperation").click (function ()
	{
        i++;
        $("#editOperation").slideToggle("fast");

	});

    $("#btnAnnuler").click (function ()
    {
        i++;
        $("#nom_produit").val("");
        $("#quantite_vendue").val("");
        $("#warnings_popup").css("display", "none");
        $("#editOperation").slideToggle("fast");

    });

    $("#btnValider").click (function ()
    {
        var ok = false;
        if ( $("#nom_produit").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir le nom du produit.");

            $("#nom_produit").focus ();
            ok = false;
        }
        else if ( $("#quantite_vendue").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir la quantité vendue.");

            $("#quantite_vendue").focus ();
            ok = false;
        }
        else
        {
            ok = true;
        }

        if(ok)
        {
            var params = $("#form_popup_operation").serialize ();
        //    alert( param );
        //    var responseText = Serialize (params);
        //    alert( responseText );
            var responseText = storeOperation();
            alert("news : "+responseText);
            if (responseText != "")
            {
                response = eval (responseText);
                if (response.result == "SUCCESS")
                {
                    ShowSuccess ("Le produit (<strong>" + $("#nom_produit").val () + "</strong>) a bien été enregistré dans la facture.");
                    $.modal.close ();
                    document.location.href="administration_magasin.php?sub=operations_journal";
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

    });
});

</script>
{/literal}
<style type="text/css">

    .input_container input {
        height: 16px;
        width: 200px;
        padding: 3px;
        border: 1px solid #cccccc;
        border-radius: 0;
    }
    .input_container ul {
        width: 206px;
        border: 1px solid #eaeaea;
        position: absolute;
        z-index: 9;
        list-style: none;
        list-style-type: none;
    }
    .input_container ul li {
        padding: 2px;
    }
    .input_container ul li:hover {
        background: #eaeaea;
        color: #000000;
    }
    #list_nom_produit {
        display: none;
    }

</style>
<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Réaliser </strong> <strong style="color:black;">le journal</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de réaliser le journal.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b>{$nb_operations}</b></font> opérations enregistrées dans le journal.
                </td>
                <td>
                {if {$smarty.session.infoUser.id_type_user eq 1} or {$smarty.session.infoUser.id_type_user eq 2} or {$smarty.session.infoUser.id_type_user eq 3} or {$smarty.session.infoUser.id_type_user eq 4}}
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_ajouter" id="addOperation"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour ajouter une opération :&nbsp;</div>
                {/if}
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="editOperation" class="content ">
        <div class="TitrePopup">ajouter/modifier <strong style="color:#1c9bd3">une opération du journal</strong></div>
        <div class="subTitlePopup" style="color: #ffffff; text-decoration: none; font-size: 12px;">Veuillez saisir les informations du produit en remplissant les champs obligatoires.</div>
        <br style="clear: both; " />
        <div style="width: 100%;">
            <form name="form_popup_operation" id="form_popup_operation" method="post">
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
                                    <td class="input_container" ><input type="text" name="nom_produit_search" id="nom_produit_search" value="" onkeyup="autocomplet()"/>
                                        <ul id="list_nom_produit" style="list-style-type: none;"></ul>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <!--PARTIE DROITE-->
                        <td>
                            <table>
                                <tr>
                                    <td>Quantité vendue :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="quantite_vendue" id="quantite_vendue" value=""/></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <input type="hidden" id="target" name="target" value="operations_journal" />
                <input type="hidden" id="id_operation" name="id_operation" value="0" />
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

    <div id="tableau_journal"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration_magasin.php';"></div>
</div>
{include file="common/footer.tpl"}