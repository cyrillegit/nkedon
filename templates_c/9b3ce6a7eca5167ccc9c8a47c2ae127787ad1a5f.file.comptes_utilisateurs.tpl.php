<?php /* Smarty version Smarty-3.1.14, created on 2015-04-13 17:01:12
         compiled from ".\templates\administration\gestion_users\comptes_utilisateurs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2892352ebac2dad3b68-18198693%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9b3ce6a7eca5167ccc9c8a47c2ae127787ad1a5f' => 
    array (
      0 => '.\\templates\\administration\\gestion_users\\comptes_utilisateurs.tpl',
      1 => 1428944468,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2892352ebac2dad3b68-18198693',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52ebac2dba8200_85572695',
  'variables' => 
  array (
    'nb_comptes_utilisateurs' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ebac2dba8200_85572695')) {function content_52ebac2dba8200_85572695($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableComptesUtilisateurs ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration/GetTableauComptesUtilisateurs.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_comptes_utilisateurs").empty ().html (responseText);

	UpdateTSorter ();
}

function fetchAllTypesUsers( id_type_user ){
    $.ajax({
        type: "POST",
        url: 'ajax/populate.php',
        data: {'target': "types_users",'isAjax':true},
        dataType:'json',
        success: function(data) {
            var select = $("#type_user_select"), options = '';
            select.empty();
            if(id_type_user == 0) {
                options = "<option value=0>Sélectionner un profil utilisateur</option>";
                for (var i = 0; i < data.length; i++) {
                    options += "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
                }
            }else{
                options = "<option value=0>Sélectionner un profil utilisateur</option>";
                for (var i = 0; i < data.length; i++) {
                    if(id_type_user == data[i].id){
                        options += "<option value='" + data[i].id + "' selected='selected'>" + data[i].name + "</option>";
                    }else {
                        options += "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
                    }
                }
            }

            select.append(options);
        }
    });
}

function resetInputs(){
    $("#nom").val("");
    $("#prenom").val("");
    $("#adresse").val("");
    $("#email").val("");
    $("#login").val("");
    $("#password").val("");

    fetchAllTypesUsers(0);

    $("#warnings_popup").css("display", "none");
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
    $("#editCompteUtilisateur").hide();
    RefreshTableComptesUtilisateurs ();

    $("#addCompteUtilisateur").click (function ()
    {
        resetInputs();
        $("#password_label").show();
        $("#password").show();
        $("#editCompteUtilisateur").show("slow");
    });

    $("#btnAnnuler").click (function ()
    {
        resetInputs();
        $("#editCompteUtilisateur").hide("slow");
    });

    $("#btnValider").click (function ()
    {
        var ok = false;
        if ( $("#nom").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir le nom civil de l'utilisateur.");

            $("#nom").focus ();
            ok = false;
        }
        else if ( $("#prenom").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir le prénom de l'utilisateur.");

            $("#prenom").focus ();
            ok = false;
        }
        else if ( $("#login").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir le login du compte utilisateur.");

            $("#login").focus ();
            ok = false;
        }
        else if ( $("#password").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir le mot de passe du compte utilisateur.");

            $("#password").focus ();
            ok = false;
        }
        else if ( $("#id_type_user").val () == "" )
        {
            ShowPopupError  ("Veuillez sélectionner le profil utilisateur.");

            $("#id_type_user").focus ();
            ok = false;
        }
        else if ( $("#email").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir l'email du compte utilisateur.");

            $("#email").focus ();
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

                    ShowSuccess ("Le compte utilisateur (<strong>" + $("#login").val () + "</strong>) a bien été enregistré.");
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

//	$("#addCompteUtilisateur").click (function ()
//	{
//		update_content ("ajax/popups/edit_compte_utilisateur.php", "popup", "id_compte=0");
//		ShowPopupHeight (300);
//	});
});

</script>

<div id="Content">
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Ajouter / Modifier</strong> <strong style="color:black;">un compte utilisateur</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité d'ajouter ou de modifier des comptes utilisateurs qui permettront à vos Inspecteurs, Inventoristes et visiteurs de pouvoir se connecter sur le BackOffice.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="black"><b><?php echo $_smarty_tpl->tpl_vars['nb_comptes_utilisateurs']->value;?>
</b></font> comptes utilisateurs enregistrés, dont <font color="black"><b>3</b></font>  comptes adminitrateurs non visibles.
                </td>
                <td>
                <?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==1;?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==2;?>
<?php $_tmp2=ob_get_clean();?><?php if ($_tmp1||$_tmp2){?>
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_ajouter" id="addCompteUtilisateur"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour ajouter un compte utilisateur :&nbsp;</div>
                <?php }?>
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="editCompteUtilisateur" class="content">
        <div class="TitrePopup">ajouter/modifier <strong style="color:#1c9bd3">un compte utilisateur</strong></div>
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
                                    <td><input type="text" name="nom" id="nom" value=""/></td>
                                </tr>
                                <tr>
                                    <td>Prénom :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="prenom" id="prenom" value=""/></td>
                                </tr>
                                <tr>
                                    <td>Adresse :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="adresse" id="adresse" value=""/></td>
                                </tr>
                                <tr>
                                    <td>Email :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="email" id="email" value=""/></td>
                                </tr>
                            </table>
                        </td>
                        <!--PARTIE DROITE-->
                        <td>
                            <table>
                                <tr>
                                    <td>Login :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="login" id="login" value=""/></td>
                                </tr>
                                <<?php ?>?php
                    			if($id_compte == 0)
                    			{
                    			?<?php ?>>
                                <tr>
                                    <td id="password_label">Mot de passe:<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="password" id="password" value=""/></td>
                                </tr>
                                <<?php ?>?php
                    			}
                    			else
                    			{
                    			?<?php ?>>
                                <tr>
                                    <td><input type="hidden" name="password" id="password" value=""/></td>
                                </tr>
                                <<?php ?>?php
                    			}
                    			?<?php ?>>
                                <tr>
                                    <td>Profil utilisateur :<span class="champObligatoire">*</span></td>
                                    <td>
                                        <select name="id_type_user" id="type_user_select">

                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <input type="hidden" id="target" name="target" value="compte_utilisateur" />
                <input type="hidden" id="id_compte" name="id_compte" value="<<?php ?>?=$id_compte;?<?php ?>>" />
                <input type="hidden" id="id_type_user_hidden" name="id_type_user_hidden" value=0 />
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
        <hr size="5" style="margin-top: 50px; background-color: #ff0000;"/>
    </div>

    <div id="tableau_comptes_utilisateurs"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>