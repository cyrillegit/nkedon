{include file="common/header.tpl"}
{literal}
<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableComptesUtilisateurs ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration/GetTableauComptesUtilisateurs.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_comptes_utilisateurs").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
	RefreshTableComptesUtilisateurs ();

	$("#addCompteUtilisateur").click (function ()
	{
		update_content ("ajax/popups/edit_compte_utilisateur.php", "popup", "id_compte=0");
		ShowPopupHeight (300);
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
                <div class="title"><strong>Ajouter / Modifier</strong> <strong style="color:black;">un compte utilisateur</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité d'ajouter ou de modifier des comptes utilisateurs qui permettront à vos Inspecteurs, Inventoristes et visiteurs de pouvoir se connecter sur le BackOffice.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b>{$nb_comptes_utilisateurs}</b></font> comptes utilisateurs enregistrés, dont <font color="red"><b>2</b></font>  comptes adminitrateurs non visibles.
                </td>
                <td>
                {if {$smarty.session.infoUser.id_type_user eq 1} or {$smarty.session.infoUser.id_type_user eq 2}}
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_ajouter" id="addCompteUtilisateur"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour ajouter un compte utilisateur :&nbsp;</div>
                {/if}
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_comptes_utilisateurs"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration.php';"></div>
</div>

{include file="common/footer.tpl"}