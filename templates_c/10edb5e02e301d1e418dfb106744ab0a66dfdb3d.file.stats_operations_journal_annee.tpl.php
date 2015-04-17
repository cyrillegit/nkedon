<?php /* Smarty version Smarty-3.1.14, created on 2015-04-17 10:17:42
         compiled from ".\templates\statistiques\stats_operations_journal_annee.tpl" */ ?>
<?php /*%%SmartyHeaderCode:265135530dd33bd6382-61159983%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '10edb5e02e301d1e418dfb106744ab0a66dfdb3d' => 
    array (
      0 => '.\\templates\\statistiques\\stats_operations_journal_annee.tpl',
      1 => 1429265812,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '265135530dd33bd6382-61159983',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5530dd33e9e853_04390925',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5530dd33e9e853_04390925')) {function content_5530dd33e9e853_04390925($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<script language="javascript">

    function RefreshXMLOperationsJournalAnnee()
    {
        var responseText = $.ajax({
            type    : "POST",
            url     : "ajax/infos/statistiques/GetXMLOperationsJournalAnnee.php",
            async   : false,
            data    : "",
            success : function (msg){}
        }).responseText;
        $("#chartContainer").empty ().html (responseText);
    }

$(document).ready (function ()
{
    RefreshXMLOperationsJournalAnnee();
});
</script>

<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Statistiques : </strong> <strong style="color:black;"> des operations du journal des 12 derniers mois</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">Affichage des statistiques representant les operations du journal  des 12 derniers mois.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle">Evolutions du montant des operations du journal :</span></strong></em>
    <div id="chartContainer"></div>
    </div>
    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='statistiques.php?sub=statistiques';"></div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>