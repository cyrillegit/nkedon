<?php /* Smarty version Smarty-3.1.14, created on 2015-03-17 09:48:25
         compiled from ".\templates\administration_magasin\gestion_factures\factures.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2029452ebaf52350ec3-59687912%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d4b5bc2e6a5bcd5203e8e58945a6fea4f9e87a6' => 
    array (
      0 => '.\\templates\\administration_magasin\\gestion_factures\\factures.tpl',
      1 => 1426526077,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2029452ebaf52350ec3-59687912',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52ebaf524a7ec0_66123872',
  'variables' => 
  array (
    'nb_factures' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ebaf524a7ec0_66123872')) {function content_52ebaf524a7ec0_66123872($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableFactures ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/GetTableauFactures.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_factures").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
	RefreshTableFactures ();

	$("#addFacture").click (function ()
	{
	//	update_content ("ajax/popups/edit_facture.php", "popup", "id_facture=0");
	//	ShowPopupHeight (550);
     document.location.href="administration_magasin.php?sub=edit_facture&id_facture=0";
	});
});

</script>

<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Ajouter / Modifier</strong> <strong style="color:black;">une facture</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité d'ajouter ou de modifier des factures.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b><?php echo $_smarty_tpl->tpl_vars['nb_factures']->value;?>
</b></font> factures enregistrés.
                </td>
                <td>
                <?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==1;?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==2;?>
<?php $_tmp2=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==3;?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==4;?>
<?php $_tmp4=ob_get_clean();?><?php if ($_tmp1||$_tmp2||$_tmp3||$_tmp4){?>
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_ajouter" id="addFacture"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour ajouter un facture :&nbsp;</div>
                <?php }?>
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_factures"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration_magasin.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>