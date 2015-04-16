<?php /* Smarty version Smarty-3.1.14, created on 2015-04-08 09:10:36
         compiled from ".\templates\statistiques\stats_fournisseurs_factures.tpl" */ ?>
<?php /*%%SmartyHeaderCode:169725524ef8d0ca711-79116915%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '893d954589fa52827b3cf44218e94b9d885eec20' => 
    array (
      0 => '.\\templates\\statistiques\\stats_fournisseurs_factures.tpl',
      1 => 1428484215,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '169725524ef8d0ca711-79116915',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5524ef8d167990_83277593',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5524ef8d167990_83277593')) {function content_5524ef8d167990_83277593($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<script language="javascript">

function RefreshXMLFacturesFournisseur()
{
    var responseText = $.ajax({
            type    : "POST",
            url     : "ajax/infos/administration_magasin/statistiques/GetXMLFacturesFournisseur.php",
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
			<div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
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
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='statistiques.php?sub=statistiques';"></div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>