{include file="common/header.tpl"}
{literal}
<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableProduits ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/GetTableauProduitsForInventaire.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_produits").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
	RefreshTableProduits ();

	$("#validateInventaire").click (function ()
	{
		update_content ("ajax/popups/recapitulatif_inventaire.php", "popup", "id_recapitulatif=1");
		ShowPopupHeight (550);
	});
});

</script>
{/literal}
<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Réaliser l'inventaire</strong> <strong style="color:black;">du magasin</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de réaliser l'inventaire en entrant le stock physique du produit. Pour entrer le stock physique, cliquez sur les icones dans la colonne Actions.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b>{$nb_produits}</b></font> produits enregistrés.
                </td>
                <td>
                {if $smarty.session.infoUser.id_type_user <= 5}
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_valider" id="validateInventaire"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour valider l'inventaire :&nbsp;</div>
                {/if}
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_produits"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration_magasin.php';"></div>
</div>

{include file="common/footer.tpl"}