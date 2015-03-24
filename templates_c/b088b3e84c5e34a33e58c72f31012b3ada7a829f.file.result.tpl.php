<?php /* Smarty version Smarty-3.1.14, created on 2015-03-17 16:54:21
         compiled from ".\templates\delete\result.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3244952ebd6620a84b3-73546977%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b088b3e84c5e34a33e58c72f31012b3ada7a829f' => 
    array (
      0 => '.\\templates\\delete\\result.tpl',
      1 => 1426526077,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3244952ebd6620a84b3-73546977',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52ebd6621a0970_03031824',
  'variables' => 
  array (
    'error' => 0,
    'message' => 0,
    'show_return' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ebd6621a0970_03031824')) {function content_52ebd6621a0970_03031824($_smarty_tpl) {?><style type="text/css">
#Content .wrapper .counters .countdown {
	text-align: center;
}
</style>
<?php echo $_smarty_tpl->getSubTemplate ('common/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script type="application/javascript">
$(document).ready (function ()
{
	<?php if ($_smarty_tpl->tpl_vars['error']->value==0){?>
	var Counters = $("div.wrapper div.counters");
	var TickTimeout = 3;
	
	$("div.countdown", Counters).everyTime (1000,function(i) 
	{
		if (i <= TickTimeout)
		{
			$(this).html ("Rechargement automatique de la page dans <strong>" + (TickTimeout - i) + "</strong> secondes.");
		}
		else
		{
			history.back (-1);
		}
	});
	<?php }?>
});
</script>

<div id="Content">
  	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
		<div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/menu_fdr.png" width="42" height="42" style="float:left" /></div>
            
            <div class="t_titre">
                <div class="title"><strong>suppression</strong> <strong style="color:black;">d'une information</strong></div>
	        </div>
    	</div>
    </div>
    <div class="<?php if ($_smarty_tpl->tpl_vars['error']->value==0){?>success<?php }else{ ?>warnings<?php }?>">
    <?php echo $_smarty_tpl->tpl_vars['message']->value;?>

    </div>
    <br style="clear: both;" />
    <?php if ($_smarty_tpl->tpl_vars['error']->value==0){?>
    <div class="wrapper">
    	<div class="counters">
		    <div class="countdown">Rechargement automatique de la page dans <strong>3</strong> secondes.</div>
        </div>
    </div>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['show_return']->value){?><br /><br /><a href="javascript:history.back();" class="std" style="font-size: 16px;">Cliquez ici pour revenir à la page précédente.</a><?php }?>
</div>
<?php echo $_smarty_tpl->getSubTemplate ('common/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>