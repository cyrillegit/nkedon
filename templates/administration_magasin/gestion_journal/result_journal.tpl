{include file='common/header.tpl'}
{literal}
<script language="javascript" xmlns="http://www.w3.org/1999/html">

function RefreshTableOperationsJournal ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/administration_magasin/GetTableauJournal.php",
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
        <b>Le journal a bien été enregistré.</b>
        <div></div>
    </div>
    {if isset($smarty.session.journal)}
        {if !$smarty.session.journal}
            <div class="bloc_alerts" id="alert_journal" style="display: block;">
                <b>Attention!.</b><br/>
                <div>Il n'est plus possible de réaliser un journal pour ce jour.</div>
            </div>
        {/if}
    {/if}
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Journal du </strong> <strong style="color:black;"></strong></div>
            </div>
        </div>
  	</div>
	<div class="intro">
        Dans cet écran, vous avez la possibilité de visualiser le journal nouvellement crée".
	</div>
	<br/><br/>
	{include file="common/messages_boxes.tpl"}

        <div class="bg_filter" style="line-height:50px;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                    Actuellement <font color="black"><b>{$nb_produits}</b></font> opérations enregistrées pour ce journal.
                    </td>
                </tr>
            </table>
        </div>
        <br style="clear: both;" />

        <div id="editOperationJournal" class="content">
            <div class="TitrePopup">ajouter/modifier <strong style="color:#1c9bd3">une opération du journal</strong></div>
            <div class="subTitlePopup" style="color: #ffffff; text-decoration: none; font-size: 12px;">Veuillez saisir les informations de l'opération en remplissant les champs obligatoires.</div>
            <br style="clear: both; " />
            <hr size="1" style="margin-top: 50px;" />
            <div style="float: left; text-align: left;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
            <hr size="5" style="margin-top: 50px; background-color: #ff0000;" />
        </div>

		<div id="tableau_operations_journal"></div>


</div>
<hr size="1" style="margin-top: 15px;" />
<div style="float: left; text-align: left; margin-left: 200px;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
{include file='common/footer.tpl'}