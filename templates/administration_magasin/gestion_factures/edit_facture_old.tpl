{include file='common/header.tpl'}
{literal}
<script language="javascript">

function FillTableauProduitsAchetes(id_facture, nom_produit, quantite_achat, date_fabrication, date_peremption )
{
	var param = "id_facture="+id_facture+"&nom_produit=" +nom_produit+"&quantite_achat="+quantite_achat+"&date_fabrication="+date_fabrication+"&date_peremption="+date_peremption;
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/getTableauProduitsAchetes.php",
			async	: false,
			data	: param,
			success	: function (msg)
			{}
	}).responseText;
	$("#tabProduitsAchetes").html (responseText);
}

function FillTableauProduitsAchetesForEdit(id_facture)
{
	var param = "id_facture="+id_facture;
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/getTableauProduitsAchetesForEdit.php",
			async	: false,
			data	: param,
			success	: function (msg)
			{}
	}).responseText;
	$("#tabProduitsAchetes").html (responseText);
}

function GetURLParameter(sParam)
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

$(document).ready (function ()
{
	var id_facture = GetURLParameter('id_facture');
	var numero_facture = GetURLParameter('numero_facture');
	var id_fournisseur = GetURLParameter('id_fournisseur');
	var nom_fournisseur = GetURLParameter('nom_fournisseur');
	var date_facture = GetURLParameter('date_facture');
	if(id_facture != 0)
	{
		FillTableauProduitsAchetesForEdit(id_facture);
		$("#id_facture").val(id_facture);
		$("#numero_facture").val(numero_facture);
		$("#id_fournisseur").val(nom_fournisseur);
		$("#date_facture").val(date_facture);
	}
	else
	{
		$("#id_facture").val(0);
	}

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

	jQuery('a.add_achat').click(function(event){

		event.preventDefault();

		var id_facture = $("#id_facture").val();
		var numero_facture = $("#numero_facture").val();
		var id_fournisseur = $("#id_fournisseur").val();
		var date_facture = $("#date_facture").val();

		var nom_produit = $("#nom_produit").val();
		var quantite_achat = $("#quantite_achat").val();
		var date_fabrication = $("#date_fabrication").val();
		var date_peremption = $("#date_peremption").val();

		if(nom_produit != "" && quantite_achat != "" && $.isNumeric(quantite_achat))
		{	
	    	$("#nom_produit").val('');
	    	$("#quantite_achat").val('');
	    	$("#date_fabrication").val('');
	    	$("#date_peremption").val('');

	    	FillTableauProduitsAchetes(id_facture, nom_produit, quantite_achat, date_fabrication, date_peremption);
	    	document.location.href="administration_magasin.php?sub=edit_facture&id_facture="+id_facture+"&numero_facture="+numero_facture+"&id_fournisseur="+id_fournisseur+"&date_facture="+date_facture;
    	}
    	else
    	{
    		alert("valeurs incorrectes");
    		document.location.href="administration_magasin.php?sub=edit_facture&id_facture="+id_facture+"&numero_facture="+numero_facture+"&id_fournisseur="+id_fournisseur+"&date_facture="+date_facture;
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

	$("#btnAnnuler").click (function ()
	{
		var didConfirm = confirm("Voulez-vous vraiment supprimer tous les achats déja enregistrés?");
		  if (didConfirm == true) {
		    document.location.href="delete.php?target=delete_produits_facture&id=0";
		  }
	});

	$("#btnOK").click(function ()
	{
		var ok = false;
		if ( $("#numero_facture").val () == "" )
		{
			ShowPopupError  ("Veuillez saisir le numéro de la facture.");			
			
			$("#numero_facture").focus ();
			ok = false;
		}
		else if ( $("#id_fournisseur").val () == "" )
		{
			ShowPopupError  ("Veuillez choisir un fournisseur.");			
			
			$("#id_fournisseur").focus ();
			ok = false;
		}
		else if ( $("#date_facture").val () == "" )
		{
			ShowPopupError  ("Veuillez choisir la date de la facture.");			
			
			$("#date_facture").focus ();
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
					ShowSuccess ("La facture (<strong>" + $("#numero_facture").val () + "</strong>) a bien été enregistrée.");
					$.modal.close ();					
					document.location.href="administration_magasin.php?sub=factures";
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
			alert("Veuillez saisir : \n -le numéro de la facture. \n -le fournisseur. \n -la date de la facture.");
		}

	});
	FillTableauProduitsAchetes("", "", "", "", "");
});

</script>
{/literal}
<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>{if $id_facture eq 0}Ajouter{else}Modifier{/if}</strong> <strong style="color:black;">une facture</strong></div>
            </div>
        </div>
  	</div>
	<div class="intro">
	Dans cet écran, vous avez la possibilité de créer/modifier une facture. Veuillez remplir les champs obligatoires, et appuyez sur le bouton "Valider".
	</div>
	<br/><br/>
	{include file="common/messages_boxes.tpl"}
	<form name="form_popup" id="form_popup" method="post">
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

			#results{
				display:none;
				width:228px;
				border:1px solid #AAA;
				border-top-width:0;
				margin-left: 80px;
			}

			#results div{
				width:220px;
				padding:2px 4px;
				text-align:left;
				border:0;
			}

			#results div:hover,.result_focus{
				background-color:#DDD!important;
				color: black;
			}
		</style>
		<table style="float:left;" cellspacing="2" cellpadding="5">
			<tr>
				<!-- PARTIE GAUCHE -->
				<td width="1%">
					<table cellspacing="5" cellpadding="2" class="blocInfoBis" width="100%">
						<tr>
							<td colspan="2" width="100%">
								<div class="titre">
									<b>
										<i><u>INFORMATIONS DE LA FACTURE:</u></i>
										<hr/>
									</b>
								</div>
							</td>
						</tr>
							<td>
								Numéro de la facture :<span class="champObligatoire">*</span>
							</td>
							<td>
								<input type="text" id="numero_facture" name="numero_facture" value="{if $id_facture neq 0}{$infos.numero_facture}{/if}"/>
							</td>
						</tr>
						<tr>
							<td>
								Raison sociale du fournisseur :<span class="champObligatoire">*</span>
							</td>
							<td>
								<select name="id_fournisseur" id="id_fournisseur">
									<option value="">Sélectionner un fournisseur</option>
										{foreach from=$fournisseurs item=item key=key}
											<option value="{$item.idt_fournisseurs}">{$item.nom_fournisseur}</option>
										{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<td>Date de la facture :<span class="champObligatoire">*</span></td>
            				<td>
            					<input type="text" name="date_facture" id="date_facture" value="{if $id_facture neq 0}{$infos.date_facture}{/if}"/>
            				</td>
						</tr>
					</table>
					<table style="margin-top: 5px;" cellspacing="5" cellpadding="2" class="blocAddAchat" width="100%">
						<tr>
							<td colspan="2" width="100%">
								<div class="titre">
									<b>
										<i><u>POUR AJOUTER UN ACHAT:</u></i>
										<hr />
											<a href="#" title="" class="add_achat">cliquez pour ajouter un nouvel achat.</a>
									</b>
								</div>
							</td>
						</tr>
						<tr>
							<td width="50%">
								Nom du produit :<span class="champObligatoire">*</span><input type="text" id="nom_produit" name="nom_produit"/><div id="results"></div>
							</td>
							<td width="50%">
								Quantité achetée :<span class="champObligatoire">*</span><input type="text" id="quantite_achat" name="quantite_achat"/>
							</td>
						</tr>
						<tr>
							<td width="50%">
								Date de fabrication: <input type="text" id="date_fabrication" name="date_fabrication"/>
							</td>
							<td width="50%">
								Date de peremption: <input type="text" id="date_peremption" name="date_peremption"/>
							</td>
						</tr>							
					</table>
				</td>
			</tr>
		</table>
		<div id="tabProduitsAchetes"></div>
		<input type="hidden" name="target" id="target" value="factures"/>
		<input type="hidden" name="id_facture" id="id_facture" value="0"/>
	</form>
</div>
<hr size="1" style="margin-top: 50px;" />
<div style="float: left; text-align: left; margin-left: 200px;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
<div style="float: right; text-align: right; margin-right: 200px;">
    <table border="0" cellspacing="0" cellpadding="0" align="right">
        <tr>
            <td><div id="btnAnnuler"><img src="css/images/boutons/btn_annuler.png" class="button" width="110" height="30" /></div></td>
            <td>&nbsp;</td>
            <td><div id="btnValider"><img src="css/images/boutons/btn_valider.png" class="button" width="110" id="btnOK" height="30" /></div></td>
        </tr>
    </table>        
</div>
<script src="assets/js/autocomplete.js"></script>
{include file='common/footer.tpl'}