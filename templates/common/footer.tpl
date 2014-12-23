<div style="clear: both;"></div>
<div id="footer">
    <div class="foot_top"></div>
    <div class="foot_body">
        <div class="foot_text_right">Design & Developpement by <a href="http://www.nemand-soft.com" target="_blank" class="std">Nemand Softwares</a>. Copyright 2013 - {$smarty.now|date_format:"%Y"}. <strong><span style="color: #000;">Version : </span></strong> <strong style="color:#F00;">1.0 bêta-test.</strong></div>
    </div>
    <div class="foot_bottom"></div>
</div>
{literal}
<!-- Librairies supplémentaires... -->
<script type="text/javascript" src="assets/js/jquery.ui.core.min.js"></script> 
<script type="text/javascript" src="assets/js/jquery.ui.sortable.min.js"></script> 
<script type="text/javascript" src="assets/js/jquery.cookie.js"></script> 
<script type="text/javascript" src="assets/js/jquery.md5.js"></script> 
<script type="text/javascript" src="assets/js/jquery.easyslider.js"></script> 
<script type="text/javascript" src="assets/js/metadata.js"></script>
<script type="text/javascript" src="assets/js/jquery.alerts.js"></script>
<script type="text/javascript" src="assets/js/jquery.datatable.js"></script>
<script type="text/javascript" src="assets/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="assets/js/jquery.simplemodal.js"></script>
<script type="text/javascript" src="assets/js/jquery.lazyRender.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.confirm.js"></script>
<script type="text/javascript" src="assets/js/fancybox/jquery.fancybox.js"></script>
<script type="text/javascript" src="assets/js/jquery.paginate.js"></script>
<script type="text/javascript" src="assets/js/jquery.validate.js"></script>
<script type="text/javascript" src="assets/js/jquery.osx.js"></script>
<script type="text/javascript" src="assets/js/jquery.flash.js"></script>
<script type="text/javascript" src="assets/js/jquery.timers.js"></script>
<script type="text/javascript" src="assets/js/jquery.mosaic.js"></script>
<script type="text/javascript" src="assets/js/jquery.scrollTo.js"></script>
<script type="text/javascript" src="assets/js/jquery.colorpicker.js"></script>
<script type="text/javascript" src="assets/js/eye.js"></script>
<script type="text/javascript" src="assets/js/utils.js"></script>
<script type="text/javascript" src="assets/js/layout_eye.js?ver=1.0.2"></script>
<script type="text/javascript" src="assets/js/jquery.checkbox.js"></script>
<script type="text/javascript" src="assets/js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="assets/js/jquery.fastconfirm.js"></script>
<script type="text/javascript" src="assets/js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="assets/js/jquery.numeric.js"></script>
<script type="text/javascript" src="assets/js/jquery.contextmenu.min.js"></script>
<script type="text/javascript" src="assets/js/swfobject.js"></script>
<script type="text/javascript" src="assets/js/uploadify/jquery.uploadify.js"></script>
<script type="text/javascript" src="assets/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="assets/js/jquery.dropshadow.js"></script>
<script type="text/javascript" src="assets/js/jquery.easing.js"></script>
<script type="text/javascript" src="assets/js/jquery.jBreadCrumb.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.delegate.js"></script>
<script type="text/javascript" src="assets/js/jquery.dimensions.js"></script>
<script type="text/javascript" src="assets/js/jquery.tooltip.js"></script>
<script type="text/javascript" src="assets/js/jquery.bgiframe.js"></script>
<script type="text/javascript" src="assets/js/jquery.utils.js"></script>
<script type="text/javascript" src="assets/js/jquery.timeentry.js"></script>
<script type="text/javascript" src="assets/js/jquery.timeentry.fr.js"></script>
<script type="text/javascript" src="assets/js/zenWidgetDoubleList.js"></script>
<script type="text/javascript" src="assets/js/fullcalendar.min.js"></script>
<script type="text/javascript" src="assets/js/i18n/jquery.ui.datepicker-fr.js"></script>
<script type="text/javascript" src="assets/js/jquery.tinytips.js"></script>
<script type="text/javascript" src="assets/js/ui.multiselect.js"></script>
<script type="text/javascript" src="assets/js/ui-multiselect-fr.js"></script>
<script type="text/javascript">
function FooterUIReload ()
{
	var theme = "light";
	
	$("a.delete_link").each (function ()
	{
		$(this).click (function ()
		{
			var Url = $(this).attr ("url");
			
			$(this).fastConfirm({
				position: "right",
				targetElement: $(this),
				proceedText: "Oui",
				unique: true,				// Correctif bogue N°576.
				cancelText: "Non",
				questionText: "Êtes-vous sûr de vouloir<br />supprimer cette information <br />(<strong>opération irréversible</strong>) ?",
				onProceed: function(trigger) 
				{
					document.location.href = Url;
					$(trigger).fastConfirm('close');
				},
				onCancel: function(trigger) 
				{
					$(trigger).fastConfirm('close');
				}
			});
		});
	});
	
	$("input[name=telephone]").each (function ()
	{
		if ($(this).attr ("readonly") != "readonly")
		{
			$(this).mask ("99 99 99 99 99");
		}
	});
	$("input[name=fax]").each (function ()
	{
		if ($(this).attr ("readonly") != "readonly")
		{
			$(this).mask ("99 99 99 99 99");
		}
	});
	$("input[name=portable]").each (function ()
	{
		if ($(this).attr ("readonly") != "readonly")
		{
			$(this).mask ("99 99 99 99 99");
		}
	});
	
		
	$('input[safari]:checkbox').checkbox({cls:'jquery-safari-checkbox'});
	
	$.unblockUI ();
}
/*
 * Natural Sort algorithm for Javascript - Version 0.6 - Released under MIT license
 * Author: Jim Palmer (based on chunking idea from Dave Koelle)
 * Contributors: Mike Grier (mgrier.com), Clint Priest, Kyle Adams, guillermo
 */
function naturalSort (a, b) {
	var re = /(^-?[0-9]+(\.?[0-9]*)[df]?e?[0-9]?$|^0x[0-9a-f]+$|[0-9]+)/gi,
		sre = /(^[ ]*|[ ]*$)/g,
		dre = /(^([\w ]+,?[\w ]+)?[\w ]+,?[\w ]+\d+:\d+(:\d+)?[\w ]?|^\d{1,4}[\/\-]\d{1,4}[\/\-]\d{1,4}|^\w+, \w+ \d+, \d{4})/,
		hre = /^0x[0-9a-f]+$/i,
		ore = /^0/,
		// convert all to strings and trim()
		x = a.toString().replace(sre, '') || '',
		y = b.toString().replace(sre, '') || '',
		// chunk/tokenize
		xN = x.replace(re, '\0$1\0').replace(/\0$/,'').replace(/^\0/,'').split('\0'),
		yN = y.replace(re, '\0$1\0').replace(/\0$/,'').replace(/^\0/,'').split('\0'),
		// numeric, hex or date detection
		xD = parseInt(x.match(hre)) || (xN.length != 1 && x.match(dre) && Date.parse(x)),
		yD = parseInt(y.match(hre)) || xD && y.match(dre) && Date.parse(y) || null;
	// first try and sort Hex codes or Dates
	if (yD)
		if ( xD < yD ) return -1;
		else if ( xD > yD )	return 1;
	// natural sorting through split numeric strings and default strings
	for(var cLoc=0, numS=Math.max(xN.length, yN.length); cLoc < numS; cLoc++) {
		// find floats not starting with '0', string or 0 if not defined (Clint Priest)
		oFxNcL = !(xN[cLoc] || '').match(ore) && parseFloat(xN[cLoc]) || xN[cLoc] || 0;
		oFyNcL = !(yN[cLoc] || '').match(ore) && parseFloat(yN[cLoc]) || yN[cLoc] || 0;
		// handle numeric vs string comparison - number < string - (Kyle Adams)
		if (isNaN(oFxNcL) !== isNaN(oFyNcL)) return (isNaN(oFxNcL)) ? 1 : -1; 
		// rely on string comparison if different types - i.e. '02' < 2 != '02' < '2'
		else if (typeof oFxNcL !== typeof oFyNcL) {
			oFxNcL += ''; 
			oFyNcL += ''; 
		}
		if (oFxNcL < oFyNcL) return -1;
		if (oFxNcL > oFyNcL) return 1;
	}
	return 0;
}
function UpdateTSorter ()
{
	jQuery.fn.dataTableExt.oSort['natural-asc']  = function(a,b) {
		return naturalSort(a,b);
	};
	 
	jQuery.fn.dataTableExt.oSort['natural-desc'] = function(a,b) {
		return naturalSort(a,b) * -1;
	};

	$(".tablesorter").each (function ()
	{
		if ( (($(this).attr ("bReload") != undefined ) && ($(this).attr ("bReload") == "1")) || ( ($(this).attr ("bReload") == undefined ) ) )
		{
			$(this).dataTable ({
				"iDisplayLength": {/literal}{$parametrage.nb_rows_in_table|default:100}{literal}, 
				"oLanguage": {
					"sUrl": "langpacks/fr/dataTables.txt"},
				"bDestroy": true,
				"bRetrieve": true,
				"aaSorting": [[ 0, "desc" ]]
			});
		}
	});
}
$(document).ready (function ()
{
	UpdateTSorter ();
	$.unblockUI ();
	$(document).ajaxStop($.unblockUI);
	FooterUIReload ();
	
	$( ".ui-tabs" ).bind( "tabsselect", function(event, ui) 
	{
		$(".fast_confirm").each (function ()
		{
			$(this).hide();
		});
	});
	
	{/literal}{if !isset($Globals.ActivateInfoBulles) or $Globals.ActivateInfoBulles}{literal}
		var theme = "light";
	
		$('a.tTip').each (function ()
		{
			$(this).tinyTips(theme, $(this).attr ("tip"));
		});
		$('a.imgTip').each (function ()
		{
			$(this).tinyTips(theme, $(this).attr ("tip"));
		});
		$('img.tTip').each (function ()
		{
			$(this).tinyTips(theme, $(this).attr ("tip"));
		});
		$('input.tTip').each (function ()
		{
			$(this).tinyTips(theme, $(this).attr ("tip"));
		});
		$('div.tTip').each (function ()
		{
			$(this).tinyTips(theme, $(this).attr ("tip"));
		});
		$('tr.tTip').each (function ()
		{
			$(this).tinyTips(theme, $(this).attr ("tip"));
		});
		$('td.tTip').each (function ()
		{
			$(this).tinyTips(theme, $(this).attr ("tip"));
		});
		$('h1.tagline').each (function ()
		{
			$(this).tinyTips(theme, $(this).attr ("tip"));
		});
	{/literal}{/if}{literal}
	
	// Permet de supplanter les erreurs de dataTable sur les colspan...
	$("td.rowOK").each (function ()
	{
		$(this).attr ("colspan", $(this).attr ("nbcolumns"));
		var className = $(this).attr ("class");
		$(this).attr ("class", className + " group");
	});
	$("td.rowOK_invisible").remove ();
	
	SetSessionInfo ("EOJ", 1);
});
</script>
{/literal}
</body>  
</html>  