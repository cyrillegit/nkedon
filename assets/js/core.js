/***************************/
//@Author: Adrian "yEnS" Mato Gondelle & Ivan Guardado Castro
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

//OS elements
var main = $("#main");
var taskbar = $("#taskbar");
var clock = $("#clock");
var trash = $("#trash");
var icons = $(".icon");

//Mouse status
var mouseDiffY = 0;
var mouseDiffX = 0;
var mouseActiveIcon = 0;
var mouseActiveCloneIcon = 0;

//update clock function
function updateClock(){
	var now = new Date();
	var hour = now.getHours();
	if(hour < 10) hour = "0" + hour;
    var mins = now.getMinutes();
	if(mins < 10) mins = "0" + mins;
    var secs = now.getSeconds();
	if(secs < 10) secs = "0" + secs;
	//print the current time in the clock division
	clock.html(hour + " : " + mins + " : " + secs);
	//recursive call
    setTimeout("updateClock()", 1000);
}

function updateContent (container, type)
{
	var responseText = "kqsfdlqfkq";
	
	container.html (responseText);
}

$(document).ready(function(){
	//cancel context menu
	$(document).bind("contextmenu",function(e){
		return false;
	});
	
	//show icons
	trash.css({'top':(main.height()) - (128 + taskbar.height()), 'left':main.width() - 128});
	icons.fadeIn(1500);
	taskbar.slideDown();
	
	icons.each(function()
	{
		var posX = $.cookie('cook-'+$(this).attr('id')+'X');
		var posY = $.cookie('cook-'+$(this).attr('id')+'Y');
		if (posX && posY)
			$(this).css({'top' : posY+"px", 'left' : posX+"px"});
	});
	
	//show current time
	updateClock();
	
	//mouse click
	icons.mousedown(function(e){
		//only accepts left click; all navs uses 0 but IE uses 1 lol...
		if(e.button <= 1){
			//calculate differences when user clicks the icon
			mouseDiffY = e.pageY - this.offsetTop;
			mouseDiffX = e.pageX - this.offsetLeft;
			if(mouseActiveIcon !=0){
				mouseActiveIcon.removeClass("active");
			}
			mouseActiveIcon = $(this);
			mouseActiveCloneIcon = mouseActiveIcon.clone(false).insertBefore(mouseActiveIcon);
		}
	});
	
	//moving mouse
	$(document).mousemove(function(e){
		if(mouseActiveIcon){
			//update position
			mouseActiveIcon.css({"top":e.pageY - mouseDiffY, "left":e.pageX - mouseDiffX, "opacity":0.35});
			var restaY = parseInt(mouseActiveIcon.css("top"));
			var restaX = parseInt(mouseActiveIcon.css("left"));
			
			// todo : save in the database the x/y coords for the widget.
			$.cookie('cook-'+mouseActiveIcon.attr('id')+'X', restaX, {expires: 36500});
			$.cookie('cook-'+mouseActiveIcon.attr('id')+'Y', restaY, {expires: 36500});
		}
	});
	
	//release mouse click
	$(document).mouseup(function(){
		if(mouseActiveIcon != 0){
			mouseActiveIcon.css({"opacity":1.0});
			mouseActiveIcon = 0;
			mouseActiveCloneIcon.remove();
			mouseActiveCloneIcon = 0;
		}
	});
	
	//mouse double click
	icons.dblclick(function()
	{
		$("<div>").qDialog({	title : $(this).text(), 
								id : this.id,
								height : $(this).attr("qHeight"),
								width : $(this).attr("qWidth")
							});
	});
	
	//custom context menu on right click
	main.mousedown(function(e)
	{
		if(e.button == 2)
		{
			/**
				Affichage du manu contextuel de base pour indiquer des informations.
			*/
			$(this).contextMenu({
					menu: 'MenuMainWindow'
				},
					function(action, el, pos) 
					{
						{
							var param = {};
							
							// On ouvre alors la qDialog qui via bien.
							if (action == "about_box")
							{
								$("<div>").qDialog({	title : "A propos de Qualiweb", 
									id : "about",
									params: param,
									height : 400,
									width : 600
								});
							}
							else
							{
								alert
								(
									'Action: ' + action + '\n\n' +
									'Element ID: ' + $(el).attr('id') + '\n\n' + 
									'X: ' + pos.x + '  Y: ' + pos.y + ' (relative to element)\n\n' + 
									'X: ' + pos.docX + '  Y: ' + pos.docY+ ' (relative to document)'
								);
							}
						}
					});
		}
	});
});

/**
	Ci-dessous, toutes les fonctions qui sont utilis&eacute;es pour la validation des diff&eacute;rentes saisies.
*/
function CheckMandatoryField (libelle, value)
{
	if (value == '')
	{
		return [false, libelle + "est obligatoire.", ""];
	}
	else
	{
		return [true, "", ""];
	}
}
function CheckTvaName (value)
{
	return CheckMandatoryField ("Le nom du taux de TVA ", value);
}
function CheckSexName (value)
{
	return CheckMandatoryField ("Le nom du sexe ", value);
}
function CheckSex(value) 
{ 
	return CheckMandatoryField ("L'abr&eacute;viation du sexe ");	
}
function CheckTva(value) 
{ 
	if(parseFloat(value) > 0 && parseFloat(value) <= 100) 
	{ 
		return [true,"",""]; 
	} 
	else 
	{ 
		return [false,"Le taux de TVA doit être compris entre 0 et 100 %",""]; 
	} 
} 
