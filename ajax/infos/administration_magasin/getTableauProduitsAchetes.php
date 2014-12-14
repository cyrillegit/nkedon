<?php
/**
    Fichier GetTableauProduitsAchetes.php
    -----------------------------------
    Ce fichier crée un tableau contenant les informations des produits présents en base de données.
*/
@session_start();
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");
@require_once("../../../include/ClassMail.php");

@session_start();
$db = new Database ();
$db->beginTransaction ();

    isset( $_POST ["nom_produit"] ) ? $nom_produit = strtoupper(addslashes(htmlspecialchars($_POST ["nom_produit"]))) : $nom_produit = "";
    isset( $_POST ["quantite_achat"] ) ? $quantite_achat = addslashes(htmlspecialchars($_POST ["quantite_achat"])) : $quantite_achat = "";
    isset( $_POST ["date_fabrication"] ) ? $date_fabrication = addslashes(htmlspecialchars($_POST ["date_fabrication"])) : $date_fabrication = "";
    isset( $_POST ["date_peremption"] ) ? $date_peremption = addslashes(htmlspecialchars($_POST ["date_peremption"])) : $date_peremption = "";

    if($nom_produit != NULL && $quantite_achat != NULL)
    {
        $infos = $db->getInfosProduitsAchetes($nom_produit);
        if($infos != NULL)
        {
            $id_produit = $infos["idt_produits"];
            if($date_fabrication != "")
            {
                $ok &= validateDate($date_fabrication);
            }
            else
            {
                $date_fabrication = "00/00/0000";
            }

            if($date_peremption != "")
            {
                $ok &= validateDate($date_peremption);
            }
            else
            {
                $date_peremption = "00/00/0000";
            }

            $date_fabrication = FrenchDateToSQLDate($date_fabrication);
            $date_peremption = FrenchDateToSQLDate($date_peremption);

        //    if(strtotime($date_fabrication) <= strtotime($date_peremption))
        //    {
                $sql = "INSERT INTO t_produits_factures(
                                id_produit,
                                quantite_achat,
                                date_fabrication,
                                date_peremption)
                        VALUES ('$id_produit',
                                '$quantite_achat',
                                '$date_fabrication',
                                '$date_peremption')";

             //   echo $sql;

                if( $db->Execute ( $sql ) )
                {
                    $db->commit ();
                }
                else
                {
                    $db->rollBack();
                }
        //    }
        }
        else
        {

        }
    }
    else
    {

    }

$datas = $db->getInfosFactureEnCours ();
?>
<script language="javascript">
$(document).ready (function ()
{
    $(".edit_produit_achete").each (function ()
    {
        /*
        $(this).click (function ()
        {
            update_content ("ajax/popups/edit_produit_achete.php", "popup", "id_produit_achete=" + $(this).attr ("id_produit_achete"));
            ShowPopupHeight (550);
        });
        //*/
    });
});
</script>
<table class="tablesorter" style="width: 100%;" border="0" id="tableau_produits">
    <thead>
        <tr>
            <th>Désignation du produit</th>
            <th>Quantité achetée</th>
            <th>Date de fabrication</th>
            <th>Date de péremption</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if( count( $datas ) > 0)
        {
            foreach( $datas as &$obj )
            {
                ?>
                <tr>
                    <td align="center"><?php echo $obj["nom_produit"]; ?></td>
                    <td align="center"><?php echo $obj["quantite_achat"]; ?></td>
                    <td align="center"><?php echo SQLDateToFrenchDate($obj["date_fabrication"]); ?></td>
                    <td align="center"><?php echo SQLDateToFrenchDate($obj["date_peremption"]); ?></td>
                    <td align="center">
                    <?php if($_SESSION ["infoUser"]["idt_types_users"] <= 3){?>
                        <img src="css/images/page_white_edit.png" title="modifier" border="0" class="edit_produit_achete" style="cursor: pointer;" id_produit_achete="<?=$obj ["idt_produits_factures"]; ?>" />
                        <a class="delete_link" title="supprimer" url="delete.php?target=edit_produit_achete&id=<?=$obj["idt_produits_factures"]; ?>"><img src="css/images/supprimer.png" border="0" /></a>
                    <?php }?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>