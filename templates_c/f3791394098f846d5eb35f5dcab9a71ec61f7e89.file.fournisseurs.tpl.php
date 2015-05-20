<?php /* Smarty version Smarty-3.1.14, created on 2015-05-19 09:08:16
         compiled from ".\templates\magasin\gestion_fournisseurs\fournisseurs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:308965536461c02d271-83814984%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f3791394098f846d5eb35f5dcab9a71ec61f7e89' => 
    array (
      0 => '.\\templates\\magasin\\gestion_fournisseurs\\fournisseurs.tpl',
      1 => 1432026334,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '308965536461c02d271-83814984',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5536461c143443_79204952',
  'variables' => 
  array (
    'nb_fournisseurs' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5536461c143443_79204952')) {function content_5536461c143443_79204952($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableFournisseurs ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/magasin/GetTableauFournisseurs.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_fournisseurs").empty ().html (responseText);

	UpdateTSorter ();
}

function resetInputs(){
    $("#nom_fournisseur").val("");
    $("#adresse_fournisseur").val("");
    $("#telephone_fournisseur").val("");

    $("#warnings_popup").css("display", "none");
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
    $("#editFournisseur").hide();
	RefreshTableFournisseurs ();

	$("#addFournisseur").click (function ()
	{
        resetInputs();
        $("#editFournisseur").show("slow");
	});

    $("#btnAnnuler").click (function ()
    {
        // On ferme la boîte de dialogue affichée juste avant.
        resetInputs();
        $("#editFournisseur").hide("slow");
    });

    $("#btnValider").click (function ()
    {
        var ok = false;
        if ( $("#nom_fournisseur").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir la raison sociale de l'entreprise.");

            $("#nom_fournisseur").focus ();
            ok = false;
        }
        else if ( $("#adresse_fournisseur").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir l'adresse du fournisseur'.");

            $("#adresse_fournisseur").focus ();
            ok = false;
        }
        else if ( $("#telephone_fournisseur").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir le numéro de téléphone du fournisseur.");

            $("#telephone_fournisseur").focus ();
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
                    ShowSuccess ("Le produit (<strong>" + $("#nom_fournisseur").val () + "</strong>) a bien été enregistré.");
                    $.modal.close ();
                    document.location.href="magasin.php?sub=fournisseurs";
                }
                else
                {
                    ShowPopupError  (response.result);
                }
            }
            else
            {
                ShowPopupError  ("Une erreur est survenue.");
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
                <div class="title"><strong>Ajouter / Modifier</strong> <strong style="color:black;">un fournisseur</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité d'ajouter ou de modifier des fournisseurs.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="black"><b><?php echo $_smarty_tpl->tpl_vars['nb_fournisseurs']->value;?>
</b></font> fournisseurs enregistrés.
                </td>
                <td>
                <?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==1;?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==2;?>
<?php $_tmp2=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==3;?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['infoUser']['id_type_user']==4;?>
<?php $_tmp4=ob_get_clean();?><?php if ($_tmp1||$_tmp2||$_tmp3||$_tmp4){?>
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_ajouter" id="addFournisseur"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour ajouter un fournisseur :&nbsp;</div>
                <?php }?>
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="editFournisseur" class="content">
        <div class="TitrePopup">ajouter/modifier <strong style="color:#1c9bd3">un founisseur</strong></div>
        <div class="subTitlePopup" style="color: #ffffff; text-decoration: none; font-size: 12px;">Veuillez saisir les informations du produit en remplissant les champs obligatoires.</div>
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
                                    <td>Raison sociale :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="nom_fournisseur" id="nom_fournisseur" value="" style="width: 200px;"/></td>
                                </tr>
                                <tr>
                                    <td>Adresse du fournisseur :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="adresse_fournisseur" id="adresse_fournisseur" value="" style="width: 200px;"/></td>
                                </tr>
                                <tr>
                                    <td>Numéro de téléphone :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="telephone_fournisseur" id="telephone_fournisseur" value="" style="width: 200px;"/></td>
                                </tr>
                            </table>
                        </td>
                        <!--PARTIE DROITE-->
                        <td>
                        </td>
                    </tr>
                </table>
                <input type="hidden" id="target" name="target" value="fournisseurs" />
                <input type="hidden" id="id_fournisseur" name="id_fournisseur" value="0" />
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

    <div id="tableau_fournisseurs"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='magasin.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>