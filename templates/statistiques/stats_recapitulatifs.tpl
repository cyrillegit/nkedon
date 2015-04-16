{include file="common/header.tpl"}
{literal}

<script language="javascript">

function RefreshXMLRecapitulatifs()
{
    var responseText = $.ajax({
            type    : "POST",
            url     : "ajax/infos/statistiques/GetXMLRecapitulatifs.php",
            async   : false,
            data    : "",
            success : function (msg){}
    }).responseText;
    $("#chartContainer").empty ().html (responseText);
}

$(document).ready (function ()
{
    RefreshXMLRecapitulatifs();
});
</script>
{/literal}
<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Statistiques </strong> <strong style="color:black;"> des récapitulatifs des inventaires</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">Affichage des statistiques representant l'évolution des écapitulatifs des inventaires.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle"> Evolution des recapitulatifs</span></strong></em>
    <div id="chartContainer"></div>
    </div>
    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='statistiques.php?sub=statistiques';"></div>
</div>
{include file="common/footer.tpl"}