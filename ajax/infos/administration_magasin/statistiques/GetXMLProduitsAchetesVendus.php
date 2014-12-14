<?php
/**
  Fichier GetXMLFacturesFournisseur.php
  -----------------------------------
  Ce fichier crée un fichier .xml du nombre de factures par fournisseur.
*/
@require_once("../../../../config/config.php");
@require_once("../../../../include/function.php");
@require_once("../../../../include/ClassDB.php");

@session_start();
$db = new Database ();

$date_debut = explode(" ", setLocalTime() )[0];
$date_fin_1_mois = date('Y-m-d',strtotime($current_date.'-1 month'));
$date_fin_3_mois = date('Y-m-d',strtotime($current_date.'-3 month'));
$date_fin_6_mois = date('Y-m-d',strtotime($current_date.'-6 month'));
$date_fin_12_mois = date('Y-m-d',strtotime($current_date.'-12 month'));

$current_datas[0] = $db->getAllCurrentQuantiteProduitsByPeriode( $date_debut, $date_fin_1_mois );
$current_datas[1] = $db->getAllCurrentQuantiteProduitsByPeriode( $date_debut, $date_fin_3_mois );
$current_datas[2] = $db->getAllCurrentQuantiteProduitsByPeriode( $date_debut, $date_fin_6_mois );
$current_datas[3] = $db->getAllCurrentQuantiteProduitsByPeriode( $date_debut, $date_fin_12_mois );

$histo_datas[0] = $db->getAllHistoriqueQuantiteProduitsByPeriode( $date_debut, $date_fin_1_mois );
$histo_datas[1] = $db->getAllHistoriqueQuantiteProduitsByPeriode( $date_debut, $date_fin_3_mois );
$histo_datas[2] = $db->getAllHistoriqueQuantiteProduitsByPeriode( $date_debut, $date_fin_6_mois );
$histo_datas[3] = $db->getAllHistoriqueQuantiteProduitsByPeriode( $date_debut, $date_fin_12_mois );
//*
for ($i=0; $i < 4; $i++) 
{ 
  $datas_achat[$i] = $histo_datas[$i]["quantite_achat"] + $current_datas[$i]["quantite_achat"];
  $datas_vente[$i] =  $histo_datas[$i]["stock_initial"] + $current_datas[$i]["stock_initial"] + $histo_datas[$i]["quantite_achat"] + $current_datas[$i]["quantite_achat"] - $histo_datas[$i]["stock_physique"] - $current_datas[$i]["stock_physique"];
}
//*/
$writer = new XMLWriter();  
$writer->openURI( 'data_stats_produits_achetes_vendus.xml');  
$writer->startDocument('1.0','UTF-8');  
$writer->setIndent(4);   
$writer->startElement('chart'); 
   $writer->writeAttribute('palette', '2');   
   $writer->writeAttribute('caption', 'NKedon');  
   $writer->writeAttribute('subcaption', 'Quantité de produits achétés et vendus'); 
   $writer->writeAttribute('xAxisName', 'Périodes');
   $writer->writeAttribute('yAxisName', 'Quantité de produits'); 
   $writer->writeAttribute('numberPrefix', '');  
   $writer->writeAttribute('numberSuffix', 'FCFA');  

    $writer->startElement('categories');
      $writer->startElement('category');
      $writer->writeAttribute('label', '1 mois');
      $writer->endElement();

      $writer->startElement('category');
      $writer->writeAttribute('label', '3 mois');
      $writer->endElement();

      $writer->startElement('category');
      $writer->writeAttribute('label', '6 mois');
      $writer->endElement();

      $writer->startElement('category');
      $writer->writeAttribute('label', '12 mois');
      $writer->endElement();
    $writer->endElement();

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Quantité achétée');
    $writer->writeAttribute('color', 'DBDC25');
    $writer->writeAttribute('showvalues', '1');
    foreach ( $datas_achat as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data );  
        $writer->endElement();
    }
    $writer->endElement(); 

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Quantité vendue');
    $writer->writeAttribute('color', 'AFD8F8');
    $writer->writeAttribute('showvalues', '1');
    foreach ( $datas_vente as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data );  
        $writer->endElement();
    }
    $writer->endElement();

          
$writer->endElement();  
$writer->endDocument();   
$writer->flush();

?>
<div id="chartContainer"></div>
    <script type="text/javascript">
        var myChart = new FusionCharts("FusionCharts/MSBar2D.swf", "myChartId", "900", "700", "0", "1" );
        myChart.setXMLUrl("ajax/infos/administration_magasin/statistiques/data_stats_produits_achetes_vendus.xml");
        myChart.render("chartContainer");
    </script>
</div>