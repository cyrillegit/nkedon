{include file="common/header.tpl"}
{literal}
<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableHistoriqueSynthese(date_histo_synthese)
{
    var param = "date_histo_synthese="+date_histo_synthese;
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/GetTableauHistoriqueSyntheses.php",
			async	: false,
			data	: param,
			success	: function (msg){}
	}).responseText;
	$("#tableau_histo_syntheses").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
	RefreshTableHistoriqueSynthese ("");

    $("#date_histo_synthese").datepicker({
        beforeShow:function(input) {
            $(input).css({
                "position": "relative",
                "z-index": 999999
            });
        }
    });

    $("#date_histo_synthese").change (function ()
    {
        var date_histo_synthese = $("#date_histo_synthese").val();
        RefreshTableHistoriqueSynthese (date_histo_synthese);
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
                <div class="title"><strong>Historique</strong> <strong style="color:black;">des synthèses</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de visualiser l'historique des synthèses.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b>{$nb_histo_syntheses}</b></font> synthèses effectuées.
                </td>

                <td>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Afficher les historiques de syntése à partir de:  <input type="text" name="date_histo_synthese" id="date_histo_synthese" value=""/>&nbsp;</div>

                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_histo_syntheses"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration_magasin.php';"></div>
</div>

{include file="common/footer.tpl"}