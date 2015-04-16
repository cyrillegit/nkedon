<?php /* Smarty version Smarty-3.1.14, created on 2015-04-14 14:16:35
         compiled from ".\templates\statistiques\main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:40695524eb3fe5d6f5-61463523%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5d8c9df5c56e16e9d0ee56e89167159985ce7737' => 
    array (
      0 => '.\\templates\\statistiques\\main.tpl',
      1 => 1429020993,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '40695524eb3fe5d6f5-61463523',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5524eb3fedee71_95291511',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5524eb3fedee71_95291511')) {function content_5524eb3fedee71_95291511($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


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
                <div class="title"><strong>Statistiques </strong> <strong style="color:black;"> du magasin</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">Les statistiques du magasin est un espace reservé aux personnes abilités à se connecter sur cette partie.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle">Visualisez les statistiques en cliquant sur un des liens ci-dessous :</span></strong></em>
        <div>
            <br />
            <ul class="my_account">
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="statistiques.php?sub=stats_fournisseurs_factures" style="color:white;"><div class="btn_statistique"></div><div style="text-align: center; margin: 15px;">Factures par fournisseurs</div></a></li><br/>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="statistiques.php?sub=stats_factures_achats" style="color:white;"><div class="btn_statistique"></div><div style="text-align: center; margin: 15px;">Factures d'achats <br/> du mois courant</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="statistiques.php?sub=stats_factures_ventes" style="color:white;"><div class="btn_statistique"></div><div style="text-align: center; margin: 15px;">Factures de ventes du mois courant</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="statistiques.php?sub=stats_operations_journal" style="color:white;"><div class="btn_statistique"></div><div style="text-align: center; margin: 15px;">Journaux <br/> du mois courant</div></a></li><br/>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="statistiques.php?sub=stats_recapitulatifs" style="color:white;"><div class="btn_statistique"></div><div style="text-align: center; margin: 15px;">Evolution des recapitulatifs</div></a></li>
            </ul>
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>