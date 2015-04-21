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

$datas = $db->getAllNumberFacturesFournisseur();

$writer = new XMLWriter();  
$writer->openURI( 'data_stats_factures_fournisseurs.xml');  
$writer->startDocument('1.0','UTF-8');  
$writer->setIndent(4);   
$writer->startElement('chart');   
   $writer->writeAttribute('caption', 'NKedon');  
   $writer->writeAttribute('subcaption', 'Nombre de factures archivées par fournisseur'); 
   $writer->writeAttribute('xAxisName', 'Fournisseurs');
   $writer->writeAttribute('yAxisName', 'Nombre de factures archivées'); 
   $writer->writeAttribute('numberPrefix', '');  
   $writer->writeAttribute('numberSuffix', '');  
   $writer->writeAttribute('showValue', '0');
   $writer->writeAttribute('bgColor', 'F1F1F1');
   $writer->writeAttribute('canvasBorderThickness', '1');  
   $writer->writeAttribute('canvasBorderColor', '999999');
   $writer->writeAttribute('plotFillAngle', '330'); 
   $writer->writeAttribute('plotBorderColor', '999999');  
   $writer->writeAttribute('showAlternateVGridColor', '1');
   $writer->writeAttribute('divLineAlpha', '0');

    foreach ($datas as $data) 
    {
        $writer->startElement('set'); 
        $writer->writeAttribute('label', $data["nom_fournisseur"] );  
        $writer->writeAttribute('value', $data["nb_factures"] );
        $writer->endElement();
    } 
          
$writer->endElement();  
$writer->endDocument();   
$writer->flush();

?>
<div id="chartContainer"></div>
    <script type="text/javascript">
        var myChart = new FusionCharts("FusionCharts/Bar2D.swf", "myChartId", "900", "700", "0", "1" );
        myChart.setXMLUrl("ajax/infos/administration_magasin/statistiques/data_stats_factures_fournisseurs.xml");
        myChart.render("chartContainer");
    </script>
</div>