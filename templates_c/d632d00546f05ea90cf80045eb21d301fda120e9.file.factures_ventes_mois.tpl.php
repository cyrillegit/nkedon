<?php /* Smarty version Smarty-3.1.14, created on 2015-04-20 14:29:48
         compiled from ".\templates\historiques\historiques_factures\factures_ventes_mois.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11004551a747366a7e5-44278230%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd632d00546f05ea90cf80045eb21d301fda120e9' => 
    array (
      0 => '.\\templates\\historiques\\historiques_factures\\factures_ventes_mois.tpl',
      1 => 1429181300,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11004551a747366a7e5-44278230',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_551a74736fc4b6_98765091',
  'variables' => 
  array (
    'nb_factures' => 0,
    'mois_annee' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_551a74736fc4b6_98765091')) {function content_551a74736fc4b6_98765091($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


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
                Actuellement <font color="black"><b><?php echo $_smarty_tpl->tpl_vars['nb_factures']->value;?>
</b></font> factures de ventes pour <font color="black"><b><?php echo $_smarty_tpl->tpl_vars['mois_annee']->value;?>
</b></font>.
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

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>