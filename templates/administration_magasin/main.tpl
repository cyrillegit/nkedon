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
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="administration_magasin.php?sub=produits" style="color:white;"><div class="btn_produit"></div><div>Ajouter / Modifer un produit</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="administration_magasin.php?sub=fournisseurs" style="color:white;"><div class="btn_fournisseur"></div><div>Ajouter / modifier un fournisseur</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="administration_magasin.php?sub=factures" style="color:white;"><div class="btn_facture"></div><div>Ajouter / Modifier une facture</div></a></li><br/>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="administration_magasin.php?sub=operations_journal" style="color:white;"><div class="btn_journal"></div><div>Réaliser le journal</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="administration_magasin.php?sub=inventaire" style="color:white;"><div class="btn_inventaire"></div><div>Réaliser l'inventaire du magasin</div></a></li><br/>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="administration_magasin.php?sub=groupes_factures" style="color:white;"><div class="btn_histo_facture"></div><div>Historiques des factures</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="administration_magasin.php?sub=groupes_factures" style="color:white;"><div class="btn_histo_facture"></div><div>Historiques des journaux</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="administration_magasin.php?sub=historique_syntheses" style="color:white;"><div class="btn_histo_synthese"></div><div>Historiques des synthéses</div></a></li><br/>
                {if $smarty.session.infoUser.id_type_user <= 4}
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="administration_magasin.php?sub=statistiques" style="color:white;"><div class="btn_statistique"></div><div>Afficher les statistiques</div></a></li>
                {/if}              
            </ul>
        </div>
    </div>
</div>
{include file="common/footer.tpl"}