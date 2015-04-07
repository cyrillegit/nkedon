<?php /* Smarty version Smarty-3.1.14, created on 2015-04-07 22:03:42
         compiled from ".\templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:78352eba7b1662c86-76128190%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '749422d4cfc3eb5677cf499730392b6accd4d1c7' => 
    array (
      0 => '.\\templates\\index.tpl',
      1 => 1428444220,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '78352eba7b1662c86-76128190',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52eba7b16f8a44_37825025',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52eba7b16f8a44_37825025')) {function content_52eba7b16f8a44_37825025($_smarty_tpl) {?>﻿<?php echo $_smarty_tpl->getSubTemplate ('common/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script language="javascript">

    function RefreshXMLAchats()
    {
        var responseText = $.ajax({
            type    : "POST",
            url     : "ajax/infos/statistiques/GetXMLAchats.php",
            async   : false,
            data    : "",
            success : function (msg){}
        }).responseText;
        $("#chartContainerAchats").empty ().html (responseText);
    }

    function RefreshXMLVentesJournal()
    {
        var responseText = $.ajax({
            type    : "POST",
            url     : "ajax/infos/statistiques/GetXMLVentesJournal.php",
            async   : false,
            data    : "",
            success : function (msg){}
        }).responseText;
        $("#chartContainerVentes").empty ().html (responseText);
    }

	function slideSwitch() 
	{
	    var $active = $('#slideshow IMG.active');

	    if ( $active.length == 0 ) $active = $('#slideshow IMG:last');

	    var $next =  $active.next().length ? $active.next()
	        : $('#slideshow IMG:first');

	    $active.addClass('last-active');
	        
	    $next.css({opacity: 0.0})
	        .addClass('active')
	        .animate({opacity: 1.0}, 1000, function() {
	            $active.removeClass('active last-active');
	        });
	}

	$(document).ready (function ()
	{
        RefreshXMLAchats();
        RefreshXMLVentesJournal();

		$(function() {
		//    setInterval( "slideSwitch()", 5000 );

            $('#container').highcharts({
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Fruit Consumption'
                },
                xAxis: {
                    categories: ['Apples', 'Bananas', 'Oranges']
                },
                yAxis: {
                    title: {
                        text: 'Fruit eaten'
                    }
                },
                series: [{
                    name: 'Jane',
                    data: [1, 0, 4]
                }, {
                    name: 'John',
                    data: [5, 7, 3]
                }]
            });
		});

	});
</script>
    <style type="text/css">
        .blocInfoBis
        {
            background-image: url("css/images/bg_bloc_alertes.png");
            background-repeat: repeat;
            border: 1px solid #313131;
            padding: 5px 10px 10px;
        }

        #slideshow
        {
            position:relative;
            height:350px;
        }

        #slideshow IMG
        {
            position:absolute;
            top:0;
            left:0;
            z-index:8;
        }

        #slideshow IMG.active
        {
            z-index:10;
        }

        #slideshow IMG.last-active
        {
            z-index:9;
        }
    </style>

<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_tb.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>NKedon -</strong> <strong style="color:black;">- gestion du magasin et de la production </strong></div>
            </div>
        </div>
  	</div>

	<div class="intro">
	Bienvenue sur votre nouveau BackOffice Nkedon.
	</div>
	<div id="main">
        <div id="mainCenter">
        	
            	
				
              	
    				
    				
    				
				
            
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <div id="chartContainerAchats"></div>
                    </td>

                    <td>
                        <div id="chartContainerVentes"></div>
                    </td>
                </tr>
            </table>
		</div>
	</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ('common/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>