<?php /* Smarty version Smarty-3.1.14, created on 2015-04-21 12:40:37
         compiled from ".\templates\production\main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:82755536433666f4d9-29479440%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7a16748481525cff978ccf721c08f56f18ba69c0' => 
    array (
      0 => '.\\templates\\production\\main.tpl',
      1 => 1429619946,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '82755536433666f4d9-29479440',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_553643366f28f6_89437880',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_553643366f28f6_89437880')) {function content_553643366f28f6_89437880($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


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
                <div class="title"><strong>Gestion général </strong> <strong style="color:black;"> de la production</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">L'administration de la production est un espace reservé aux personnes abilités à se connecter sur cette partie, pour créer et mettre à jour les informations utiles pour le bon fonctionnement de la production.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle">Gérez votre production en cliquant sur un des liens ci-dessous :</span></strong></em>
        <div>
            <br />
            <ul class="my_account">
                <li><a href="production.php" style="color:white;">Cette partie est encore en construction.</a></li>
            </ul>
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>