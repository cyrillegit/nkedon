<?php /* Smarty version Smarty-3.1.14, created on 2014-02-12 21:16:49
         compiled from ".\templates\administration_magasin\gestion_magasin\recapitulatif_inventaire.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1768852ebec69712655-88900947%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e87cc5c3952e078b19863ada84abac90e08e4ac2' => 
    array (
      0 => '.\\templates\\administration_magasin\\gestion_magasin\\recapitulatif_inventaire.tpl',
      1 => 1392238863,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1768852ebec69712655-88900947',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52ebec697da962_98760244',
  'variables' => 
  array (
    'nb_recapitulatif' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ebec697da962_98760244')) {function content_52ebec697da962_98760244($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableRecapitulatif ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/GetTableauRecapitulatifInventaire.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_recapitulatif").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
	RefreshTableRecapitulatif ();

    $('#validateInventaire').click(function() 
    {
        var didConfirm = confirm("Vous êtes sur le point de générer la synthèse de l'inventaire. \n cet action est irréversible");
      if (didConfirm == true) {
        document.location.href="administration_magasin.php?sub=generate_synthese";
      }
    });
});

</script>

<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Recapitulatifs</strong> <strong style="color:black;">des inventaires du magasin</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de modifier des recapitulatifs.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b><?php echo $_smarty_tpl->tpl_vars['nb_recapitulatif']->value;?>
</b></font> recapitulatifs enregistrés.
                </td>
                <td>
                <?php if ($_SESSION['infoUser']['id_type_user']<=5){?>
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_valider" id="validateInventaire"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour générer la synthése :&nbsp;</div>
                <?php }?>
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_recapitulatif"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration_magasin.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>