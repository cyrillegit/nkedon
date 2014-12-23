<?php
/**
	Fichier GetTableauComptesUtilisateurs.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations des comptes utilisateurs présents en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

$datas = $db->getAllComptesUtilisateursWithoutAdmin ();
?>
<script language="javascript">
$(document).ready (function ()
{
	$(".edit_compte_utilisateur_password").each (function ()
	{
		$(this).click (function ()
		{
			update_content ("ajax/popups/edit_compte_utilisateur_password.php", "popup", "id_compte=" + $(this).attr ("id_compte"));
			ShowPopupHeight (550);
		});
	});
});
</script>
<table class="tablesorter" style="width: 100%;" border="0" id="tableau_comptes_utilisateurs">
	<thead>
    	<tr>
        	<th>Nom Prénom</th>
        	<th>Email</th>
            <th>Informations civiles</th>
            <th>Profil utilisateur</th>
            <th>Login</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if( count( $datas ) > 0)
        {
            foreach( $datas as &$obj )
            {
                $infosUser = $db->GetInfoUser ( $obj ["idt_users"] );
                ?>
                <tr>
                    <td align="center"><?php echo $infosUser["nom_user"]." ".$infosUser["prenom_user"]; ?></td>
                    <td align="center"><?php echo $infosUser["email_user"]; ?></td>
                    <td align="center"><?php echo $infosUser["adresse_user"]; ?></td>
                    <td align="center"><?php echo $infosUser["nom_type_user"]; ?></td>
                    <td align="center"><?php echo $infosUser["login"]; ?></td>
                    <td align="center">
                    <?php if($_SESSION ["infoUser"]["idt_types_users"] == 1 || $_SESSION ["infoUser"]["idt_types_users"] == 2){?>
                        <img src="css/images/page_white_edit.png" title="modifier le mot de passe" border="0" class="edit_compte_utilisateur_password" style="cursor: pointer;" id_compte="<?=$obj ["idt_users"]; ?>" />
                    <?php }?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>