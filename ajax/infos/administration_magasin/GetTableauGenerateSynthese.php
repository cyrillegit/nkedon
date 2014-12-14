<?php
/**
	Fichier GetTableauGenerateSynthese.php
	-----------------------------------
	Ce fichier permet de generer la synthese de l'inventaire.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");
@require_once('../../../html2pdf/html2pdf.class.php');
@require_once("../../../include/ClassBackupDatabase.php");

$html2pdf = new HTML2PDF('L','A4','fr', false, 'ISO-8859-15', array(5, 5, 5, 5));

@session_start ();
$db = new Database ();
$db->beginTransaction ();

$ok = true;

if (!$_SESSION["connected"])
{
    // On est plus connecté, on sort.
    $ok &= false;
    $_SESSION ["sessionExpired"] = true;
    header ("Location: ../index.php");
}
else
{
    /**
        errorHandler
        ------------
        
        Fonction pour être absolument certain d'avoir une réponse enn toute circonstances, même en cas de plantage du PHP ou du serveur.
    */
    function errorHandler($n, $m, $f, $l) 
    {
        $err = error_get_last();
        if($err)
        {
            $ok &= false;
        //    echo "({'result': 'FAILED', 'message': 'Erreur interne du serveur. Le support technique en a été informé.'})";
        }
    }
    
    //register_shutdown_function('errorHandler');
    if ((!isset ($_SESSION ['infoUser'])))
    {
        $ok &= false;
    //    echo "({'result': 'FAILED', 'message': 'Erreur de sécurité. Vous êtes déconnecté.'})";
    }
    else
    {
        try
        {
            $date_synthese = setLocalTime();
            $libelle = getLitterateMonthYear( setLocalTime() );
            $sql = "INSERT INTO t_groupes_factures(
                                    libelle,
                                    nombre_factures,
                                    date_synthese)
                        VALUES('$libelle',
                                0,
                                '$date_synthese')";

            if($db->Execute ( $sql ))
            {
                $ok &= true;
            }
            else
            {
                $ok &= false;
            }

            $id_groupes_factures = $db->getLastInsertedIdInGroupesFactures();

            $directoryInventaire = "../../../downloads/Inventaire";
            if( !file_exists( $directoryInventaire ) )
            {
                mkdir( $directoryInventaire, 0777, true );
            }

            $directoryBackupDB = "../../../downloads/BackupDB";
            if(!file_exists( $directoryBackupDB ))
            {
                mkdir( $directoryBackupDB, 0777, true);
            }

            $file_inventaire = "inventaire_".str_replace("-", "", explode(" ", setLocalTime())[0])."_".str_replace(":", "", explode(" ", setLocalTime())[1]);
            $filename = $directoryInventaire."/".$file_inventaire.".html";

            if(file_exists($filename))
            {
                unlink($filename);
            }

            $head = "<!DOCTYPE html>
                    <html>
                            <style type=\"text/css\">
                                form{text-align:center}
                                p{text-align:center}
                                h2, h1{text-align:center}
                                table
                                {
                                   border-collapse: collapse;
                                }
                                td, th 
                                {
                                   border: 1px solid black;
                                }
                                .class_nom{
                                   width: 80px;
                                }
                                .class_num{
                                    width: 70px;
                                }
                                .inventaire_table{
                                    width:100%; 
                                    border-collapse:collapse; 
                                }
                                .inventaire_table td{ 
                                    padding:3px; 
                                    border:#4e95f4 1px solid;
                                }
                                .inventaire_table tr{
                                    background: #b8d1f3;
                                }
                                .inventaire_table tr:nth-child(odd){ 
                                    background: #b8d1f3;
                                }
                                .inventaire_table tr:nth-child(even){
                                    background: #dae5f4;
                                }
                                body {
                                    width: 1000px;
                                }
                                .blocInfoBis
                                {
                                    background-repeat: repeat;
                                    border: 1px solid #313131;
                                    padding: 5px 5px 5px;
                                }
                            </style>
                        <head>
                            <meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />
                            <title>Synthese</title>
                        </head>
                        <body>
                                <h1> ENTREPRISE </h1>
                                <h1> FICHE D'INVENTAIRE MENSUEL DU ".setLocalTime()."</h1>
                                <table class=\"inventaire_table\">
                                    <tr>
                                        <th class=\"class_nom\" >Nom du produit</th>
                                        <th class=\"class_num\" >Stock initial</th>  
                                        <th class=\"class_num\" >Achats</th>
                                        <th class=\"class_num\" >Nouveau stock</th>
                                        <th class=\"class_num\" >Stock physique</th>
                                        <th class=\"class_num\" >Quantité vendue</th>
                                        <th class=\"class_num\" >Prix d'achat par unité</th>
                                        <th class=\"class_num\" >Prix de vente par unité</th>
                                        <th class=\"class_num\" >Ventes totales</th>
                                        <th class=\"class_num\" >Benefice brut</th>
                                        <th class=\"class_num\" >Montant en stock</th>
                                        <th class=\"class_num\" >Achats totales</th>     
                                    </tr>";


            $file = fopen($filename,'a');
            fseek($file, 0);
            fputs($file, $head);

            $datas = $db->getSynthese();

            $i = 0;
            $nomCaissier = "";
            $ventesTotales = 0;
            $beneficeBrut = 0;
            $achatsTotales = 0;
            $montantStock = 0;
            $fondsEspeces = 0;
            $totalCharges = 0;
            $patrimoine = 0;
            $beneficeNet = 0;

            if( count( $datas ) > 0)
            {
                foreach ($datas as $data) 
                {
                    $nom_produit = $data["nom_produit"];
                    $stock_initial = $data["stock_initial"];

                    if( $data["achat"] != NULL ) $achats = $data["achat"]; else $achats = 0;
                    $stock_physique = $data["stock_physique"];
                    $nouveau_stock = $data["stock_initial"] + $data["achat"];
                    $quantite_vendue = $data["stock_initial"] + $data["achat"] - $data["stock_physique"];
                    $prix_achat = $data["prix_achat"];
                    $prix_vente = $data["prix_vente"];
                    $ventes_totales = ($data["stock_initial"] + $data["achat"] - $data["stock_physique"]) * $data["prix_vente"];
                    $benefice_brut = ($data["prix_vente"] - $data["prix_achat"]) * ($data["stock_initial"] + $data["achat"] - $data["stock_physique"]);
                    $montant_stock = $data["stock_physique"] * $data["prix_vente"];
                    $achats_totales = $data["achat"] * $data["prix_achat"];

                    $body = "<tr>
                                <td class=\"class_nom\" >$nom_produit</td>
                                <td class=\"class_num\" >$stock_initial</td>
                                <td class=\"class_num\" >$achats</td>
                                <td class=\"class_num\" >$nouveau_stock</td>
                                <td class=\"class_num\" >$stock_physique</td>
                                <td class=\"class_num\" >$quantite_vendue</td>
                                <td class=\"class_num\" >$prix_achat</td>
                                <td class=\"class_num\" >$prix_vente</td>
                                <td class=\"class_num\" >$ventes_totales</td>
                                <td class=\"class_num\" >$benefice_brut</td>
                                <td class=\"class_num\" >$montant_stock</td>
                                <td class=\"class_num\" >$achats_totales</td>                                
                            </tr>";
                    $i++;
                    $ventesTotales += ($data["stock_initial"] + $data["achat"] - $data["stock_physique"]) * $data["prix_vente"];
                    $beneficeBrut += ($data["prix_vente"] - $data["prix_achat"]) * ($data["stock_initial"] + $data["achat"] - $data["stock_physique"]);
                    $achatsTotales += $data["achat"] * $data["prix_achat"];
                    $montantStock += $data["stock_physique"] * $data["prix_vente"];

                    fputs($file, $body);
                }

                fputs($file, "</table> <br /> <h1> SYNTHESE </h1>");

                $infosRecap = $db->getAllRecapitulatif();
                if(count( $infosRecap ) > 0)
                {
                    $nomCaissier = $infosRecap["nom_user"]." ".$infosRecap["prenom_user"];
                    $fondsEspeces = $infosRecap["fonds"];
                    $capsules = $infosRecap["capsules"];
                    $totalCharges = $infosRecap["ration"] + $infosRecap["dette_fournisseur"] + $infosRecap["depenses_diverses"] + $infosRecap["avaries"] + $infosRecap["credit_client"];
                    $patrimoine = $fondsEspeces + $montantStock + $capsules;
                    $beneficeNet = $beneficeBrut - $totalCharges;
                    $recettesPercues = $infosRecap["recettes_percues"];
                    $ecart = $ventesTotales - $recettesPercues - $fondsEspeces;
                    $solde = $totalCharges - $ecart;
                    $date_inventaire = SQLDateTimeToFrenchDateTime($infosRecap["date_inventaire"]);
                }

                $recap = "<table class=\"inventaire_table\">
                            <tr>
                                <th>Nom du Caissier</th>
                                <td>$nomCaissier</td>
                            </tr> 
                            <tr>
                                <th>Achat mensuel</th>
                                <td>$achatsTotales</td>
                            </tr>              
                            <tr>
                                <th>Recapitulatif des ventes</th>
                                <td>$ventesTotales</td>
                            </tr>
                            <tr>
                                <th>Benefice brut</th>
                                <td>$beneficeBrut</td>
                            </tr>
                            <tr>
                                <th> Montant des marchandises disponibles en stock </th>
                                <td>$montantStock</td>
                            </tr>
                            <tr>
                                <th>Fonds en especes</th>
                                <td>$fondsEspeces</td>
                            </tr>
                            <tr>
                                <th>Montant des charges diverses</th>
                                <td>$totalCharges</td>
                            </tr>
                            <tr>
                                <th>Patrimoine</th>
                                <td>$patrimoine</td>
                            </tr>
                        </table>
                <br />
                        <table class=\"inventaire_table\">
                            <tr>
                                <th>Benefice net</th>
                                <td>$beneficeNet</td>
                            </tr>
                        </table>
                <br />
                        <table class=\"inventaire_table\">
                            <tr>
                                <th>Ventes totales</th>
                                <th>Recettes percues</th>
                                <th>Ecart</th>
                                <th>Solde</th>
                            </tr>
                            <tr>
                                <td>$ventesTotales</td>
                                <td>$recettesPercues</td>
                                <td>$ecart</td>
                                <td>$solde</td>
                            </tr>
                        </table>";

                $user = $_SESSION["infoUser"]["nom_user"]." ".$_SESSION["infoUser"]["prenom_user"];
                $foot = "<br />
                        Inventaire de ".$i." produits <br />
                        Réalisé par ".$user." le ".setLocalTime()." <br />
                    </body>
                </html>";

                fputs($file, $recap);
                fputs($file, $foot);
                fclose($file);

                $ok = true;
    
            /**
             * Instantiate Backup_Database and perform backup
             */
            $backupDatabase = new BackupDatabase();
            $status = $backupDatabase->backupTables() ? 'OK' : 'KO';

            /**
            * initiliaze db
            */  

                $produits = $db->getTableProduits();
                foreach ($produits as $produit) 
                {
                    $idt_produits = $produit["idt_produits"];
                    $stock_physique = $produit["stock_physique"];
                    $sql = "UPDATE t_produits
                            SET stock_initial = $stock_physique,
                                stock_physique = 0
                            WHERE idt_produits = $idt_produits";

                    if($db->Execute ( $sql ))
                    {
                        $ok &= true;
                    }
                    else
                    {
                        $ok &= false;
                    }
                }

                // archiver les factures et les achats
                $factures = $db->getAllFactures();
                $nombre_factures = 0;
                foreach ( $factures as $facture ) 
                {
                    $numero_facture = $facture["numero_facture"];
                    $id_fournisseur = $facture["id_fournisseur"];
                    $date_facture = $facture["date_facture"];
                    $date_insertion_facture = $facture["date_insertion_facture"];

                    $sql = "INSERT INTO t_historiques_factures
                                    (numero_facture,
                                     id_fournisseur,
                                     date_facture,
                                     date_insertion_facture,
                                     id_groupes_factures)
                        VALUES ('$numero_facture',
                                '$id_fournisseur',
                                '$date_facture',
                                '$date_insertion_facture',
                                '$id_groupes_factures')";

                        if( $db->Execute ( $sql ) )
                        {
                            $nombre_factures ++;
                            $ok &= true;
                        }
                        else
                        {
                            $ok &= false;
                        }

                    $id_facture = $db->getLastInsertedIdInHistoriquesFactures();
                    $achats = $db->getAllAchatsByFacture( $facture["idt_factures"] );
                    foreach ( $achats as $achat ) 
                    {
                        $id_produit = $achat["id_produit"];
                        $quantite_achat = $achat["quantite_achat"];
                        $date_fabrication = $achat["date_fabrication"];
                        $date_peremption = $achat["date_peremption"];

                        $sql = "INSERT INTO t_historiques_achats
                                    (id_produit,
                                     id_facture,
                                     quantite_achat,
                                     date_fabrication,
                                     date_peremption)
                        VALUES ('$id_produit',
                                '$id_facture',
                                '$quantite_achat',
                                '$date_fabrication',
                                '$date_peremption')";

                        if( $db->Execute ( $sql ) )
                        {
                            $ok &= true;
                        }
                        else
                        {
                            $ok &= false;
                        }
                    }
                }
       
                if( $ok )
                {
                    $sql = "UPDATE t_groupes_factures
                            SET nombre_factures = '$nombre_factures'
                            WHERE idt_groupes_factures = $id_groupes_factures";

                    $db->Execute ( $sql );
                    
                    $sql = "DELETE FROM t_achats";
                    $db->Execute ( $sql );
                    
                    $sql = "DELETE FROM t_factures";
                    $db->Execute ( $sql );
                    
                    $db->commit ();
                }
                else
                {
                    $db->rollBack();
                }
            }                                               
            else
            {
            //    header("Location:../administration_magasin.php?sub=recapitulatif_inventaire");
            }
        }
        catch (Exception $e)
        {
            $msg = $e->getMessage();
            $ok &= false;
        //    echo "({'result': 'FAILED', 'message': 'Exception : ".$msg."'})";
        }
    }
}

set_time_limit(0);

// Call the download function with file path,file name and file type
$content = output_file($filename, ''.$file_inventaire.'.html', 'text/plain');

$html2pdf->WriteHTML($content);
$html2pdf->Output( $directoryInventaire.'/'.$file_inventaire.'.pdf', "F");

if( file_exists( $filename ) ) unlink( $filename );

    $id_historiques_syntheses  = $db->getLastInsertedIdInHistoriquesSyntheses();
//*
    $path_to_file = "Inventaire/".$file_inventaire.".pdf";
    $sql = "UPDATE t_historiques_syntheses
            SET filepath = '$path_to_file'
            WHERE idt_historiques_syntheses = $id_historiques_syntheses";

    if($db->Execute ( $sql ))
    {
        $ok &= true;
    }
    else
    {
        $ok &= false;
    }

?>
<script language="javascript">

  $(function() {
    $( "#progressbar" ).progressbar({
      value: false
    });
    $( "button" ).on( "click", function( event ) {
      var target = $( event.target ),
        progressbar = $( "#progressbar" ),
        progressbarValue = progressbar.find( ".ui-progressbar-value" );
 
      if ( target.is( "#numButton" ) ) {
        progressbar.progressbar( "option", {
          value: Math.floor( Math.random() * 100 )
        });
      } else if ( target.is( "#colorButton" ) ) {
        progressbarValue.css({
          "background": '#' + Math.floor( Math.random() * 16777215 ).toString( 16 )
        });
      } else if ( target.is( "#falseButton" ) ) {
        progressbar.progressbar( "option", "value", false );
      }
    });
  });

$(document).ready (function ()
{
    $(".link").each (function ()
    {
        $(this).click (function ()
        {
            var filename = $(this).attr("filename");
            document.location.href="download.php?filename="+filename;
        });
    });
});
</script>
    <div style="width: 100%;">
        <form name="form_popup" id="form_popup" method="post">

        <style type="text/css">
            #progressbar .ui-progressbar-value {
                background-color: #ccc;
            }
            .blocInfoSuccess
            {
                background-image: url("css/images/bg_bloc_alertes.png");
                background-repeat: repeat;
                background-color: green;
                width: 50px;
                font-size: 28px;
                text-align: center;
                border: 10px solid #313131;
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
    <?php

        $id_historiques_syntheses  = $db->getLastInsertedIdInHistoriquesSyntheses();
        $histo_syntheses = $db->getHistoriqueSyntheseById( $id_historiques_syntheses );

    if( count( $histo_syntheses ) > 0)
    {
        foreach ($histo_syntheses as $obj) 
        {
    ?>
            <div style="width: 100%;">
                <form name="form_popup" id="form_popup" method="post">

                <style type="text/css">
                    .blocInfoBis
                    {
                        background-image: url("css/images/bg_bloc_alertes.png");
                        background-repeat: repeat;
                        border: 1px solid #313131;
                        padding: 5px 5px 5px;
                    }
                    .maindiv{ 
                        width:690px; 
                        margin:0 auto; 
                        padding:20px; 
                        background:#CCC;
                    }
                    .innerbg{ 
                        padding:6px; 
                        background:#FFF;
                    }
                    .link{ 
                        font-weight:bold; 
                        color:#ff0000; 
                        text-decoration:none; 
                        font-size:12px;
                    }
                </style>
                    <table cellspacing="2" cellpadding="2" class="blocInfoBis" width="100%">
                        <tr>
                            <!--PARTIE GAUCHE-->
                            <td>
                                <table cellspacing="5" cellpadding="2" width="60%">
                                    <tr class="blocInfoBis">
                                        <td>Nom du caissier :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php  echo $obj["nom_user"]." ".$obj["prenom_user"]; ?></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Achats mensuels :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php  echo $obj["achats_mensuels"]; ?></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Ventes mensuelles :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo $obj["ventes_mensuelles"]; ?></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Montant marchandises en stock :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo $obj["montant_stock"]; ?></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Montant charges diverses  :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo $obj["montant_charges_diverses"]; ?></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Ration :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo $obj["ration"]; ?></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Dette fournisseur :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo $obj["dette_fournisseur"]; ?></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Dépenses diverses  :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo $obj["depenses_diverses"]; ?></strong></td>
                                    </tr>                            
                                    <tr class="blocInfoBis">
                                        <td>Date inventaire :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo SQLDateTimeToFrenchDateTime($obj["date_inventaire"]); ?></strong></td>
                                    </tr>
                                    <tr>    
                                        <td align="left" valign="middle"><a class="link" filename="<?=$obj ["filepath"]; ?>"><img src="assets/images/tick.jpg" alt="" width="16" height="16" /> Téléchargez le fichier de synthése</a></td>                     
                                    </tr>                                                                                            
                                </table>
                            </td>
                            <!--PARTIE DROITE-->
                            <td>
                                <table cellspacing="5" cellpadding="2" width="80%">
                                    <tr class="blocInfoBis">
                                        <td>Fonds en espéces :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo $obj["fonds_especes"]; ?></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Patrimoine :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo $obj["patrimoine"]; ?></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Recettes perçues :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo $obj["recettes_percues"]; ?></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Bénéfice brut :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo $obj["benefice_brut"]; ?></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Bénéfice net  :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo $obj["benefice_net"]; ?></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Avaries :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo $obj["avaries"]; ?></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Crédit client :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo $obj["credit_client"]; ?></strong></td>
                                    </tr>
                                    <tr class="blocInfoBis">
                                        <td>Capsules :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo $obj["capsules"]; ?></strong></td>
                                    </tr>                          
                                    <tr class="blocInfoBis">
                                        <td>Ecart :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo $obj["ecart"]; ?></strong></td>
                                    </tr> 
                                    <tr class="blocInfoBis">
                                        <td>Solde  :<span class="champObligatoire">*</span></td>
                                        <td><strong><?php echo $obj["solde"]; ?></strong></td>
                                    </tr>                                                       
                                </table>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        <br />    
<?php
        }
    }
?>