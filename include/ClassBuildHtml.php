<?php

@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");
// Report all errors
error_reporting(E_ALL);
@session_start ();
$db = new Database ();

$ok = true;

/**
 * The Build HTML class
 */
class BuildHtml
{

    public $content = "";
    /**
     * Constructor initializes database
     */
    function BuildHtml()
    {
        $this->host     = "localhost";
        $this->username = "root";
        $this->passwd   = "";
        $this->dbName   = "nkedon_db";
        $this->charset  = "utf8";
    }

    /**
     * Save SQL to file
     * @param string $sql
     */
    public function generateContent()
    {
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
                                    </tr>
                                </table>
                        </body>";

        $this->content = $head;
        return $this->content;

    }

    public function getContent(){
        return $this->content;
    }
}
?>