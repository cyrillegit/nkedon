<?php /* Smarty version Smarty-3.1.14, created on 2015-03-26 15:28:23
         compiled from ".\templates\magasin\statistiques\stats_users_types_users.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2359452fc9c14908f66-27978377%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a6334d06c0bd039e04c3bca76454a4450c946262' => 
    array (
      0 => '.\\templates\\magasin\\statistiques\\stats_users_types_users.tpl',
      1 => 1426526077,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2359452fc9c14908f66-27978377',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52fc9c14974e01_82877228',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52fc9c14974e01_82877228')) {function content_52fc9c14974e01_82877228($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<script language="javascript">

function RefreshXMLUsersTypesUsers ()
{
    var responseText = $.ajax({
            type    : "POST",
            url     : "ajax/infos/magasin/statistiques/GetXMLUsersTypesUsers.php",
            async   : false,
            data    : "",
            success : function (msg){}
    }).responseText;
    $("#chartContainerUsersTypesUsers").empty ().html (responseText);
}

$(document).ready (function ()
{
    RefreshXMLUsersTypesUsers ();
});
</script>

<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Statistiques : </strong> <strong style="color:black;"> Nombre d'utilisateur par compte utilisateur</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">Affichage des statistiques representant le nombre d'utilisateur par compte utilisateur.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle"> Nombre d'utilisateur par compte utilisateur :</span></strong></em>
    <div id="chartContainerUsersTypesUsers"></div>
    </div>
    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='../magasin.php';"></div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>