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
            $("#id_compte").val($(this).attr ("id_compte"));
            $("#nom").val($(this).attr ("nom_user"));
            $("#prenom").val( $(this).attr ("prenom_user") );
            $("#email").val($(this).attr ("email_user"));
            $("#login").val( $(this).attr ("login") );

            $("#editPasswordCompteUtilisateur").show("slow");
//			update_content ("ajax/popups/edit_compte_utilisateur_password.php", "popup", "id_compte=" + $(this).attr ("id_compte"));
//			ShowPopupHeight (550);
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
                        <img src="css/images/edit.png" title="modifier le mot de passe" border="0" class="edit_compte_utilisateur_password" style="cursor: pointer;" id_compte="<?=$obj ["idt_users"]; ?>" nom_user="<?=$obj ["nom_user"];?>" prenom_user="<?=$obj ["prenom_user"];?>" email_user="<?=$obj ["email_user"];?>" login="<?=$obj ["login"];?>" />
                    <?php }?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>