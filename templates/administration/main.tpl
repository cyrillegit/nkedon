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
                <div class="title"><strong>Paramétrage</strong> <strong style="color:black;">général du backoffice</strong></div>
            </div>
        </div>
  	</div>

    <div class="intro">L'administration est un espace reservé aux personnes abilités à se connecter sur cette partie, pour créer et maintenir à jour les informations utiles pour le bon fonctionnement du site.<br/><br/></div>
	
    <div style="clear: both;"></div>
    

    <div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle">Gérez votre BackOffice en cliquant sur un des liens ci-dessous :</span></strong></em>
        <div>
            <br />
            <ul class="my_account">
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="administration.php?sub=comptes_utilisateurs" style="color:white; list-style-image:     url(css/images/li_ul_my_account_old.png);"><div class="btn_add_contact"></div><div style="text-align: center">Ajouter / Modifer un compte utilisateur</div></a></li>
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="administration.php?sub=types_comptes_utilisateurs" style="color:white;"><div class="btn_users"></div><div>Ajouter / Modifier un profil utilisateur</div></a></li>
                {if {$smarty.session.infoUser.id_type_user eq 1} or {$smarty.session.infoUser.id_type_user eq 2}}
                <li class="button hvr-buzz-out hvr-bounce-to-right "><a href="administration.php?sub=password_oublie" style="color:white;"><div class="btn_password"></div><div>Mot de passe oublié</div></a></li>
                {/if}
            </ul>
        </div>
    </div>
</div>
{include file="common/footer.tpl"}