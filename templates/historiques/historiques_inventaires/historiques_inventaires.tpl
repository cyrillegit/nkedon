{include file="common/header.tpl"}
{literal}
<script language="javascript">
/**
	Rafraîchissement du tableau des inventaires
*/
function RefreshTableHistoriquesInventaires()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/historiques/GetTableauHistoriquesInventaires.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_historiques_inventaires").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
    RefreshTableHistoriquesInventaires ();

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
        RefreshTableHistoriquesInventaires ();
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
                <div class="title"><strong>Historiques </strong> <strong style="color:black;">des inventaires</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de visualiser l'historique des inventaires.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Les différentes années des inventaires.
                </td>

                <td>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Afficher les historiques des inventaires à partir de:  <input type="text" name="date_histo_synthese" id="date_histo_synthese" value=""/>&nbsp;</div>

                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_historiques_inventaires"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='historiques.php';"></div>
</div>

{include file="common/footer.tpl"}