<?php /* Smarty version Smarty-3.1.14, created on 2014-07-16 21:01:09
         compiled from ".\templates\administration_magasin\gestion_magasin\historiques_journal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4961531c6de0ceb624-48460298%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fd29c511983ffe5c66877f6cf8ee0ac9c4d31379' => 
    array (
      0 => '.\\templates\\administration_magasin\\gestion_magasin\\historiques_journal.tpl',
      1 => 1405544454,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4961531c6de0ceb624-48460298',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_531c6de0f22619_46925336',
  'variables' => 
  array (
    'nb_histo_factures' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_531c6de0f22619_46925336')) {function content_531c6de0f22619_46925336($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableHistoriqueFacture(date_histo_facture)
{
    var param = "date_histo_facture="+date_histo_facture;
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/GetTableauHistoriquesFactures.php",
			async	: false,
			data	: param,
			success	: function (msg){}
	}).responseText;
	$("#tableau_histo_factures").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
	RefreshTableHistoriqueFacture ("");

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
            <div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Historiques</strong> <strong style="color:black;">des factures</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de visualiser l'historique des factures.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b><?php echo $_smarty_tpl->tpl_vars['nb_histo_factures']->value;?>
</b></font> factures enregistrées.
                </td>

                <td>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Afficher les historiques de factures à partir de:  <input type="text" name="date_histo_facture" id="date_histo_facture" value=""/>&nbsp;</div>

                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_histo_factures"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration_magasin.php?sub=groupes_factures';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>