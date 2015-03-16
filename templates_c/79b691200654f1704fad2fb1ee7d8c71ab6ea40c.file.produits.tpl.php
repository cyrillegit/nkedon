<?php /* Smarty version Smarty-3.1.14, created on 2015-03-16 17:51:21
         compiled from ".\templates\administration_magasin\gestion_produits\produits.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1206552ebaf4c5b8346-00584196%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '79b691200654f1704fad2fb1ee7d8c71ab6ea40c' => 
    array (
      0 => '.\\templates\\administration_magasin\\gestion_produits\\produits.tpl',
      1 => 1426526077,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1206552ebaf4c5b8346-00584196',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52ebaf4c685a16_22703770',
  'variables' => 
  array (
    'nb_produits' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ebaf4c685a16_22703770')) {function content_52ebaf4c685a16_22703770($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableProduits ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/GetTableauProduits.php",
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

	$("#addProduit").click (function ()
	{
		update_content ("ajax/popups/edit_produit.php", "popup", "id_produit=0");
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
                <div class="title"><strong>Ajouter / Modifier</strong> <strong style="color:black;">un produit</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité d'ajouter ou de modifier des produits.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b><?php echo $_smarty_tpl->tpl_vars['nb_produits']->value;?>
</b></font> produits enregistrés.
                </td>
                <td>
                <?php if ($_SESSION['infoUser']['id_type_user']<=3){?>
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_ajouter" id="addProduit"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour ajouter un produit :&nbsp;</div>
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