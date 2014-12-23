{include file="common/header.tpl"}
{literal}
<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableGenerateSynthese(date_histo_synthese)
{
    var param = "date_histo_synthese="+date_histo_synthese;
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/GetTableauGenerateSynthese.php",
			async	: false,
			data	: param,
			success	: function (msg){}
	}).responseText;
	$("#tableau_generate_synthese").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
	RefreshTableGenerateSynthese ("");

   $('#histoSynthese').click(function() 
    {
        document.location.href="administration_magasin.php?sub=historiques_syntheses";
    });
//*
    $(".links").each (function ()
    {
        $(this).click (function ()
        {
            var filename = $(this).attr("filename");
            alert("Bientot disponible");
        //    document.location.href="ajax/download.php?filename="+filename;
        });
    });
    //*/
});

</script>
{/literal}
<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Génération</strong> <strong style="color:black;">de la synthèse</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de générer la synthèse de l'inventaire.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b>{$nb_histo_syntheses}</b></font> synthèses effectuées.
                </td>

                <td>
                {if $smarty.session.infoUser.id_type_user <= 5}
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_valider" id="histoSynthese"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Afficher l'historique des synthèses:&nbsp;</div>
                {/if}
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_generate_synthese"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration_magasin.php';"></div>
</div>

{include file="common/footer.tpl"}