<?php
/**
	Fichier GetXMLUsersTypesUsers.php
	-----------------------------------
	Ce fichier crée un fichier .xml du nombre d'users en fonction du type d'user.
*/
@require_once("../../../../config/config.php");
@require_once("../../../../include/function.php");
@require_once("../../../../include/ClassDB.php");

@session_start();
$db = new Database ();

$datas = $db->getAllNumberUsersByTypesUSers ();

$writer = new XMLWriter();  
$writer->openURI( 'data_stats_users_types_users.xml');  
$writer->startDocument('1.0','UTF-8');  
$writer->setIndent(4);   
$writer->startElement('chart');   
   $writer->writeAttribute('caption', 'NKedon');  
   $writer->writeAttribute('subcaption', 'Nombre utilisateur par profil utilisateur'); 
   $writer->writeAttribute('xAxisName', 'Types compte utilisateur');
   $writer->writeAttribute('yAxisName', 'Nombre utilisateur'); 
   $writer->writeAttribute('numberPrefix', '');  
   $writer->writeAttribute('numberSuffix', '');  
   $writer->writeAttribute('showValue', '1');  

    foreach ( $datas as $data ) 
    {
      if( $data["idt_users"] == NULL ) $data["nb"] = 0;
        $writer->startElement('set'); 
        $writer->writeAttribute('label', $data["nom_type_user"]);  
        $writer->writeAttribute('value', $data["nb"]);
        $writer->endElement();
    } 
          
$writer->endElement();  
$writer->endDocument();   
$writer->flush();

?>
<div id="chartContainerUsersTypesUsers"></div>
    <script type="text/javascript">
        var myChart = new FusionCharts("FusionCharts/Column3D.swf", "myChartId", "900", "500", "0", "1" );
        myChart.setXMLUrl("ajax/infos/administration_magasin/statistiques/data_stats_users_types_users.xml");
        myChart.render("chartContainerUsersTypesUsers");
    </script>
</div>