<?php /* Smarty version Smarty-3.1.14, created on 2015-03-18 12:17:57
         compiled from ".\templates\magasin\gestion_journal\edit_operations_journal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2711255086616e12ea1-09040167%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90621457dbaa28f2a5a65daeb9bf15841db408d0' => 
    array (
      0 => '.\\templates\\magasin\\gestion_journal\\edit_operations_journal.tpl',
      1 => 1426681070,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2711255086616e12ea1-09040167',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_55086616f1d2f7_35538576',
  'variables' => 
  array (
    'nb_operations' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55086616f1d2f7_35538576')) {function content_55086616f1d2f7_35538576($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableOperations ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/magasin/GetTableauProduitsOperation.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_journal").empty ().html (responseText);

	UpdateTSorter ();
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
    RefreshTableOperations ();

	$("#addOperation").click (function ()
	{
		update_content ("ajax/popups/edit_operation.php", "popup", "id_operation=0");
		ShowPopupHeight (550);
	});
});

</script>

<style type="text/css">
    #results{
        display:none;
        width:228px;
        border:1px solid #AAA;
        border-top-width:0;
        margin-left: 80px;
    }

    #results div{
        width:220px;
        padding:2px 4px;
        text-align:left;
        border:0;
    }

    #results div:hover,.result_focus{
        background-color:#DDD!important;
        color: black;
    }
</style>
<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Réaliser </strong> <strong style="color:black;">le journal</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de réaliser le journal.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b><?php echo $_smarty_tpl->tpl_vars['nb_operations']->value;?>
</b></font> opérations enregistrées dans le journal.
                </td>
                <td>
                <?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==1;?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==2;?>
<?php $_tmp2=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==3;?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==4;?>
<?php $_tmp4=ob_get_clean();?><?php if ($_tmp1||$_tmp2||$_tmp3||$_tmp4){?>
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_ajouter" id="addOperation"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour ajouter une opération :&nbsp;</div>
                <?php }?>
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_journal"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='../magasin.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>