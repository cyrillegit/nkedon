<?php
/**
	Fichier GetTableauTypesAnomalies.php
	-----------------------------------
	Ce fichier crée un tableau contenant les types d'anomalies présentes en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$output = "";
$db = new Database ();

$datas = $db->getAllTypesAnomalies ();
?>
<script language="javascript">
$(document).ready (function ()
{
	$(".edit_type_anomalie").each (function ()
	{
		$(this).click (function ()
		{
			update_content ("ajax/popups/edit_type_anomalie.php", "popup", "id_type_anomalie=" + $(this).attr ("id_type_anomalie"));
			ShowPopupHeight (550);
		});
	});
});
</script>
<table class="tablesorter" style="width: 100%;" border="0" id="tableau_types_anomalies">
	<thead>
    	<tr>
            <th>Nom du type d'anomalie</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if( count( $datas ) > 0)
        {
            foreach( $datas as &$obj )
            {
                $nom_type_anomalie = $obj ["description"];
                ?>
                <tr>
                    <td align="center"><?php echo $nom_type_anomalie; ?></td>
                    <td align="center">
                        <img src="css/images/page_white_edit.png" border="0" class="edit_type_anomalie" style="cursor: pointer;" id_type_anomalie="<?=$obj ["idt_types_anomalies"]; ?>" />
                        <a class="delete_link" url="delete.php?target=type_anomalie&id=<?=$obj["idt_types_anomalies"]; ?>"><img src="css/images/supprimer.png" border="0" /></a>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>