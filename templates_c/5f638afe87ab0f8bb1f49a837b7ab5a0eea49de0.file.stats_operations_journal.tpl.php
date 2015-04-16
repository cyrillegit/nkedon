<?php /* Smarty version Smarty-3.1.14, created on 2015-04-08 10:10:46
         compiled from ".\templates\statistiques\stats_operations_journal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:65425524fdf1b50477-95473009%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5f638afe87ab0f8bb1f49a837b7ab5a0eea49de0' => 
    array (
      0 => '.\\templates\\statistiques\\stats_operations_journal.tpl',
      1 => 1428487843,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '65425524fdf1b50477-95473009',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5524fdf1bf7829_66360505',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5524fdf1bf7829_66360505')) {function content_5524fdf1bf7829_66360505($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<script language="javascript">

    function RefreshXMLOperationsJournal()
    {
        var responseText = $.ajax({
            type    : "POST",
            url     : "ajax/infos/statistiques/GetXMLOperationsJournal.php",
            async   : false,
            data    : "",
            success : function (msg){}
        }).responseText;
        $("#chartContainer").empty ().html (responseText);
    }

$(document).ready (function ()
{
    RefreshXMLOperationsJournal();
});
</script>

<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Statistiques : </strong> <strong style="color:black;"> des operations du journal du mois courant</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">Affichage des statistiques representant les operations du journal  du mois courant.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle">Evolutions du montant des operations du journal :</span></strong></em>
    <div id="chartContainer"></div>
    </div>
    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='statistiques.php?sub=statistiques';"></div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>