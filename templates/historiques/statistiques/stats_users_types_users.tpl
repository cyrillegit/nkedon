{include file="common/header.tpl"}
{literal}

<script language="javascript">

function RefreshXMLUsersTypesUsers ()
{
    var responseText = $.ajax({
            type    : "POST",
            url     : "ajax/infos/magasin/statistiques/GetXMLUsersTypesUsers.php",
            async   : false,
            data    : "",
            success : function (msg){}
    }).responseText;
    $("#chartContainerUsersTypesUsers").empty ().html (responseText);
}

$(document).ready (function ()
{
    RefreshXMLUsersTypesUsers ();
});
</script>
{/literal}
<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Statistiques : </strong> <strong style="color:black;"> Nombre d'utilisateur par compte utilisateur</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">Affichage des statistiques representant le nombre d'utilisateur par compte utilisateur.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle"> Nombre d'utilisateur par compte utilisateur :</span></strong></em>
    <div id="chartContainerUsersTypesUsers"></div>
    </div>
    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='../../../magasin.php';"></div>
</div>
{include file="common/footer.tpl"}