<?php
/**
	Fichier GetTableauHistoriquesFacturesVentes.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations des factures en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

$factures = $db->getAllFacturesVentes();
if( COUNT($factures) > 0 )
{
    foreach ( $factures as &$facture )
    {
        $annee = getYearFromDate( $facture["date_facture"] );
        if( isset($histo_annee[ $annee ]) ){
            $histo_annee[ $annee ] ++;
        }else{
            $histo_annee[ $annee ] = 1;
        }
    }
}

?>
<script language="javascript">
$(document).ready (function ()
{
    $(".histo_annee").each (function ()
    {
        $(this).click (function ()
        {
            document.location.href="historiques.php?sub=historiques_factures_ventes&annee="+$(this).attr("annee");
        });
    });
});
</script>

<div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle">Accedez à l'historique des factures de ventes d'une année en cliquant sur un des liens ci-dessous :</span></strong></em>
    <div>
        <br />
        <ul class="my_account">
        <?php
        if(isset($histo_annee)) {
            if (count($histo_annee) > 0) {
                $count = 0;
                foreach ($histo_annee as $index => $value) {
                    $count++;
                    ?>
                    <li class="button hvr-buzz-out hvr-bounce-to-right histo_annee" annee="<?= $index; ?>">
                        <a style="color:white;">
                            <div class="btn_folder"></div>
                            <div style="margin: 10px;">
                                <b><?php echo $index . "<br/><br/>"; ?></b>
                                <b style="color: #000000;"><?php echo $value; if($value <= 1 ) echo " facture"; else echo " factures"; ?></b>
                            </div>
                        </a>
                    </li>
                    <?php if ($count % 4 == 0) { echo "<br/>"; } ?>
                <?php
                }
            }
        }
        ?>
        </ul>
    </div>
</div>
<br />
