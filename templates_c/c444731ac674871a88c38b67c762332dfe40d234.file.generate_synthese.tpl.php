<?php /* Smarty version Smarty-3.1.14, created on 2014-03-09 14:12:32
         compiled from ".\templates\administration_magasin\gestion_magasin\generate_synthese.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2750552ebec823a1dd1-31378644%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c444731ac674871a88c38b67c762332dfe40d234' => 
    array (
      0 => '.\\templates\\administration_magasin\\gestion_magasin\\generate_synthese.tpl',
      1 => 1394332729,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2750552ebec823a1dd1-31378644',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52ebec82456371_30444728',
  'variables' => 
  array (
    'nb_histo_syntheses' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ebec82456371_30444728')) {function content_52ebec82456371_30444728($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableGenerateSynthese(date_histo_synthese)
{
    var param = "date_histo_synthese="+date_histo_synthese;
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/GetTableauGenerateSynthese.php",
			async	: false,
			data	: param,
			success	: function (msg){}
	}).responseText;
	$("#tableau_generate_synthese").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
	RefreshTableGenerateSynthese ("");

   $('#histoSynthese').click(function() 
    {
        document.location.href="administration_magasin.php?sub=historiques_syntheses";
    });
//*
    $(".links").each (function ()
    {
        $(this).click (function ()
        {
            var filename = $(this).attr("filename");
            alert("Bientot disponible");
        //    document.location.href="ajax/download.php?filename="+filename;
        });
    });
    //*/
});

</script>

<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Génération</strong> <strong style="color:black;">de la synthèse</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de générer la synthèse de l'inventaire.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b><?php echo $_smarty_tpl->tpl_vars['nb_histo_syntheses']->value;?>
</b></font> synthèses effectuées.
                </td>

                <td>
                <?php if ($_SESSION['infoUser']['id_type_user']<=5){?>
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_valider" id="histoSynthese"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Afficher l'historique des synthèses:&nbsp;</div>
                <?php }?>
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_generate_synthese"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration_magasin.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>