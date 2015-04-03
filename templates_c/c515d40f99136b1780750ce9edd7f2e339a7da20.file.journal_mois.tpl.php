<?php /* Smarty version Smarty-3.1.14, created on 2015-03-28 11:39:53
         compiled from ".\templates\historiques\historiques_journal\journal_mois.tpl" */ ?>
<?php /*%%SmartyHeaderCode:25689551693096c9292-12974631%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c515d40f99136b1780750ce9edd7f2e339a7da20' => 
    array (
      0 => '.\\templates\\historiques\\historiques_journal\\journal_mois.tpl',
      1 => 1427541435,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25689551693096c9292-12974631',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'nb_journal' => 0,
    'mois_annee' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_55169309771144_61572231',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55169309771144_61572231')) {function content_55169309771144_61572231($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des des journaux groupées pour mois.
*/
function RefreshTableHistoriquesJournalMoisAnnee( mois, annee )
{
    var param = "mois="+mois+"&annee="+annee;
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/historiques/GetTableauHistoriquesJournalMoisAnnee.php",
			async	: false,
			data	: param,
			success	: function (msg){}
	}).responseText;
	$("#tableau_historiques_journal_mois_annee").empty ().html (responseText);

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

    RefreshTableHistoriquesJournalMoisAnnee( mois, annee );

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
        RefreshTableHistoriqueFacture( date_histo_journal );
    });
});

</script>

<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Historiques </strong> <strong style="color:black;">des journaux d'un mois</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de visualiser des journaux d'un mois.<br/><br/></div>

    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="black"><b><?php echo $_smarty_tpl->tpl_vars['nb_journal']->value;?>
</b></font> journaux pour <font color="black"><b><?php echo $_smarty_tpl->tpl_vars['mois_annee']->value;?>
</b></font>.
                </td>

                <td>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Afficher les historiques de journaux à partir de:  <input type="text" name="date_histo_journal" id="date_histo_journal" value=""/>&nbsp;</div>

                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_historiques_journal_mois_annee"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='historiques.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>