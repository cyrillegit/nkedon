<?php /* Smarty version Smarty-3.1.14, created on 2015-04-16 13:21:24
         compiled from ".\templates\historiques\historiques_inventaires\inventaires_annee.tpl" */ ?>
<?php /*%%SmartyHeaderCode:214635517e191e206a6-87497676%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b42f63afc82748540c1fce7676d795ec366d166a' => 
    array (
      0 => '.\\templates\\historiques\\historiques_inventaires\\inventaires_annee.tpl',
      1 => 1429190170,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '214635517e191e206a6-87497676',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5517e191ead282_56061872',
  'variables' => 
  array (
    'nb_inventaires' => 0,
    'annee' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5517e191ead282_56061872')) {function content_5517e191ead282_56061872($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des des journaux groupées pour mois.
*/
function RefreshTableHistoriquesInventairesAnnee( date_histo_inventaire, annee )
{
    var param = "date_histo_inventaire="+date_histo_inventaire+"&annee="+annee;
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/historiques/GetTableauHistoriquesInventairesAnnee.php",
			async	: false,
			data	: param,
			success	: function (msg){}
	}).responseText;
	$("#tableau_historiques_inventaires_annee").empty ().html (responseText);

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
/**
	jQuery init.
*/
$(document).ready (function ()
{
    var annee = getUrlParameter("annee");

    RefreshTableHistoriquesInventairesAnnee( "", annee );

    $("#date_histo_inventaire").datepicker({
        beforeShow:function(input) {
            $(input).css({
                "position": "relative",
                "z-index": 999999
            });
        }
    });

    $("#date_histo_inventaire").change (function ()
    {
        var annee = getUrlParameter("annee");
        var date_histo_inventaire = $("#date_histo_inventaire").val();
        RefreshTableHistoriquesInventairesAnnee( date_histo_inventaire, annee );
    });
});

</script>

<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Historiques </strong> <strong style="color:black;">des inventaires d'une année</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de visualiser des inventaires d'une année.<br/><br/></div>

    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="black"><b><?php echo $_smarty_tpl->tpl_vars['nb_inventaires']->value;?>
</b></font> inventaires pour <font color="black"><b><?php echo $_smarty_tpl->tpl_vars['annee']->value;?>
</b></font>.
                </td>

                <td>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Afficher les historiques des inventaires à partir de:  <input type="text" name="date_histo_inventaire" id="date_histo_inventaire" value=""/>&nbsp;</div>

                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_historiques_inventaires_annee"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='historiques.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>