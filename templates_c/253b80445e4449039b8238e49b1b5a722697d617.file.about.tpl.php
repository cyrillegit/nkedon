<?php /* Smarty version Smarty-3.1.14, created on 2015-03-17 11:42:51
         compiled from ".\templates\about\about.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2714252fbbc8e3d7f37-05044636%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '253b80445e4449039b8238e49b1b5a722697d617' => 
    array (
      0 => '.\\templates\\about\\about.tpl',
      1 => 1426526077,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2714252fbbc8e3d7f37-05044636',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52fbbc8e43bc68_33813945',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52fbbc8e43bc68_33813945')) {function content_52fbbc8e43bc68_33813945($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
$(document).ready (function ()
{

});

</script>

<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>A propos de </strong> <strong style="color:black;">NKEDON</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Description de l'application Nkedon.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                <font color="red"><b>Nkedon</b></font> application de gestion de magasin.
                </td>
                <td>
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='about.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>