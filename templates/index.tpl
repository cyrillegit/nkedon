{include file='common/header.tpl'}
{literal}
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
		    setInterval( "slideSwitch()", 5000 );

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
{/literal}
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
        	<div class="blocInfoBis" style="width: 970px;">
            	<div class="titre"><b><i>Gestion du magasin et de la production par NKEDON</i></b></div>
				<hr/>
              	<div id="slideshow">
    				<img src="assets/images/slideshow_images/img1.jpg" alt="" class="active" />

                    <img src="assets/images/slideshow_images/img2.jpg" alt="" />

                    <img src="assets/images/slideshow_images/img3.jpg" alt="" />
				</div>
            </div>
            {*<table width="100%" border="0" cellpadding="0" cellspacing="0">*}
                {*<tr>*}
                    {*<td>*}
                        {*<div id="chartContainerAchats"></div>*}
                    {*</td>*}

                    {*<td>*}
                        {*<div id="chartContainerVentes"></div>*}
                    {*</td>*}
                {*</tr>*}
            {*</table>*}
		</div>
	</div>
</div>
{include file='common/footer.tpl'}