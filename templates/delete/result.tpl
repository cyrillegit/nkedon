<style type="text/css">
#Content .wrapper .counters .countdown {
	text-align: center;
}
</style>
{include file='common/header.tpl'}
{literal}
<script type="application/javascript">
$(document).ready (function ()
{
	{/literal}{if $error eq 0}{literal}
	var Counters = $("div.wrapper div.counters");
	var TickTimeout = 3;
	
	$("div.countdown", Counters).everyTime (1000,function(i) 
	{
		if (i <= TickTimeout)
		{
			$(this).html ("Rechargement automatique de la page dans <strong>" + (TickTimeout - i) + "</strong> secondes.");
		}
		else
		{
			history.back (-1);
		}
	});
	{/literal}{/if}{literal}
});
</script>
{/literal}
<div id="Content">
  	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
		<div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
            <div class="ico_title"><img src="css/images/menu_fdr.png" width="42" height="42" style="float:left" /></div>
            
            <div class="t_titre">
                <div class="title"><strong>suppression</strong> <strong style="color:black;">d'une information</strong></div>
	        </div>
    	</div>
    </div>
    <div class="{if $error eq 0}success{else}warnings{/if}">
    {$message}
    </div>
    <br style="clear: both;" />
    {if $error eq 0}
    <div class="wrapper">
    	<div class="counters">
		    <div class="countdown">Rechargement automatique de la page dans <strong>3</strong> secondes.</div>
        </div>
    </div>
    {/if}
    {if $show_return}<br /><br /><a href="javascript:history.back();" class="std" style="font-size: 16px;">Cliquez ici pour revenir à la page précédente.</a>{/if}
</div>
{include file='common/footer.tpl'}