<?php /* Smarty version Smarty-3.1.14, created on 2015-05-24 11:46:42
         compiled from ".\templates\magasin\gestion_magasin\recapitulatif_inventaire.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15377555a229326b966-70455225%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f59660d30b91c5190fd40df7b78d507e47658def' => 
    array (
      0 => '.\\templates\\magasin\\gestion_magasin\\recapitulatif_inventaire.tpl',
      1 => 1432290172,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15377555a229326b966-70455225',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_555a2293340b24_50761615',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555a2293340b24_50761615')) {function content_555a2293340b24_50761615($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">
/**
	Rafraîchissement du tableau de l'inventaire.
*/
function RefreshTableRecapitulatifInventaire ()
{
	var responseText = $.ajax({
			type	: "POST",
			url		: "ajax/infos/magasin/GetTableauRecapitulatifInventaire.php",
			async	: false,
			data	: "",
			success	: function (msg){}
	}).responseText;
	$("#tableau_recapitulatif").empty ().html (responseText);

	UpdateTSorter ();
}

/**
 pour generer la synthese de l'inventaire.
 */
function RefreshTableGenerateSynthese()
{
    var responseText = $.ajax({
        type	: "POST",
        url		: "ajax/infos/magasin/GetTableauGenerateSynthese.php",
        async	: false,
        data	: "",
        success	: function (msg){
            alert("msg : "+msg);
        }
    }).responseText;

    alert( responseText );
}

/**
 pour generer la synthese de l'inventaire.
 */
function RefreshTableAnnulerSynthese()
{
    var responseText = $.ajax({
        type	: "POST",
        url		: "ajax/infos/magasin/GetTableauAnnulerSynthese.php",
        async	: false,
        data	: "",
        success	: function (msg){}
    }).responseText;
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
    $("#downloadLink").hide();
    if(getUrlParameter("sub") == "synthese_inventaire" ){
        $("#succes_register").show();
        $("#succes_cancel").hide();
        $("#downloadLink").show();
        $("#btnAnnulerValider").hide();
    }else{
        $("#succes_register").hide();
        $("#succes_cancel").hide();
        $("#downloadLink").hide();
    }
}

/**
	jQuery init.
*/
$(document).ready (function ()
{
    setRegisterPopup();
	RefreshTableRecapitulatifInventaire ();


    $('#btnValiderInventaire').click(function()
    {
        var didConfirm = confirm("Vous êtes sur le point de générer la synthèse de l'inventaire. \n cet action est irréversible");
      if (didConfirm == true) {
          document.location.href="magasin.php?sub=recapitulatif_inventaire";
      }
    });

    $('#btnAnnulerInventaire').click(function()
    {
        var didConfirm = confirm("Vous êtes sur le point d'annuler la synthèse de l'inventaire. \n cet action est irréversible");
        if (didConfirm == true) {
            RefreshTableAnnulerSynthese();
            RefreshTableRecapitulatifInventaire ();
            $("#tableau_recapitulatif").hide();
            $("#btnAnnulerValider").hide();
            $("#succes_cancel").show();
        }
    });
});

</script>

<div id="Content">
    <div class="success" id="succes_register" style="display: block;">
        <b>La synthèse de l'inventaire a été réalisée avec succès.
            </br> Vous pouvez télécharger le fichier de synthèse .
            </br> Vous pouvez aussi consulter cette synthèse dans l'historique des inventaires.
        </b>
        <div></div>
    </div>
    <div class="success" id="succes_cancel" style="display: block;">
        <b>La synthèse de l'inventaire a été annulée avec succès.
            </br> Vous pouvez consulter les syntèses dans l'historique des inventaires.
        </b>
        <div></div>
    </div>
    <div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Recapitulatif</strong> <strong style="color:black;">de l'inventaire du magasin</strong></div>
            </div>
        </div>
    </div>
    <div class="intro">Dans cet écran, vous avez la possibilité de visualiser le recapitulatif de l'inventaire.<br/><br/></div>
    
    <div style="clear: both;"></div>

    <div class="bg_filter" style="line-height:50px;"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                Actuellement, le recapitulatif de l'inventaire.
                </td>
                <td>
                <?php if ($_SESSION['infoUser']['id_type_user']<=5){?>
                <div style="margin-left:20px; margin-right: 20px; float: right;">Pour générer la synthése de l'inventaire, veuillez valider avec le boutton ci-dessous :&nbsp;</div>
                <?php }?>
                </td>
            </tr>
        </table>
    </div>
    <br style="clear: both;" />

    <div id="tableau_recapitulatif"></div>

    <hr size="1" style="margin-top: 25px;" />
    <div style="float: left; text-align: left;"><span class="champObligatoire">*</span> : Champs obligatoires.</div>
    <div id="btnAnnulerValider" style="float: right; text-align: right; padding-bottom: 10px;">
        <table border="0" cellspacing="0" cellpadding="0" align="right">
            <tr>
                <td><div id="btnAnnulerInventaire"><img src="css/images/boutons/btn_annuler.png" class="" style="cursor: pointer;" width="110" height="30" /></div></td>
                <td>&nbsp;</td>
                <td><div id="btnValiderInventaire"><img src="css/images/boutons/btn_valider.png" class="" style="cursor: pointer;" width="110" id="btnOK" height="30" /></div></td>
            </tr>
        </table>
    </div>

    <div style="clear: both;">&nbsp;</div>
    <div class="btn_precedent"style="float: right;" onclick="javascript:document.location.href='magasin.php';"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>