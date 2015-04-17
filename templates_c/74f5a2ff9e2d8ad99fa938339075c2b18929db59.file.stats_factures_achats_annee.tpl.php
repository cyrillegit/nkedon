<?php /* Smarty version Smarty-3.1.14, created on 2015-04-16 15:11:15
         compiled from ".\templates\statistiques\stats_factures_achats_annee.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9699552fc8a18305c3-87126816%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '74f5a2ff9e2d8ad99fa938339075c2b18929db59' => 
    array (
      0 => '.\\templates\\statistiques\\stats_factures_achats_annee.tpl',
      1 => 1429195072,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9699552fc8a18305c3-87126816',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_552fc8a189eb17_13851315',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_552fc8a189eb17_13851315')) {function content_552fc8a189eb17_13851315($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<script language="javascript">

    function RefreshXMLAchats()
    {
        var responseText = $.ajax({
            type    : "POST",
            url     : "ajax/infos/statistiques/GetXMLFacturesAchatsAnnee.php",
            async   : false,
            data    : "",
            success : function (msg){}
        }).responseText;
        $("#chartContainer").empty ().html (responseText);
    }

$(document).ready (function ()
{
    RefreshXMLAchats();
});
</script>

<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Statistiques : </strong> <strong style="color:black;"> des factures d'achats des 12 derniers mois</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">Affichage des statistiques representant les factures d'achats des 12 derniers mois.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle">Evolutions du montant des achats:</span></strong></em>
    <div id="chartContainer"></div>
    </div>
    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='statistiques.php?sub=statistiques';"></div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>