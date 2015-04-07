<?php /* Smarty version Smarty-3.1.14, created on 2015-04-07 20:12:38
         compiled from ".\templates\administration_magasin\statistiques\stats_graphes_progression.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1019252fde79eb2be89-36889924%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5a7a56bc5b4ac828f502c52d462c367128b4298b' => 
    array (
      0 => '.\\templates\\administration_magasin\\statistiques\\stats_graphes_progression.tpl',
      1 => 1428437507,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1019252fde79eb2be89-36889924',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52fde79eb90076_47883417',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52fde79eb90076_47883417')) {function content_52fde79eb90076_47883417($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<script language="javascript">

function RefreshXMLGraphesProgressions()
{
    var responseText = $.ajax({
            type    : "POST",
            url     : "ajax/infos/administration_magasin/statistiques/GetXMLAchatsVentesJournal.php",
            async   : false,
            data    : "",
            success : function (msg){}
    }).responseText;
    $("#chartContainer").empty ().html (responseText);
}

$(document).ready (function ()
{
    RefreshXMLGraphesProgressions();
});
</script>

<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Statistiques : </strong> <strong style="color:black;"> Courbes des progressions</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">Affichage des statistiques representant les courbes des progressions.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle"> Courbes des progression :</span></strong></em>
    <div id="chartContainer"></div>
    </div>
    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration_magasin.php?sub=statistiques';"></div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>