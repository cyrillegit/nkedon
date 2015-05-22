<?php /* Smarty version Smarty-3.1.14, created on 2015-05-22 09:10:21
         compiled from ".\templates\common\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:399652eba7b1708760-69883461%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '14a35e64d31f6f39c819ba645103d1de351d1aea' => 
    array (
      0 => '.\\templates\\common\\header.tpl',
      1 => 1432285697,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '399652eba7b1708760-69883461',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52eba7b1864b45_21946484',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52eba7b1864b45_21946484')) {function content_52eba7b1864b45_21946484($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">  
<head>  
<title>Nkedon - Interface d'administration</title>  
<META NAME="AUTHOR" CONTENT="Nemand Softwares (developpement@nemand-soft.com)">
<META NAME="COPYRIGHT" CONTENT="&copy; 2013 Nemand Softwares">
<META NAME="DESCRIPTION" CONTENT="Backoffice Nkedon">
<LINK REL="SHORTCUT ICON" href="fav_icon.ico">
<link rel="stylesheet" href="css/styles.css" type="text/css" media="screen" />



<link rel="stylesheet" href="assets/css/ui.jquery/jquery-ui.custom.css" type="text/css" /> 

<script type="text/javascript" src="FusionCharts/FusionCharts.js"></script>

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.js"></script>
<script type="text/javascript" src="assets/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="assets/js/jquery.featurelist.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script type="text/javascript" src="assets/js/gmap3.min.js"></script>

<script type="text/javascript" src="assets/js/jquery.confirm.js"></script>










<style type="text/css">
#cssmenu {
  position: relative;
  height: 44px;
  background: #2b2f3a;
  width: auto;
}
#cssmenu ul {
  list-style: none;
  padding: 0;
  margin: 0;
  line-height: 1;
}
#cssmenu > ul {
  position: relative;
  display: block;
  background: #2b2f3a;
  height: 32px;
  width: 100%;
  z-index: 500;
}
#cssmenu > ul > li {
  display: block;
  position: relative;
  float: left;
  margin: 0;
  padding: 0;
}
#cssmenu > ul > #menu-button {
  display: none;
}
#cssmenu ul li a {
  display: block;
  font-family: Helvetica, sans-serif;
  text-decoration: none;
}
#cssmenu > ul > li > a {
  font-size: 14px;
  font-weight: bold;
  padding: 15px 20px;
  color: #7a8189;
  text-transform: uppercase;
  -webkit-transition: color 0.25s ease-out;
  -moz-transition: color 0.25s ease-out;
  -ms-transition: color 0.25s ease-out;
  -o-transition: color 0.25s ease-out;
  transition: color 0.25s ease-out;
}
#cssmenu > ul > li.has-sub > a {
  padding-right: 32px;
  font-family: Helvetica, sans-serif;
}
#cssmenu > ul > li:hover > a {
  color: #ffffff;
}
#cssmenu li.has-sub::after {
  display: block;
  content: '';
  position: absolute;
  width: 0;
  height: 0;
  font-family: Helvetica, sans-serif;
}
#cssmenu > ul > li.has-sub::after {
  right: 10px;
  top: 20px;
  border: 5px solid transparent;
  border-top-color: #7a8189;
  font-family: Helvetica, sans-serif;
}
#cssmenu > ul > li:hover::after {
  border-top-color: #ffffff;
}
#indicatorContainer {
  position: absolute;
  height: 12px;
  width: 100%;
  bottom: 0px;
  overflow: hidden;
  z-index: -1;
}
#pIndicator {
  position: absolute;
  height: 0;
  width: 100%;
  border: 12px solid transparent;
  border-top-color: #2b2f3a;
  z-index: -2;
  -webkit-transition: left .25s ease;
  -moz-transition: left .25s ease;
  -ms-transition: left .25s ease;
  -o-transition: left .25s ease;
  transition: left .25s ease;
}
#cIndicator {
  position: absolute;
  height: 0;
  width: 100%;
  border: 12px solid transparent;
  border-top-color: #2b2f3a;
  top: -12px;
  right: 100%;
  z-index: -2;
}
#cssmenu ul ul {
  position: absolute;
  left: -9999px;
  top: 70px;
  opacity: 0;
  -webkit-transition: opacity .3s ease, top .25s ease;
  -moz-transition: opacity .3s ease, top .25s ease;
  -ms-transition: opacity .3s ease, top .25s ease;
  -o-transition: opacity .3s ease, top .25s ease;
  transition: opacity .3s ease, top .25s ease;
  z-index: 1000;
}
#cssmenu ul ul ul {
  top: 37px;
  padding-left: 5px;
}
#cssmenu ul ul li {
  position: relative;
}
#cssmenu > ul > li:hover > ul {
  left: auto;
  top: 44px;
  opacity: 1;
}
#cssmenu ul ul li:hover > ul {
  left: 170px;
  top: 0;
  opacity: 1;
}
#cssmenu ul ul li a {
  width: 130px;
  border-bottom: 1px solid #eee;
  padding: 10px 20px;
  font-size: 14px;
  color: #000000;
  background: #fff;
  -webkit-transition: all .35s ease;
  -moz-transition: all .35s ease;
  -ms-transition: all .35s ease;
  -o-transition: all .35s ease;
  transition: all .35s ease;
}
#cssmenu ul ul li:hover > a {
  background: #f6f6f6;
  color: #8c9195;
}
#cssmenu ul ul li:last-child > a,
#cssmenu ul ul li.last > a {
  border-bottom: 0;
}
.submenuArrow {
  border: 6px solid transparent;
  width: 0;
  height: 0;
  border-bottom-color: #fff;
  position: absolute;
  top: -12px;
}
#cssmenu ul ul li.has-sub::after {
  border: 4px solid transparent;
  border-left-color: #9ea2a5;
  right: 10px;
  top: 12px;
  -moz-transition: all .2s ease;
  -ms-transition: all .2s ease;
  -o-transition: all .2s ease;
  transition: all .2s ease;
  -webkit-transition: -webkit-transform 0.2s ease, right 0.2s ease;
}
#cssmenu ul ul li.has-sub:hover::after {
  border-left-color: #fff;
  right: -5px;
  -webkit-transform: rotateY(180deg);
  -ms-transform: rotateY(180deg);
  -moz-transform: rotateY(180deg);
  -o-transform: rotateY(180deg);
  transform: rotateY(180deg);
}
@media all and (max-width: 800px), only screen and (-webkit-min-device-pixel-ratio: 2) and (max-width: 1024px), only screen and (min--moz-device-pixel-ratio: 2) and (max-width: 1024px), only screen and (-o-min-device-pixel-ratio: 2/1) and (max-width: 1024px), only screen and (min-device-pixel-ratio: 2) and (max-width: 1024px), only screen and (min-resolution: 192dpi) and (max-width: 1024px), only screen and (min-resolution: 2dppx) and (max-width: 1024px) {
  #cssmenu {
    width: auto;
  }
  #cssmenu ul {
    width: auto;
  }
  #cssmenu .submenuArrow,
  #cssmenu #indicatorContainer {
    display: none;
  }
  #cssmenu > ul {
    height: auto;
    display: block;
  }
  #cssmenu > ul > li {
    float: none;
  }
  #cssmenu li,
  #cssmenu > ul > li {
    display: none;
  }
  #cssmenu ul ul,
  #cssmenu ul ul ul,
  #cssmenu ul > li:hover > ul,
  #cssmenu ul ul > li:hover > ul {
    position: relative;
    left: auto;
    top: auto;
    opacity: 1;
    padding-left: 0;
  }
  #cssmenu ul .has-sub::after {
    display: none;
  }
  #cssmenu ul li a {
    padding: 12px 20px;
  }
  #cssmenu ul ul li a {
    border: 0;
    background: none;
    width: auto;
    padding: 8px 35px;
  }
  #cssmenu ul ul li:hover > a {
    background: none;
    color: #8c9195;
  }
  #cssmenu ul ul ul a {
    padding: 8px 50px;
  }
  #cssmenu ul ul ul ul a {
    padding: 8px 65px;
  }
  #cssmenu ul ul ul ul ul a {
    padding: 8px 80px;
  }
  #cssmenu ul ul ul ul ul ul a {
    padding: 8px 95px;
  }
  #cssmenu > ul > #menu-button {
    display: block;
    cursor: pointer;
  }
  #cssmenu #menu-button > a {
    padding: 14px 20px;
  }
  #cssmenu ul.open li,
  #cssmenu > ul.open > li {
    display: block;
  }
  #cssmenu > ul.open > li#menu-button > a {
    color: #fff;
    border-bottom: 1px solid rgba(150, 150, 150, 0.1);
  }
  #cssmenu #menu-button::after {
    display: block;
    content: '';
    position: absolute;
    height: 3px;
    width: 22px;
    border-top: 2px solid #7a8189;
    border-bottom: 2px solid #7a8189;
    right: 20px;
    top: 15px;
  }
  #cssmenu #menu-button::before {
    display: block;
    content: '';
    position: absolute;
    height: 3px;
    width: 22px;
    border-top: 2px solid #7a8189;
    right: 20px;
    top: 25px;
  }
  #cssmenu ul.open #menu-button::after,
  #cssmenu ul.open #menu-button::before {
    border-color: #fff;
  }
}

/* Bounce To Right */
.has-sub {
    display: inline-block;
    vertical-align: middle;
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
    box-shadow: 0 0 1px rgba(0, 0, 0, 0);
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -moz-osx-font-smoothing: grayscale;
    position: relative;
    -webkit-transition-property: color;
    transition-property: color;
    -webkit-transition-duration: 0.5s;
    transition-duration: 0.5s;
}
.has-sub:before {
    content: "";
    position: absolute;
    z-index: -1;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: #2098d1;
    -webkit-transform: scaleX(0);
    transform: scaleX(0);
    -webkit-transform-origin: 0 50%;
    transform-origin: 0 50%;
    -webkit-transition-property: transform;
    transition-property: transform;
    -webkit-transition-duration: 0.5s;
    transition-duration: 0.5s;
    -webkit-transition-timing-function: ease-out;
    transition-timing-function: ease-out;
}
.has-sub:hover, .has-sub:focus, .has-sub:active {
    color: white;
}
.has-sub:hover:before, .has-sub:focus:before, .has-sub:active:before {
    -webkit-transform: scaleX(1);
    transform: scaleX(1);
    -webkit-transition-timing-function: cubic-bezier(0.52, 1.64, 0.37, 0.66);
    transition-timing-function: cubic-bezier(0.52, 1.64, 0.37, 0.66);
}
</style>

</head>


<script language="javascript">

$('#cssmenu').prepend('<div id="indicatorContainer"><div id="pIndicator"><div id="cIndicator"></div></div></div>');
	var posLeft = $('#cssmenu>ul>li.active').position();
	var elementWidth = $('#cssmenu>ul>li.active').width();
	posLeft = posLeft + elementWidth/2 -6;
	if ($('#cssmenu>ul>li.active').hasClass('has-sub')) {
		posLeft -= 6;
	}

	$('#cssmenu #pIndicator').css('left', posLeft);
	var element, leftPos, indicator = $('#cssmenu pIndicator');
	
	$("#cssmenu>ul>li").hover(function() {
        element = $(this);
        var w = element.width();
        if ($(this).hasClass('has-sub'))
        {
        	leftPos = element.position().left + w/2 - 12;
        }
        else {
        	leftPos = element.position().left + w/2 - 6;
        }

        $('#cssmenu #pIndicator').css('left', leftPos);
    }
    , function() {
    	$('#cssmenu #pIndicator').css('left', posLeft);
    });


	$('#cssmenu>ul>.has-sub>ul').append('<div class="submenuArrow"></div>');
	$('#cssmenu>ul').children('.has-sub').each(function() {
		var posLeftArrow = $(this).width();
		posLeftArrow /= 2;
		posLeftArrow -= 12;
		$(this).find('.submenuArrow').css('left', posLeftArrow);

	});

	$('#cssmenu>ul').prepend('<li id="menu-button"><a>Menu</a></li>');
	$( "#menu-button" ).click(function(){
    		if ($(this).parent().hasClass('open')) {
    			$(this).parent().removeClass('open');
    		}
    		else {
    			$(this).parent().addClass('open');
    		}
    });

function UploadifyTips ()
{
	// mise en place du lien vers l'object Flash associé.
	$('input.tTipUploadify').each (function ()
	{
		var ID = $(this).attr ("id");
		var TIP = $(this).attr ("tip");
		//alert (ID + " " + TIP);
		$("#" + ID + "Uploader").tinyTips(theme, $(this).attr ("tip"));
	});
}
// Permet de modifier le code source HTML d'une page en chargeant un fichier PHP ajax.
function update_content(page,to,param)
{
	var cdiv = (to) ? to : "main";
	var cparam = (param) ? param : null;
	
	$.blockUI({ message: '<h4 style="font-size:10px;margin:10px 0;">Veuillez patienter pendant le chargement de la page...</h4><img src="assets/images/progress.gif" /><br/><br/>' });
	var myContent = $.ajax({
			type	: "POST",
			url		: page,
			async	: false,
			data	: cparam,
			success	: function (content)
			{
				/**
					Suite au bug n°00074 : correctif sur Msie qui plante sur un .append...
				*/
				if ($.browser.msie)
					document.getElementById(to).innerHTML = content;
				else
					$("#"+cdiv).empty().append ( content );
					
				$.unblockUI ();
			}
	}).responseText;
}
/**
	Cette fonction retourne l'id enregistré dans l'ordinateur client pour le cookie
	dont le nom est passé en paramètre à la fonction.
*/
function GetCookieTab (CookieName)
{
	var index = $.cookie (CookieName);
	if ((index == null) || (index == ""))
		index = 0;
		
	return index;
}
/**
	Cette fonction récupère la liste des ids du select dont on passe l'id en paramètre.
*/
function GetSelectedValues (id)
{
	var selected = "";
	
	$("#" + id + " option:selected").each (function ()
	{
		if (selected != "") selected += ",";
		selected += $(this).val ();
	});
	return selected;
}
/**
	Envoi la fonction de sérialisation (Serializer.php)
	et renvoie ensuite le résultat, qui lui sera retraité ou non.
*/
function Serialize (param)
{
	ShowSerializeWaitMessage ();
	var text = $.ajax({
			type	: "POST",
			url		: "ajax/serializer.php",
			async	: false,
			data	: param,
			success	: function (msg)
			{}
	}).responseText;
	
	return text;
}
/**
	Cette fonction enregistre dans la session sous $_SESSION ["SelectedValues"][...]
	l'information voulue.
	
	Le script Session peut changer le parent Key si on le saisit dans cette fonction (après value).
*/
function SetSessionInfo (key, value, parentkey)
{
	var param = "key=" + key + "&value=" + value;
	$.ajax({
			type	: "POST",
			url		: "ajax/session.php",
			async	: false,
			data	: param,
			success	: function (msg)
			{}
		}).responseText;
}
/**
	Cette fonction met à jour tous les tableaux de type "tablesorter" pour qu'ils
	aient tous le design qui ne saute pas à chaque ajustement de page.
*/
function updateTableSorter ()
{
	UpdateTSorter ();
}
/**
	Cette fonction va masquer les messages SUCCESS/FAULT.
	Contrib. Jperciot, le 08/08/2011.
*/
function HideMessages ()
{
	$("#warnings").hide ();
	$("#success").hide ();
	$("#warnings_popup").hide ();
}
/**
	Fonction affichant un message d'erreur.
*/
function ShowError (message)
{
	$("#warnings div").empty ().html (message).show ();
	$("#warnings").show ();
	$("#success").hide ();
}
/**
	Fonction affichant un message d'erreur.
*/
function ShowPopupError (message)
{
	$("#warnings_popup div").empty ().html (message).show ();
	$("#warnings_popup").show ();
}
/**
	Fonction affichant un message d'erreur.
*/
function ShowUnknownError ()
{
	$("#warnings div").empty ().html ("Une erreur inconnue est survenue, le service technique en a été averti !").show ();
	$("#warnings").show ();
	$("#success").hide ();
}
/**
	Fonction affichant un message de succès.
*/
function ShowSuccess (message)
{
	$("#success").empty ().html (message);
	$("#success").show ();
	$("#warnings").hide ();
}
/**
	Fonction qui affiche simplement la popup.
*/
function ShowPopup ()
{
	$("#popup").modal ({
		bgiframe : true,
		position: ["5%","35%"],
		onShow: function (dialog) 
		{
			$(".popup_title").attr ("style", "cursor: pointer;");
			dialog.container.draggable();
		}
	});
	$("#popup").dropShadow({left: 4, top: 6, opacity: 0.5, color: "#3c3c3c", blur: 2});
}
function ShowPopupHeight (HEIGHT)
{
	$("#popup").modal ({
		bgiframe : true,
		position: ["5%","35%"],
		onShow: function (dialog) 
		{
			$(".popup_title").attr ("style", "cursor: pointer;");
			dialog.container.draggable();
		}
	});
	$("#popup").dropShadow({left: 4, top: 6, opacity: 0.5, color: "#3c3c3c", blur: 2});
	var myStyle = $("#popup").attr ("style");
	$("#popup").attr ("style", myStyle + "height: " + HEIGHT + "px;");
}
/**
	Fonction permettant d'afficher la valeur correspondante dans une combo box.
*/
function SelectInCombo (cb, value)
{
	var found = false;
	
	$(cb+" option").each (function ()
	{
		if ($(this).val () == value)
		{
			$(this).attr ("selected", "selected");
			found = true;
		}
	});
}
function ShowReloadMessage ()
{
	$.blockUI({ message: '<h4 style="font-size:10px;margin:10px 0;">Veuillez patienter pendant le chargement de votre page.<br /><span class=\"champObligatoire\">Attention</span>, ce processus peut �tre long selon l\'état du réseau et le flot de données à traiter...</h4><img src="assets/images/progress.gif" /><br/><br/>' });
}
/**
	Fonction qui compare 2 dates passées en paramètre, renvoie 0 si la première date passée en paramètre est strictement inférieure à la seconde en paramètre, sinon renvoie 1.
*/
function compareDate(date1, date2) {
	
	var m_date1 = new Date();
	m_date1.setFullYear(date1.substr(6,4));
	m_date1.setMonth(date1.substr(3,2));
	m_date1.setDate(date1.substr(0,2));
	m_date1.setHours(0);
	m_date1.setMinutes(0);
	m_date1.setSeconds(0);
	m_date1.setMilliseconds(0);
	var d1=m_date1.getTime()
	
	var m_date2 = new Date();
	m_date2.setFullYear(date2.substr(6,4));
	m_date2.setMonth(date2.substr(3,2));
	m_date2.setDate(date2.substr(0,2));
	m_date2.setHours(0);
	m_date2.setMinutes(0);
	m_date2.setSeconds(0);
	m_date2.setMilliseconds(0);
	var d2=m_date2.getTime()

	if( d1 < d2 )
	{	
		return 0;
	}
	else
	{
		return 1;
	}
}
function ShowSerializeWaitMessage ()
{
	$.blockUI({ message: '<h4 style="font-size:10px;margin:10px 0;">Veuillez patienter pendant l\'enregistrement de vos données ...</h4><img src="assets/images/progress.gif" /><br/><br/>' });
}

// autocomplet : this function will be executed every time we change the text
function autocomplet() {
    var min_length = 0; // min caracters to display the autocomplete
    var keyword = $('#nom_produit_search').val();
    if (keyword.length >= min_length) {
        $.ajax({
            url: 'ajax/populate.php',
            type: 'POST',
            data: {target:'produits', keyword:keyword},
            success:function(data){
                $('#list_nom_produit').show();
                $('#list_nom_produit').html(data);
            }
        });
    } else {
        $('#list_nom_produit').hide();
    }
}

// set_item : this function will be executed when we select an item
function set_item(item) {
    // change input value
    $('#nom_produit_search').val(item);
    // hide proposition list
    $('#list_nom_produit').hide();
}

$(document).ready (function ()
{
	// Définition de variables globales pour le site Web.
    jQuery.fn.jBreadCrumb.defaults.easing = 'linear';
	
	/**
	 * Champ numérique.
	 */
	$("input.numeric").each (function ()
	{
		$(this).numeric ();
	});
	
	$("#buttonDisconnect").click (function ()
	{
		// On déconnecte l'utilisateur du site Internet.
		document.location.href = "index.php?logout";
	});
	
	updateTableSorter ();
	
	/**
		Affichage d'une popup de chargement de la page, pour faire patienter le client.
	*/
	$.blockUI({ message: '<h4 style="font-size:10px;margin:10px 0;">Veuillez patienter pendant le chargement de vos informations...</h4><br/><br/>' });
	
	// Ce script permet de débloquer l'interface quand ajax arrête.
	$(document).ajaxStop($.unblockUI);

	$("#id_client_nav").change (function ()
	{
		SetSessionInfo("id_client", $(this).val() );
		var url = String(location);
		document.location.href=url;
	});

});
</script>

<body>
<div style="width:100%; 
			height:135px; 
			float:left; 
			background-image:url(css/images/elements/bg_hd_old.png); 
			background-repeat:repeat-x;
			">
<div id="popup" class="popup" style="display: none;"></div>

<div id="header">
	<?php if (isset($_SESSION['connected'])){?>
		<?php if ($_SESSION['connected']){?>
			<table>
				<tr>
					<td>
						<div class="" style="background: none;">
							<a href="index.php">
								<img src="assets/images/nkedon_logo.png" border="0" style="margin-top: -5px;" width="275" height="120">
							</a>
						</div>
					</td>
				<tr/>
			</table>
			<div class="menu" style="margin-top: -50px;width: 770px; margin-left: 230px;">
				<div id='cssmenu'>
				<ul>
				   <?php if ($_SESSION['infoUser']['id_type_user']<=2){?>
				   <li class='has-sub'><a href="administration.php"><span>Administration</span></a>
				      <ul>
				         <li class="has-sub"><a href="administration.php?sub=comptes_utilisateurs"><span>Ajouter / Modifer un compte utilisateur</span></a>
				         </li>
				         <li class='has-sub'><a href="administration.php?sub=types_comptes_utilisateurs"><span>Ajouter / Modifier un profil utilisateur</span></a>
				         </li>
				         <li class='has-sub'><a href="administration.php?sub=password_oublie"><span>Mot de passe oublié</span></a>
				         </li>							         
				      </ul>
				   </li>
				   <?php }?>
				   <li class='has-sub'><a href="magasin.php"><span>Magasin</span></a>
				      <ul>
				         <li class='has-sub'><a href="magasin.php?sub=produits"><span>Ajouter / Modifer un produit</span></a></li>
                          <li class='has-sub'><a href="magasin.php?sub=fournisseurs"><span>Ajouter / modifier un fournisseur</span></a></li>
				         <li class='has-sub'><a href="magasin.php?sub=edit_facture_achat"><span>Enregistrer une facture d'achat</span></a></li>
                          <li class='has-sub'><a href="magasin.php?sub=edit_facture_vente"><span>Etablir une facture de vente</span></a></li>
                          <li class='has-sub'><a href="magasin.php?sub=edit_operations_journal"><span>Réaliser le journal</span></a></li>
				         <li class='has-sub'><a href="magasin.php?sub=inventaire"><span>Réaliser l'inventaire du magasin</span></a></li>
				      </ul>
				   </li>

				   <li class='has-sub'><a href="production.php"><span>Production</span></a>
                       <ul>
                           <li class='has-sub'><a href="production.php?sub=matieres_premieres"><span>Ajouter / Modifer une matiére première</span></a></li>
                           <li class='has-sub'><a href="production.php?sub=portions_journalieres"><span>Ajouter / Modifer une portion journaliére</span></a></li>
                           <li class='has-sub'><a href="production.php?sub=produits_confectionnes"><span>Ajouter / Modifer un produit confectionné</span></a></li>
                           <li class='has-sub'><a href="production.php?sub=fournisseurs"><span>Ajouter / modifier un fournisseur</span></a></li>
                           <li class='has-sub'><a href="production.php?sub=factures_achats"><span>Enregistrer une facture d'achat</span></a></li>
                           <li class='has-sub'><a href="production.php?sub=factures_ventes"><span>Etablir une facture de vente</span></a></li>
                           <li class='has-sub'><a href="production.php?sub=operations_journal"><span>Réaliser le journal</span></a></li>
                           <li class='has-sub'><a href="production.php?sub=inventaire"><span>Réaliser l'inventaire du magasin</span></a></li>
                       </ul>
				   </li>
                    <?php if ($_SESSION['infoUser']['id_type_user']<=5){?>
                        <li class='has-sub'><a href="historiques.php"><span>Historiques</span></a>
                            <ul>
                                <li class="has-sub"><a href="historiques.php?sub=historiques_factures_achats"><span>Historiques des factures d'achats</span></a></li>
                                <li class="has-sub"><a href="historiques.php?sub=historiques_factures_ventes"><span>Historiques des factures de ventes</span></a></li>
                                <li class='has-sub'><a href="historiques.php?sub=historiques_journal"><span>Historiques des journaux</span></a></li>
                                <li class='has-sub'><a href="historiques.php?sub=historiques_inventaires"><span>Historiques des inventaires</span></a></li>
                                <?php if ($_SESSION['infoUser']['id_type_user']<=4){?>
                                    <li class='has-sub'><a href="statistiques.php?sub=main"><span>Statistiques</span></a></li>
                                <?php }?>
                            </ul>
                        </li>
                    <?php }?>
				   <li class='last has-sub'><a href="contact.php"><span>Contact</span></a></li>
				</ul>
				</div>
			</div>
		<?php }?>
	<?php }?>
</div>
<div class="s_menu">
	<div class="bloc_connect">
		<?php if (isset($_SESSION['connected'])){?>
	    	<?php if ($_SESSION['connected']){?>
	            <div class="deco"><a href="index.php?logout=logout" class="std">Déconnexion</a></div>
	            <div class="info_connect std">Bonjour, <strong><?php echo $_SESSION['infoUser']['nom_user'];?>
 <?php echo $_SESSION['infoUser']['prenom_user'];?>
</strong>. Derniére connexion: <?php echo $_SESSION['infoUser']['datetime_last_connected'];?>
 </div>
	        <?php }?>
	    <?php }else{ ?>
        	<div class="home">
            	<table border="0" cellpadding="0" cellspacing="0">
                	<tr>
                    	<td><a href="index.php" class="std"><img src="css/images/ico_42x42/menu_tb.png" border="0" style="margin-top: -3px;"" /></a></td>
                        <td><a href="index.php" class="std">&nbsp;&nbsp;Accueil</a></td>
                    </tr>
                </table>
            </div>
		<?php }?>
    </div>
</div>
    
<?php }} ?>