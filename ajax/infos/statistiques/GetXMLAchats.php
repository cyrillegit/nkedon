<?php
/**
  Fichier GetXMLFacturesFournisseurMois.php
  -----------------------------------
  Ce fichier crée un fichier .xml du nombre de factures par fournisseurs et par mois.
*/
@require_once("../../../config/config.php");
@require_once("../../../include/function.php");
@require_once("../../../include/ClassDB.php");

@session_start();
$db = new Database ();

$datasAchats = $db->getAllProduitsAchetesByInventaire( 7 );
foreach ( $datasAchats as $data )
{
    $date =  getDateFromDatetime( $data["date_facture"] );
    if( isset( $dataAchat[ $date ])){
        $dataAchat[ $date ] += $data["quantite_achetee"] * $data["prix_achat"];
    }else{
        $dataAchat[ $date ] = $data["quantite_achetee"] * $data["prix_achat"];
    }
}

$writer = new XMLWriter();  
$writer->openURI( 'data_stats_achats.xml');
$writer->startDocument('1.0','UTF-8');  
$writer->setIndent(4);   
$writer->startElement('chart');   
   $writer->writeAttribute('caption', 'Evolution des achats');
   $writer->writeAttribute('subcaption', 'du mois courant');
   $writer->writeAttribute('lineThickness', '1');
   $writer->writeAttribute('formatNumberScale', '0');
   $writer->writeAttribute('anchorRadius', '2');
   $writer->writeAttribute('divLineAlpha', '20');
   $writer->writeAttribute('numvdivlines', '5');
   $writer->writeAttribute('chartRightMargin', '35');
   $writer->writeAttribute('bgColor', '0000FF');
   $writer->writeAttribute('bgAngle', '270');
   $writer->writeAttribute('bgAlpha', '0');
   $writer->writeAttribute('alternateHGridAlpha', '5');  
   $writer->writeAttribute('divLineColor', 'CC3300');
   $writer->writeAttribute('divLineIsDashed', '0');
   $writer->writeAttribute('shadowAlpha', '90');
   $writer->writeAttribute('legendPosition', 'BOTTOM');  
   $writer->writeAttribute('labelStep', '5');
   $writer->writeAttribute('showValues', '0');
   $writer->writeAttribute('canvasBgAlpha', '0');
   $writer->writeAttribute('legendBgAlpha', '0');
   $writer->writeAttribute('bgImage', '');
   $writer->writeAttribute('bgImageAlpha', '100');

$writer->startElement('categories');
    foreach ( $dataAchat as $index => $value )
    {
        $writer->startElement('category');
            $writer->writeAttribute('label',  $index );
        $writer->endElement();
    }
    $writer->endElement(); 


//    $writer->startElement('dataset');
//    $writer->writeAttribute('seriesName', 'Achats mensuels');
//    $writer->writeAttribute('color', '2AD62A');
//    $writer->writeAttribute('anchorBorderColor', '2AD62A');
//    $writer->writeAttribute('anchorBgColor', '2AD62A');
//    foreach ( $datasVentes as $data )
//    {
//        $writer->startElement('set');
//            $writer->writeAttribute('value', $data["quantite_vendue"] * $data["prix_achat"] );
//        $writer->endElement();
//    }
//    $writer->endElement();

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Achats mensuelles');
    $writer->writeAttribute('color', '000000');

    foreach ( $dataAchat as $index => $value )
    {
        $writer->startElement('set');
            $writer->writeAttribute('value', $value );
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
<div id="chartContainerAchats"></div>
    <script type="text/javascript">
        var myChart = new FusionCharts("FusionCharts/MSLine.swf", "myChartId", "500", "300", "0", "0" );
        myChart.setXMLUrl("ajax/infos/statistiques/data_stats_achats.xml");
        myChart.render("chartContainerAchats");
    </script>
</div>