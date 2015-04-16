{include file="common/header.tpl"}
{literal}
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
{/literal}
<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/menu_fdr.png" style="float:left" /></div>
            
            <div class="t_titre">
                <div class="title"><strong>connexion</strong> <strong style="color:black;">à votre tableau de  bord</strong></div>
            </div>
        </div>
        
    </div>
    
    <br style="clear: both;" />
    {include file="common/messages_boxes.tpl"}
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
{include file="common/footer.tpl"}