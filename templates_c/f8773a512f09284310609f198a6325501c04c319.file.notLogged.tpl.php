<?php /* Smarty version Smarty-3.1.14, created on 2014-02-04 19:50:09
         compiled from ".\templates\notLogged.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2188252eba7c69be9b7-97408979%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f8773a512f09284310609f198a6325501c04c319' => 
    array (
      0 => '.\\templates\\notLogged.tpl',
      1 => 1391543407,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2188252eba7c69be9b7-97408979',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52eba7c6a5ee72_52968380',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52eba7c6a5ee72_52968380')) {function content_52eba7c6a5ee72_52968380($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
function connect ()
{
	var prerequis = "";
	var ok = true;
	
	if ($("#connect_login").val () == "")
	{
		prerequis = prerequis + "L'identifiant est <u>obligatoire</u>.<br />";
		ok = false;
	}
	if ($("#connect_password").val () == "")
	{
		prerequis = prerequis + "Le mot de passe est <u>obligatoire</u>.<br />";
		ok = false;
	}
		
	if (!ok)
	{
		ShowError (prerequis);
		ok = false;
	}
	else
	{
		var encodedPassword = $.md5 ($("#connect_password").val());
			
		$.blockUI ({ message: '<h4 style="font-size:10px;margin:10px 0;">Veuillez patientez pendant la connexion...</h4><img src="../assets/images/progress.gif" /><br/><br/>' });
		var response = $.ajax({
			type	: "POST",
			url		: "ajax/authenticate.php",
			async	: false,
			data	: "login="+$("#connect_login").val()+"&password="+encodedPassword,
			success	: function (msg)
			{
				
			}
		}).responseText;

		$.unblockUI ();
		response = eval(response);
		if (response.connected)
		{
			// Si la connexion a fonctionné, on sort sur la page d'accueil.
			ShowSuccess ("Félicitations, la connexion a réussie, chargement en cours de votre espace personnel...");
			document.location.href = "index.php";
		}
		else
		{
			ShowError ("La connexion a échouée, soit le login et/ou le mot de passe sont erronés !");
			// On r&eacute;initialise les champs de saisie.
			$("#connect_login").val ("");
			$("#connect_password").val ("");
			$("#connect_login").focus ();
		}
	}
}
$(document).ready (function ()
{
	/**
		Fonction de connection au site une fois les identifiants saisis.
	*/
	$("#btnConnecter").click (function ()
	{
		connect ();
	});
	
	$("#connect_login").keydown(function(event) {
		if (event.keyCode == '13') 
		{
			event.preventDefault();
			connect ();
		}
	});
	
	$("#connect_password").keydown(function(event) {
		if (event.keyCode == '13') 
		{
			event.preventDefault();
			connect ();
		}
	});
});
</script>

<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/menu_tb.png" style="float:left" /></div>
            
            <div class="t_titre">
                <div class="title"><strong>connexion</strong> <strong style="color:black;">à votre tableau de  bord</strong></div>
            </div>
        </div>
        
    </div>
    
    <br style="clear: both;" />
    <?php echo $_smarty_tpl->getSubTemplate ("common/messages_boxes.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	<div id="main">
		<div align="center">
			<div style="margin auto; width: 470px;padding-right: 20px;">
				<div align="center">
					Vous n'êtes pas connecté sur le site.<br />Pour vous connecter, veuillez remplir les champs situés ci-dessous.
				</div>
			</div>
			<table style="margin auto; width:470px;">
				<tr>
					<td valign="top" class="bg_connexion" >
						<table width="100%" border="0" cellpadding="2" cellspacing="3"  style="margin-top: 30px;">
							<tr >
								<td colspan="2"><div style="font-size: 18px; font-style: italic; font-weight: bold; margin-left: 50px;"><strong>Vous disposez</strong> <strong style="color:black;">déjà d'un compte ?</strong></div></td>
							</tr>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td class="left_50">Identifiant :</td>
								<td align=""><input type="text" name="connect_login" id="connect_login" tabindex="1" /></td>
							</tr>
							<tr>
								<td class="left_50">Mot de passe :</td>
								<td align=""><input type="password" name="connect_password" id="connect_password"  tabindex="2" /></td>
							</tr>
							<tr>
							  <td align="" class="left_50">&nbsp;</td>
							  <td><img src="css/images/btn_connect_me.png" width="120" id="btnConnecter" height="20" style="cursor: pointer;"/></td>
							</tr>
						</table>
				  </td>
				</tr>
			</table>
		</div>        
	</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>