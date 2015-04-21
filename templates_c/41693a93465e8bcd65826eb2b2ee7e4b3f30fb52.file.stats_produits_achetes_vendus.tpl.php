<?php /* Smarty version Smarty-3.1.14, created on 2014-03-12 20:48:05
         compiled from ".\templates\magasin\statistiques\stats_produits_achetes_vendus.tpl" */ ?>
<?php /*%%SmartyHeaderCode:29699531f8a5de9f617-42394333%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '41693a93465e8bcd65826eb2b2ee7e4b3f30fb52' => 
    array (
      0 => '.\\templates\\magasin\\statistiques\\stats_produits_achetes_vendus.tpl',
      1 => 1394657254,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '29699531f8a5de9f617-42394333',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_531f8a5df3ca22_33116016',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_531f8a5df3ca22_33116016')) {function content_531f8a5df3ca22_33116016($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<script language="javascript">

function RefreshXMLProduitsAchetesVendus()
{
    var responseText = $.ajax({
            type    : "POST",
            url     : "ajax/infos/magasin/statistiques/GetXMLProduitsAchetesVendus.php",
            async   : false,
            data    : "",
            success : function (msg){}
    }).responseText;
    $("#chartContainer").empty ().html (responseText);
}

$(document).ready (function ()
{
    RefreshXMLProduitsAchetesVendus();
});
</script>

<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Statistiques : </strong> <strong style="color:black;"> Quantités de produits achétés et vendus</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">Affichage des statistiques representant les quantités de produits achétés et vendus.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle"> Quantités de produits achétés et vendus:</span></strong></em>
    <div id="chartContainer"></div>
    </div>
    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='../magasin.php';"></div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>