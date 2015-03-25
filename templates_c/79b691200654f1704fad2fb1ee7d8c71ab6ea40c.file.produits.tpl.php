<?php /* Smarty version Smarty-3.1.14, created on 2015-03-24 17:51:04
         compiled from ".\templates\administration_magasin\gestion_produits\produits.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1206552ebaf4c5b8346-00584196%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '79b691200654f1704fad2fb1ee7d8c71ab6ea40c' => 
    array (
      0 => '.\\templates\\administration_magasin\\gestion_produits\\produits.tpl',
      1 => 1427219441,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1206552ebaf4c5b8346-00584196',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52ebaf4c685a16_22703770',
  'variables' => 
  array (
    'nb_produits' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ebaf4c685a16_22703770')) {function content_52ebaf4c685a16_22703770($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau des chaînes de tri.
*/
function RefreshTableProduits ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/GetTableauProduits.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_produits").empty ().html (responseText);

	UpdateTSorter ();
}

function resetInputs(){
    $("#nom_produit").val("");
    $("#prix_achat").val("");
    $("#prix_vente").val("");

    $("#warnings_popup").css("display", "none");
}
/**
	jQuery init.
*/
$(document).ready (function ()
{
    $("#editProduit").hide();
	RefreshTableProduits ();

	$("#addProduit").click (function ()
	{
        resetInputs();
        $("#editProduit").slideToggle("slow");

//		update_content ("ajax/popups/edit_produit.php", "popup", "id_produit=0");
//		ShowPopupHeight (550);
	});

    $("#btnAnnuler").click (function ()
    {
        resetInputs();
        $("#editProduit").slideToggle("slow");
    });

    $("#btnValider").click (function ()
    {
        var ok = false;
        if ( $("#nom_produit").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir le nom du produit.");

            $("#nom_produit").focus ();
            ok = false;
        }
        else if ( $("#prix_achat").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir le prix d'achat par unité.");

            $("#prix_achat").focus ();
            ok = false;
        }
        else if ( $("#prix_vente").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir le prix de vente par unité.");

            $("#prix_vente").focus ();
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
                    ShowSuccess ("Le produit (<strong>" + $("#nom_produit").val () + "</strong>) a bien été enregistré.");
                    $.modal.close ();
                    document.location.href="administration_magasin.php?sub=produits";
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
            <div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Ajouter / Modifier</strong> <strong style="color:black;">un produit</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité d'ajouter ou de modifier des produits.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b><?php echo $_smarty_tpl->tpl_vars['nb_produits']->value;?>
</b></font> produits enregistrés.
                </td>
                <td>
                <?php if ($_SESSION['infoUser']['id_type_user']<=3){?>
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_ajouter" id="addProduit"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour ajouter un produit :&nbsp;</div>
                <?php }?>
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="editProduit" class="content">
        <div class="TitrePopup">ajouter/modifier <strong style="color:#1c9bd3">un produit</strong></div>
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
                                    <td>Nom du produit :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="nom_produit" id="nom_produit" value=""/></td>
                                </tr>
                                <tr>
                                    <td>Prix de d'achat par unité :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="prix_achat" id="prix_achat" value=""/></td>
                                </tr>
                                <tr>
                                    <td>Prix de vente par unité :<span class="champObligatoire">*</span></td>
                                    <td><input type="text" name="prix_vente" id="prix_vente" value=""/></td>
                                </tr>
                            </table>
                        </td>
                        <!--PARTIE DROITE-->
                        <td>

                        </td>
                    </tr>
                </table>
                <input type="hidden" id="target" name="target" value="produits" />
                <input type="hidden" id="id_produit" name="id_produit" value="<<?php ?>?=$id_produit;?<?php ?>>" />
            </form>
        </div>
        <hr size="1" style="margin-top: 25px;" />
        <div style="float: left; text-align: left;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
        <div style="float: right; text-align: right;">
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

    <div id="tableau_produits"></div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='administration_magasin.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>