<?php
/**
	Fichier GetTableauClients.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations des clients présents en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$output = "";
$db = new Database ();

$datas = $db->getAllClients ();
if( count( $datas ) > 0 )
{
    foreach( $datas as &$obj )
    {
        $usersAssoc = $db->getAllUsersAssocClients ( $obj ["idt_clients"] );
        $obj ["users"] = $usersAssoc;
    }
}
?>
<script language="javascript">
$(document).ready (function ()
{
	$(".edit_client").each (function ()
	{
		$(this).click (function ()
		{
			update_content ("ajax/popups/edit_client.php", "popup", "id_client=" + $(this).attr ("id_client"));
			ShowPopupHeight (550);
		});
	});
});
</script>
<table class="tablesorter" style="width: 100%;" border="0" id="tableau_clients">
	<thead>
    	<tr>
            <th>Nom du client</th>
            <th>Utilisateurs associés</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if( count( $datas ) > 0)
        {
            foreach( $datas as &$obj )
            {
                $nom_client = $obj ["nom_client"];
                ?>
                <tr>
                    <td align="center"><?php echo $nom_client; ?></td>
                    <td align="center">
                        <?php
                        if( isset( $obj ["users"] ) && count( $obj ["users"]) > 0)
                        {
                            foreach( $obj ["users"] as $u )
                                echo "- " . $u ["nom"] . " " . $u ["prenom"] . " (" . $u ["nom_type"] . ")<br/>";
                        }
                        else
                        {
                            echo "<font color='red'><b>Seul les admins sont associés à ce client.</b></font>";
                        }
                        ?>
                    </td>
                    <td align="center">
                        <img src="css/images/page_white_edit.png" border="0" class="edit_client" style="cursor: pointer;" id_client="<?=$obj ["idt_clients"]; ?>" />
                        <a class="delete_link" url="delete.php?target=client&id=<?=$obj["idt_clients"]; ?>"><img src="css/images/supprimer.png" border="0" /></a>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>