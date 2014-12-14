<?php /* Smarty version Smarty-3.1.14, created on 2014-01-31 14:08:47
         compiled from ".\templates\administration\gestion_users\password_oublie.tpl" */ ?>
<?php /*%%SmartyHeaderCode:838552ebae6f7989b4-81320616%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd36110f299053bb023713f0ffb79caa0dcacf7f1' => 
    array (
      0 => '.\\templates\\administration\\gestion_users\\password_oublie.tpl',
      1 => 1387746838,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '838552ebae6f7989b4-81320616',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'nb_comptes_utilisateurs' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52ebae6f83f855_57214876',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ebae6f83f855_57214876')) {function content_52ebae6f83f855_57214876($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableComptesUtilisateurs ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration/GetTableauComptesUtilisateursForPassword.php",
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

});

</script>

<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Modifier le mot de passe</strong> <strong style="color:black;">pour un compte utilisateur</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de modifier un mot de passe pour des comptes utilisateurs qui permettront à vos utilisateurs de pouvoir se connecter sur le BackOffice.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b><?php echo $_smarty_tpl->tpl_vars['nb_comptes_utilisateurs']->value;?>
</b></font> comptes utilisateurs enregistrés, dont <font color="red"><b>2</b></font> comptes utilisateurs administrateurs non visibles.
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