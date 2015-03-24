<?php
/**
	Fichier GetTableauTypesUtilisateurs.php
	-----------------------------------
	Ce fichier crée un tableau contenant les profils utilisateurs présents en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

$datas = $db->getAllTypesUsersWithoutAdmin ();
?>
<script language="javascript">
$(document).ready (function ()
{
	$(".edit_type_user").each (function ()
	{
		$(this).click (function ()
		{
            $("#id_type_user").val($(this).attr ("id_type_user"));
            $("#nom_type_user").val( $(this).attr ("nom_type_user") );
            $("#editTypeUser").slideToggle("fast");
//			update_content ("ajax/popups/edit_type_user.php", "popup", "id_type_user=" + $(this).attr ("id_type_user"));
//			ShowPopupHeight (300);
		});
	});
});
</script>
<table class="tablesorter" style="width: 100%;" border="0" id="tableau_types_users">
	<thead>
    	<tr>
            <th>Nom du profil utilisateur</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if( count( $datas ) > 0)
        {
            foreach( $datas as &$obj )
            {
                $nom_type_user = $obj ["nom_type_user"];
                ?>
                <tr>
                    <td align="center"><?php echo $nom_type_user; ?></td>
                    <td align="center">
                    <?php if($_SESSION ["infoUser"]["idt_types_users"] == 1 || $_SESSION ["infoUser"]["idt_types_users"] == 2){?>
                        <img src="css/images/edit.png" border="0" title="modifier" class="edit_type_user" style="cursor: pointer; margin: 1px;" id_type_user="<?=$obj ["idt_types_users"]; ?>" nom_type_user="<?=$obj ["nom_type_user"]; ?>"/>
                        <a class="delete_link" style="margin: 1px;" title="supprimer" url="delete.php?target=type_user&id=<?=$obj["idt_types_users"]; ?>"><img src="css/images/delete.png" border="0" /></a>
                    <?php }?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>