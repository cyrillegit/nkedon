{include file="common/header.tpl"}
{literal}
<script language="javascript">
/**
	Rafraîchissement du tableau de l'inventaire.
*/
function RefreshTableRecapitulatifInventaire ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/magasin/GetTableauRecapitulatifInventaire.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_recapitulatif").empty ().html (responseText);

	UpdateTSorter ();
}

/**
 pour generer la synthese de l'inventaire.
 */
function RefreshTableGenerateSynthese()
{
    var responseText = $.ajax({
        type	: "POST",
        url		: "ajax/infos/magasin/GetTableauGenerateSynthese.php",
        async	: false,
        data	: "",
        success	: function (msg){
            alert("msg : "+msg);
        }
    }).responseText;

    alert( responseText );
}

/**
 pour generer la synthese de l'inventaire.
 */
function RefreshTableAnnulerSynthese()
{
    var responseText = $.ajax({
        type	: "POST",
        url		: "ajax/infos/magasin/GetTableauAnnulerSynthese.php",
        async	: false,
        data	: "",
        success	: function (msg){}
    }).responseText;
}

function getUrlParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            return sParameterName[1];
        }
    }
}

function setRegisterPopup(){
    $("#downloadLink").hide();
    if(getUrlParameter("sub") == "synthese_inventaire" ){
        $("#succes_register").show();
        $("#succes_cancel").hide();
        $("#downloadLink").show();
        $("#btnAnnulerValider").hide();
    }else{
        $("#succes_register").hide();
        $("#succes_cancel").hide();
        $("#downloadLink").hide();
    }
}

/**
	jQuery init.
*/
$(document).ready (function ()
{
    setRegisterPopup();
	RefreshTableRecapitulatifInventaire ();


    $('#btnValiderInventaire').click(function()
    {
        var didConfirm = confirm("Vous êtes sur le point de générer la synthèse de l'inventaire. \n cet action est irréversible");
      if (didConfirm == true) {
          document.location.href="magasin.php?sub=recapitulatif_inventaire";
      }
    });

    $('#btnAnnulerInventaire').click(function()
    {
        var didConfirm = confirm("Vous êtes sur le point d'annuler la synthèse de l'inventaire. \n cet action est irréversible");
        if (didConfirm == true) {
            RefreshTableAnnulerSynthese();
            RefreshTableRecapitulatifInventaire ();
            $("#tableau_recapitulatif").hide();
            $("#btnAnnulerValider").hide();
            $("#succes_cancel").show();
        }
    });
});

</script>
{/literal}
<div id="Content">
    <div class="success" id="succes_register" style="display: block;">
        <b>La synthèse de l'inventaire a été réalisée avec succès.
            </br> Vous pouvez télécharger le fichier pdf.
            </br> Vous pouvez aussi consulter cette syntèse dans l'historique des inventaires.
        </b>
        <div></div>
    </div>
    <div class="success" id="succes_cancel" style="display: block;">
        <b>La synthèse de l'inventaire a été annulée avec succès.
            </br> Vous pouvez consulter les syntèses dans l'historique des inventaires.
        </b>
        <div></div>
    </div>
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Recapitulatif</strong> <strong style="color:black;">de l'inventaire du magasin</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de visualiser le recapitulatif de l'inventaire.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement, le recapitulatif de l'inventaire.
                </td>
                <td>
                {if $smarty.session.infoUser.id_type_user <= 5}
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour générer la synthése de l'inventaire, veuillez valider avec le boutton ci-dessous :&nbsp;</div>
                {/if}
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_recapitulatif"></div>

    <hr size="1" style="margin-top: 25px;" />
    <div style="float: left; text-align: left;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
    <div id="btnAnnulerValider" style="float: right; text-align: right; padding-bottom: 10px;">
        <table border="0" cellspacing="0" cellpadding="0" align="right">
            <tr>
                <td><div id="btnAnnulerInventaire"><img src="css/images/boutons/btn_annuler.png" class="" style="cursor: pointer;" width="110" height="30" /></div></td>
                <td>&nbsp;</td>
                <td><div id="btnValiderInventaire"><img src="css/images/boutons/btn_valider.png" class="" style="cursor: pointer;" width="110" id="btnOK" height="30" /></div></td>
            </tr>
        </table>
    </div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='../../../magasin.php';"></div>
</div>

{include file="common/footer.tpl"}