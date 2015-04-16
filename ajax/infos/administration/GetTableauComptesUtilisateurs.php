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
	$(".edit_compte_utilisateur").each (function ()
	{
		$(this).click (function ()
		{
            id_type_user = $(this).attr ("id_type_user");
            fetchAllTypesUsers( id_type_user );

            $("#id_compte").val($(this).attr ("id_compte"));
            $("#nom").val($(this).attr ("nom_user"));
            $("#prenom").val( $(this).attr ("prenom_user") );
            $("#email").val($(this).attr ("email_user"));
            $("#adresse").val( $(this).attr ("adresse_user") );
            $("#nom_type_user").val($(this).attr ("nom_type_user"));
            $("#id_type_user_hidden").val($(this).attr ("id_type_user"));
            $("#login").val( $(this).attr ("login") );
            $("#password").val( $(this).attr ("password") );
            $("#password").hide();
            $("#password_label").hide();

            $('html, body').animate({ scrollTop: 0 }, 'slow');
            $("#editCompteUtilisateur").show("slow");

//			update_content ("ajax/popups/edit_compte_utilisateur.php", "popup", "id_compte=" + $(this).attr ("id_compte"));
//			ShowPopupHeight (300);
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
                        <img src="css/images/edit.png" title="modifier" border="0" class="edit_compte_utilisateur" style="cursor: pointer; margin: 1px;" id_compte="<?=$obj ["idt_users"]; ?>" nom_user="<?=$obj ["nom_user"];?>" prenom_user="<?=$obj ["prenom_user"];?>" email_user="<?=$obj ["email_user"];?>" adresse_user="<?=$obj ["adresse_user"];?>" id_type_user="<?=$obj ["id_type_user"];?>" nom_type_user="<?=$obj ["nom_type_user"];?>" login="<?=$obj ["login"];?>" password="<?=$obj ["password"];?>"/>
                        <a class="delete_link" style="margin: 1px;" title="supprimer" url="delete.php?target=compte_utilisateur&id=<?=$obj["idt_users"]; ?>"><img src="css/images/delete.png" border="0" /></a>
                    <?php }?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>