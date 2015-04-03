<?php /* Smarty version Smarty-3.1.14, created on 2015-03-29 14:11:46
         compiled from ".\templates\historiques\historiques_inventaires\historiques_inventaires.tpl" */ ?>
<?php /*%%SmartyHeaderCode:284405517d80ba4a536-28978642%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '29dbbf672e364286a1ba288622014a07667dfc7d' => 
    array (
      0 => '.\\templates\\historiques\\historiques_inventaires\\historiques_inventaires.tpl',
      1 => 1427638303,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '284405517d80ba4a536-28978642',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5517d80c3468f1_07159494',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5517d80c3468f1_07159494')) {function content_5517d80c3468f1_07159494($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des inventaires
*/
function RefreshTableHistoriquesInventaires()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/historiques/GetTableauHistoriquesInventaires.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_historiques_inventaires").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
    RefreshTableHistoriquesInventaires ();

    $("#date_histo_synthese").datepicker({
        beforeShow:function(input) {
            $(input).css({
                "position": "relative",
                "z-index": 999999
            });
        }
    });

    $("#date_histo_synthese").change (function ()
    {
        var date_histo_synthese = $("#date_histo_synthese").val();
        RefreshTableHistoriquesInventaires ();
    });
});

</script>

<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Historiques </strong> <strong style="color:black;">des inventaires</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de visualiser l'historique des inventaires.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Les différentes années des inventaires.
                </td>

                <td>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Afficher les historiques des inventaires à partir de:  <input type="text" name="date_histo_synthese" id="date_histo_synthese" value=""/>&nbsp;</div>

                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_historiques_inventaires"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='historiques.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>