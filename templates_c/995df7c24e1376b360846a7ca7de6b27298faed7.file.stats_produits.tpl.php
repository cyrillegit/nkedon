<?php /* Smarty version Smarty-3.1.14, created on 2015-04-07 19:48:54
         compiled from ".\templates\administration_magasin\statistiques\stats_produits.tpl" */ ?>
<?php /*%%SmartyHeaderCode:135355308defb15e4b0-78890336%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '995df7c24e1376b360846a7ca7de6b27298faed7' => 
    array (
      0 => '.\\templates\\administration_magasin\\statistiques\\stats_produits.tpl',
      1 => 1426526077,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '135355308defb15e4b0-78890336',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5308defb270110_63876334',
  'variables' => 
  array (
    'nb_produits' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5308defb270110_63876334')) {function content_5308defb270110_63876334($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableDatePeremptionProduits( time_peremption )
{
    var param = "time_peremption="+time_peremption;
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/GetTableauDatePeremptionProduits.php",
			async	: false,
			data	: param,
			success	: function (msg){}
	}).responseText;
	$("#tableau_produits_peremption").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
	RefreshTableDatePeremptionProduits ("all");

    $("#time_peremption").change (function ()
    {
        var time_peremption = $("#time_peremption").val();
        RefreshTableDatePeremptionProduits ( time_peremption );
    });
});

</script>

<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Produits</strong> <strong style="color:black;"> par date de péremption</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de visualiser les dates de péremption des produits.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b><?php echo $_smarty_tpl->tpl_vars['nb_produits']->value;?>
</b></font> produits enregistrés.
                </td>

                <td>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Afficher les produits qui se périment dans moins de : 
                    <select id="time_peremption">
                        <option value="all" selected>Tous</option> 
                        <option value="1_week">1 semaine</option>
                        <option value="2_week">2 semaines</option>
                        <option value="1_month">1 mois</option>
                        <option value="2_month">2 mois</option>
                        <option value="3_month">3 mois</option>
                        <option value="6_month">6 mois</option>
                        <option value="12_month">12 mois</option>                       
                    </select>&nbsp;</div>

                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_produits_peremption"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration_magasin.php?sub=statistiques';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>