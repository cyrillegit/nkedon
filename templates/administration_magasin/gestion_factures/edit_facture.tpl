{include file='common/header.tpl'}
{literal}
<script language="javascript">

function RefreshTableProduitsFacture ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/GetTableauProduitsFacture.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_produits_facture").empty ().html (responseText);

	UpdateTSorter ();
}

$(document).ready (function ()
{
	RefreshTableProduitsFacture ();

	$("#addProduitFacture").click (function ()
	{
		update_content ("ajax/popups/edit_produit_facture.php", "popup", "id_produit_facture=0");
		ShowPopupHeight (550);
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
});

</script>
{/literal}
<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Ajouter/Modifier</strong> <strong style="color:black;">des produits dans une facture</strong></div>
            </div>
        </div>
  	</div>
	<div class="intro">
	Dans cet écran, vous avez la possibilité de créer/modifier les produits d'une facture. Veuillez remplir les champs obligatoires, et appuyez sur le bouton "Valider".
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
	<div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement <font color="red"><b>{$nb_produits}</b></font> produits enregistrés dans la facture.
                </td>
                <td>
                <div style="float: right; margin-top: 10px; margin-right: 15px;"><div class="btn_ajouter" id="addProduitFacture"></div></div>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour ajouter un produit dans la facture :&nbsp;</div>
                </td>
            </tr>
        </table>
    </div>
		<div id="tableau_produits_facture"></div>

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
										<i><u>INFORMATIONS DE LA FACTURE:</u></i> <span style="margin-left:260px;">Prix total de la facture : <strong>{$prix_total_produits}</strong> FCFA</span>
										<hr/>
									</b>
								</div>
							</td>
						</tr>
							<td>
								Numéro de la facture :<span class="champObligatoire">*</span>
							</td>
							<td>
								<input type="text" id="numero_facture" name="numero_facture" value="{if $id_facture neq 0}{$numero_facture}{/if}"/>
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
												{if $id_fournisseur eq 0}
													<option value="{$item.idt_fournisseurs}">{$item.nom_fournisseur}</option>
												{else}
													{if $item.idt_fournisseurs eq $id_fournisseur}
														{assign var="opt" value="selected='selected'"}
													{else}
														{assign var="opt" value=""}
													{/if}
													<option value="{$item.idt_fournisseurs}" {$opt} >{$item.nom_fournisseur}</option>
												{/if}
										{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<td>Date de la facture :<span class="champObligatoire">*</span></td>
            				<td>
            					<input type="text" name="date_facture" id="date_facture" value="{if $id_facture neq 0}{$date_facture}{/if}"/>
            				</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<input type="hidden" name="target" id="target" value="factures"/>
		<input type="hidden" name="id_facture" id="id_facture" value="{if $id_facture neq 0}{$id_facture}{else}{0}{/if}"/>
	</form>
</div>
<hr size="1" style="margin-top: 5px;" />
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