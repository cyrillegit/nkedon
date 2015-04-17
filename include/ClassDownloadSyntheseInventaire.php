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

    class SyntheseInventaire extends Database
    {
        protected $id_inventaire;
        protected $suffix;

        function SyntheseInventaire( $id ){
            $this->id_inventaire = $id;
            $this->suffix = str_replace("-", "", explode(" ", setLocalTime())[0]);
            parent::__construct();
        }

        function buildHtml(){
            $htmlContent = "";
            $montant_achat_inventaire = 0;
            $montant_vente_inventaire = 0;
            $benefice_brut = 0;
            $montant_stock = 0;
            $i = 0;

            $id_invenatire = $this->id_inventaire;

            if ( $id_invenatire != "") {
                $inventaire = $this->getRecapitulatifInventaire( $id_invenatire );
                $produits = $this->getAllProduits();

                if (count($inventaire) > 0) {

                    $ration = $inventaire["ration"];
                    $dette_fournisseur = $inventaire["dette_fournisseur"];
                    $date_inventaire = SQLDateToFrenchDate($inventaire["date_inventaire"]);
                    $caissier = $inventaire["nom_user"] . " " . $inventaire["prenom_user"];
                    $commentaire = trim(stripslashes(htmlentities($inventaire["commentaire"])));
                    $depenses_diverses = $inventaire["depenses_diverses"];
                    $avaries = $inventaire["avaries"];
                    $credit_client = $inventaire["credit_client"];
                    $fonds = $inventaire["fonds"];
                    $capsules = $inventaire["capsules"];
                    $recettes_percues = $inventaire["recettes_percues"];

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
                                        <title>Synthèse de l'inventaire</title>
                                    </head>
                                    <body>
                                        <div class=\"\" style=\"background: none;\">
                                            <img src=\"nkedon_logo.png\" border=\"0\" style=\"margin-top: -5px;\" width=\"275\" height=\"120\">
                                        </div>
                                        <br/><br/>
                                        <table class=\"\" width=\"100%\">
                                            <tr>
                                                <td class=\"\"><br/><strong></strong></td>
                                                <td class=\"\"><br/><strong></strong></td>
                                            </tr>
                                            <tr>
                                                <td class=\"\">Date inventaire: <br/><strong>$date_inventaire</strong></td>
                                                <td class=\"\"><br/><strong></strong></td>
                                            </tr>
                                            <tr>
                                                <td class=\"\">Caissier : <br/><strong>$caissier</strong></td>
                                                <td class=\"\"></td>
                                            </tr>
                                        </table>
                                        <hr size=\"1\" style=\"margin-top: 10px;\" />
                                        <table rules=\"all\" cellspacing=\"3\" cellpadding=\"3\" class=\"\" width=\"100%\" style='border: 1px solid #313131;'>
                                            <tr>
                                                <td>
                                                    <tr class=\"blocInfoBis\">
                                                        <td class=\"\">Nom produit </td>
                                                        <td class=\"\">Stock initial </td>
                                                        <td class=\"\">Stock physique)</td>
                                                        <td class=\"\">Quantité en stock</td>
                                                        <td class=\"\">Quantité achetée </td>
                                                        <td class=\"\">Prix d'achat (FCFA)</td>
                                                        <td class=\"\">Montant des achats (FCFA)</td>
                                                        <td class=\"\">Quantité vendue </td>
                                                        <td class=\"\">Prix de vente (FCFA)</td>
                                                        <td class=\"\">Montant des ventes (FCFA)</td>
                                                    </tr>
                                                    <tr height=\"5px;\"></tr>";

                    $htmlBody = "";

                    foreach ($produits as $value) {
                        $i++;
                        // recupere les infos sur chaque produit liées a cet inventaire
                        $dataAchat = $this->getInfosProduitAcheteByInventaire( $value["idt_produits"], $id_invenatire );
                        $dataVente = $this->getInfosProduitVenduByInventaire( $value["idt_produits"], $id_invenatire );

                        $nom_produit = $value["nom_produit"];
                        $stock_initial = $value["stock_initial"];
                        $stock_physique = $value["stock_physique"];
                        $quantite_achetee = $dataAchat["quantite_achetee"];
                        $prix_achat = number_format($value["prix_achat"], 2, ",", " ");
                        $montant_achat = number_format($quantite_achetee * $value["prix_achat"], 2, ",", " ");
                        $montant_achat_inventaire += $quantite_achetee * $value["prix_achat"];
                        $quantite_vendue = $dataVente["quantite_vente"];
                        $prix_vente = $value["prix_vente"];
                        $montant_vente = number_format($quantite_vendue * $value["prix_vente"], 2, ",", " ");
                        $montant_vente_inventaire += $quantite_vendue * $value["prix_vente"];

                        $quantite_stock = $stock_initial + $quantite_achetee - $quantite_vendue;
                        $benefice_brut += ($value["prix_vente"] - $value["prix_achat"]) * ($value["stock_initial"] + $quantite_achetee - $value["stock_physique"]);
                        $montant_stock += $value["stock_physique"] * $value["prix_vente"];

                        $htmlBody .= "<tr class=\"blocInfoBis\">
                                        <td class=\"\">$nom_produit</td>
                                        <td class=\"\">$stock_initial</td>
                                        <td class=\"\">$stock_physique</td>
                                        <td class=\"\">$quantite_stock</td>
                                        <td class=\"\">$quantite_achetee</td>
                                        <td class=\"\">$prix_achat</td>
                                        <td class=\"\">$montant_achat</td>
                                        <td class=\"\">$quantite_vendue</td>
                                        <td class=\"\">$prix_vente</td>
                                        <td class=\"\">$montant_vente</td>
                                    </tr>";
                    }

                    $montant_achat_inventaire = number_format($montant_achat_inventaire, 2, ",", " ");
                    $montant_vente_inventaire = number_format($montant_vente_inventaire, 2, ",", " ");
                    $charges_totles = $ration+ $dette_fournisseur + $depenses_diverses + $avaries + $credit_client;
                    $user = $_SESSION["infoUser"]["nom_user"]." ".$_SESSION["infoUser"]["prenom_user"];

                    $patrimoine = $fonds + $montant_stock + $capsules;
                    $benefice_net = $benefice_brut - $charges_totles;
                    $ecart = $montant_vente_inventaire - $recettes_percues - $fonds;
                    $solde = $charges_totles - $ecart;

                                    $htmlFoot = "</td>
                                        </tr>
                                    </table><br/><br/>
                                        <table rules=\"all\" class=\"\" width=\"100%\" style='border: 1px solid #313131;'>
                                            <tr class=\"blocInfoBis\">
                                                <td class=\"\"><strong>Ration</strong></td>
                                                <td class=\"\"><strong>Dette fournisseur</strong></td>
                                                <td class=\"\"><strong>Dépenses diverses</strong></td>
                                                <td class=\"\"><strong>Avaries</strong></td>
                                                <td class=\"\"><strong>Crédit client</strong></td>
                                                <td class=\"\"><strong>Fonds</strong></td>
                                                <td class=\"\"><strong>Capsules</strong></td>
                                                <td class=\"\"><strong>Recettes oerçues</strong></td>
                                            </tr>
                                            <tr class=\"blocInfoBis\">
                                                <td class=\"\">$ration <span style='float: right; margin-right: 5px;'>FCFA</span></td>
                                                <td class=\"\">$dette_fournisseur <span style='float: right; margin-right: 5px;'>FCFA</span></td>
                                                <td class=\"\">$depenses_diverses <span style='float: right; margin-right: 5px;'>FCFA</span></td>
                                                <td class=\"\">$avaries <span style='float: right; margin-right: 5px;'>FCFA</span></td>
                                                <td class=\"\">$credit_client <span style='float: right; margin-right: 5px;'>FCFA</span></td>
                                                <td class=\"\">$fonds <span style='float: right; margin-right: 5px;'>FCFA</span></td>
                                                <td class=\"\">$capsules <span style='float: right; margin-right: 5px;'>FCFA</span></td>
                                                <td class=\"\">$recettes_percues <span style='float: right; margin-right: 5px;'>FCFA</span></td>
                                            </tr>
                                        </table>
                                        <br/>
                                        <table rules=\"all\" class=\"blocInfoBis\" width=\"100%\" style='border: 1px solid #313131;'>
                                            <tr class=\"blocInfoBis\">
                                                <td class=\"\"><strong>Montant des achats mensuels</strong></td>
                                                <td class=\"\">$montant_achat_inventaire <span style='float: right; margin-right: 5px;'>FCFA</span></td>
                                            </tr>
                                            <tr class=\"blocInfoBis\">
                                                <td class=\"\"><strong>Montant des ventes mensuelles</strong></td>
                                                <td class=\"\">$montant_vente_inventaire <span style='float: right; margin-right: 5px;'>FCFA</span></td>
                                            </tr>
                                            <tr class=\"blocInfoBis\">
                                                <td class=\"\"><strong>Patrimoine</strong></td>
                                                <td class=\"\">$patrimoine <span style='float: right; margin-right: 5px;'>FCFA</span></td>
                                            </tr>
                                            <tr class=\"blocInfoBis\">
                                                <td class=\"\"><strong>Bénéfice brut</strong></td>
                                                <td class=\"\">$benefice_brut <span style='float: right; margin-right: 5px;'>FCFA</span></td>
                                            </tr>
                                            <tr class=\"blocInfoBis\">
                                                <td class=\"\"><strong>Bénéfice net</strong></td>
                                                <td class=\"\">$benefice_net <span style='float: right; margin-right: 5px;'>FCFA</span></td>
                                            </tr>
                                            <tr class=\"blocInfoBis\">
                                                <td class=\"\"><strong>Ecart</strong></td>
                                                <td class=\"\">$ecart <span style='float: right; margin-right: 5px;'>FCFA</span></td>
                                            </tr>
                                            <tr class=\"blocInfoBis\">
                                                <td class=\"\"><strong>Solde</strong></td>
                                                <td class=\"\">$solde <span style='float: right; margin-right: 5px;'>FCFA</span></td>
                                            </tr>
                                        </table>
                                        <br/><br/>
                                    <div style='border: 1px solid #000000;'><strong>Commentaire : </strong><br/>$commentaire</div>
                                    <br/>
                                    <div>
                                        Inventaire de <strong>".$i."</strong> produits <br />
                                        Réalisé par ".$user." le ".setLocalTime()." <br />
                                    </div>
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
            $filename = $this->getFilename();
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
            $mpdf->Output( "synthese.pdf", 'D');
        }

        function  getDirectory(){
            // directory for pdf file
            $directory = "downloads/inventaires";
            if( !file_exists( $directory ) )
            {
                mkdir( $directory, 0777, true );
            }
            return $directory;
        }

        function getFilename(){

            $directory = $this->getDirectory();

            $file_inventaire = "inventaire_".$this->suffix;
            $filename = $directory."/".$file_inventaire;

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

            $filename = $this->getFilename();
            echo "the filename : ".$filename;
            $file = fopen($filename.".html",'a');
            fseek($file, 0);
            fputs($file, $htmlContent);
            fclose($file);
        }
}
?>