{include file='common/header.tpl'}
{literal}
<script language="javascript">

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
		$(function() {
		    setInterval( "slideSwitch()", 5000 );
		});

	});
</script>
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
		<br/>
        <div id="mainCenter">
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
        	<div class="blocInfoBis" style="width: 970px;">
            	<div class="titre"><b><i>Gestion du magasin et de la production par NKEDON</i></b></div>
				<hr/>
              	<div id="slideshow">
    				<img src="assets/images/slideshow_images/img1.jpg" alt="" class="active" />
    				<img src="assets/images/slideshow_images/img2.jpg" alt="" />
    				<img src="assets/images/slideshow_images/img3.jpg" alt="" />
				</div>
            </div>			
		</div>
	</div>
</div>
{include file='common/footer.tpl'}