<?php
/**
	Fichier GetTableauHistoriquesFactures.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations des factures en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

isset( $_POST ["annee"] ) ? $annee = addslashes(htmlspecialchars($_POST ["annee"])) : $annee = "";
isset( $_POST ["date_histo_journal"] ) ? $date_histo_journal = addslashes(htmlspecialchars($_POST ["date_histo_journal"])) : $date_histo_journal = "";

if(  $date_histo_journal == "" ) {
    $journal = $db->getAllJournalByAnnee( $annee );
}else{
    $mois = explode( "/", $date_histo_journal )[1];
    $journal = $db->getAllJournalByDate("", $mois, $annee );
}

if( COUNT($journal) > 0 )
{
    foreach ( $journal as &$j )
    {
        $mois = getMonthFromDate( $j["date_journal"] );
        if( isset($histo_mois[ $mois ]) ){
            $histo_mois[ $mois ] ++;
        }else{
            $histo_mois[ $mois ] = 1;
        }
    }
}

?>
<script language="javascript">
$(document).ready (function ()
{
    $(".histo_mois").each (function ()
    {
        $(this).click (function ()
        {
            document.location.href="historiques.php?sub=historiques_journal&mois="+$(this).attr("mois")+"&annee="+$(this).attr("annee");
        });
    });
});
</script>

<div style="float: left; width: 100%; font-size: 16px; padding-left: 30px; padding-top: 30px;"><em><strong><span class="adminSubtitle">Accedez à l'historique des journaux d'un mois de année en cliquant sur un des liens ci-dessous :</span></strong></em>
    <div>
        <br />
        <ul class="my_account">
        <?php
        if( isset($histo_mois)) {
            if (count($histo_mois) > 0) {
                $count = 0;
                foreach ($histo_mois as $index => $value) {
                    $count++;
                    ?>
                    <li class="button hvr-buzz-out hvr-bounce-to-right histo_mois" mois="<?= $index; ?>" annee="<?= $annee; ?>">
                        <a style="color:white;">
                            <div class="btn_folder"></div>
                            <div style="margin: 10px;">
                                <b><?php echo getLitterateMonth($index)." ".$annee."<br/><br/>"; ?></b>
                                <b style="color: #000000;"><?php echo $value; if($value <= 1 ) echo " journal"; else echo " journaux"; ?></b>
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
