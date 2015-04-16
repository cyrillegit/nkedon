<?php /* Smarty version Smarty-3.1.14, created on 2015-04-14 13:01:17
         compiled from ".\templates\historiques\main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5932551426835ec483-58637777%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c9a08fce85b770487594c1ab16df47933fd4e2ad' => 
    array (
      0 => '.\\templates\\historiques\\main.tpl',
      1 => 1429016471,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5932551426835ec483-58637777',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_551426836654f7_18059493',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_551426836654f7_18059493')) {function content_551426836654f7_18059493($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


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
                <div class="title"><strong>Historiques </strong> <strong style="color:black;"> du magasin</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">L'administration du magasin est un espace reservé aux personnes abilités à se connecter sur cette partie, pour créer et mettre à jour les informations utiles pour le bon fonctionnement du magasin.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle">Gérez votre magasin en cliquant sur un des liens ci-dessous :</span></strong></em>
        <div>
            <br />
            <ul class="my_account">
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="historiques.php?sub=historiques_factures" style="color:white;"><div class="btn_histo_facture"></div><div style="text-align: center; margin: 15px;">Historiques des factures d'achats</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="historiques.php?sub=historiques_factures_ventes" style="color:white;"><div class="btn_histo_facture"></div><div style="text-align: center; margin: 15px;">Historiques des factures de ventes</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="historiques.php?sub=historiques_journal" style="color:white;"><div class="btn_histo_facture"></div><div style="text-align: center; margin: 15px;">Historiques des journaux</div></a></li><br/>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="historiques.php?sub=historiques_inventaires" style="color:white;"><div class="btn_histo_synthese"></div><div style="text-align: center; margin: 15px;">Historiques des inventaires</div></a></li>
                <?php if ($_SESSION['infoUser']['id_type_user']<=4){?>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="statistiques.php?sub=main" style="color:white;"><div class="btn_statistique"></div><div style="text-align: center; margin: 15px;">Afficher les statistiques</div></a></li>
                <?php }?>              
            </ul>
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>