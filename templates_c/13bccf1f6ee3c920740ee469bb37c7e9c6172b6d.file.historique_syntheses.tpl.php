<?php /* Smarty version Smarty-3.1.14, created on 2015-03-17 09:49:29
         compiled from ".\templates\magasin\gestion_magasin\historiques_inventaires.tpl" */ ?>
<?php /*%%SmartyHeaderCode:203052ebaf5fc4fd71-66558753%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '13bccf1f6ee3c920740ee469bb37c7e9c6172b6d' => 
    array (
      0 => '.\\templates\\magasin\\gestion_magasin\\historiques_inventaires.tpl',
      1 => 1426526077,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '203052ebaf5fc4fd71-66558753',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52ebaf5fcea076_22377556',
  'variables' => 
  array (
    'nb_histo_syntheses' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ebaf5fcea076_22377556')) {function content_52ebaf5fcea076_22377556($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableHistoriqueSynthese(date_histo_synthese)
{
    var param = "date_histo_synthese="+date_histo_synthese;
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/magasin/GetTableauHistoriqueSyntheses.php",
			async	: false,
			data	: param,
			success	: function (msg){}
	}).responseText;
	$("#tableau_histo_syntheses").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
	RefreshTableHistoriqueSynthese ("");

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
        RefreshTableHistoriqueSynthese (date_histo_synthese);
    });
});

</script>

<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Historique</strong> <strong style="color:black;">des synthèses</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de visualiser l'historique des synthèses.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b><?php echo $_smarty_tpl->tpl_vars['nb_histo_syntheses']->value;?>
</b></font> synthèses effectuées.
                </td>

                <td>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Afficher les historiques de syntése à partir de:  <input type="text" name="date_histo_synthese" id="date_histo_synthese" value=""/>&nbsp;</div>

                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_histo_syntheses"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='../magasin.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>