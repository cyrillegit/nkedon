<?php
/**
	Fichier GetTableauDatePeremptionProduits.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations des dates de peremption des produits en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();
isset( $_POST ["time_peremption"] ) ? $time_peremption = addslashes(htmlspecialchars($_POST ["time_peremption"])) : $time_peremption = "";

if( $time_peremption != "all" && $time_peremption != "" )
{
    $duration = explode( "_", $time_peremption );
    $stop_date = date('Y-m-d H:i:s', strtotime( setLocalTime() .' + '.$duration[0].' '.$duration[1] ) );
    $stop_date = explode(" ", $stop_date)[0];
}
else
    $stop_date = "";

$datas = $db->getAllProduitsWithDatePeremption ( $stop_date );
?>
<script language="javascript">
$(document).ready (function ()
{
	$(".edit_produit").each (function ()
	{
		$(this).click (function ()
		{
			update_content ("ajax/popups/edit_produit.php", "popup", "id_produit=" + $(this).attr ("id_produit"));
			ShowPopupHeight (550);
		});
	});
});
</script>
<table class="tablesorter" style="width: 100%;" border="0" id="tableau_produits">
	<thead>
    	<tr>
        	<th>Désignation du produit</th>
            <th>Numéro facture</th>
            <th>Nom fournisseur</th>
            <th>Date fabrication</th>
            <th>Date peremption</th>
            <th>Péremption dans</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if( count( $datas ) > 0)
        {
            foreach( $datas as &$obj )
            {
                $peremption = getElaspedDateTime( setLocalTime(), $obj["date_peremption"]." 00:00:00" );
                $split_date = explode( " ", $peremption );
                if( $split_date[0] <=0 )
                { 
                    $peremption = "<span style='color:#FF0000;'><strong>Périmé</strong></span>";
                }
                elseif ( $split_date[1] == "semaines" ) 
                {
                    $peremption = "<span style='color:#A52A2A;'><strong>".$peremption."</strong></span>";
                }
                elseif ( $split_date[1] == "semaine" || $split_date[1] == "jours" || $split_date[1] == "jour" ) 
                {
                    $peremption = "<span style='color:#FFA500;'><strong>".$peremption."</strong></span>";
                }
                else
                {
                    $peremption = "<span style='color:#000000;'><strong>".$peremption."</strong></span>";
                }
                ?>
                <tr>
                    <td align="center"><?php echo $obj["nom_produit"]; ?></td>
                    <td align="center"><?php echo $obj["numero_facture"]; ?></td>
                    <td align="center"><?php echo $obj["nom_fournisseur"]; ?></td>
                    <td align="center"><?php echo SQLDateToFrenchDate( $obj["date_fabrication"] ); ?></td>
                    <td align="center"><?php echo SQLDateToFrenchDate( $obj["date_peremption"] ); ?></td>
                    <td align="center"><?php echo $peremption; ?></td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>