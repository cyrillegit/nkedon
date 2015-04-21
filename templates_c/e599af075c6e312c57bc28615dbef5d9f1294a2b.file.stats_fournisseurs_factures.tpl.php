<?php /* Smarty version Smarty-3.1.14, created on 2015-04-07 17:29:04
         compiled from ".\templates\magasin\statistiques\stats_fournisseurs_factures.tpl" */ ?>
<?php /*%%SmartyHeaderCode:918052fd4606f26ee9-56942019%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e599af075c6e312c57bc28615dbef5d9f1294a2b' => 
    array (
      0 => '.\\templates\\magasin\\statistiques\\stats_fournisseurs_factures.tpl',
      1 => 1426526077,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '918052fd4606f26ee9-56942019',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52fd4607053249_37166602',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52fd4607053249_37166602')) {function content_52fd4607053249_37166602($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<script language="javascript">

function RefreshXMLFacturesFournisseur()
{
    var responseText = $.ajax({
            type    : "POST",
            url     : "ajax/infos/magasin/statistiques/GetXMLFacturesFournisseur.php",
            async   : false,
            data    : "",
            success : function (msg){}
    }).responseText;
    $("#chartContainer").empty ().html (responseText);
}

$(document).ready (function ()
{
    RefreshXMLFacturesFournisseur();
});
</script>

<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Statistiques : </strong> <strong style="color:black;"> Nombre de factures par fournisseurs</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">Affichage des statistiques representant le nombre de factures par fournisseurs.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle"> Nombre de factures par fournisseurs:</span></strong></em>
    <div id="chartContainer"></div>
    </div>
    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='../magasin.php';"></div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>