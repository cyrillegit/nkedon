<?php
/**
	Fichier GetTableauRecapitulatifInventaire.php
	-----------------------------------
	Ce fichier crée un tableau contenant les informations de l'inventaire en base de données.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

isset( $_POST ["date_histo_synthese"] ) ? $date_histo_synthese = addslashes(htmlspecialchars($_POST ["date_histo_synthese"])) : $date_histo_synthese = "";

if($date_histo_synthese == "")
{
    $histo_syntheses = $db->getHistoriqueSynthese();
}
else
{
    $histo_syntheses = $db->getHistoriqueSyntheseByDate(FrenchDateToSQLDate($date_histo_synthese));
}

?>
<script language="javascript">
$(document).ready (function ()
{

});

</script>
    <div style="width: 100%;">
        <form name="form_popup" id="form_popup" method="post">

        <style type="text/css">
            .blocInfoSuccess
            {
                background-image: url("css/images/bg_bloc_alertes.png");
                background-repeat: repeat;
                background-color: green;
                width: 50px;
                font-size: 28px;
                text-align: center;
                border: 1px solid #313131;
                padding: 5px 5px 5px;
            }

            .blocInfoFailed
            {
                background-image: url("css/images/bg_bloc_alertes.png");
                background-repeat: repeat;
                background-color: red;
                width: 50px;
                font-size: 28px;
                text-align: center;
                border: 1px solid #313131;
                padding: 5px 5px 5px;
            }

        </style>

            <table cellspacing="2" cellpadding="2" width="100%">
                <?php
                if($ok)
                {
                ?>
                <tr class="blocInfoSuccess">
                    <td>
                        La synthése de l'inventaire s'est déroulée avec succés
                    </td>
                </tr>
                <?php
                }
                else
                {
                ?>
                <tr class="blocInfoFailed">
                    <td>
                        La synthése de l'inventaire a échoué
                    </td>
                </tr>
                <?php  
                }
                ?>
            </table>
        </form>
    </div> <br /> 