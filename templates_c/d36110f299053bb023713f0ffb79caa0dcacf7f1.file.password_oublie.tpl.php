<?php /* Smarty version Smarty-3.1.14, created on 2015-03-26 22:42:26
         compiled from ".\templates\administration\gestion_users\password_oublie.tpl" */ ?>
<?php /*%%SmartyHeaderCode:838552ebae6f7989b4-81320616%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd36110f299053bb023713f0ffb79caa0dcacf7f1' => 
    array (
      0 => '.\\templates\\administration\\gestion_users\\password_oublie.tpl',
      1 => 1427409692,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '838552ebae6f7989b4-81320616',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52ebae6f83f855_57214876',
  'variables' => 
  array (
    'nb_comptes_utilisateurs' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ebae6f83f855_57214876')) {function content_52ebae6f83f855_57214876($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableComptesUtilisateurs ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration/GetTableauComptesUtilisateursForPassword.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_comptes_utilisateurs").empty ().html (responseText);

	UpdateTSorter ();
}

function resetInputs(){
    $("#nom").val("");
    $("#prenom").val("");
    $("#email").val("");
    $("#login").val("");

    fetchAllTypesUsers(0);

    $("#warnings_popup").css("display", "none");
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
    $("#editPasswordCompteUtilisateur").hide();
	RefreshTableComptesUtilisateurs ();

    $("#btnAnnuler").click (function ()
    {
        $("#editPasswordCompteUtilisateur").hide("slow");
    });

    $("#btnValider").click (function ()
    {
        var ok = false;
        if ( $("#password").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir le mot de passe du compte utilisateur.");

            $("#password").focus ();
            ok = false;
        }
        else
        {
            ok = true;
        }

        if (ok)
        {
            var param = $("#form_popup").serialize ();

            var responseText = Serialize (param);

            if (responseText != "")
            {
                response = eval (responseText);
                if (response.result == "SUCCESS")
                {

                    ShowSuccess ("Le mot de passe du compte utilisateur (<strong>" + $("#login").val () + "</strong>) a bien été enregistré.");
                    $.modal.close ();
                    document.location.href="administration.php?sub=comptes_utilisateurs";
                }
                else
                {
                    ShowPopupError  (response.result);

                }
            }
            else
            {
                ShowPopupError  ("Une erreur est survenue. Veuillez contacter le service technique (technique@id2tel.com) pour avoir plus d'informations.");
            }
        }
        else
        {
        }
    });

});

</script>

<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Modifier le mot de passe</strong> <strong style="color:black;">pour un compte utilisateur</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de modifier un mot de passe pour des comptes utilisateurs qui permettront à vos utilisateurs de pouvoir se connecter sur le BackOffice.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="black"><b><?php echo $_smarty_tpl->tpl_vars['nb_comptes_utilisateurs']->value;?>
</b></font> comptes utilisateurs enregistrés, dont <font color="black"><b>2</b></font> comptes utilisateurs administrateurs non visibles.
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="editPasswordCompteUtilisateur" class="content">
        <div class="TitrePopup">Modifier un mot de passe <strong style="color:#1c9bd3"> pour un compte utilisateur</strong></div>
        <div class="subTitlePopup" style="color: #ffffff; text-decoration: none; font-size: 12px;">Veuillez saisir les informations du compte utilisateur en remplissant les champs obligatoires.</div>
        <br style="clear: both; " />
        <div style="width: 100%;">
            <form name="form_popup" id="form_popup" method="post">
                <table width="100%">
                    <tr>
                        <td colspan="2">
                            <div class="warnings" id="warnings_popup" style="display: none;">
                                <b>Certains champs n'ont pas &eacute;t&eacute; remplis correctement :</b>
                                <div></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <!--PARTIE GAUCHE-->
                        <td>
                            <table>
                                <tr>
                                    <td>Nom :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="nom" id="nom" value="" readonly="readonly"/></td>
                                </tr>
                                <tr>
                                    <td>Prénom :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="prenom" id="prenom" value="" readonly="readonly"/></td>
                                </tr>
                                <tr>
                                    <td>Login :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="login" id="login" value="" readonly="readonly"/></td>
                                </tr>
                                <tr>
                                    <td>Email :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="email" id="email" value="" readonly="readonly"/></td>
                                </tr>
                            </table>
                        </td>
                        <!--PARTIE DROITE-->
                        <td>
                            <table>
                                <<?php ?>?php if($_SESSION ["infoUser"]["idt_types_users"] == 1 || $_SESSION ["infoUser"]["idt_types_users"] == 2) { ?<?php ?>>
                                <tr>
                                    <td>Nouveau mot de passe :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="password" id="password" value=""/></td>
                                </tr>
                                <<?php ?>?php } ?<?php ?>>
                            </table>
                        </td>
                    </tr>
                </table>
                <input type="hidden" id="target" name="target" value="password_oublie" />
                <input type="hidden" id="id_compte" name="id_compte" value="<<?php ?>?=$id_compte;?<?php ?>>" />
            </form>
        </div>
        <hr size="1" style="margin-top: 25px;" />
        <div style="float: left; text-align: left;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
        <div style="float: right; text-align: right; padding-bottom: 10px;">
            <table border="0" cellspacing="0" cellpadding="0" align="right">
                <tr>
                    <td><div id="btnAnnuler"><img src="css/images/boutons/btn_annuler.png" class="" style="cursor: pointer;" width="110" height="30" /></div></td>
                    <td>&nbsp;</td>
                    <td><div id="btnValider"><img src="css/images/boutons/btn_valider.png" class="" style="cursor: pointer;" width="110" id="btnOK" height="30" /></div></td>
                </tr>
            </table>
        </div>
        <hr size="5" style="margin-top: 50px; background-color: #ff0000;" />
    </div>

    <div id="tableau_comptes_utilisateurs"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>