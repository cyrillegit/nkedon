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
                <div class="title"><strong>Historiques </strong> <strong style="color:black;"> du magasin</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">L'administration du magasin est un espace reservé aux personnes abilités à se connecter sur cette partie, pour créer et mettre à jour les informations utiles pour le bon fonctionnement du magasin.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle">Gérez votre magasin en cliquant sur un des liens ci-dessous :</span></strong></em>
        <div>
            <br />
            <ul class="my_account">
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="historiques.php?sub=historiques_factures" style="color:white;"><div class="btn_histo_facture"></div><div>Historiques des factures</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="administration_magasin.php?sub=groupes_factures" style="color:white;"><div class="btn_histo_facture"></div><div>Historiques des journaux</div></a></li><br/>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="administration_magasin.php?sub=historique_syntheses" style="color:white;"><div class="btn_histo_synthese"></div><div>Historiques des synthéses</div></a></li>
                {if $smarty.session.infoUser.id_type_user <= 4}
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="administration_magasin.php?sub=statistiques" style="color:white;"><div class="btn_statistique"></div><div>Afficher les statistiques</div></a></li>
                {/if}              
            </ul>
        </div>
    </div>
</div>
{include file="common/footer.tpl"}