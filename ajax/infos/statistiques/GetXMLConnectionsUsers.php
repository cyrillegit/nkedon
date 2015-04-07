<?php
/**
	Fichier GetXMLConnectionsUsers.php
	-----------------------------------
	Ce fichier crée un fichier .xml du nombre de connexionx en fonction de l'user.
*/
@require_once("../../../../config/config.php");
@require_once("../../../../include/function.php");
@require_once("../../../../include/ClassDB.php");

@session_start();
$db = new Database ();

$datas = $db->getAllNumberConnectionsByUSers ();

$writer = new XMLWriter();  
$writer->openURI( 'data_stats_connections_users.xml');  
$writer->startDocument('1.0','UTF-8');  
$writer->setIndent(4);   
$writer->startElement('chart');   
   $writer->writeAttribute('caption', 'NKedon');  
   $writer->writeAttribute('subcaption', 'Nombre de connexions par utilisateur'); 
   $writer->writeAttribute('xAxisName', 'Comptes utilisateur');
   $writer->writeAttribute('yAxisName', 'Nombre de connexions'); 
   $writer->writeAttribute('numberPrefix', '');  
   $writer->writeAttribute('numberSuffix', '');  
   $writer->writeAttribute('showValue', '1');  

    foreach ($datas as $data) 
    {
        $writer->startElement('set'); 
        $writer->writeAttribute('label', $data["nom_user"]." ".$data["prenom_user"] );  
        $writer->writeAttribute('value', $data["nombre_connexion"] );
        $writer->endElement();
    } 
          
$writer->endElement();  
$writer->endDocument();   
$writer->flush();

?>
<div id="chartContainer"></div>
    <script type="text/javascript">
        var myChart = new FusionCharts("FusionCharts/Column3D.swf", "myChartId", "900", "500", "0", "1" );
        myChart.setXMLUrl("ajax/infos/administration_magasin/statistiques/data_stats_connections_users.xml");
        myChart.render("chartContainer");
    </script>
</div>