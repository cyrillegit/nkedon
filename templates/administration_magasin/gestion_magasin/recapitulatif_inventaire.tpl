{include file="common/header.tpl"}
{literal}
<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableRecapitulatif ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/GetTableauRecapitulatifInventaire.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_recapitulatif").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
	RefreshTableRecapitulatif ();

    $('#validateInventaire').click(function() 
    {
        var didConfirm = confirm("Vous êtes sur le point de générer la synthèse de l'inventaire. \n cet action est irréversible");
      if (didConfirm == true) {
        document.location.href="administration_magasin.php?sub=generate_synthese";
      }
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
                <div class="title"><strong>Recapitulatifs</strong> <strong style="color:black;">des inventaires du magasin</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de modifier des recapitulatifs.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b>{$nb_recapitulatif}</b></font> recapitulatifs enregistrés.
                </td>
                <td>
                {if $smarty.session.infoUser.id_type_user <= 5}
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_valider" id="validateInventaire"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour générer la synthése :&nbsp;</div>
                {/if}
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_recapitulatif"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration_magasin.php';"></div>
</div>

{include file="common/footer.tpl"}