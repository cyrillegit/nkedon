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

    class FactureAchat extends Database
    {
        protected $id_facture;

        function FactureAchat( $id ){
            $this->id_facture = $id;
            parent::__construct();
        }

        function buildHtml(){
            $htmlContent = "";
            $montant_facture = 0;
            $id_facture = $this->id_facture;

            if ( $id_facture != "") {
                $infosFactureAchat = $this->getInfosFactureAchatById($id_facture);

                if (count($infosFactureAchat) > 0) {

                    $numero_facture = $infosFactureAchat[0]["numero_facture"];
                    $nom_fournisseur = $infosFactureAchat[0]["nom_fournisseur"];
                    $date_facture = SQLDateToFrenchDate($infosFactureAchat[0]["date_facture"]);
                    $date_register = SQLDateTimeToFrenchDateTime($infosFactureAchat[0]["date_insertion_facture"]);
                    $nom_prenom_user = $infosFactureAchat[0]["nom_user"] . " " . $infosFactureAchat[0]["prenom_user"];
                    $commentaire = trim(stripslashes(htmlentities($infosFactureAchat[0]["commentaire"])));

                    $htmlHead = "<!DOCTYPE html>
                                <html>
                                    <style type=\"text/css\">
                                        .blocInfoBis
                                        {
                                            background-image: url(\"css/images/bg_bloc_alertes.png\");
                                            background-repeat: repeat;
                                        }
                                        .blocTitreId{
                                            font-weight: bold;
                                            width: 17%;
                                        }
                                        .blocTitre{
                                            font-weight: bold;
                                            width: 17%;
                                        }
                                        .blocValue{
                                            font-weight: bold;
                                            width: 17%;
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
                                                <td class=\"\">Numéro facture : <br/><strong>$numero_facture</strong></td>
                                                <td class=\"\">Nom fournisseur : <br/><strong>$nom_fournisseur</strong></td>
                                            <tr>
                                            </tr>
                                                <td class=\"\">Date facture : <br/><strong>$date_facture</strong></td>
                                                <td class=\"\">Enregistrée le : <br/><strong>$date_register</strong></td>
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
                                                        <td class=\"\">Nom produit </td>
                                                        <td class=\"\">Quantité achétée </td>
                                                        <td class=\"\">Prix d'achat (FCFA)</td>
                                                        <td class=\"\">Montant de l'achat (FCFA)</td>
                                                        <td class=\"\">Date fabrication </td>
                                                        <td class=\"\">Date péremption</td>
                                                    </tr>
                                                    <tr height=\"5px;\"></tr>";

                    $htmlBody = "";

                    foreach ($infosFactureAchat as $value) {
                        $nom_produit = $value["nom_produit"];
                        $quantite_achat = $value["quantite_achat"];
                        $prix_achat = number_format($value["prix_achat"], 2, ",", " ");
                        $date_fabrication = SQLDateToFrenchDate($value["date_fabrication"]);
                        $date_peremption = SQLDateToFrenchDate($value["date_peremption"]);
                        $montant_achat = number_format($value["quantite_achat"] * $value["prix_achat"], 2, ",", " ");
                        $montant_facture += $value["quantite_achat"] * $value["prix_achat"];

                        $htmlBody .= "<tr class=\"blocInfoBis\">
                                        <td class=\"\">$nom_produit</td>
                                        <td class=\"\">$quantite_achat</td>
                                        <td class=\"\">$prix_achat</td>
                                        <td class=\"\">$montant_achat</td>
                                        <td class=\"\">$date_fabrication</td>
                                        <td class=\"\">$date_peremption</td>
                                    </tr>";
                    }

                    $montant_facture = number_format($montant_facture, 2, ",", " ");
                                    $htmlFoot = "<tr>
                                                    <td class=\"\" colspan=\"3\">Montant de la facture : </td>
                                                    <td class=\"\" colspan=\"2\"><strong>$montant_facture FCFA</strong></td>
                                                </tr>
                                            </td>
                                        </tr>
                                    </table><br/>
                                    <div><strong>Commentaire : </strong><br/>$commentaire</div>
                                </body>
                          </html>";
                    $htmlContent = $htmlHead . $htmlBody . $htmlFoot;
                } else {
                    $htmlContent = "Facture not found. Facture introuvable";
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
            $mpdf->Output();
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