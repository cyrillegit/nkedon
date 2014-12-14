<?php
/**
	Fichier GetTableauImei.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations des PDA enregistrés en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$output = "";
$db = new Database ();

$datas = $db->getAllPda ();
?>
<script language="javascript">
$(document).ready (function ()
{
	$(".edit_imei").each (function ()
	{
		$(this).click (function ()
		{
			update_content ("ajax/popups/edit_imei.php", "popup", "id_imei=" + $(this).attr ("id_imei"));
			ShowPopupHeight (550);
		});
	});
});
</script>
<table class="tablesorter" style="width: 100%;" border="0" id="tableau_imei">
	<thead>
    	<tr>
        	<th>Numéro IMEI</th>
        	<th>Utilisateur associé</th>
            <th>Actif ?</th>
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
                $informations_civiles = $infosUser ["nom"] . " " . $infosUser ["prenom"] . "<br/>(<font color='red'><b>" . $infosUser ["nom_type"] . "</b></font>)";
                if( $obj ["actif"] == 1)
                {
                    //$style_css = "background-color:green;color:white;font-weight:bold;font-size:17px;";
                    $class_css = "dataCellVert";
                    $actif = "OUI";
                }
                else
                {
                    //$style_css = "background-color:red;color:white;font-weight:bold;font-size:17px;";
                    $class_css = "dataCellRouge";
                    $actif = "NON";
                }
                ?>
                <tr>
                    <td align="center"><?php echo $obj ["imei"]; ?></td>
                    <td align="center"><?=$informations_civiles;?></td>
                    <td align="center" class="<?=$class_css;?>"><?=$actif;?></td>
                    <td align="center">
                        <img src="css/images/page_white_edit.png" border="0" class="edit_imei" style="cursor: pointer;" id_imei="<?=$obj ["idt_imei"]; ?>" />
                        <a class="delete_link" url="delete.php?target=imei&id=<?=$obj["idt_imei"]; ?>"><img src="css/images/supprimer.png" border="0" /></a>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>