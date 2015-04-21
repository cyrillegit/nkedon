<?php /* Smarty version Smarty-3.1.14, created on 2015-04-21 12:43:59
         compiled from ".\templates\magasin\gestion_factures\edit_facture_vente.tpl" */ ?>
<?php /*%%SmartyHeaderCode:214915536460fd299b4-51759515%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4d031b202d3229c260a95b38e1239a49067a7858' => 
    array (
      0 => '.\\templates\\magasin\\gestion_factures\\edit_facture_vente.tpl',
      1 => 1429620142,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '214915536460fd299b4-51759515',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'nb_produits' => 0,
    'montant_facture' => 0,
    'nom_client' => 0,
    'id_facture' => 0,
    'commentaire' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5536460fe23853_65968121',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5536460fe23853_65968121')) {function content_5536460fe23853_65968121($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('common/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript" xmlns="http://www.w3.org/1999/html">

function RefreshTableProduitsFactureVente ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/magasin/GetTableauProduitsFactureVente.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_produits_facture").empty ().html (responseText);

	UpdateTSorter ();
}

function getUrlParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            return sParameterName[1];
        }
    }
}

function setRegisterPopup(){
    if(getUrlParameter("status") == "register" ){
        $("#succes_register").show();
    }else{
        $("#succes_register").hide();
    }
}

function resetInputs(){

    $("#nom_produit_search").val("");
    $("#quantite_achat").val("");

    $("#warnings_popup").css("display", "none");
    $("#succes_register").css("display", "none");
}

$(document).ready (function ()
{
    setRegisterPopup();
    $("#editProduitFacture").hide();
	RefreshTableProduitsFactureVente ();

	$("#addProduitFacture").click (function ()
	{
        resetInputs();
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        $("#editProduitFacture").show("slow");
	});

	$("#date_fabrication").datepicker({
	    beforeShow:function(input) {
	        $(input).css({
	            "position": "relative",
	            "z-index": 999999
	        });
	    }
	});

	$("#date_peremption").datepicker({
	    beforeShow:function(input) {
	        $(input).css({
	            "position": "relative",
	            "z-index": 999999
	        });
	    }
	});

	$("#date_facture").datepicker({
	    beforeShow:function(input) {
	        $(input).css({
	            "position": "relative",
	            "z-index": 999999
	        });
	    }
	});

    $("#btnAnnulerProduit").click (function ()
    {
        resetInputs();
        $("#editProduitFacture").hide('slow');
    });

    $("#btnValiderProduit").click (function ()
    {
        var ok = false;
        if ( $("#nom_produit_search").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir le nom du produit.");

            $("#nom_produit_search").focus ();
            ok = false;
        }
        else if ( $("#quantite_vendue").val () == "" )
        {
            ShowPopupError  ("Veuillez saisir la quantité vendue.");

            $("#quantite_vendue").focus ();
            ok = false;
        }
        else
        {
            ok = true;
        }

        if (ok)
        {

            var param = $("#form_popup_produit").serialize ();
            var responseText = Serialize (param);

            if (responseText != "")
            {
                response = eval (responseText);
                if (response.result == "SUCCESS")
                {
                    ShowSuccess ("Le produit (<strong>" + $("#nom_produit").val () + "</strong>) a bien été enregistré dans la facture.");
                    $.modal.close ();
                    document.location.href="../../../magasin.php";
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

	$("#btnAnnuler").click (function ()
	{
		var didConfirm = confirm("Voulez-vous vraiment supprimer tous les produits déja enregistrés?");
		  if (didConfirm == true) {
		    document.location.href="delete.php?target=delete_produits_ventes&id=0";
		  }
	});

	$("#btnValider").click(function ()
	{

			var param = $("#form_popup").serialize ();
				
			var responseText = Serialize (param);
			
			if (responseText != "")
			{
				response = eval (responseText);
				if (response.result == "SUCCESS")
				{	
					ShowSuccess ("La facture (<strong>" + $("#numero_facture").val () + "</strong>) a bien été enregistrée.");
					$.modal.close ();					
					document.location.href="../../../magasin.php";
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
	});
});

</script>
<style type="text/css">
    .blocInfoBis
    {
        background-image: url("css/images/bg_bloc_alertes.png");
        background-repeat: repeat;
        border: 1px solid #313131;
        padding: 15px 25px 15px;
    }
    .blocAddAchat
    {
        background-image: url("css/images/bg_bloc_alertes.png");
        background-repeat: repeat;
        border: 1px solid #313131;
        padding: 15px 25px 15px;
    }

    .input_container input {
        height: 13px;
        width: 200px;
        padding: 3px;
        border: 1px solid #cccccc;
        border-radius: 0;
    }
    .input_container ul {
        width: 206px;
        border: 1px solid #eaeaea;
        position: absolute;
        z-index: 9;
        list-style: none;
        list-style-type: none;
    }
    .input_container ul li {
        padding: 2px;
    }
    .input_container ul li:hover {
        background: #eaeaea;
        color: #000000;
    }
    #list_nom_produit {
        display: none;
        background-color: slategrey;
    }

</style>

<div id="Content">
    <div class="success" id="succes_register" style="display: block;">
        <b>La facture a bien été réalisée. </br> Vous pouvez réaliser une nouvelle facture.</b>
        <div></div>
    </div>
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Etablir</strong> <strong style="color:black;"> une facture de vente</strong></div>
            </div>
        </div>
  	</div>
	<div class="intro">
	Dans cet écran, vous avez la possibilité d'enregistrer les produits d'une facture de vente. Veuillez remplir les champs obligatoires, et appuyez sur le bouton "Valider".
	</div>
	<br/><br/>
	<?php echo $_smarty_tpl->getSubTemplate ("common/messages_boxes.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


        <div class="bg_filter" style="line-height:50px;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                    Actuellement <font color="black"><b><?php echo $_smarty_tpl->tpl_vars['nb_produits']->value;?>
</b></font> produits enregistrés dans la facture.
                    </td>
                    <td>
                    <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_ajouter" id="addProduitFacture"></div></div>
                    <div style="margin-left:20px; margin-right: 20px; float: right;">Pour ajouter un produit dans la facture :&nbsp;</div>
                    </td>
                </tr>
            </table>
        </div>
        <br style="clear: both;" />

        <div id="editProduitFacture" class="content">
            <div class="TitrePopup">ajouter / modifier <strong style="color:#1c9bd3">un produit de la facture</strong></div>
            <div class="subTitlePopup" style="color: #ffffff; text-decoration: none; font-size: 12px;">Veuillez saisir les informations du produit en remplissant les champs obligatoires.</div>
            <br style="clear: both; " />
            <div style="width: 100%;">
                <form name="form_popup_produit" id="form_popup_produit" method="post" >
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
                                        <td class="input_container" ><input type="text" name="nom_produit_search" id="nom_produit_search" value="" onkeyup="autocomplet()"/>
                                            <ul id="list_nom_produit" style="list-style-type: none;"></ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Quantité vendue :<span class="champObligatoire">*</span></td>
                                        <td class="input_container" ><input type="text" name="quantite_vendue" id="quantite_vendue" value=""/></td>
                                    </tr>
                                </table>
                            </td>
                            <!--PARTIE DROITE-->
                            <td>

                            </td>
                        </tr>
                    </table>
                    <input type="hidden" id="target" name="target" value="produits_vente" />
                    <input type="hidden" id="id_produit_vente" name="id_produit_vente" value="0" />
                </form>
            </div>
            <hr size="1" style="margin-top: 50px;" />
            <div style="float: left; text-align: left;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
            <div style="float: right; text-align: right;">
                <table border="0" cellspacing="0" cellpadding="0" align="right">
                    <tr>
                        <td><div id="btnAnnulerProduit"><img src="css/images/boutons/btn_annuler.png" class="" style="cursor: pointer;" width="110" height="30" /></div></td>
                        <td>&nbsp;</td>
                        <td><div id="btnValiderProduit"><img src="css/images/boutons/btn_valider.png" class="" style="cursor: pointer;" width="110" id="btnOKProduit" height="30" /></div></td>
                    </tr>
                </table>
            </div>
            <hr size="5" style="margin-top: 50px; background-color: #ff0000;" />
        </div>

		<div id="tableau_produits_facture"></div>

    <form name="form_popup" id="form_popup" method="post">
		<table style="float:left;" cellspacing="2" cellpadding="5">
			<tr>
	        	<td colspan="2">
	                <div class="warnings" id="warnings_popup" style="display: none;">
	                    <b>Certains champs n'ont pas &eacute;t&eacute; remplis correctement :</b>
	                    <div></div>
	                </div>
	            </td>
            </tr>
			<tr>
				<!-- PARTIE GAUCHE -->
				<td width="1%">
					<table cellspacing="5" cellpadding="2" class="blocInfoBis" width="100%">
						<tr>
							<td colspan="2" width="100%">
								<div class="titre">
									<b>
										<i><u>INFORMATIONS DE LA FACTURE:</u></i> <span style="margin-left:260px;">Montant de la facture : <strong><?php echo $_smarty_tpl->tpl_vars['montant_facture']->value;?>
</strong> FCFA</span>
										<hr/>
									</b>
								</div>
							</td>
						</tr>
                        <tr>
                            <td>
                                Nom du client :
                            </td>
                            <td>
                                <input type="text" id="nom_client" name="nom_client" style="width: 200px;" value="<?php echo $_smarty_tpl->tpl_vars['nom_client']->value;?>
"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Commentaire :
                            </td>
                            <td>
                                <textarea name="commentaire" id="commentaire" cols="30" rows="10" style="height: 70px; width: 100%;"><?php if ($_smarty_tpl->tpl_vars['id_facture']->value!=0){?><?php echo $_smarty_tpl->tpl_vars['commentaire']->value;?>
<?php }?></textarea>
                            </td>
                        </tr>
					</table>
				</td>
			</tr>
		</table>
		<input type="hidden" name="target" id="target" value="facture_vente"/>
		<input type="hidden" name="id_facture" id="id_facture" value="<?php if ($_smarty_tpl->tpl_vars['id_facture']->value!=0){?><?php echo $_smarty_tpl->tpl_vars['id_facture']->value;?>
<?php }else{ ?><?php echo 0;?>
<?php }?>"/>
	</form>
</div>
<hr size="1" style="margin-top: 5px; margin-top: 0px;" />
<div style="float: left; text-align: left; margin-left: 200px;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
<div style="float: right; text-align: right; margin-right: 200px;">
    <?php if ($_smarty_tpl->tpl_vars['nb_produits']->value!=0){?>
        <table border="0" cellspacing="0" cellpadding="0" align="right">
            <tr>
                <td><div id="btnAnnuler"><img src="css/images/boutons/btn_annuler.png" class="" style="cursor: pointer;" width="110" height="30" /></div></td>
                <td>&nbsp;</td>
                <td><div id="btnValider"><img src="css/images/boutons/btn_valider.png" class="" style="cursor: pointer;" width="110" id="btnOK" height="30" /></div></td>
            </tr>
        </table>
    <?php }?>
</div>
<?php echo $_smarty_tpl->getSubTemplate ('common/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>