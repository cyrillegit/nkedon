<?php
/**
  Fichier GetXMLFacturesFournisseurMois.php
  -----------------------------------
  Ce fichier crée un fichier .xml du nombre de factures par fournisseurs et par mois.
*/
@require_once("../../../../config/config.php");
@require_once("../../../../include/function.php");
@require_once("../../../../include/ClassDB.php");

@session_start();
$db = new Database ();

$datas = $db->getAllHistoriquesSyntheses ();

$writer = new XMLWriter();  
$writer->openURI( 'data_stats_courbes_progressions.xml');  
$writer->startDocument('1.0','UTF-8');  
$writer->setIndent(4);   
$writer->startElement('chart');   
   $writer->writeAttribute('caption', 'Courbes des progressions'); 
   $writer->writeAttribute('subcaption', 'des six derniéres synthéses'); 
   $writer->writeAttribute('lineThickness', '1');
   $writer->writeAttribute('formatNumberScale', '0');
   $writer->writeAttribute('anchorRadius', '2');
   $writer->writeAttribute('divLineAlpha', '20');
   $writer->writeAttribute('numvdivlines', '5');
   $writer->writeAttribute('chartRightMargin', '35');
   $writer->writeAttribute('bgColor', 'FFFFFF,CC3300');
   $writer->writeAttribute('bgAngle', '270');
   $writer->writeAttribute('bgAlpha', '10,10'); 
   $writer->writeAttribute('alternateHGridAlpha', '5');  
   $writer->writeAttribute('divLineColor', 'CC3300');
   $writer->writeAttribute('divLineIsDashed', '1');
   $writer->writeAttribute('showAlternateHGridColor', '1');
   $writer->writeAttribute('alternateHGridColor', 'CC3300');
   $writer->writeAttribute('shadowAlpha', '40'); 
   $writer->writeAttribute('legendPosition', 'BOTTOM');  
   $writer->writeAttribute('labelStep', '0');  
   $writer->writeAttribute('showValues', '0'); 

    $writer->startElement('categories');
    foreach ( $datas as $data ) 
    {
        $writer->startElement('category');
            $writer->writeAttribute('label',  getDateFromDatetime( $data["date_inventaire"] ));  
        $writer->endElement();
    }
    $writer->endElement(); 


    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Achats mensuels');
    $writer->writeAttribute('color', '2AD62A');
    $writer->writeAttribute('anchorBorderColor', '2AD62A');
    $writer->writeAttribute('anchorBgColor', '2AD62A');
    foreach ( $datas as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data["achats_mensuels"] );  
        $writer->endElement();
    }
    $writer->endElement(); 

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Ventes mensuelles');
    $writer->writeAttribute('color', 'DBDC25');
    $writer->writeAttribute('anchorBorderColor', 'DBDC25');
    $writer->writeAttribute('anchorBgColor', 'DBDC25');
    foreach ( $datas as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data["ventes_mensuelles"] );  
        $writer->endElement();
    }
    $writer->endElement(); 

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Montant en stock');
    $writer->writeAttribute('color', '1D8BD1');
    $writer->writeAttribute('anchorBorderColor', '1D8BD1');
    $writer->writeAttribute('anchorBgColor', '1D8BD1');
    foreach ( $datas as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data["montant_stock"] );  
        $writer->endElement();
    }
    $writer->endElement();

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Montant charges diverses');
    $writer->writeAttribute('color', 'F1683C');
    $writer->writeAttribute('anchorBorderColor', 'F1683C');
    $writer->writeAttribute('anchorBgColor', 'F1683C');
    foreach ( $datas as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data["montant_charges_diverses"] );  
        $writer->endElement();
    }
    $writer->endElement();

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Fonds en espéces');
    $writer->writeAttribute('color', '54683C');
    $writer->writeAttribute('anchorBorderColor', '54683C');
    $writer->writeAttribute('anchorBgColor', '54683C');
    foreach ( $datas as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data["fonds_especes"] );  
        $writer->endElement();
    }
    $writer->endElement();

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Patrimoine');
    $writer->writeAttribute('color', '54F13C');
    $writer->writeAttribute('anchorBorderColor', '54F13C');
    $writer->writeAttribute('anchorBgColor', '54F13C');
    foreach ( $datas as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data["patrimoine"] );  
        $writer->endElement();
    }
    $writer->endElement();

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Recettes perçues');
    $writer->writeAttribute('color', '54F1D2');
    $writer->writeAttribute('anchorBorderColor', '54F1D2');
    $writer->writeAttribute('anchorBgColor', '54F1D2');
    foreach ( $datas as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data["recettes_percues"] );  
        $writer->endElement();
    }
    $writer->endElement();

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Bénéfice brut');
    $writer->writeAttribute('color', 'D8F1D2');
    $writer->writeAttribute('anchorBorderColor', 'D8F1D2');
    $writer->writeAttribute('anchorBgColor', 'D8F1D2');
    foreach ( $datas as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data["benefice_brut"] );  
        $writer->endElement();
    }
    $writer->endElement();

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Bénéfice Net');
    $writer->writeAttribute('color', 'D8C6D2');
    $writer->writeAttribute('anchorBorderColor', 'D8C6D2');
    $writer->writeAttribute('anchorBgColor', 'D8C6D2');
    foreach ( $datas as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data["benefice_net"] );  
        $writer->endElement();
    }
    $writer->endElement();

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Ecart');
    $writer->writeAttribute('color', 'D8C6B9');
    $writer->writeAttribute('anchorBorderColor', 'D8C6B9');
    $writer->writeAttribute('anchorBgColor', 'D8C6B9');
    foreach ( $datas as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data["ecart"] );  
        $writer->endElement();
    }
    $writer->endElement();

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Ration');
    $writer->writeAttribute('color', '5401D2');
    $writer->writeAttribute('anchorBorderColor', '5401D2');
    $writer->writeAttribute('anchorBgColor', '5401D2');
    foreach ( $datas as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data["ration"] );  
        $writer->endElement();
    }
    $writer->endElement();

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Dette fournisseurs');
    $writer->writeAttribute('color', 'D0F1D2');
    $writer->writeAttribute('anchorBorderColor', 'D0F1D2');
    $writer->writeAttribute('anchorBgColor', 'D0F1D2');
    foreach ( $datas as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data["dette_fournisseur"] );  
        $writer->endElement();
    }
    $writer->endElement();

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Depenses diverses');
    $writer->writeAttribute('color', 'D81602');
    $writer->writeAttribute('anchorBorderColor', 'D81602');
    $writer->writeAttribute('anchorBgColor', 'D81602');
    foreach ( $datas as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data["depenses_diverses"] );  
        $writer->endElement();
    }
    $writer->endElement();

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Crédit client');
    $writer->writeAttribute('color', 'D80009');
    $writer->writeAttribute('anchorBorderColor', 'D80009');
    $writer->writeAttribute('anchorBgColor', 'D80009');
    foreach ( $datas as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data["credit_client"] );  
        $writer->endElement();
    }
    $writer->endElement(); 

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Avaries');
    $writer->writeAttribute('color', 'D0F000');
    $writer->writeAttribute('anchorBorderColor', 'D0F000');
    $writer->writeAttribute('anchorBgColor', 'D0F000');
    foreach ( $datas as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data["avaries"] );  
        $writer->endElement();
    }
    $writer->endElement();

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Capsules');
    $writer->writeAttribute('color', '000602');
    $writer->writeAttribute('anchorBorderColor', '000602');
    $writer->writeAttribute('anchorBgColor', '000602');
    foreach ( $datas as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data["capsules"] );  
        $writer->endElement();
    }
    $writer->endElement();

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Solde');
    $writer->writeAttribute('color', 'D8FF09');
    $writer->writeAttribute('anchorBorderColor', 'D8FF09');
    $writer->writeAttribute('anchorBgColor', 'D8FF09');
    foreach ( $datas as $data ) 
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $data["solde"] );  
        $writer->endElement();
    }
    $writer->endElement();       

  $writer->startElement('styles'); 
      $writer->startElement('definition');
          $writer->startElement('style');
              $writer->writeAttribute('type', 'font');
              $writer->writeAttribute('name', 'CaptionFont'); 
              $writer->writeAttribute('size', '12');
          $writer->endElement();
      $writer->endElement();
      $writer->startElement('application');
          $writer->startElement('apply');
              $writer->writeAttribute('toObject', 'CAPTION');
              $writer->writeAttribute('styles', 'CaptionFont'); 
          $writer->endElement();
          $writer->startElement('apply');
              $writer->writeAttribute('toObject', 'SUBCAPTION');
              $writer->writeAttribute('styles', 'SubCaptionFont'); 
          $writer->endElement();
      $writer->endElement();
  $writer->endElement();              
$writer->endElement();  
$writer->endDocument();   
$writer->flush();

?>
<div id="chartContainer"></div>
    <script type="text/javascript">
        var myChart = new FusionCharts("FusionCharts/MSLine.swf", "myChartId", "950", "600", "0", "1" );
        myChart.setXMLUrl("ajax/infos/administration_magasin/statistiques/data_stats_courbes_progressions.xml");
        myChart.render("chartContainer");
    </script>
</div>