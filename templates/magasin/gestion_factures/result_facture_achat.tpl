{include file="common/header.tpl"}
{literal}
<script language="javascript">
/**
	Rafraîchissement du tableau des de la facture courante.
*/
function RefreshTableFactureAchat ()
{
    var responseText = $.ajax({
        type	: "POST",
        url		: "ajax/infos/magasin/GetTableauFactureAchat.php",
        async	: false,
        data	: "",
        success	: function (msg){}
    }).responseText;
    $("#tableau_facture").empty ().html (responseText);

    UpdateTSorter ();
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
    if(getUrlParameter("status") == "register" ){
        $("#succes_register").show();
    }else{
        $("#succes_register").hide();
    }
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
    setRegisterPopup();
    RefreshTableFactureAchat( );
});

</script>
{/literal}
<div id="Content">
    <div class="success" id="succes_register" style="display: block;">
        <b>La facture d'achat a bien été enregistrée.</b>
        <div></div>
    </div>
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Facture d'achat du </strong> <strong style="color:black;"></strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de visualiser la facture d'achat nouvellement crée.<br/><br/></div>

    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="black"><b>{$nb_produits}</b></font> produits dans cette facture d'achat.
                </td>

                <td>
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_facture"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='../../../magasin.php';"></div>
</div>

{include file="common/footer.tpl"}