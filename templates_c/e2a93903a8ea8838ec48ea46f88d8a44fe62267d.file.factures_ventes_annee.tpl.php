<?php /* Smarty version Smarty-3.1.14, created on 2015-03-31 10:06:55
         compiled from ".\templates\historiques\historiques_factures\factures_ventes_annee.tpl" */ ?>
<?php /*%%SmartyHeaderCode:22293551a7040e238c2-14407672%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e2a93903a8ea8838ec48ea46f88d8a44fe62267d' => 
    array (
      0 => '.\\templates\\historiques\\historiques_factures\\factures_ventes_annee.tpl',
      1 => 1427796403,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '22293551a7040e238c2-14407672',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_551a7040e9dfd5_87770264',
  'variables' => 
  array (
    'annee' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_551a7040e9dfd5_87770264')) {function content_551a7040e9dfd5_87770264($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des des factures groupées pour mois.
*/
function RefreshTableHistoriquesFactureVenteAnnee( annee )
{
    var param = "annee="+annee;
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/historiques/GetTableauHistoriquesFacturesVentesAnnee.php",
			async	: false,
			data	: param,
			success	: function (msg){}
	}).responseText;
	$("#tableau_historiques_factures_annee").empty ().html (responseText);

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
    RefreshTableHistoriquesFactureVenteAnnee( getUrlParameter("annee") );

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
        RefreshTableHistoriqueFacture( date_histo_facture );
    });
});

</script>

<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Historiques </strong> <strong style="color:black;">des factures de ventes par mois</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de visualiser des factures de ventes classées par mois.<br/><br/></div>

    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement, les factures de ventes de l'année <font color="black"><b><?php echo $_smarty_tpl->tpl_vars['annee']->value;?>
</b></font> classées par mois.
                </td>

                <td>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Afficher les historiques de factures de ventes à partir de:  <input type="text" name="date_histo_facture" id="date_histo_facture" value=""/>&nbsp;</div>

                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_historiques_factures_annee"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='historiques.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>