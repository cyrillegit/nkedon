<?php /* Smarty version Smarty-3.1.14, created on 2014-02-13 20:37:10
         compiled from ".\templates\administration_magasin\statistiques\stats_fournisseurs_factures_mois.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1516552fd2648120e74-92658770%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '058c042157d9e822968fde4d7a1ab55bf74c30f4' => 
    array (
      0 => '.\\templates\\administration_magasin\\statistiques\\stats_fournisseurs_factures_mois.tpl',
      1 => 1392323827,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1516552fd2648120e74-92658770',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52fd2648193987_86502955',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52fd2648193987_86502955')) {function content_52fd2648193987_86502955($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<script language="javascript">

function RefreshXMLFacturesFournisseurMois()
{
    var responseText = $.ajax({
            type    : "POST",
            url     : "ajax/infos/administration_magasin/statistiques/GetXMLFacturesFournisseurMois.php",
            async   : false,
            data    : "",
            success : function (msg){}
    }).responseText;
    $("#chartContainer").empty ().html (responseText);
}

$(document).ready (function ()
{
    RefreshXMLFacturesFournisseurMois();
});
</script>

<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Statistiques : </strong> <strong style="color:black;"> Nombre de factures par fournisseurs et par mois</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">Affichage des statistiques representant le nombre de factures par fournisseurs et par mois.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle"> Nombre de factures par fournisseurs et par mois :</span></strong></em>
    <div id="chartContainer"></div>
    </div>
    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration_magasin.php?sub=statistiques';"></div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>