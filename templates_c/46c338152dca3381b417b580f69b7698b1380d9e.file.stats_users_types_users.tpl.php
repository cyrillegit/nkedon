<?php /* Smarty version Smarty-3.1.14, created on 2014-02-13 19:31:27
         compiled from ".\templates\administration_magasin\statistiques\stats_users_types_users\stats_users_types_users.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3143052fca0d9c75a33-87905784%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '46c338152dca3381b417b580f69b7698b1380d9e' => 
    array (
      0 => '.\\templates\\administration_magasin\\statistiques\\stats_users_types_users\\stats_users_types_users.tpl',
      1 => 1392319879,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3143052fca0d9c75a33-87905784',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52fca0d9cd0b49_31042975',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52fca0d9cd0b49_31042975')) {function content_52fca0d9cd0b49_31042975($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<script language="javascript">

function RefreshXMLUsersTypesUsers ()
{
    var responseText = $.ajax({
            type    : "POST",
            url     : "ajax/infos/administration_magasin/GetXMLUsersTypesUsers.php",
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
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration_magasin.php?sub=statistiques';"></div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>