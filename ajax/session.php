<?php
/**
	Fichier session.php
	-------------------
	Version : 1.0
	Auteur : Intuitive Soft
	Date : 07/12/2013
	
	Mise en place d'un script de session pour sauvegarder directement et simplement les valeurs de session utiles.
	
	v1.0
		* Ajout d'un paramètre format qui s'il est égal à french_date convertit en date SQL la date passée en paramètre.
*/
@session_start ();

/**
 * Fonction FrenchDateToSQLDate
 * ----------------------------
 * Transforme la date 15/11/2010 en 2010-11-15
 */
function FrenchDateToSQLDate ($date)
{
	$arr = explode ("/", $date);
	
	$new_date = $arr [2]."-".$arr [1]."-".$arr [0];
	return $new_date;
}

if (isset ($_POST ["format"]) && ($_POST ["format"] == "french_date"))
	$_SESSION ["SelectedValues"][$_POST ["key"]] = FrenchDateToSQLDate ($_POST ["value"]);
else if ( $_POST ["key"] == "date_start_filter_histos_anomalies" )
{
	$_SESSION ["SelectedValues"]["date_start_filter_histos_anomalies"] = $_POST ["value"];
}
else if ( $_POST ["key"] == "date_end_filter_histos_anomalies" )
{
	$_SESSION ["SelectedValues"]["date_end_filter_histos_anomalies"] = $_POST ["value"];
}
else
	$_SESSION ["SelectedValues"][$_POST ["key"]] = $_POST ["value"];

?>