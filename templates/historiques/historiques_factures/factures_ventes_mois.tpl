{include file="common/header.tpl"}
{literal}
<script language="javascript">
/**
	Rafraîchissement du tableau des des factures groupées pour mois.
*/
function RefreshTableHistoriquesFactureVentesMoisAnnee( date_histo_facture, mois, annee )
{
    var param = "date_histo_facture="+date_histo_facture+"&mois="+mois+"&annee="+annee;
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/historiques/GetTableauHistoriquesFacturesVentesMoisAnnee.php",
			async	: false,
			data	: param,
			success	: function (msg){}
	}).responseText;
	$("#tableau_historiques_factures_mois_annee").empty ().html (responseText);

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
/**
	jQuery init.
*/
$(document).ready (function ()
{
    var annee = getUrlParameter("annee");
    var mois = getUrlParameter("mois");

    RefreshTableHistoriquesFactureVentesMoisAnnee( "", mois, annee );

    $("#date_histo_facture").datepicker({
        beforeShow:function(input) {
            $(input).css({
                "position": "relative",
                "z-index": 999999
            });
        }
    });

    $("#date_histo_facture").change (function ()
    {
        var date_histo_facture = $("#date_histo_facture").val();
        var annee = getUrlParameter("annee");
        var mois = getUrlParameter("mois");
        RefreshTableHistoriquesFactureVentesMoisAnnee( date_histo_facture, mois, annee );
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
                <div class="title"><strong>Historiques </strong> <strong style="color:black;">des factures de ventes d'un mois</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de visualiser des factures de ventes d'un mois.<br/><br/></div>

    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="black"><b>{$nb_factures}</b></font> factures de ventes pour <font color="black"><b>{$mois_annee}</b></font>.
                </td>

                <td>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Afficher les historiques de factures de ventes à partir de:  <input type="text" name="date_histo_facture" id="date_histo_facture" value=""/>&nbsp;</div>

                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_historiques_factures_mois_annee"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='historiques.php';"></div>
</div>

{include file="common/footer.tpl"}