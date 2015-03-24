<?php /* Smarty version Smarty-3.1.14, created on 2015-03-17 10:06:55
         compiled from ".\templates\administration_magasin\gestion_fournisseurs\fournisseurs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1767152ebaf57636ca0-42910577%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ddae0c858688a44dc1aa12beccf0e76bd5034fff' => 
    array (
      0 => '.\\templates\\administration_magasin\\gestion_fournisseurs\\fournisseurs.tpl',
      1 => 1426526077,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1767152ebaf57636ca0-42910577',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52ebaf57756fa2_65389006',
  'variables' => 
  array (
    'nb_fournisseurs' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ebaf57756fa2_65389006')) {function content_52ebaf57756fa2_65389006($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableFournisseurs ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/GetTableauFournisseurs.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_fournisseurs").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
	RefreshTableFournisseurs ();

	$("#addFournisseur").click (function ()
	{
		update_content ("ajax/popups/edit_fournisseur.php", "popup", "id_fournisseur=0");
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
                <div class="title"><strong>Ajouter / Modifier</strong> <strong style="color:black;">un fournisseur</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité d'ajouter ou de modifier des fournisseurs.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b><?php echo $_smarty_tpl->tpl_vars['nb_fournisseurs']->value;?>
</b></font> fournisseurs enregistrés.
                </td>
                <td>
                <?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==1;?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==2;?>
<?php $_tmp2=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==3;?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==4;?>
<?php $_tmp4=ob_get_clean();?><?php if ($_tmp1||$_tmp2||$_tmp3||$_tmp4){?>
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_ajouter" id="addFournisseur"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour ajouter un fournisseur :&nbsp;</div>
                <?php }?>
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_fournisseurs"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration_magasin.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>