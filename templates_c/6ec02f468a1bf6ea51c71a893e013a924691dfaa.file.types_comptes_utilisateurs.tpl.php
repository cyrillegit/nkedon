<?php /* Smarty version Smarty-3.1.14, created on 2015-03-16 17:51:07
         compiled from ".\templates\administration\gestion_users\types_comptes_utilisateurs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:548052ebac3a82cfd2-94116775%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6ec02f468a1bf6ea51c71a893e013a924691dfaa' => 
    array (
      0 => '.\\templates\\administration\\gestion_users\\types_comptes_utilisateurs.tpl',
      1 => 1426526077,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '548052ebac3a82cfd2-94116775',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52ebac3a928481_87950254',
  'variables' => 
  array (
    'nb_types_users' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ebac3a928481_87950254')) {function content_52ebac3a928481_87950254($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des profils utilisateurs.
*/
function RefreshTableTypesUtilisateurs ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration/GetTableauTypesUtilisateurs.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_types_users").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
	RefreshTableTypesUtilisateurs ();

	$("#addTypeUser").click (function ()
	{
		update_content ("ajax/popups/edit_type_user.php", "popup", "id_type_user=0");
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
                <div class="title"><strong>Ajouter / Modifier</strong> <strong style="color:black;">un profil utilisateur</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité d'ajouter ou de modifier des profils utilisateurs sur le BackOffice.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b><?php echo $_smarty_tpl->tpl_vars['nb_types_users']->value;?>
</b></font> profils utilisateurs enregistrés, dont <font color="red"><b>2</b></font> profils utilisateurs administrateurs non visibles .
                </td>
                <td>
                <?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==1;?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==2;?>
<?php $_tmp2=ob_get_clean();?><?php if ($_tmp1||$_tmp2){?>
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_ajouter" id="addTypeUser"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour ajouter un profil utilisateur :&nbsp;</div>
                <?php }?>
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_types_users"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>