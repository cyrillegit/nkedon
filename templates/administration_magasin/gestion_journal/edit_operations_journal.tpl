{include file='common/header.tpl'}
{literal}
<script language="javascript" xmlns="http://www.w3.org/1999/html">

function RefreshTableOperationsJournal ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/GetTableauProduitsOperation.php",
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

$(document).ready (function ()
{
    setRegisterPopup();
    $("#editOperationJournal").hide();
    RefreshTableOperationsJournal ();

	$("#addOperation").click (function ()
	{
        resetInputs();
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        $("#editOperationJournal").show("slow");

//		update_content ("ajax/popups/edit_produit_facture.php", "popup", "id_produit_facture=0");
//		ShowPopupHeight (550);
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
                    document.location.href="administration_magasin.php?sub=edit_operations_journal";
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
                document.location.href="administration_magasin.php?sub=edit_operations_journal&status=register";
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
{/literal}
<div id="Content">
    <div class="success" id="succes_register" style="display: block;">
        <b>Le journal a bien été enregistrée.</b>
        <div></div>
    </div>
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
	{include file="common/messages_boxes.tpl"}

        <div class="bg_filter" style="line-height:50px;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                    Actuellement <font color="black"><b>{$nb_operations}</b></font> opérations enregistrées pour le journal.
                    </td>
                    <td>
                    <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_ajouter" id="addOperation"></div></div>
                    <div style="margin-left:20px; margin-right: 20px; float: right;">Pour ajouter une opération :&nbsp;</div>
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
										<i><u>INFORMATIONS DU JOURNAL:</u></i> <span style="margin-left:260px;">Montant du journal : <strong>{$montant_operation}</strong> FCFA</span>
										<hr/>
									</b>
								</div>
							</td>
						</tr>
                        <tr>
							<td>
								Commentaire :
							</td>
							<td width="100%">
                                <textarea name="commentaire" id="commentaire" cols="30" rows="10" style="height: 100px; width: 100%;"></textarea>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<input type="hidden" name="target" id="target" value="journal"/>
		<input type="hidden" name="id_journal" id="id_journal" value="0"/>
	</form>
</div>
<hr size="1" style="margin-top: 5px;" />
<div style="float: left; text-align: left; margin-left: 200px;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
<div style="float: right; text-align: right; margin-right: 200px;">
    <table border="0" cellspacing="0" cellpadding="0" align="right">
        <tr>
            <td><div id="btnAnnuler"><img src="css/images/boutons/btn_annuler.png" class="" style="cursor: pointer;" width="110" height="30" /></div></td>
            <td>&nbsp;</td>
            <td><div id="btnValider"><img src="css/images/boutons/btn_valider.png" class="" style="cursor: pointer;" width="110" id="btnOK" height="30" /></div></td>
        </tr>
    </table>        
</div>
{include file='common/footer.tpl'}