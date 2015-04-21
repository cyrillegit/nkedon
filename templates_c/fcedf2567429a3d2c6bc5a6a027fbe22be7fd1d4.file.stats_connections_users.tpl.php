<?php /* Smarty version Smarty-3.1.14, created on 2014-02-13 22:26:57
         compiled from ".\templates\magasin\statistiques\stats_connections_users.tpl" */ ?>
<?php /*%%SmartyHeaderCode:117252fd2437bbdd96-56747861%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fcedf2567429a3d2c6bc5a6a027fbe22be7fd1d4' => 
    array (
      0 => '.\\templates\\magasin\\statistiques\\stats_connections_users.tpl',
      1 => 1392323789,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '117252fd2437bbdd96-56747861',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52fd2437c35d90_91212475',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52fd2437c35d90_91212475')) {function content_52fd2437c35d90_91212475($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<script language="javascript">

function RefreshXMLConnectionsUsers ()
{
    var responseText = $.ajax({
            type    : "POST",
            url     : "ajax/infos/magasin/statistiques/GetXMLConnectionsUsers.php",
            async   : false,
            data    : "",
            success : function (msg){}
    }).responseText;
    $("#chartContainer").empty ().html (responseText);
}

$(document).ready (function ()
{
    RefreshXMLConnectionsUsers ();
});
</script>

<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Statistiques : </strong> <strong style="color:black;"> Nombre de connexions par utilisateur</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">Affichage des statistiques representant le nombre de connexions par  utilisateur.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle"> Nombre de connexions par utilisateur :</span></strong></em>
    <div id="chartContainer"></div>
    </div>
    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='../magasin.php';"></div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>