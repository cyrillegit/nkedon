<?php /* Smarty version Smarty-3.1.14, created on 2014-03-13 20:50:25
         compiled from ".\templates\administration_magasin\statistiques\statistiques.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3102152f158f745f2b3-02286462%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c26d85fee2ba5c78e893eabc910ed136668884cf' => 
    array (
      0 => '.\\templates\\administration_magasin\\statistiques\\statistiques.tpl',
      1 => 1394743816,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3102152f158f745f2b3-02286462',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52f158f74c5756_82929730',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52f158f74c5756_82929730')) {function content_52f158f74c5756_82929730($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
$(document).ready (function ()
{


});
</script>

<style type="text/css">
    .blocInfoBis
    {
        background-image: url("css/images/bg_bloc_alertes.png");
        background-repeat: repeat;
        border: 1px solid #313131;
        padding: 5px 5px 5px;
    }
    .maindiv{ 
        width:690px; 
        margin:0 auto; 
        padding:20px; 
        background:#CCC;
    }
    .innerbg{ 
        padding:6px; 
        background:#FFF;
    }
    .links{ 
        font-weight:bold; 
        color:#ff0000; 
        text-decoration:none; 
        font-size:12px;
    }
</style>
<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Affichage </strong> <strong style="color:black;"> des statistiques</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">Affichage des statistiques est un espace reservé aux personnes abilités à se connecter sur cette partie.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle">Parametrez l'affichage des statistiques en cliquant sur un des liens ci-dessous :</span></strong></em>
        <div style="clear: both;"></div><br />
        <div class="blocInfoBis">
            <div class="blocInfoBis" >Statistiques des utilisateurs</div>
            <ul class="my_account">
                <li><a href="administration_magasin.php?sub=stats_users_types_users" style="color:white;">Nombre d'utilisateurs par compte utilisateur.</a></li>

                <li><a href="administration_magasin.php?sub=stats_connections_users" style="color:white;">Nombre de connexions par utilisateur.</a></li>                
            </ul>
        </div>
        <div style="clear: both;"></div><br />
        <div class="blocInfoBis">
            <div class="blocInfoBis" >Statistiques des fournisseurs</div>
            <ul class="my_account">
                <li><a href="administration_magasin.php?sub=stats_fournisseurs_factures" style="color:white;">Nombre de factures courantes par fournisseur.</a></li>
                <li><a href="administration_magasin.php?sub=stats_fournisseurs_factures_archivees" style="color:white;">Nombre de factures archivées par fournisseur.</a></li>                 
            </ul>
        </div> 
        <div style="clear: both;"></div><br />
        <div class="blocInfoBis">
            <div class="blocInfoBis" >Statistiques des progressions</div>
            <ul class="my_account">
                <li><a href="administration_magasin.php?sub=stats_graphes_progression" style="color:white;">Graphes de progression.</a></li>                
            </ul>
        </div> 
        <div style="clear: both;"></div><br />
        <div class="blocInfoBis">
            <div class="blocInfoBis" >Statistiques des produits</div>           
            <ul class="my_account">
                <li><a href="administration_magasin.php?sub=stats_produits" style="color:white;">Dates de péremption.</a></li>
                <li><a href="administration_magasin.php?sub=stats_produits_achetes_vendus" style="color:white;">Quantité de produits achétés et vendus.</a></li>                  
            </ul>          
        </div>                       
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>