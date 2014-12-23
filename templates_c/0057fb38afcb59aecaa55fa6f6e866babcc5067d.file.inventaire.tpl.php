<?php /* Smarty version Smarty-3.1.14, created on 2014-03-09 01:51:14
         compiled from ".\templates\administration_magasin\gestion_magasin\inventaire.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1674552ebaf5bc937c2-10831535%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0057fb38afcb59aecaa55fa6f6e866babcc5067d' => 
    array (
      0 => '.\\templates\\administration_magasin\\gestion_magasin\\inventaire.tpl',
      1 => 1394329872,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1674552ebaf5bc937c2-10831535',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52ebaf5bd51082_54130975',
  'variables' => 
  array (
    'nb_produits' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ebaf5bd51082_54130975')) {function content_52ebaf5bd51082_54130975($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableProduits ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/GetTableauProduitsForInventaire.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_produits").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
	RefreshTableProduits ();

	$("#validateInventaire").click (function ()
	{
		update_content ("ajax/popups/recapitulatif_inventaire.php", "popup", "id_recapitulatif=1");
		ShowPopupHeight (550);
	});
});

</script>

<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Réaliser l'inventaire</strong> <strong style="color:black;">du magasin</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de réaliser l'inventaire en entrant le stock physique du produit. Pour entrer le stock physique, cliquez sur les icones dans la colonne Actions.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b><?php echo $_smarty_tpl->tpl_vars['nb_produits']->value;?>
</b></font> produits enregistrés.
                </td>
                <td>
                <?php if ($_SESSION['infoUser']['id_type_user']<=5){?>
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_valider" id="validateInventaire"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour valider l'inventaire :&nbsp;</div>
                <?php }?>
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_produits"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration_magasin.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>