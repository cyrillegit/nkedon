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

//$datas = $db->getAllHistoriquesSyntheses ();
$datasVentes = $db->getAllProduitsVendusByInventaire( 0 );
foreach ( $datasVentes as $data )
{
    $date = getDateFromDatetime( $data["date_journal"] );
    if( isset( $dataVente[ $date ])){
        $dataVente[ $date ] += $data["quantite_vendue"] * $data["prix_vente"];
    }else{
        $dataVente[ $date ] = $data["quantite_vendue"] * $data["prix_vente"];
    }
}

$writer = new XMLWriter();  
$writer->openURI( 'data_stats_ventes.xml');
$writer->startDocument('1.0','UTF-8');  
$writer->setIndent(4);   
$writer->startElement('chart');   
   $writer->writeAttribute('caption', 'Evolution des ventes');
   $writer->writeAttribute('subcaption', 'du mois courant');
   $writer->writeAttribute('lineThickness', '3');
   $writer->writeAttribute('formatNumberScale', '0');
   $writer->writeAttribute('anchorRadius', '2');
   $writer->writeAttribute('divLineAlpha', '20');
   $writer->writeAttribute('numvdivlines', '5');
   $writer->writeAttribute('chartRightMargin', '35');
   $writer->writeAttribute('bgColor', '14');
   $writer->writeAttribute('bgAngle', '270');
   $writer->writeAttribute('bgAlpha', '0');
   $writer->writeAttribute('alternateHGridAlpha', '5');  
   $writer->writeAttribute('divLineColor', 'CC3300');
   $writer->writeAttribute('divLineIsDashed', '1');
   $writer->writeAttribute('showAlternateHGridColor', '1');
   $writer->writeAttribute('alternateHGridColor', 'CC3300');
   $writer->writeAttribute('shadowAlpha', '90');
   $writer->writeAttribute('legendPosition', 'BOTTOM');  
   $writer->writeAttribute('labelStep', '0');  
   $writer->writeAttribute('showValues', '0');
   $writer->writeAttribute('canvasBgAlpha', '0');
   $writer->writeAttribute('legendBgAlpha', '0');
   $writer->writeAttribute('bgImage', '');
   $writer->writeAttribute('bgImageAlpha', '100');

$writer->startElement('categories');
    foreach ( $dataVente as $index => $value )
    {
        $writer->startElement('category');
            $writer->writeAttribute('label',  $index );
        $writer->endElement();
    }
    $writer->endElement();

    $writer->startElement('dataset');
    $writer->writeAttribute('seriesName', 'Ventes mensuelles');
    $writer->writeAttribute('color', '00FF00');

    foreach ( $dataVente as $index => $value )
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
<div id="chartContainerVentes"></div>
    <script type="text/javascript">
        var myChart = new FusionCharts("FusionCharts/MSLine.swf", "myChartId", "500", "300", "0", "0" );
        myChart.setXMLUrl("ajax/infos/statistiques/data_stats_ventes.xml");
        myChart.render("chartContainerVentes");
    </script>
</div>