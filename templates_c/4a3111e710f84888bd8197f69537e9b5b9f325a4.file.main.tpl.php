<?php /* Smarty version Smarty-3.1.14, created on 2014-07-16 21:03:22
         compiled from ".\templates\administration_magasin\main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:244052ebaf4403b577-83190040%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4a3111e710f84888bd8197f69537e9b5b9f325a4' => 
    array (
      0 => '.\\templates\\administration_magasin\\main.tpl',
      1 => 1405544551,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '244052ebaf4403b577-83190040',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52ebaf440f14d6_26470424',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ebaf440f14d6_26470424')) {function content_52ebaf440f14d6_26470424($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
$(document).ready (function ()
{


});
</script>

<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Gestion général </strong> <strong style="color:black;"> du magasin</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">L'administration du magasin est un espace reservé aux personnes abilités à se connecter sur cette partie, pour créer et mettre à jour les informations utiles pour le bon fonctionnement du magasin.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle">Gérez votre magasin en cliquant sur un des liens ci-dessous :</span></strong></em>
        <div>
            <br />
            <ul class="my_account">
                <li><a href="administration_magasin.php?sub=produits" style="color:white;">Ajouter / Modifer un produit.</a></li>
                <li><a href="administration_magasin.php?sub=factures" style="color:white;">Ajouter / Modifier une facture.</a></li>
                <li><a href="administration_magasin.php?sub=fournisseurs" style="color:white;">Ajouter / modifier un fournisseur.</a></li>
                <li><a href="administration_magasin.php?sub=inventaire" style="color:white;">Réaliser l'inventaire du magasin.</a></li>
                <li><a href="administration_magasin.php?sub=groupes_factures" style="color:white;">Historiques des factures</a></li>
                <li><a href="administration_magasin.php?sub=historique_syntheses" style="color:white;">Afficher l'historique des synthéses.</a></li>  
                <?php if ($_SESSION['infoUser']['id_type_user']<=4){?>
                <li><a href="administration_magasin.php?sub=statistiques" style="color:white;">Afficher les statistiques.</a></li> 
                <?php }?>              
            </ul>
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>