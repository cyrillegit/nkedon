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
			<div class="ico_title"><img src="css/images/ico_42x42/menu_fdr_0.png" /></div>
            <div class="t_titre">
                <div class="title"><strong>Gestion général </strong> <strong style="color:black;"> du magasin</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">L'administration du magasin est un espace reservé aux personnes abilités à se connecter sur cette partie, pour créer et mettre à jour les informations utiles pour le bon fonctionnement du magasin.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle">Gérez votre magasin en cliquant sur un des liens ci-dessous :</span></strong></em>
        <div>
            <br />
            <ul class="my_account">
                <li><a href="administration_magasin.php?sub=produits" style="color:white;">Ajouter / Modifer un produit.</a></li>
                <li><a href="administration_magasin.php?sub=factures" style="color:white;">Ajouter / Modifier une facture.</a></li>
                <li><a href="administration_magasin.php?sub=fournisseurs" style="color:white;">Ajouter / modifier un fournisseur.</a></li>
                <li><a href="administration_magasin.php?sub=inventaire" style="color:white;">Réaliser l'inventaire du magasin.</a></li>
                <li><a href="administration_magasin.php?sub=groupes_factures" style="color:white;">Historiques des factures</a></li>
                <li><a href="administration_magasin.php?sub=historique_syntheses" style="color:white;">Afficher l'historique des synthéses.</a></li>  
                {if $smarty.session.infoUser.id_type_user <= 4}
                <li><a href="administration_magasin.php?sub=statistiques" style="color:white;">Afficher les statistiques.</a></li> 
                {/if}              
            </ul>
        </div>
    </div>
</div>
{include file="common/footer.tpl"}