<?php /* Smarty version Smarty-3.1.14, created on 2015-05-18 17:18:13
         compiled from ".\templates\magasin\gestion_journal\edit_operations_journal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:90255365ba5a993d3-61646901%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9685c43de77b5a37b95171f99bd4c81dab118a57' => 
    array (
      0 => '.\\templates\\magasin\\gestion_journal\\edit_operations_journal.tpl',
      1 => 1431969486,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '90255365ba5a993d3-61646901',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_55365ba5c0ef50_23209106',
  'variables' => 
  array (
    'nb_produits' => 0,
    'montant_journal' => 0,
    'commentaire' => 0,
    'id_journal' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55365ba5c0ef50_23209106')) {function content_55365ba5c0ef50_23209106($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('common/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript" xmlns="http://www.w3.org/1999/html">

function RefreshTableOperationsJournal ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/magasin/GetTableauProduitsOperation.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_operations_journal").empty ().html (responseText);

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
    $("#quantite_vendue").val("");

    $("#warnings_popup").css("display", "none");
    $("#succes_register").css("display", "none");
}

function confirmLogout(){
    if( getUrlParameter( "logout" ) == "logout" ){
        var didConfirm = confirm("Vous êtes sur le point de vous déconnecter alors que vous n'avez pas valider le journal \n Veuillez le valider avant toute deconnexion \n sinon, toutes les enregistrements seront effacées. \n Voulez-vous néanmois vous déconnecter?");
        if (didConfirm == true) {
            document.location.href="index.php?logout=disconnect";
        }
    }
}

$(document).ready (function ()
{
    confirmLogout();
    setRegisterPopup();
    $("#editOperationJournal").hide();
    RefreshTableOperationsJournal ();

	$("#addOperation").click (function ()
	{
        resetInputs();
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        $("#editOperationJournal").show("slow");
	});

    $("#btnAnnulerOperation").click (function ()
    {
        resetInputs();
        $("#editOperationJournal").hide('slow');
    });

    $("#btnValiderOperation").click (function ()
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
            var param = $("#form_popup_operation").serialize ();

            var responseText = Serialize (param);

            if (responseText != "")
            {
                response = eval (responseText);
                if (response.result == "SUCCESS")
                {
                    ShowSuccess ("Le produit (<strong>" + $("#nom_produit").val () + "</strong>) a bien été enregistré dans la facture.");
                    $.modal.close ();
                    document.location.href="magasin.php?sub=operation_journal";
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
		var didConfirm = confirm("Voulez-vous vraiment supprimer tous les opérations de vente déja enregistrées?");
		  if (didConfirm == true) {
		    document.location.href="delete.php?target=delete_operations_journal&id=0";
		  }
	});

	$("#btnValider").click(function ()
	{

        var param = $("#form_popup_journal").serialize ();

        var responseText = Serialize (param);

        if (responseText != "")
        {
            response = eval (responseText);
            if (response.result == "SUCCESS")
            {
                ShowSuccess ("Le journal a bien été enregistrée.");
                $.modal.close ();
                document.location.href="magasin.php?sub=result_journal";
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
        <b>Le journal a bien été enregistrée.</b>
        <div></div>
    </div>
    <?php if (isset($_SESSION['journal'])){?>
        <?php if (!$_SESSION['journal']){?>
            <div class="bloc_alerts" id="alert_journal" style="display: block;">
                <b>Attention!.</b><br/>
                <div>Il n'est plus possible de réaliser un journal pour ce jour.</div>
            </div>
        <?php }?>
    <?php }?>
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Réaliser </strong> <strong style="color:black;">le journal</strong></div>
            </div>
        </div>
  	</div>
	<div class="intro">
        Dans cet écran, vous avez la possibilité de réaliser le journal. Veuillez remplir les champs obligatoires, et appuyez sur le bouton "Valider".
	</div>
	<br/><br/>
	<?php echo $_smarty_tpl->getSubTemplate ("common/messages_boxes.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


        <div class="bg_filter" style="line-height:50px;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                    Actuellement <font color="black"><b><?php echo $_smarty_tpl->tpl_vars['nb_produits']->value;?>
</b></font> opérations enregistrées pour le journal.
                    </td>
                    <td>
                        <?php if (isset($_SESSION['journal'])){?>
                            <?php if ($_SESSION['journal']){?>
                                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_ajouter" id="addOperation"></div></div>
                                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour ajouter une opération :&nbsp;</div>
                            <?php }?>
                        <?php }?>
                    </td>
                </tr>
            </table>
        </div>
        <br style="clear: both;" />

        <div id="editOperationJournal" class="content">
            <div class="TitrePopup">ajouter/modifier <strong style="color:#1c9bd3">une opération du journal</strong></div>
            <div class="subTitlePopup" style="color: #ffffff; text-decoration: none; font-size: 12px;">Veuillez saisir les informations de l'opération en remplissant les champs obligatoires.</div>
            <br style="clear: both; " />
            <div style="width: 100%;">
                <form name="form_popup_operation" id="form_popup_operation" method="post" >
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
                                        <td class="input_container" ><input type="text" name="nom_produit_search" id="nom_produit_search" value=""  onkeyup="autocomplet()"/>
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
                    <input type="hidden" id="target" name="target" value="operations_journal" />
                    <input type="hidden" id="id_operation_journal" name="id_operation_journal" value="0" />
                </form>
            </div>
            <hr size="1" style="margin-top: 50px;" />
            <div style="float: left; text-align: left;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
            <div style="float: right; text-align: right;">
                <table border="0" cellspacing="0" cellpadding="0" align="right">
                    <tr>
                        <td><div id="btnAnnulerOperation"><img src="css/images/boutons/btn_annuler.png" class="" style="cursor: pointer;" width="110" height="30" /></div></td>
                        <td>&nbsp;</td>
                        <td><div id="btnValiderOperation"><img src="css/images/boutons/btn_valider.png" class="" style="cursor: pointer;" width="110" id="btnOKOperation" height="30" /></div></td>
                    </tr>
                </table>
            </div>
            <hr size="5" style="margin-top: 50px; background-color: #ff0000;" />
        </div>

		<div id="tableau_operations_journal"></div>

    <form name="form_popup_journal" id="form_popup_journal" method="post">
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
										<i><u>INFORMATIONS DU JOURNAL:</u></i> <span style="margin-left:260px;">Montant du journal : <strong><?php echo $_smarty_tpl->tpl_vars['montant_journal']->value;?>
</strong> FCFA</span>
										<hr/>
									</b>
								</div>
							</td>
						</tr>
                        <tr>
							<td>
								Commentaire:
							</td>
							<td width="100%">
                                <textarea name="commentaire" id="commentaire" cols="30" rows="10" style="height: 100px; width: 100%;"><?php echo $_smarty_tpl->tpl_vars['commentaire']->value;?>
</textarea>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<input type="hidden" name="target" id="target" value="journal"/>
		<input type="hidden" name="id_journal" id="id_journal" value="<?php if ($_smarty_tpl->tpl_vars['id_journal']->value!=0){?><?php echo $_smarty_tpl->tpl_vars['id_journal']->value;?>
<?php }else{ ?><?php echo 0;?>
<?php }?>"/>
	</form>
</div>
<hr size="1" style="margin-top: 15px;" />
<div style="float: left; text-align: left; margin-left: 200px;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
<div style="float: right; text-align: right; margin-right: 200px;">
    <?php if (isset($_SESSION['journal'])){?>
        <?php if ($_SESSION['journal']){?>
            <?php if ($_smarty_tpl->tpl_vars['nb_produits']->value!=0){?>
                <table border="0" cellspacing="0" cellpadding="0" align="right">
                    <tr>
                        <td><div id="btnAnnuler"><img src="css/images/boutons/btn_annuler.png" class="" style="cursor: pointer;" width="110" height="30" /></div></td>
                        <td>&nbsp;</td>
                        <td><div id="btnValider"><img src="css/images/boutons/btn_valider.png" class="" style="cursor: pointer;" width="110" id="btnOK" height="30" /></div></td>
                    </tr>
                </table>
            <?php }?>
        <?php }?>
    <?php }?>
</div>
<?php echo $_smarty_tpl->getSubTemplate ('common/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>