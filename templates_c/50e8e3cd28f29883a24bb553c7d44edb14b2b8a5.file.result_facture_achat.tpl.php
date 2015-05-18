<?php /* Smarty version Smarty-3.1.14, created on 2015-05-18 16:02:58
         compiled from ".\templates\magasin\gestion_factures\result_facture_achat.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10805555a0d32521758-64166928%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '50e8e3cd28f29883a24bb553c7d44edb14b2b8a5' => 
    array (
      0 => '.\\templates\\magasin\\gestion_factures\\result_facture_achat.tpl',
      1 => 1429620142,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10805555a0d32521758-64166928',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'nb_produits' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_555a0d329f8c09_51878030',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555a0d329f8c09_51878030')) {function content_555a0d329f8c09_51878030($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des de la facture courante.
*/
function RefreshTableFactureAchat ()
{
    var responseText = $.ajax({
        type	: "POST",
        url		: "ajax/infos/magasin/GetTableauFactureAchat.php",
        async	: false,
        data	: "",
        success	: function (msg){}
    }).responseText;
    $("#tableau_facture").empty ().html (responseText);

    UpdateTSorter ();
}

function getUrlParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            return sParameterName[1];
        }
    }
}

function setRegisterPopup(){
    if(getUrlParameter("status") == "register" ){
        $("#succes_register").show();
    }else{
        $("#succes_register").hide();
    }
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
    setRegisterPopup();
    RefreshTableFactureAchat( );
});

</script>

<div id="Content">
    <div class="success" id="succes_register" style="display: block;">
        <b>La facture d'achat a bien été enregistrée.</b>
        <div></div>
    </div>
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Facture d'achat du </strong> <strong style="color:black;"></strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de visualiser la facture d'achat nouvellement crée.<br/><br/></div>

    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="black"><b><?php echo $_smarty_tpl->tpl_vars['nb_produits']->value;?>
</b></font> produits dans cette facture d'achat.
                </td>

                <td>
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_facture"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='../../../magasin.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>