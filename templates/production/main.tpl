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
                <div class="title"><strong>Gestion général </strong> <strong style="color:black;"> de la production</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">L'administration de la production est un espace reservé aux personnes abilités à se connecter sur cette partie, pour créer et mettre à jour les informations utiles pour le bon fonctionnement de la production.<br/><br/></div>
	
    <div style="clear: both;"></div>

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle">Gérez votre production en cliquant sur un des liens ci-dessous :</span></strong></em>
        <div>
            <br />
            <ul class="my_account">
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="production.php?sub=matieres_premieres" style="color:white;"><div class="btn_produit"></div><div style="text-align: center; margin: 15px;">Ajouter / Modifer une matiére première</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="production.php?sub=portions_journalieres" style="color:white;"><div class="btn_produit"></div><div style="text-align: center; margin: 15px;">Ajouter / Modifer une portion journaliére</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="production.php?sub=produits_confectionnes" style="color:white;"><div class="btn_produit"></div><div style="text-align: center; margin: 15px;">Ajouter / Modifer un produit confectionné</div></a></li><br/>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="production.php?sub=fournisseurs" style="color:white;"><div class="btn_fournisseur"></div><div style="text-align: center; margin: 15px;">Ajouter / modifier un fournisseur</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="production.php?sub=factures_achats" style="color:white;"><div class="btn_facture"></div><div style="text-align: center; margin: 15px;">Enregistrer une facture d'achat</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="production.php?sub=factures_ventes" style="color:white;"><div class="btn_facture"></div><div style="text-align: center; margin: 15px;">Etablir une facture de vente</div></a></li><br/>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="production.php?sub=operations_journal" style="color:white;"><div class="btn_journal"></div><div style="text-align: center; margin: 15px;">Réaliser le journal</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="production.php?sub=inventaire" style="color:white;"><div class="btn_inventaire"></div><div style="text-align: center; margin: 15px;">Réaliser l'inventaire du magasin</div></a></li>
            </ul>
        </div>
    </div>
</div>
{include file="common/footer.tpl"}