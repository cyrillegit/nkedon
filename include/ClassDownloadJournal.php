<?php
	@session_start();
	@require_once("./config/config.php");
	@require_once("./include/function.php");
	@require_once("./include/ClassUser.php");
//	@require_once("./include/MasterDB.php");
	@require_once("./include/ClassDB.php");
	@require_once("Smarty/libs/Smarty.class.php");
    @require_once("mpdf/mpdf.php");

	// On d&eacute;sactive les notices dans les messages d'erreur.
	ini_set("error_reporting",E_ALL & ~E_NOTICE);
	ini_set("display_errors", true);
    header("Content-type: text/html; charset=UTF-8");

    class Journal extends Database
    {
        protected $id_journal;

        function Journal( $id ){
            $this->id_journal = $id;
            parent::__construct();
        }

        function buildHtml(){
            $htmlContent = "";
            $montant_journal = 0;
            $id_journal = $this->id_journal;

            if ( $id_journal != "") {
                $infosJournal = $this->getInfosJournalById($id_journal);

                if (count($infosJournal) > 0) {
                    $date_journal = SQLDateToFrenchDate($infosJournal[0]["date_journal"]);
                    $nom_prenom_user = $infosJournal[0]["nom_user"] . " " . $infosJournal[0]["prenom_user"];
                    $commentaire = trim(stripslashes(htmlentities($infosJournal[0]["commentaire"])));

                    $htmlHead = "<!DOCTYPE html>
                                <html>
                                    <style type=\"text/css\">
                                        .blocInfoBis
                                        {
                                            background-image: url(\"css/images/bg_bloc_alertes.png\");
                                            background-repeat: repeat;
                                        }
                                    </style>
                                    <head>
                                        <meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />
                                        <title>Facture d'achat</title>
                                    </head>
                                    <body>
                                        <div class=\"\" style=\"background: none;\">
                                            <img src=\"assets/images/nkedon_logo.png\" border=\"0\" style=\"margin-top: -5px;\" width=\"275\" height=\"120\">
                                        </div>
                                        <br/><br/>
                                        <table class=\"\" width=\"100%\">
                                            <tr>
                                                <td class=\"\"><br/><strong></strong></td>
                                                <td class=\"\"><br/><strong></strong></td>
                                            <tr>
                                            </tr>
                                                <td class=\"\"><br/><strong></strong></td>
                                                <td class=\"\">Enregistrée le : <br/><strong>$date_journal</strong></td>
                                            <tr>
                                            </tr>
                                                <td class=\"\">Enregistrée par : <br/><strong>$nom_prenom_user</strong></td>
                                                <td class=\"\"></td>
                                            </tr>
                                        </table>
                                        <hr size=\"1\" style=\"margin-top: 10px;\" />
                                        <table rules=\"all\" cellspacing=\"3\" cellpadding=\"3\" class=\"\" width=\"100%\" style='border: 1px solid #313131;'>
                                            <tr>
                                                <td>
                                                    <tr class=\"blocInfoBis\">
                                                        <td class=\"\">Numéro opération</td>
                                                        <td class=\"\">Nom produit </td>
                                                        <td class=\"\">Quantité vendue </td>
                                                        <td class=\"\">Prix de vente (FCFA)</td>
                                                        <td class=\"\">Montant de l'opération (FCFA)</td>
                                                    </tr>
                                                    <tr height=\"5px;\"></tr>";

                    $htmlBody = "";

                    foreach ($infosJournal as $value) {
                        $nom_produit = $value["nom_produit"];
                        $quantite_vendue = $value["quantite_vendue"];
                        $prix_vente = number_format($value["prix_vente"], 2, ",", " ");
                        $numero_operation = $value["numero_operation"];
                        $montant_operation = number_format($value["quantite_vendue"] * $value["prix_vente"], 2, ",", " ");
                        $montant_journal += $value["quantite_vendue"] * $value["prix_vente"];

                        $htmlBody .= "<tr class=\"blocInfoBis\">
                                        <td class=\"\">$numero_operation</td>
                                        <td class=\"\">$nom_produit</td>
                                        <td class=\"\">$quantite_vendue</td>
                                        <td class=\"\">$prix_vente</td>
                                        <td class=\"\">$montant_operation</td>
                                    </tr>";
                    }

                    $montant_journal = number_format($montant_journal, 2, ",", " ");
                                    $htmlFoot = "<tr>
                                                    <td class=\"\" colspan=\"4\">Montant de du journal : </td>
                                                    <td class=\"\" ><strong>$montant_journal FCFA</strong></td>
                                                </tr>
                                            </td>
                                        </tr>
                                    </table><br/>
                                    <div><strong>Commentaire : </strong><br/>$commentaire</div>
                                </body>
                          </html>";
                    $htmlContent = $htmlHead . $htmlBody . $htmlFoot;
                } else {
                    $htmlContent = "Journal not found. Journal introuvable";
                }
            } else {
                $htmlContent = "File not found. Impossible de téléchatger le fichier";
            }
            return $htmlContent;
        }

        function  buildPdf( $htmlContent ){

            /**
             * list of arguments in order
             *  - mode : string
             *  - format : mixed
             *  - font size : float
             *  - font : string
             *  - margin left : float
             *  - margin right : float
             *  - margin top : float
             *  - margin bottom : float
             *  - margin header : float
             *  - margin footer : float
             */
            $mpdf = new mPDF('win-1252', 'A4', '', '', 5, 5, 5, 5, 10, 10);
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->WriteHTML( $htmlContent );
            $mpdf->Output('journal.pdf','D');
        }

        function  getDirectory(){
            // directory for pdf file
            $directory = "downloads/FacturesAchats";
            if( !file_exists( $directory ) )
            {
                mkdir( $directory, 0777, true );
            }
            return $directory;
        }

        function getFilename( $id_facture ){

            $directory = $this->getDirectory();
            $file = "facture_achat_".$id_facture."_".str_replace("-", "", explode(" ", setLocalTime())[0]);
            $filename = $directory."/".$file;

            if(file_exists($filename.".html"))
            {
                unlink($filename.".html");
            }
            return $filename;
        }

        /**
         * enregistre la facture sous format html
         *
         * @param $htmlContent contenu du fichier html
         */
        function  storeHtml( $htmlContent ){

            $filename = $this->getFilename( $this->id_facture );

            $file = fopen($filename.".html",'a');
            fseek($file, 0);
            fputs($file, $htmlContent);
            fclose($file);
        }
}
?>