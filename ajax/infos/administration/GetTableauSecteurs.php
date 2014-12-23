<?php
/**
	Fichier GetTableauSecteurs.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations des secteurs présents en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$output = "";
$db = new Database ();

$datas = $db->getAllSecteurs ();
?>
<script language="javascript">
$(document).ready (function ()
{
	$(".edit_secteur").each (function ()
	{
		$(this).click (function ()
		{
			update_content ("ajax/popups/edit_secteur.php", "popup", "id_secteur=" + $(this).attr ("id_secteur"));
			ShowPopupHeight (550);
		});
	});
});
</script>
<table class="tablesorter" style="width: 100%;" border="0" id="tableau_secteurs">
	<thead>
    	<tr>
        	<th>Secteur</th>
            <th>Description du secteur</th>
            <th>Client associé</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if( count( $datas ) > 0)
        {
            foreach( $datas as &$obj )
            {
                $nom_secteur = $obj ["nom_secteur"];
                $description_secteur = $obj ["description"];
                $nom_client_associe_au_secteur = $db->getClientAssocSecteurFromId ( $obj ["idt_secteurs"] );
                if( $nom_client_associe_au_secteur == NULL )
                    $nom_client_associe_au_secteur = "<font color='red'><b>Aucun client associé à ce secteur.</b></font>";
                ?>
                <tr>
                    <td align="center"><?php echo $nom_secteur; ?></td>
                    <td align="center"><?php echo $description_secteur; ?></td>
                    <td align="center"><?php echo $nom_client_associe_au_secteur; ?></td>
                    <td align="center">
                        <img src="css/images/page_white_edit.png" border="0" class="edit_secteur" style="cursor: pointer;" id_secteur="<?=$obj ["idt_secteurs"]; ?>" />
                        <a class="delete_link" url="delete.php?target=secteur&id=<?=$obj["idt_secteurs"]; ?>"><img src="css/images/supprimer.png" border="0" /></a>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>