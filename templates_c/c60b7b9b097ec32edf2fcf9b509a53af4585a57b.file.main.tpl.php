<?php /* Smarty version Smarty-3.1.14, created on 2015-03-26 22:46:20
         compiled from ".\templates\administration\main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:884252ebac1fc1a369-24141186%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c60b7b9b097ec32edf2fcf9b509a53af4585a57b' => 
    array (
      0 => '.\\templates\\administration\\main.tpl',
      1 => 1427409978,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '884252ebac1fc1a369-24141186',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52ebac1fd16d40_85578892',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ebac1fd16d40_85578892')) {function content_52ebac1fd16d40_85578892($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
$(document).ready (function ()
{


});
</script>

<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Paramétrage</strong> <strong style="color:black;">général du backoffice</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">L'administration est un espace reservé aux personnes abilités à se connecter sur cette partie, pour créer et maintenir à jour les informations utiles pour le bon fonctionnement du site.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle">Gérez votre BackOffice en cliquant sur un des liens ci-dessous :</span></strong></em>
        <div>
            <br />
            <ul class="my_account">
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="administration.php?sub=comptes_utilisateurs" style="color:white; list-style-image:     url(css/images/li_ul_my_account_old.png);"><div class="btn_add_contact"></div><div style="text-align: center; margin: 15px;">Ajouter / Modifer un compte utilisateur</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="administration.php?sub=types_comptes_utilisateurs" style="color:white;"><div class="btn_users"></div><div style="text-align: center; margin: 15px;">Ajouter / Modifier un profil utilisateur</div></a></li>
                <?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==1;?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==2;?>
<?php $_tmp2=ob_get_clean();?><?php if ($_tmp1||$_tmp2){?>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="administration.php?sub=password_oublie" style="color:white;"><div class="btn_password"></div><div style="text-align: center; margin: 15px;">Mot de passe oublié</div></a></li>
                <?php }?>
            </ul>
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>