{include file="common/header.tpl"}
{literal}
<script language="javascript">
/**
	Rafraîchissement du tableau des des journaux groupées pour mois.
*/
function RefreshTableHistoriqueJournal( date_histo_journal )
{
    var param = "date_histo_journal="+date_histo_journal;
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/historiques/GetTableauHistoriquesJournal.php",
			async	: false,
			data	: param,
			success	: function (msg){}
	}).responseText;

	$("#tableau_historiques_journal").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
    RefreshTableHistoriqueJournal ("");

    $("#date_histo_journal").datepicker({
        beforeShow:function(input) {
            $(input).css({
                "position": "relative",
                "z-index": 999999
            });
        }
    });

    $("#date_histo_journal").change (function ()
    {
        var date_histo_journal = $("#date_histo_journal").val();
        RefreshTableHistoriqueJournal( date_histo_journal );
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
                <div class="title"><strong>Historiques </strong> <strong style="color:black;">des journaux par années</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de visualiser des journaux classées par année.<br/><br/></div>

    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Les différentes années de journaux.
                </td>

                <td>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Afficher les historiques de journaux à partir de:  <input type="text" name="date_histo_journal" id="date_histo_journal" value=""/>&nbsp;</div>

                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_historiques_journal"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='historiques.php';"></div>
</div>

{include file="common/footer.tpl"}