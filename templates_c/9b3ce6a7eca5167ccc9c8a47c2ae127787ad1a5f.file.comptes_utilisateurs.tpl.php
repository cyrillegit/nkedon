<?php /* Smarty version Smarty-3.1.14, created on 2015-03-17 10:46:34
         compiled from ".\templates\administration\gestion_users\comptes_utilisateurs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2892352ebac2dad3b68-18198693%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9b3ce6a7eca5167ccc9c8a47c2ae127787ad1a5f' => 
    array (
      0 => '.\\templates\\administration\\gestion_users\\comptes_utilisateurs.tpl',
      1 => 1426589192,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2892352ebac2dad3b68-18198693',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52ebac2dba8200_85572695',
  'variables' => 
  array (
    'nb_comptes_utilisateurs' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ebac2dba8200_85572695')) {function content_52ebac2dba8200_85572695($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableComptesUtilisateurs ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration/GetTableauComptesUtilisateurs.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_comptes_utilisateurs").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
	RefreshTableComptesUtilisateurs ();

	$("#addCompteUtilisateur").click (function ()
	{
		update_content ("ajax/popups/edit_compte_utilisateur.php", "popup", "id_compte=0");
		ShowPopupHeight (300);
	});
});

</script>

<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Ajouter / Modifier</strong> <strong style="color:black;">un compte utilisateur</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité d'ajouter ou de modifier des comptes utilisateurs qui permettront à vos Inspecteurs, Inventoristes et visiteurs de pouvoir se connecter sur le BackOffice.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b><?php echo $_smarty_tpl->tpl_vars['nb_comptes_utilisateurs']->value;?>
</b></font> comptes utilisateurs enregistrés, dont <font color="red"><b>2</b></font>  comptes adminitrateurs non visibles.
                </td>
                <td>
                <?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==1;?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==2;?>
<?php $_tmp2=ob_get_clean();?><?php if ($_tmp1||$_tmp2){?>
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_ajouter" id="addCompteUtilisateur"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour ajouter un compte utilisateur :&nbsp;</div>
                <?php }?>
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_comptes_utilisateurs"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>