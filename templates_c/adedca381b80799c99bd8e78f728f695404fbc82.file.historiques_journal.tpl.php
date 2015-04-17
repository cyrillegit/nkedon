<?php /* Smarty version Smarty-3.1.14, created on 2015-04-16 13:00:58
         compiled from ".\templates\historiques\historiques_journal\historiques_journal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11898551684910a9163-12692371%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'adedca381b80799c99bd8e78f728f695404fbc82' => 
    array (
      0 => '.\\templates\\historiques\\historiques_journal\\historiques_journal.tpl',
      1 => 1429187857,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11898551684910a9163-12692371',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_55168491118cc0_72357704',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55168491118cc0_72357704')) {function content_55168491118cc0_72357704($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des des journaux groupées pour mois.
*/
function RefreshTableHistoriqueJournal( date_histo_journal )
{
    var param = "date_histo_journal="+date_histo_journal;
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/historiques/GetTableauHistoriquesJournal.php",
			async	: false,
			data	: param,
			success	: function (msg){}
	}).responseText;

	$("#tableau_historiques_journal").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
    RefreshTableHistoriqueJournal ("");

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
        RefreshTableHistoriqueJournal( date_histo_journal );
    });
});

</script>

<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Historiques </strong> <strong style="color:black;">des journaux par années</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de visualiser des journaux classées par année.<br/><br/></div>

    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Les différentes années de journaux.
                </td>

                <td>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Afficher les historiques de journaux à partir de:  <input type="text" name="date_histo_journal" id="date_histo_journal" value=""/>&nbsp;</div>

                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_historiques_journal"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='historiques.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>