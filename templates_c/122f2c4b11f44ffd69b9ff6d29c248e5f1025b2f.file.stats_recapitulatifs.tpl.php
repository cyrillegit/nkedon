<?php /* Smarty version Smarty-3.1.14, created on 2015-04-14 14:14:18
         compiled from ".\templates\statistiques\stats_recapitulatifs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2904455250519566036-54820566%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '122f2c4b11f44ffd69b9ff6d29c248e5f1025b2f' => 
    array (
      0 => '.\\templates\\statistiques\\stats_recapitulatifs.tpl',
      1 => 1429020849,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2904455250519566036-54820566',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_552505195d8404_92536376',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_552505195d8404_92536376')) {function content_552505195d8404_92536376($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<script language="javascript">

function RefreshXMLRecapitulatifs()
{
    var responseText = $.ajax({
            type    : "POST",
            url     : "ajax/infos/statistiques/GetXMLRecapitulatifs.php",
            async   : false,
            data    : "",
            success : function (msg){}
    }).responseText;
    $("#chartContainer").empty ().html (responseText);
}

$(document).ready (function ()
{
    RefreshXMLRecapitulatifs();
});
</script>

<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Statistiques </strong> <strong style="color:black;"> des récapitulatifs des inventaires</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">Affichage des statistiques representant l'évolution des écapitulatifs des inventaires.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle"> Evolution des recapitulatifs</span></strong></em>
    <div id="chartContainer"></div>
    </div>
    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='statistiques.php?sub=statistiques';"></div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>