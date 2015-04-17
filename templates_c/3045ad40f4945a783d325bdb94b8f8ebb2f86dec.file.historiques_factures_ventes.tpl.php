<?php /* Smarty version Smarty-3.1.14, created on 2015-04-16 10:38:33
         compiled from ".\templates\historiques\historiques_factures\historiques_factures_ventes.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9895551a6eccc8d6f4-71084502%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3045ad40f4945a783d325bdb94b8f8ebb2f86dec' => 
    array (
      0 => '.\\templates\\historiques\\historiques_factures\\historiques_factures_ventes.tpl',
      1 => 1429180476,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9895551a6eccc8d6f4-71084502',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_551a6eccd0e468_41914187',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_551a6eccd0e468_41914187')) {function content_551a6eccd0e468_41914187($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des des factures groupées pour mois.
*/
function RefreshTableHistoriquesFactureVente( date_histo_facture )
{
    var param = "date_histo_facture="+date_histo_facture;
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/historiques/GetTableauHistoriquesFacturesVentes.php",
			async	: false,
			data	: param,
			success	: function (msg){}
	}).responseText;

	$("#tableau_historiques_factures").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
    RefreshTableHistoriquesFactureVente ("");

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
        RefreshTableHistoriquesFactureVente( date_histo_facture );
    });
});

</script>

<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Historiques </strong> <strong style="color:black;">des factures de ventes par années</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de visualiser des factures de ventes classées par année.<br/><br/></div>

    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Les différentes années de factures de ventes.
                </td>

                <td>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Afficher les historiques de factures de ventes à partir de:  <input type="text" name="date_histo_facture" id="date_histo_facture" value=""/>&nbsp;</div>

                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_historiques_factures"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='historiques.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>