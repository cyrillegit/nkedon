{include file="common/header.tpl"}
{literal}
<script language="javascript">
$(document).ready (function ()
{


});
</script>
{/literal}
<div id="Content">
	<div class="bloc_title">
        <div class="alerte">&nbsp;</div><br/>
        <div style="width: 990px; height: 51px; border-bottom: 1px solid #fff; float:left;">
			<div class="ico_title"><img src="css/images/ico_42x42/menu_consult.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Statistiques </strong> <strong style="color:black;"> du magasin</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">Les statistiques du magasin est un espace reservé aux personnes abilités à se connecter sur cette partie.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle">Visualisez les statistiques en cliquant sur un des liens ci-dessous :</span></strong></em>
        <div>
            <br />
            <ul class="my_account">
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="statistiques.php?sub=stats_fournisseurs_factures" style="color:white;"><div class="btn_statistique"></div><div style="text-align: center; margin: 15px;">Factures par fournisseurs</div></a></li><br/>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="statistiques.php?sub=stats_factures_achats" style="color:white;"><div class="btn_statistique"></div><div style="text-align: center; margin: 15px;">Factures d'achats <br/> du mois courant</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="statistiques.php?sub=stats_factures_ventes" style="color:white;"><div class="btn_statistique"></div><div style="text-align: center; margin: 15px;">Factures de ventes du mois courant</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="statistiques.php?sub=stats_operations_journal" style="color:white;"><div class="btn_statistique"></div><div style="text-align: center; margin: 15px;">Journaux <br/> du mois courant</div></a></li><br/>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="statistiques.php?sub=stats_recapitulatifs" style="color:white;"><div class="btn_statistique"></div><div style="text-align: center; margin: 15px;">Evolution des recapitulatifs</div></a></li>
            </ul>
        </div>
    </div>
</div>
{include file="common/footer.tpl"}